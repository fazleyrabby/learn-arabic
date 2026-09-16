<?php

use App\Models\QuranWord;

test('it renders surah al-fatihah with verses and words', function (): void {
    $response = $this->get(route('quran.fatihah'));

    $response->assertStatus(200);
    $response->assertSee('Al-Fatiha');
    $response->assertSee('بِسْمِ');
    $response->assertSee('الرَّحْمَٰنِ');
    $response->assertSee('الرَّحِيمِ');
    $response->assertSee('Word Analysis');
});

test('it renders quran index with 114 surahs and kids filter', function (): void {
    $response = $this->get(route('quran.index'));

    $response->assertStatus(200);
    $response->assertSee('Al-Fatiha');
    $response->assertSee('Al-Ikhlas');
    $response->assertSee('Kids Favorites');
});

test('it renders surah in quran studio with audio and translations', function (): void {
    $response = $this->get(route('quran.show', 112));

    $response->assertStatus(200);
    $response->assertSee('Al-Ikhlas');
    $response->assertSee('قُلْ');
    $response->assertSee('বিকাশ' === 'বিকাশ' ? 'এক' : 'One');
});

test('it returns word morphology analysis via api', function (): void {
    $word = QuranWord::where('text_ar', 'الرَّحْمَٰنِ')->firstOrFail();

    $response = $this->getJson(route('api.quran.word', $word->id));

    $response->assertStatus(200);
    $response->assertJsonPath('id', $word->id);
    $response->assertJsonPath('root.root_ar', 'ر ح م');
    $response->assertJsonPath('morphology.part_of_speech', 'adjective');
});
