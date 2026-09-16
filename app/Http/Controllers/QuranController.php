<?php

namespace App\Http\Controllers;

use App\Models\QuranSurah;
use App\Models\QuranWord;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class QuranController extends Controller
{
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
