<?php
// app/Http/Middleware/EnsureUserRole.php

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
            return redirect()
                ->route('startup')
                ->with('error', 'You do not have permission to access the admin area.');
        }

        return $next($request);
    }
}
