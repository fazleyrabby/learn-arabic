<?php

use App\Models\ArabicLetter;

test('it loads the dashboard successfully', function (): void {
    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Quranic Arabic');
    $response->assertSee('Structured Learning Sequence');
});

test('it lists all 28 arabic letters and harakats', function (): void {
    $response = $this->get(route('alphabet.index'));

    $response->assertStatus(200);
    $response->assertSee('Alif');
    $response->assertSee('Baa');
    $response->assertSee('Fatḥah');
});

test('it displays single letter with all 4 forms', function (): void {
    $letter = ArabicLetter::where('order', 2)->firstOrFail();

    $response = $this->get(route('alphabet.show', $letter->order));

    $response->assertStatus(200);
    $response->assertSee('Baa');
    $response->assertSee('ب');
    $response->assertSee('isolated');
    $response->assertSee('initial');
    $response->assertSee('medial');
    $response->assertSee('final');
});

test('it serves the reading practice studio', function (): void {
    $response = $this->get(route('reading.index'));

    $response->assertStatus(200);
    $response->assertSee('Reading Practice Studio');
    $response->assertSee('Two-Letter Blends');
    $response->assertSee('Trilateral Words');
});
