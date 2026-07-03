<?php

test('the application redirects guests to login', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('login'));
});

test('the dashboard requires authentication', function () {
    $response = $this->get(route('dashboard'));

    $response->assertRedirect(route('login'));
});
