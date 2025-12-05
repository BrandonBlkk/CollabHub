<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FindFreelancersController extends Controller
{
    /**
     * Display the find freelancers page
     */
    public function index(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('signin');
        }

        // Get the authenticated user
        $user = Auth::user();

        // Check if user is a client
        if ($user->user_type !== 'client') {
            return redirect()->route('dashboard')->with('error', 'Only clients can access this page.');
        }

        // Get all freelancers
        $freelancers = User::where('user_type', 'freelancer')->get();

        // Default view type
        $viewType = 'grid';

        return view('client.find-freelancers', compact(
            'freelancers',
            'viewType'
        ));
    }
}
