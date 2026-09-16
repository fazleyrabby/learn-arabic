<?php

namespace App\Http\Controllers;

use App\Models\ArabicLetter;
use App\Models\Harakat;
use App\Models\Lesson;
use App\Models\QuranSurah;
use App\Models\ReviewCard;
use App\Models\Vocabulary;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the main learning dashboard.
     */
    public function index(Request $request): View
    {
        $letterCount = ArabicLetter::count();
        $harakatCount = Harakat::count();
        $vocabCount = Vocabulary::count();
        $fatihah = QuranSurah::withCount('verses')->where('number', 1)->first();

        $sessionId = $request->session()->getId();
        $userId = auth()->id();

        $dueQuery = ReviewCard::query();
        if ($userId) {
            $dueQuery->where('user_id', $userId);
        } else {
            $dueQuery->where('session_id', $sessionId);
        }
        $dueCount = $dueQuery->where('due_at', '<=', Carbon::now())->count();

        $lessons = Lesson::where('published', true)->orderBy('order')->get();

        return view('dashboard', [
            'letterCount' => $letterCount,
            'harakatCount' => $harakatCount,
            'vocabCount' => $vocabCount,
            'fatihah' => $fatihah,
            'dueCount' => $dueCount,
            'lessons' => $lessons,
        ]);
    }
}
