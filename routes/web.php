<?php

use App\Http\Controllers\AlphabetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuranController;
use App\Http\Controllers\ReadingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VocabularyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Alphabet, Harakat & Reading Exercises
Route::get('/alphabet', [AlphabetController::class, 'index'])->name('alphabet.index');
Route::get('/alphabet/{order}', [AlphabetController::class, 'show'])->name('alphabet.show');
Route::get('/reading', [ReadingController::class, 'index'])->name('reading.index');

// Quran Study
Route::get('/quran/fatihah', [QuranController::class, 'fatihah'])->name('quran.fatihah');
Route::get('/api/quran/words/{id}', [QuranController::class, 'word'])->name('api.quran.word');

// Vocabulary
Route::get('/vocabulary', [VocabularyController::class, 'index'])->name('vocabulary.index');
Route::get('/vocabulary/{id}', [VocabularyController::class, 'show'])->name('vocabulary.show');

// Spaced Repetition (SRS)
Route::get('/review', [ReviewController::class, 'index'])->name('review.index');
Route::post('/review/submit', [ReviewController::class, 'submit'])->name('review.submit');

// Linguistic Sources & References
Route::get('/references', function () {
    return view('references');
})->name('references');
