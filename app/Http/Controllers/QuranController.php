<?php

namespace App\Http\Controllers;

use App\Models\QuranSurah;
use App\Models\QuranWord;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuranController extends Controller
{
    /**
     * Display the Holy Quran explorer with kids favorites and Juz 'Amma filters.
     */
    public function index(Request $request): View
    {
        $query = QuranSurah::query()->orderBy('number');

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search): void {
                $q->where('number', 'like', "%{$search}%")
                    ->orWhere('name_latin', 'like', "%{$search}%")
                    ->orWhere('name_english', 'like', "%{$search}%")
                    ->orWhere('name_bn', 'like', "%{$search}%")
                    ->orWhere('name_ar', 'like', "%{$search}%");
            });
        }

        $surahs = $query->get();
        $kidsSurahNumbers = [1, 112, 113, 114, 108, 110, 103, 109, 105, 106, 107];

        return view('quran.index', [
            'surahs' => $surahs,
            'kidsSurahNumbers' => $kidsSurahNumbers,
            'activeTab' => $request->query('tab', 'kids'),
            'searchQuery' => $search ?? '',
        ]);
    }

    /**
     * Display a specific Surah with interactive audio and word-by-word study.
     */
    public function show(int $number): View
    {
        $surah = QuranSurah::with([
            'verses.words.root',
            'verses.words.morphology',
        ])->where('number', $number)->firstOrFail();

        $prevSurah = QuranSurah::where('number', $number - 1)->first();
        $nextSurah = QuranSurah::where('number', $number + 1)->first();

        return view('quran.show', [
            'surah' => $surah,
            'prevSurah' => $prevSurah,
            'nextSurah' => $nextSurah,
        ]);
    }

    /**
     * Display Surah Al-Fatihah word-by-word interactive study environment.
     */
    public function fatihah(): View
    {
        $surah = QuranSurah::with([
            'verses.words.root',
            'verses.words.morphology',
        ])->where('number', 1)->firstOrFail();

        return view('quran.fatihah', [
            'surah' => $surah,
        ]);
    }

    /**
     * Return JSON morphology breakdown for a word.
     */
    public function word(int $id): JsonResponse
    {
        $word = QuranWord::with(['root', 'morphology', 'verse.surah'])->findOrFail($id);

        return response()->json([
            'id' => $word->id,
            'text_ar' => $word->text_ar,
            'transliteration' => $word->transliteration,
            'translation' => $word->translation,
            'translation_bn' => $word->translation_bn,
            'audio_url' => $word->audio_url,
            'root' => $word->root ? [
                'root_ar' => $word->root->root_ar,
                'root_latin' => $word->root->root_latin,
                'meaning' => $word->root->meaning,
            ] : null,
            'morphology' => $word->morphology ? [
                'part_of_speech' => $word->morphology->part_of_speech,
                'pattern' => $word->morphology->pattern,
                'case' => $word->morphology->case,
                'tense' => $word->morphology->tense,
                'person' => $word->morphology->person,
                'number' => $word->morphology->number,
            ] : null,
        ]);
    }
}
