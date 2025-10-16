<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

function validContactPayload(): array
{
    return [
        'name' => 'John',
        'surname' => 'Doe',
        'phone' => '+995598123456',
        'comments' => 'Looking forward to hearing from you.',
        'g-recaptcha-response' => 'test-token',
    ];
}

test('contact form submits successfully when reCAPTCHA passes', function () {
    app()->setLocale('en');

    config([
        'services.recaptcha.secret_key' => 'testing-secret',
        'services.recaptcha.site_key' => 'testing-site',
    ]);

    Http::fake([
        'https://www.google.com/recaptcha/api/siteverify' => Http::response([
            'success' => true,
        ], 200),
    ]);

    $payload = validContactPayload();

    $response = $this->from(route('contact'))->post(route('contact.submit'), $payload);

    $response->assertRedirect(route('contact'));
    $response->assertSessionHas('success', __('contact.success'));

    $this->assertDatabaseHas('contact_submissions', [
        'name' => $payload['name'],
        'surname' => $payload['surname'],
        'phone' => $payload['phone'],
        'comments' => $payload['comments'],
    ]);
});

test('contact form shows validation error when reCAPTCHA fails', function () {
    app()->setLocale('en');

    config([
        'services.recaptcha.secret_key' => 'testing-secret',
        'services.recaptcha.site_key' => 'testing-site',
    ]);

    Http::fake([
        'https://www.google.com/recaptcha/api/siteverify' => Http::response([
            'success' => false,
        ], 200),
    ]);

    $payload = validContactPayload();

    $response = $this->from(route('contact'))->post(route('contact.submit'), $payload);

    $response->assertRedirect(route('contact'));
    $response->assertSessionHasErrors([
        'g-recaptcha-response' => __('contact.validation.captcha_invalid'),
    ]);

    $this->assertDatabaseCount('contact_submissions', 0);
});

