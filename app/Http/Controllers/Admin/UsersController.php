<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $user->load('orders');

        return view('admin.users.show', compact('user'));
    }

    public function toggleActive(Request $request, User $user): JsonResponse
    {
        $user->update(['is_active' => ! $user->is_active]);

        return response()->json([
            'ok' => true,
            'is_active' => (bool) $user->is_active,
            'label' => $user->is_active ? 'Active' : 'Disabled',
        ]);
    }
}
