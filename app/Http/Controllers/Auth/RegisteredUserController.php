<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Freelancer;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'     => ['required', 'in:client,freelancer'],
            'terms'    => ['required', 'accepted'],
        ]);

        // Use transaction
        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => $request->role,
            ]);

            // Create role-specific profile
            if ($request->role === 'client') {
                Client::create([
                    'user_id' => $user->id,
                    'total_spent' => 0,
                ]);
            }

            if ($request->role === 'freelancer') {
                Freelancer::create([
                    'user_id'          => $user->id,
                    'job_title'        => 'New Freelancer',
                    'availability'     => 'available',
                    'total_earned'     => 0,
                    'completed_projects' => 0,
                    'rating'           => null,
                    'rating_count'     => 0,
                ]);
            }

            // Create settings
            $user->settings()->create([
                'language' => 'en',
                'currency' => 'USD',
                'timezone' => 'UTC',
                'dark_mode' => false,
                'email_project_updates' => true,
                'email_new_messages' => true,
                'email_payments' => true,
                'email_marketing' => false,
                'profile_visibility' => 'public',
                'show_online_status' => true,
                'show_earnings' => true,
            ]);

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
