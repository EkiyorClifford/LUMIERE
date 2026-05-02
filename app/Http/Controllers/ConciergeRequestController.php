<?php

namespace App\Http\Controllers;

use App\Models\ConciergeRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConciergeRequestController extends Controller
{
    public function create(): View
    {
        return view('contact');
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
            'piece' => ['nullable', 'string', 'max:255'],
            'piece_category' => ['nullable', 'string', 'max:60'],
            'measurement' => ['nullable', 'string', 'max:255'],
            'source' => ['required', 'in:contact_page,size_guide_fitting'],
        ]);

        ConciergeRequest::query()->create($validated);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Request received.']);
        }

        return back()->with('status', 'Your message has been received. Our concierge team will reply within 24 hours.');
    }
}
