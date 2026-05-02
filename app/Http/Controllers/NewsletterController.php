<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'source' => ['nullable', 'string', 'max:100'],
        ]);

        $subscriber = Subscriber::firstOrCreate(
            ['email' => $request->email],
            [
                'source' => $request->source ?? 'newsletter_footer',
                'status' => 'active',
                'unsubscribe_token' => Str::random(32),
                'subscribed_at' => now(),
            ]
        );

        if ($subscriber->wasRecentlyCreated) {
            return back()->with('newsletter_status', 'Thank you for subscribing!');
        }

        return back()->with('newsletter_status', 'You are already subscribed.');
    }
}
