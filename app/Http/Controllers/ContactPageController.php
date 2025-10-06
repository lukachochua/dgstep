<?php

namespace App\Http\Controllers;

use App\Models\ContactPage;
use Illuminate\Http\Request;

class ContactPageController extends Controller
{
    public function show()
    {
        $record   = ContactPage::query()->latest('id')->first();
        $defaults = \App\Models\ContactPage::defaults() ?? []; 

        return view('pages.contact', compact('record', 'defaults'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'surname'  => ['required', 'string', 'max:100'],
            'phone'    => ['required', 'string', 'regex:/^\+?\d{7,15}$/'],
            'comments' => ['nullable', 'string', 'max:2000'],
        ]);

        // TODO: mail/notification/crm
        return back()->with('success', __('contact.success'));
    }
}
