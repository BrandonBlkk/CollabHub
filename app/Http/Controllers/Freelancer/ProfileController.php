<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\JobRole;
use App\Models\Major;
use App\Models\ProfileView;
use App\Models\Skill;
use App\Models\University;
use App\Models\User;
use App\Models\UserLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
    public function show(Request $request, string $id)
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

        ProfileView::logView($request, $user);

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

        if (Auth::id() !== (int) $id) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to update this profile.',
                ], 403);
            }

            abort(403, 'You are not authorized to update this profile.');
        }

        $validated = $request->validate([
            'phone' => ['nullable', 'string', 'max:20'],
            'location' => ['nullable', 'string', 'max:100'],
            'bio' => ['nullable', 'string'],
            'hourly_rate' => ['nullable', 'numeric', 'min:0'],
            'portfolio_url' => ['nullable', 'url', 'max:255'],
            'response_time' => ['nullable', 'string', 'max:100'],
            'response_time_hours' => ['nullable', 'string', 'max:100'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'remove_profile_photo' => ['nullable', 'boolean'],
        ]);

        $userUpdateData = [
            'phone' => $validated['phone'] ?? $freelancer->phone,
            'location' => $validated['location'] ?? $freelancer->location,
            'updated_at' => now(),
        ];

        if ($request->hasFile('profile_photo')) {
            $newPhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');

            if ($freelancer->profile_photo_path && Storage::disk('public')->exists($freelancer->profile_photo_path)) {
                Storage::disk('public')->delete($freelancer->profile_photo_path);
            }

            $userUpdateData['profile_photo_path'] = $newPhotoPath;
        } elseif ($request->boolean('remove_profile_photo')) {
            if ($freelancer->profile_photo_path && Storage::disk('public')->exists($freelancer->profile_photo_path)) {
                Storage::disk('public')->delete($freelancer->profile_photo_path);
            }

            $userUpdateData['profile_photo_path'] = null;
        }

        $freelancer->update($userUpdateData);

        $freelancer->freelancer()->update([
            'bio' => $validated['bio'] ?? $freelancer->freelancer->bio,
            'hourly_rate' => $validated['hourly_rate'] ?? $freelancer->freelancer->hourly_rate,
            'portfolio_url' => $validated['portfolio_url'] ?? $freelancer->freelancer->portfolio_url,
            'response_time' => $validated['response_time'] ?? ($validated['response_time_hours'] ?? $freelancer->freelancer->response_time),
            'updated_at' => now(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully.',
                'name' => $freelancer->name,
                'profile_photo_url' => $freelancer->profile_photo_url,
            ]);
        }

        return back()->with('status', 'profile-updated');
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
