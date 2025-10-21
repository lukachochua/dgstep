<?php

namespace App\Http\Controllers;

use App\Mail\ContactSubmissionReceived;
use App\Models\ContactPage;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    /**
     * Show the Contact page with DB/default/lang fallbacks
     */
    public function show()
    {
        $locale   = app()->getLocale();
        $record   = ContactPage::query()->latest('id')->first();
        $defaults = ContactPage::defaults() ?? [];

        // Map keys to final i18n fallbacks in lang files
        $langFallbacks = [
            'headline'              => __('contact.headline'),
            'description'           => __('contact.description'),
            'feature_professional'  => __('contact.features.professional'),
            'feature_guarantees'    => __('contact.features.guarantees'),
            'cta_button'            => __('contact.cta_button'),
            // phone href is handled below
        ];

        // Helper: get value from model → defaults() → lang fallback
        $get = function (string $key) use ($record, $defaults, $locale, $langFallbacks) {
            $db = $record?->getTranslation($key, $locale, false);
            if (!is_null($db) && $db !== '') {
                return $db;
            }

            // 2) defaults() per-locale array or scalar
            $def = $defaults[$key] ?? null;
            if (is_array($def)) {
                $val = $def[$locale] ?? ($def['en'] ?? null);
                if (!is_null($val) && $val !== '') {
                    return $val;
                }
            } elseif (!is_null($def) && $def !== '') {
                return $def;
            }

            // 3) lang file final fallback
            return $langFallbacks[$key] ?? null;
        };

        $view = [
            'headline' => $get('headline'),
            'desc'     => $get('description'),
            'featPro'  => $get('feature_professional'),
            'featGua'  => $get('feature_guarantees'),
            'ctaLabel' => $get('cta_button'),

            'ctaPhone' => $record?->cta_phone_href
                ?? ($defaults['cta_phone_href'] ?? __('contact.cta_phone_href')),

            'recaptchaSiteKey' => config('services.recaptcha.site_key'),
        ];

        return view('pages.contact', $view);
    }

    /**
     * Handle contact form submit:
     *  - Validate + verify reCAPTCHA
     *  - Store ContactSubmission
     *  - Send ops email synchronously (mailer determined by .env/config)
     */
    public function submit(Request $request)
    {
        // 1) Validate input
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'surname'  => ['required', 'string', 'max:255'],
            'phone'    => ['required', 'regex:/^\+?\d{7,15}$/'],
            'comments' => ['nullable', 'string', 'max:1000'],
            'g-recaptcha-response' => ['required', 'string'],
        ], [
            'g-recaptcha-response.required' => __('contact.validation.captcha_required'),
        ]);

        // 2) Verify reCAPTCHA
        $recaptchaSecret = config('services.recaptcha.secret_key');

        if (! $recaptchaSecret) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => __('contact.validation.captcha_unavailable'),
            ]);
        }

        try {
            $response = Http::asForm()
                ->timeout(5)
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret'   => $recaptchaSecret,
                    'response' => $validated['g-recaptcha-response'],
                    'remoteip' => $request->ip(),
                ]);
        } catch (\Throwable $exception) {
            report($exception);

            throw ValidationException::withMessages([
                'g-recaptcha-response' => __('contact.validation.captcha_unreachable'),
            ]);
        }

        if (! data_get($response->json(), 'success')) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => __('contact.validation.captcha_invalid'),
            ]);
        }

        // 3) Store submission first (source of truth)
        $submission = ContactSubmission::create([
            'name'       => $validated['name'],
            'surname'    => $validated['surname'],
            'phone'      => $validated['phone'],
            'comments'   => $validated['comments'] ?? null,
            'locale'     => app()->getLocale(),
            'ip_address' => $request->ip(),
        ]);

        // 4) Send the ops notification email (recipient from config/env)
        try {
            $opsTo = config('mail.ops_to'); // reads MAIL_OPS_TO with default fallback
            Mail::to($opsTo)->send(new ContactSubmissionReceived($submission));
        } catch (\Throwable $e) {
            // Don't block the user if mailer fails; just log and proceed.
            Log::warning('ContactSubmission mail failed: '.$e->getMessage(), [
                'submission_id' => $submission->id,
            ]);
        }

        // 5) UX: flash success and return
        return back()->with('success', __('contact.success'));
    }
}
