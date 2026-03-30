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
        'mail.ops_to'                   => 'ops-test@dgstep.test',
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
        'mail.ops_to'                   => 'ops-test@dgstep.test',
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

test('contact form stores the submission but warns when ops recipient is invalid', function () {
    app()->setLocale('en');

    config([
        'services.recaptcha.secret_key' => 'testing-secret',
        'services.recaptcha.site_key'   => 'testing-site',
        'mail.ops_to'                   => 'hello@example.com',
    ]);

    Http::fake([
        'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true], 200),
    ]);

    Mail::fake();

    $response = $this->from(route('contact'))->post(route('contact.submit'), validContactPayload());

    $response->assertRedirect(route('contact'));
    $response->assertSessionHas('warning', __('contact.warning_mail_not_sent'));
    $response->assertSessionMissing('success');

    $this->assertDatabaseCount('contact_submissions', 1);
    Mail::assertNothingSent();
});

test('contact form stores the submission but warns when mail delivery throws', function () {
    app()->setLocale('en');

    config([
        'services.recaptcha.secret_key' => 'testing-secret',
        'services.recaptcha.site_key'   => 'testing-site',
        'mail.ops_to'                   => 'ops-test@dgstep.test',
    ]);

    Http::fake([
        'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true], 200),
    ]);

    Mail::partialMock()
        ->shouldReceive('to')
        ->once()
        ->with('ops-test@dgstep.test')
        ->andReturnSelf();

    Mail::partialMock()
        ->shouldReceive('send')
        ->once()
        ->andThrow(new RuntimeException('SMTP failed'));

    $response = $this->from(route('contact'))->post(route('contact.submit'), validContactPayload());

    $response->assertRedirect(route('contact'));
    $response->assertSessionHas('warning', __('contact.warning_mail_not_sent'));
    $response->assertSessionMissing('success');

    $this->assertDatabaseCount('contact_submissions', 1);
});
