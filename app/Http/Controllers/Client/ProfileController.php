<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\UpdateProfileRequest;
use App\Models\FavoriteJob;
use App\Models\ProfileView;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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

        ProfileView::logView($request, $user);

        return view('client.profile');
    }

    public function publicShow(Request $request, string $id)
    {
        $clientUser = User::with(['client'])
            ->where('role', 'client')
            ->findOrFail($id);

        ProfileView::logView($request, $clientUser);

        $clientJobs = $clientUser->jobs()
            ->withCount(['proposals', 'views'])
            ->orderByDesc('posted_at')
            ->get();

        $peopleAlsoViewed = collect();
        $maxSuggestions = 5;
        if (Auth::check()) {
            $recentlyViewedClientIds = ProfileView::query()
                ->where('viewer_id', Auth::id())
                ->where('profile_user_id', '!=', $clientUser->id)
                ->latest('created_at')
                ->pluck('profile_user_id')
                ->unique()
                ->take($maxSuggestions)
                ->values();

            if ($recentlyViewedClientIds->isNotEmpty()) {
                $recentlyViewedClients = User::query()
                    ->with('client')
                    ->withCount(['jobs', 'profileViews'])
                    ->where('role', 'client')
                    ->whereIn('id', $recentlyViewedClientIds)
                    ->get()
                    ->keyBy('id');

                $peopleAlsoViewed = $recentlyViewedClientIds
                    ->map(fn($id) => $recentlyViewedClients->get($id))
                    ->filter()
                    ->values();
            }
        }

        if ($peopleAlsoViewed->count() < $maxSuggestions) {
            $excludeIds = $peopleAlsoViewed->pluck('id')
                ->push($clientUser->id)
                ->unique()
                ->values();

            $fillClients = User::query()
                ->with('client')
                ->withCount(['jobs', 'profileViews'])
                ->where('role', 'client')
                ->whereNotIn('id', $excludeIds)
                ->orderByDesc('profile_views_count')
                ->orderByDesc('jobs_count')
                ->limit($maxSuggestions - $peopleAlsoViewed->count())
                ->get();

            $peopleAlsoViewed = $peopleAlsoViewed
                ->concat($fillClients)
                ->take($maxSuggestions)
                ->values();
        }

        $savedJobIds = FavoriteJob::where('user_id', Auth::id())
            ->whereIn('job_id', $clientJobs->pluck('id'))
            ->pluck('job_id')
            ->all();

        $savedLookup = array_flip($savedJobIds);
        $clientJobs->each(function ($job) use ($savedLookup) {
            $job->is_saved = isset($savedLookup[$job->id]);
        });

        $clientStats = [
            'total_jobs' => $clientJobs->count(),
            'open_jobs' => $clientJobs->where('status', 'open')->count(),
            'in_progress_jobs' => $clientJobs->where('status', 'in_progress')->count(),
            'completed_jobs' => $clientJobs->where('status', 'completed')->count(),
        ];

        $modalJobsData = $clientJobs->map(function ($job) {
            return [
                'id' => $job->id,
                'title' => $job->title,
                'description' => $job->description,
                'status' => $job->status,
                'created_at' => optional($job->created_at)->toIso8601String(),
                'budget_display' => $job->budget_display,
                'type' => $job->type,
                'duration' => $job->duration,
                'experience_level' => $job->experience_level,
                'skills_required' => is_array($job->skills_required) ? $job->skills_required : [],
            ];
        })->values()->all();

        return view('client.public-profile', compact('clientUser', 'clientJobs', 'clientStats', 'modalJobsData', 'peopleAlsoViewed'));
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
    public function update(UpdateProfileRequest $request, string $id)
    {
        // Check if the user is authorized to update their profile
        if (Auth::id() != $id) {
            $response = [
                'status' => 'error',
                'message' => 'You are not authorized to update this profile.',
            ];
            return response()->json($response, 403);
        }

        $user = User::findOrFail($id);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country_code' => $request->country_code,
            'country' => $request->country,
            'location' => $request->location,
            'timezone' => $request->timezone,
            'updated_at' => now(),
        ];

        if ($request->hasFile('profile_photo')) {
            $newPhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');

            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $updateData['profile_photo_path'] = $newPhotoPath;
        } elseif ($request->boolean('remove_profile_photo')) {
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $updateData['profile_photo_path'] = null;
        }

        $user->update($updateData);

        // Check if the user is a client
        if ($user->role === 'client') {
            $user->client()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'company' => $request->company,
                    'website' => $request->website,
                    'updated_at' => now(),
                ]
            );
        }

        $response = [
            'status' => 'success',
            'message' => 'Profile updated successfully.',
            'name' => $user->name,
            'email' => $user->email,
            'profile_photo_url' => $user->profile_photo_url,
        ];

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(
            [
                'success' => true,
                'message' => 'Profile deleted successfully'
            ]
        );
    }
}
