<?php

test('locale can be switched between english and bengali', function () {
    $response = $this->get(route('locale.switch', 'bn'));
    $response->assertRedirect();
    $response->assertSessionHas('locale', 'bn');
    $response->assertCookie('locale', 'bn');

    $responseEn = $this->get(route('locale.switch', 'en'));
    $responseEn->assertRedirect();
    $responseEn->assertSessionHas('locale', 'en');
});

test('unsupported locale is rejected by switcher', function () {
    $response = $this->get(route('locale.switch', 'es'));
    $response->assertRedirect();
    $response->assertSessionMissing('locale');
});
