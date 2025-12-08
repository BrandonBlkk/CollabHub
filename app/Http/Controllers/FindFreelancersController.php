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
        if ($user->role !== 'client') {
            return redirect()->route('dashboard')->with('error', 'Only clients can access this page.');
        }

        // Get all freelancers
        $freelancers = User::where('role', 'freelancer')->get();

        // Default view type
        $viewType = 'grid';

        return view('client.find-freelancers', compact(
            'freelancers',
            'viewType'
        ));
    }

    public function freelancerProfile($id)
    {
        $freelancer = User::with(['freelancer', 'skills'])
            ->where('role', 'freelancer')
            ->where('id', $id)
            ->firstOrFail();

        // Similar freelancers
        $similarFreelancers = User::with('freelancer')
            ->where('role', 'freelancer')
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('freelancer.freelancer-profile', compact(
            'freelancer',
            'similarFreelancers'
        ));
    }
}
