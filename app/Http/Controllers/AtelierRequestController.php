<?php

namespace App\Http\Controllers;

use App\Models\AtelierRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AtelierRequestController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        $atelierRequest = AtelierRequest::create($validated);

        return response()->json([
            'message' => 'Your atelier visit request has been received.',
            'request_id' => $atelierRequest->id,
        ], 201);
    }
}
