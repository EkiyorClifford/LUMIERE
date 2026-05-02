<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ConciergeController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'request' => ['required', 'string', 'max:2000'],
        ]);

        // TODO: Store concierge request in database or send email

        return back()->with('success', 'Your concierge request has been received. We will contact you shortly.');
    }
}
