<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Mail\ConsultantContactNotification;
use App\Models\Appointment;
use App\Models\BespokeProject;
use App\Models\Order;
use App\Models\Product;
use App\Models\Treasure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's L'Espace dashboard.
     */
    public function show(Request $request): View
    {
        $user = $request->user();

        // Get recent orders
            $recentOrders = Order::where('user_id', auth('web')->id())
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Get bespoke projects
            $bespokeProjects = BespokeProject::where('user_id', auth('web')->id())
            ->with('consultant')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get treasures
            $treasures = Treasure::where('user_id', auth('web')->id())
            ->with('product')
            ->orderBy('purchased_at', 'desc')
            ->get();

        // Get upcoming appointments
            $upcomingAppointments = Appointment::where('user_id', auth('web')->id())
            ->with('consultant')
            ->where('scheduled_at', '>=', now())
            ->where('status', 'confirmed')
            ->orderBy('scheduled_at', 'asc')
            ->get();

        // Get past appointments
            $pastAppointments = Appointment::where('user_id', auth('web')->id())
            ->with('consultant')
            ->where('scheduled_at', '<', now())
            ->orderBy('scheduled_at', 'desc')
            ->take(5)
            ->get();

        // Get recommended products for the dashboard
        $recommendedProducts = Product::query()
            ->with('collection', 'media', 'primaryImage')
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('lespace', [
            'user' => $user,
            'recentOrders' => $recentOrders,
            'bespokeProjects' => $bespokeProjects,
            'treasures' => $treasures,
            'upcomingAppointments' => $upcomingAppointments,
            'pastAppointments' => $pastAppointments,
            'recommendedProducts' => $recommendedProducts,
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

            auth('web')->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the user's order history.
     */
    public function orders(Request $request): View
    {
        $orders = Order::where('user_id', auth('web')->id())
                ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('profile.orders', [
            'user' => $request->user(),
            'orders' => $orders,
        ]);
    }

    /**
     * Book an appointment with a consultant.
     */
    public function bookAppointment(Request $request): RedirectResponse
    {
        $request->validate([
            'consultant_id' => 'required|exists:consultants,id',
            'type' => 'required|in:virtual,in-person',
            'scheduled_at' => 'required|date|after:now',
            'notes' => 'nullable|string|max:500',
        ]);

            Appointment::create([
                'user_id' => auth('web')->id(),
            'consultant_id' => $request->consultant_id,
            'type' => $request->type,
            'scheduled_at' => $request->scheduled_at,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return Redirect::route('profile.show')->with('status', 'appointment-requested');
    }

    /**
     * Contact consultant for bespoke project.
     */
    public function contactConsultant(Request $request): RedirectResponse
    {
        $request->validate([
            'consultant_id' => 'required|exists:consultants,id',
            'message' => 'required|string|max:1000',
            'project_type' => 'required|string|max:255',
        ]);

        // Create or update bespoke project
            $project = BespokeProject::create([
                'user_id' => auth('web')->id(),
            'consultant_id' => $request->consultant_id,
            'project_title' => $request->project_type,
            'current_step' => 'consultation',
        ]);

        // Send notification to consultant
        if ($project->consultant && $project->consultant->email) {
            Mail::to($project->consultant->email)->send(new ConsultantContactNotification($project));
        }

        return Redirect::route('profile.show')->with('status', 'consultant-contacted');
    }
}
