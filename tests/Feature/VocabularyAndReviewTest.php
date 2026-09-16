<?php

use App\Models\ReviewCard;
use App\Models\Vocabulary;

test('it displays high-frequency vocabulary list and supports search', function (): void {
    $response = $this->get(route('vocabulary.index', ['q' => 'Allah']));

    $response->assertStatus(200);
    $response->assertSee('الله');

    $vocab = Vocabulary::where('arabic', 'الله')->firstOrFail();
    $detailResponse = $this->get(route('vocabulary.show', $vocab->id));
    $detailResponse->assertStatus(200);
    $detailResponse->assertSee('Occurs 2,699 times');
});

test('it serves review session and submits spaced repetition grades', function (): void {
    $response = $this->get(route('review.index'));

    $response->assertStatus(200);
    $response->assertSee('Daily Review Session');

    $card = ReviewCard::firstOrFail();

    $submitResponse = $this->postJson(route('review.submit'), [
        'card_id' => $card->id,
        'quality' => 3, // Good
    ]);

    $submitResponse->assertStatus(200);
    $submitResponse->assertJsonPath('success', true);

    $card->refresh();
    expect($card->repetitions)->toBe(1);
    expect($card->interval_days)->toBe(1);
});
