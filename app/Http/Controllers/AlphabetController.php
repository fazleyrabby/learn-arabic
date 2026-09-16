<?php

namespace App\Http\Controllers;

use App\Models\ArabicLetter;
use App\Models\Harakat;
use Illuminate\Contracts\View\View;

class AlphabetController extends Controller
{
    /**
     * Display the alphabet grid and harakat overview.
     */
    public function index(): View
    {
        $letters = ArabicLetter::with('forms')->orderBy('order')->get();
        $harakats = Harakat::orderBy('order')->get();

        return view('alphabet.index', [
            'letters' => $letters,
            'harakats' => $harakats,
        ]);
    }

    /**
     * Display detailed letter analysis and all 4 positional shapes.
     */
    public function show(int $order): View
    {
        $letter = ArabicLetter::with('forms')->where('order', $order)->firstOrFail();
        $prevLetter = ArabicLetter::where('order', $order - 1)->first();
        $nextLetter = ArabicLetter::where('order', $order + 1)->first();

        return view('alphabet.show', [
            'letter' => $letter,
            'prevLetter' => $prevLetter,
            'nextLetter' => $nextLetter,
        ]);
    }
}
