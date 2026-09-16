<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    /**
     * Display the searchable high-frequency Quranic vocabulary index.
     */
    public function index(Request $request): View
    {
        $query = Vocabulary::with(['root', 'occurrences.surah', 'occurrences.verse']);

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search): void {
                $q->where('arabic', 'like', "%{$search}%")
                    ->orWhere('normalized_arabic', 'like', "%{$search}%")
                    ->orWhere('transliteration', 'like', "%{$search}%")
                    ->orWhere('meaning_en', 'like', "%{$search}%")
                    ->orWhere('meaning_bn', 'like', "%{$search}%");
            });
        }

        if ($pos = $request->input('pos')) {
            $query->where('part_of_speech', 'like', "%{$pos}%");
        }

        $vocabularies = $query->orderByDesc('frequency')->paginate(24)->withQueryString();

        return view('vocabulary.index', [
            'vocabularies' => $vocabularies,
            'search' => $search,
            'pos' => $pos,
        ]);
    }

    /**
     * Show word detail with root information and occurrences.
     */
    public function show(int $id): View
    {
        $word = Vocabulary::with(['root.vocabularies', 'occurrences.surah', 'occurrences.verse'])->findOrFail($id);

        return view('vocabulary.show', [
            'word' => $word,
        ]);
    }
}
