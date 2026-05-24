<?php

namespace App\Http\Controllers;

use App\Mail\ConciergeRequestReceived;
use App\Models\ConciergeRequest;
use App\Models\SizerKitRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SizerKitRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'shipping_address_line_1' => ['required', 'string', 'max:255'],
            'shipping_address_line_2' => ['nullable', 'string', 'max:255'],
            'shipping_address_line_3' => ['nullable', 'string', 'max:255'],
            'ring_size_guess' => ['nullable', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $kitRequest = SizerKitRequest::query()->create($validated);

        $adminEmail = (string) (env('ADMIN_EMAIL') ?: config('mail.from.address'));
        if ($adminEmail !== '') {
            $mailRequest = new ConciergeRequest([
                'name' => $kitRequest->full_name,
                'email' => $kitRequest->email,
                'source' => 'size_guide_sizer_kit',
                'subject' => 'Ring sizer kit request',
                'message' => $kitRequest->notes ?? 'New ring sizer kit request submitted.',
            ]);
            Mail::to($adminEmail)->send(new ConciergeRequestReceived($mailRequest));
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Your ring sizer kit request has been received.',
            ]);
        }

        return back()->with('success', 'Your ring sizer kit request has been received.');
    }
}
