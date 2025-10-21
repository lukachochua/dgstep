<?php

use App\Mail\ContactSubmissionReceived;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use function Pest\Laravel\withoutMiddleware;

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

// Disable *all* HTTP middleware (including CSRF) for these tests
beforeEach(fn() => withoutMiddleware());

test('contact form submits successfully when reCAPTCHA passes and emails ops', function () {
    app()->setLocale('en');

    config([
        'services.recaptcha.secret_key' => 'testing-secret',
        'services.recaptcha.site_key'   => 'testing-site',
        'mail.ops_to'                   => 'ops-test@example.com',
    ]);

    Http::fake([
        'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true], 200),
    ]);

    Mail::fake();

    $payload  = validContactPayload();
    $response = $this->from(route('contact'))->post(route('contact.submit'), $payload);

    $response->assertRedirect(route('contact'));
    $response->assertSessionHas('success', __('contact.success'));

    $this->assertDatabaseHas('contact_submissions', [
        'name'     => $payload['name'],
        'surname'  => $payload['surname'],
        'phone'    => $payload['phone'],
        'comments' => $payload['comments'],
    ]);

    Mail::assertSent(ContactSubmissionReceived::class, fn($m) => $m->hasTo(config('mail.ops_to')));
});

test('contact form shows validation error when reCAPTCHA fails (no DB, no email)', function () {
    app()->setLocale('en');

    config([
        'services.recaptcha.secret_key' => 'testing-secret',
        'services.recaptcha.site_key'   => 'testing-site',
        'mail.ops_to'                   => 'ops-test@example.com',
    ]);

    Http::fake([
        'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => false], 200),
    ]);

    Mail::fake();

    $payload  = validContactPayload();
    $response = $this->from(route('contact'))->post(route('contact.submit'), $payload);

    $response->assertRedirect(route('contact'));
    $response->assertSessionHasErrors([
        'g-recaptcha-response' => __('contact.validation.captcha_invalid'),
    ]);

    $this->assertDatabaseCount('contact_submissions', 0);
    Mail::assertNothingSent();
});
