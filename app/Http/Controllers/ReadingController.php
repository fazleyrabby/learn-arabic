<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class ReadingController extends Controller
{
    /**
     * Display the interactive Arabic reading practice studio.
     */
    public function index(): View
    {
        $levels = [
            'syllables' => [
                'title' => 'Single Syllables',
                'description' => 'Practice instant phonetic recognition of single consonants with short vowels.',
                'items' => [
                    ['text' => 'بَ', 'trans' => 'ba', 'sound' => 'Fatḥah on Baa'],
                    ['text' => 'تِ', 'trans' => 'ti', 'sound' => 'Kasrah on Taa'],
                    ['text' => 'سُ', 'trans' => 'su', 'sound' => 'Ḍammah on Seen'],
                    ['text' => 'رَ', 'trans' => 'ra', 'sound' => 'Fatḥah on Raa'],
                    ['text' => 'دِ', 'trans' => 'di', 'sound' => 'Kasrah on Daal'],
                    ['text' => 'كُ', 'trans' => 'ku', 'sound' => 'Ḍammah on Kaaf'],
                    ['text' => 'مَ', 'trans' => 'ma', 'sound' => 'Fatḥah on Meem'],
                    ['text' => 'نِ', 'trans' => 'ni', 'sound' => 'Kasrah on Noon'],
                ],
            ],
            'two_letters' => [
                'title' => 'Two-Letter Blends & Sukūn',
                'description' => 'Learn how a vowelled letter connects to a quiescent letter stopped with Sukūn.',
                'items' => [
                    ['text' => 'مِنْ', 'breakdown' => 'مِ + نْ', 'trans' => 'min', 'meaning' => 'from / among'],
                    ['text' => 'عَنْ', 'breakdown' => 'عَ + نْ', 'trans' => '‘an', 'meaning' => 'about / from'],
                    ['text' => 'قُلْ', 'breakdown' => 'قُ + لْ', 'trans' => 'qul', 'meaning' => 'say!'],
                    ['text' => 'كُنْ', 'breakdown' => 'كُ + نْ', 'trans' => 'kun', 'meaning' => 'be!'],
                    ['text' => 'هَلْ', 'breakdown' => 'هَ + لْ', 'trans' => 'hal', 'meaning' => 'is / whether?'],
                    ['text' => 'لَمْ', 'breakdown' => 'لَ + مْ', 'trans' => 'lam', 'meaning' => 'did not'],
                    ['text' => 'قَدْ', 'breakdown' => 'قَ + دْ', 'trans' => 'qad', 'meaning' => 'certainly / already'],
                    ['text' => 'بَلْ', 'breakdown' => 'بَ + لْ', 'trans' => 'bal', 'meaning' => 'rather / nay'],
                ],
            ],
            'three_letters' => [
                'title' => 'Three-Letter Words & Verbs',
                'description' => 'Blend three connected letters in traditional Arabic trilateral verbal patterns.',
                'items' => [
                    ['text' => 'كَتَبَ', 'breakdown' => 'كَ + تَ + بَ', 'trans' => 'ka-ta-ba', 'meaning' => 'he wrote'],
                    ['text' => 'خَلَقَ', 'breakdown' => 'خَ + لَ + قَ', 'trans' => 'kha-la-qa', 'meaning' => 'he created'],
                    ['text' => 'رَزَقَ', 'breakdown' => 'رَ + زَ + قَ', 'trans' => 'ra-za-qa', 'meaning' => 'he provided'],
                    ['text' => 'عَلِمَ', 'breakdown' => 'عَ + لِ + مَ', 'trans' => '‘a-li-ma', 'meaning' => 'he knew'],
                    ['text' => 'رَحِمَ', 'breakdown' => 'رَ + حِ + مَ', 'trans' => 'ra-ḥi-ma', 'meaning' => 'he had mercy'],
                    ['text' => 'ذَهَبَ', 'breakdown' => 'ذَ + هَ + بَ', 'trans' => 'dha-ha-ba', 'meaning' => 'he went'],
                    ['text' => 'سَمِعَ', 'breakdown' => 'سَ + مِ + عَ', 'trans' => 'sa-mi-‘a', 'meaning' => 'he heard'],
                    ['text' => 'صَبَرَ', 'breakdown' => 'صَ + بَ + رَ', 'trans' => 'ṣa-ba-ra', 'meaning' => 'he was patient'],
                ],
            ],
        ];

        return view('reading.index', [
            'levels' => $levels,
        ]);
    }
}
