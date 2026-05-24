<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConciergeRequestStoreRequest;
use App\Mail\ConciergeRequestConfirmation;
use App\Mail\ConciergeRequestReceived;
use App\Models\ConciergeRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ConciergeController extends Controller
{
    public function store(ConciergeRequestStoreRequest $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();

        $conciergeRequest = ConciergeRequest::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'] ?? 'Concierge request',
            'piece' => $validated['piece'] ?? null,
            'piece_category' => $validated['piece_category'] ?? null,
            'measurement' => $validated['measurement'] ?? null,
            'message' => $validated['message'],
            'source' => $validated['source'],
            'status' => 'pending',
        ]);

        $adminEmail = (string) (env('ADMIN_EMAIL') ?: config('mail.from.address'));
        if ($adminEmail !== '') {
            Mail::to($adminEmail)->send(new ConciergeRequestReceived($conciergeRequest));
        }
        Mail::to($conciergeRequest->email)->send(new ConciergeRequestConfirmation($conciergeRequest));

        $message = 'Your message has been received. Our concierge team will reply within 24 hours.';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }
}
