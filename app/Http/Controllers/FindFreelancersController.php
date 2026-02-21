<?php

namespace App\Http\Controllers;

use App\Models\JobRole;
use App\Models\Major;
use App\Models\ProfileView;
use App\Models\Skill;
use App\Models\University;
use App\Models\User;
use App\Models\UserLanguage;
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

        // Get freelancers visible to this client based on privacy settings
        $freelancers = User::with(['freelancer', 'skills', 'reviewsReceived', 'settings'])
            ->where('role', 'freelancer')
            ->get()
            ->filter(fn($freelancer) => $freelancer->canBeViewedBy($user))
            ->values();

        // Default view type
        $viewType = 'grid';

        return view('client.find-freelancers', compact(
            'freelancers',
            'viewType'
        ));
    }

    public function freelancerProfile(Request $request, $id)
    {
        $viewer = $request->user();

        $freelancer = User::with(['freelancer', 'skills', 'settings'])
            ->where('role', 'freelancer')
            ->where('id', $id)
            ->firstOrFail();

        if (!$freelancer->canBeViewedBy($viewer)) {
            abort(403, 'This profile is not available.');
        }

        ProfileView::logView($request, $freelancer);

        // Similar freelancers
        $similarFreelancers = User::with(['freelancer', 'settings'])
            ->where('role', 'freelancer')
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->limit(20)
            ->get()
            ->filter(fn($person) => $person->canBeViewedBy($viewer))
            ->take(4)
            ->values();

        // Get active job roles
        $jobRoles = JobRole::where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('title')
            ->get();

        $universities = University::all();
        $majors = Major::all();
        $skills = Skill::all();
        $languages = UserLanguage::where('user_id', $freelancer->id)->get();

        // Get freelancer experiences with jobRole, ordered by present first, then by start_date descending
        $experiences = $freelancer->freelancer->experiences()
            ->with('jobRole')
            ->orderByRaw('CASE WHEN is_current = 1 THEN 0 ELSE 1 END') // Present experiences first
            ->orderBy('start_date', 'desc') // Then by start date descending
            ->get();

        // Get freelancer educations with university and major
        $educations = $freelancer->freelancer->educations()
            ->with(['university', 'major'])
            ->orderByRaw('CASE WHEN is_current = 1 THEN 0 ELSE 1 END')
            ->orderBy('start_year', 'desc')
            ->get();

        // Get freelancer certificates
        $certificates = $freelancer->freelancer->certificates;

        $showOnlineStatus = $freelancer->showsOnlineStatusTo($viewer);
        $isOnline = $showOnlineStatus ? $freelancer->isCurrentlyOnline() : false;

        return view('freelancer.freelancer-profile', compact(
            'freelancer',
            'similarFreelancers',
            'jobRoles',
            'universities',
            'majors',
            'skills',
            'languages',
            'experiences',
            'educations',
            'certificates',
            'showOnlineStatus',
            'isOnline'
        ));
    }
}
