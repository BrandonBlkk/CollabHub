<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.signin');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            $userExists = \App\Models\User::where('email', $request->email)->exists();

            $errorMessage = $userExists
                ? 'The password you entered is incorrect'
                : 'No account found with this email address';

            return response()->json([
                'success' => false,
                'errors'  => ['password' => [$errorMessage]],
                'message' => 'Login failed. Please check your credentials.'
            ], 422);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Determine correct redirect route
        $redirectRoute = in_array($user->role, ['admin', 'super_admin'])
            ? 'admin.dashboard'
            : 'dashboard';

        return response()->json([
            'success'  => true,
            'message'  => 'Login successful! Redirecting...',
            'redirect' => route($redirectRoute)
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
