<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('signin');
        }

        $user = Auth::user();

        // Split multiple roles: admin|super_admin
        $allowedRoles = array_filter(explode('|', $roles));

        if (!in_array($user->role, $allowedRoles)) {
            // Optional: custom message based on user type
            $message = match ($user->role) {
                'freelancer' => 'Freelancers cannot access this page.',
                'client'     => 'Clients cannot access this page.',
                default      => 'You do not have permission to access this page.',
            };

            return redirect()
                ->route('startup')
                ->with('error', $message);
        }

        return $next($request);
    }
}
