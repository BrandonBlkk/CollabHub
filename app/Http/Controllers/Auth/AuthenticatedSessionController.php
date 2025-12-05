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
        // Validate the request (automatically handled by LoginRequest)
        // If validation fails, the request will automatically return JSON response
        $validated = $request->validated();

        // Get credentials
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // Attempt authentication
        if (!Auth::attempt($credentials, $remember)) {
            // Check if email exists in database
            $userExists = \App\Models\User::where('email', $request->email)->exists();

            if ($userExists) {
                $errorMessage = 'The password you entered is incorrect';
            } else {
                $errorMessage = 'No account found with this email address';
            }

            return response()->json([
                'success' => false,
                'errors' => [
                    'password' => [$errorMessage]
                ],
                'message' => 'Login failed. Please check your credentials.'
            ], 422);
        }

        // Authentication successful - regenerate session
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Login successful! Redirecting...',
            'redirect' => route('dashboard', absolute: false)
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
