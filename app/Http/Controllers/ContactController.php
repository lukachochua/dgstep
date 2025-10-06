<?php

namespace App\Http\Controllers;

use App\Models\ContactPage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
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
        ];

        return view('pages.contact', $view);
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'surname'  => ['required', 'string', 'max:255'],
            'phone'    => ['required', 'regex:/^\+?\d{7,15}$/'],
            'comments' => ['nullable', 'string', 'max:1000'],
        ]);

        // TODO: send mail / queue a job / store CRM record, etc.
        return back()->with('success', __('contact.success'));
    }
}
