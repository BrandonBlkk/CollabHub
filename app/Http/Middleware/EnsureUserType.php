<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ← This was missing!
use Symfony\Component\HttpFoundation\Response;

class EnsureUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $type): Response
    {
        if (!Auth::check()) {
            return redirect()->route('signin');
        }

        $user = Auth::user();

        $allowedTypes = array_filter(explode('|', $type));

        if (!in_array($user->user_type, $allowedTypes)) {
            // Optional: custom message based on user type
            $message = match ($user->user_type) {
                'freelancer' => 'Freelancers cannot access this page.',
                'client'     => 'Clients cannot access this page.',
                default      => 'You do not have permission to access this page.',
            };

            return redirect()
                ->route('dashboard')
                ->with('error', $message);
        }

        return $next($request);
    }
}
