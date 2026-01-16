<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\JobRole;
use App\Models\Major;
use App\Models\Skill;
use App\Models\University;
use App\Models\User;
use App\Models\UserLanguage;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);

        $freelancer = User::with([
            'freelancer',
            'skills',
            'freelancer.experiences',
            'freelancer.educations.university',
            'freelancer.educations.major',
            'freelancer.certificates',
        ])
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

        // Get active job roles
        $jobRoles = JobRole::where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('title')
            ->get();

        // Get freelancer experiences with jobRole
        $experiences = $user->freelancer->experiences()
            ->with('jobRole')
            ->orderByRaw('CASE WHEN is_current = 1 THEN 0 ELSE 1 END')
            ->orderBy('start_date', 'desc')
            ->get();

        // Get freelancer educations with university and major
        $educations = $user->freelancer->educations()
            ->with(['university', 'major'])
            ->orderByRaw('CASE WHEN is_current = 1 THEN 0 ELSE 1 END')
            ->orderBy('start_year', 'desc')
            ->get();

        $universities = University::all();
        $majors = Major::all();
        $skills = Skill::all();

        $languages = UserLanguage::where('user_id', $user->id)->get();

        // Get freelancer certificates
        $certificates = $user->freelancer->certificates;

        return view(
            'freelancer.freelancer-profile',
            compact(
                "freelancer",
                "similarFreelancers",
                "jobRoles",
                "experiences",
                "educations",
                "universities",
                "majors",
                "skills",
                "languages",
                "certificates"
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $freelancer = User::findOrFail($id);

        $freelancer->update([
            'phone' => $request->phone,
            'location' => $request->location,
            'updated_at' => now(),
        ]);

        $freelancer->freelancer()->update([
            'bio' => $request->bio,
            'hourly_rate' => $request->hourly_rate,
            'portfolio_url' => $request->portfolio_url,
            'response_time' => $request->response_time,
            'updated_at' => now(),
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $freelancer = User::findOrFail($id);
        $freelancer->delete();

        return redirect()->route('startup');
    }
}
