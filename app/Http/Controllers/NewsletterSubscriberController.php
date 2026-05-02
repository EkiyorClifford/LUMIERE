<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsletterSubscriberController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:64'],
        ]);

        Subscriber::query()->updateOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['name'] ?? null,
                'source' => $validated['source'] ?? 'newsletter_footer',
                'status' => 'active',
                'unsubscribe_token' => Str::random(40),
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
            ],
        );

        return back()->with('newsletter_status', 'You are on the list.');
    }
}
