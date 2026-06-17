<?php

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (! function_exists('currentAdmin')) {
    function currentAdmin(): ?Admin
    {
        $admin = Auth::guard('admin')->user();

        return $admin instanceof Admin ? $admin : null;
    }
}

if (! function_exists('currentCustomer')) {
    function currentCustomer(): ?User
    {
        $user = Auth::guard('web')->user();

        return $user instanceof User ? $user : null;
    }
}
