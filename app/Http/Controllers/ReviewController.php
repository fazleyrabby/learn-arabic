<?php

namespace App\Http\Controllers;

use App\Models\ArabicLetter;
use App\Models\ReviewCard;
use App\Models\Vocabulary;
use App\Services\SrsEngine;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(
        protected SrsEngine $srsEngine
    ) {}

    /**
     * Display the review session.
     */
    public function index(Request $request): View
    {
        $sessionId = $request->session()->getId();
        $userId = auth()->id();

        $query = ReviewCard::query();
        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }

        // Auto-seed initial review queue if empty
        if ($query->count() === 0) {
            $letters = ArabicLetter::take(8)->get();
            foreach ($letters as $letter) {
                ReviewCard::create([
                    'user_id' => $userId,
                    'session_id' => $sessionId,
                    'card_type' => 'letter',
                    'card_id' => $letter->id,
                    'due_at' => Carbon::now(),
                ]);
            }

            $words = Vocabulary::take(8)->get();
            foreach ($words as $word) {
                ReviewCard::create([
                    'user_id' => $userId,
                    'session_id' => $sessionId,
                    'card_type' => 'word',
                    'card_id' => $word->id,
                    'due_at' => Carbon::now(),
                ]);
            }
        }

        $dueCards = (clone $query)->where('due_at', '<=', Carbon::now())->get();

        // Hydrate target objects
        $cardsData = $dueCards->map(function (ReviewCard $card): array {
            $title = '';
            $sub = '';
            $answer = '';
            $audio = '';
            $details = '';

            if ($card->card_type === 'letter') {
                $letter = ArabicLetter::find($card->card_id);
                $title = $letter?->character ?? '';
                $sub = 'Arabic Letter';
                $answer = $letter?->name_latin.' ('.$letter?->transliteration.')';
                $details = $letter?->makhraj ?? '';
            } elseif ($card->card_type === 'word') {
                $word = Vocabulary::find($card->card_id);
                $title = $word?->arabic ?? '';
                $sub = 'Quranic Word (Freq: '.$word?->frequency.'x)';
                $answer = $word?->meaning_en.($word?->meaning_bn ? ' / '.$word?->meaning_bn : '');
                $details = 'Transliteration: '.$word?->transliteration;
            }

            return [
                'id' => $card->id,
                'type' => $card->card_type,
                'title' => $title,
                'sub' => $sub,
                'answer' => $answer,
                'details' => $details,
                'repetitions' => $card->repetitions,
                'interval_days' => $card->interval_days,
            ];
        });

        return view('review.index', [
            'cards' => $cardsData,
            'totalDue' => $dueCards->count(),
        ]);
    }

    /**
     * Submit grade for a card (1: Again, 2: Hard, 3: Good, 4: Easy).
     */
    public function submit(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'card_id' => 'required|exists:review_cards,id',
            'quality' => 'required|integer|min:1|max:4',
        ]);

        $card = ReviewCard::findOrFail($validated['card_id']);
        $updatedCard = $this->srsEngine->review($card, (int) $validated['quality']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'card_id' => $updatedCard->id,
                'next_due' => $updatedCard->due_at?->toIso8601String(),
                'interval_days' => $updatedCard->interval_days,
            ]);
        }

        return redirect()->route('review.index');
    }
}
