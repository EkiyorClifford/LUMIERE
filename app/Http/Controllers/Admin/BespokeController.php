<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AtelierRequest;
use Illuminate\View\View;

class BespokeController extends Controller
{
    public function index(): View
    {
        $requests = AtelierRequest::query()
            ->latest()
            ->paginate(20);

        return view('admin.bespoke.index', compact('requests'));
    }
}
