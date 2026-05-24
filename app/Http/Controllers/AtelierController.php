<?php

namespace App\Http\Controllers;

use App\Mail\AtelierRequestReceived;
use App\Models\AtelierRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AtelierController extends Controller
{
    public function index()
    {
        return view('atelier');
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        $atelierRequest = AtelierRequest::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);

        $adminEmail = (string) (env('ADMIN_EMAIL') ?: config('mail.from.address'));
        if ($adminEmail !== '') {
            Mail::to($adminEmail)->send(new AtelierRequestReceived($atelierRequest));
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Your atelier visit request has been received.',
                'request_id' => $atelierRequest->id,
            ], 201);
        }

        return back()->with('success', 'Your atelier request has been received. We will contact you shortly.');
    }
}
