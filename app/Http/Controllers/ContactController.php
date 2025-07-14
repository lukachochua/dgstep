<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function show()
    {
        return view('pages.contact', ['title' => __('Contact')]);
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'surname'  => 'required|string|max:255',
            'phone'    => 'required|regex:/^\+?\d{7,15}$/',
            'comments' => 'nullable|string|max:1000',
        ]);

        // 🚀 Handle submission (e.g., send email, save to DB, etc.)
        // For now just pretend it succeeded
        return back()->with('success', __('Your message has been sent!'));
    }
}
