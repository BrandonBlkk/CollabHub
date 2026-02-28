<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\FreelancerExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExperienceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $experience = FreelancerExperience::create([
            'freelancer_id' => $request->freelancer_id,
            'job_role_id' => $request->job_role_id,
            'company' => $request->company,
            'location' => $request->location,
            'description' => $request->description,
            'is_current' => $request->is_current ?? 0,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'employment_type' => $request->employment_type
        ]);

        // Load the job role relationship
        $experience->load('jobRole');

        return response()->json([
            'success' => true,
            'experience' => [
                'id' => $experience->id,
                'job_role_id' => $experience->job_role_id,
                'job_role_title' => $experience->jobRole ? $experience->jobRole->title : __('profile.freelancer.experience.job_role_not_found'),
                'job_role' => $experience->jobRole,
                'company' => $experience->company,
                'location' => $experience->location,
                'description' => $experience->description,
                'is_current' => $experience->is_current,
                'start_date' => $experience->start_date,
                'end_date' => $experience->end_date,
                'employment_type' => $experience->employment_type,
            ],
            'message' => __('profile.freelancer.experience.messages.added')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $experience = FreelancerExperience::findOrFail($id);

        if (Auth::user()->freelancer->id !== $experience->freelancer_id) {
            return response()->json([
                'success' => false,
                'message' => __('profile.freelancer.languages.errors.unauthorized')
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $experience,
            'id' => $experience->id,
            'job_role_id' => $experience->job_role_id,
            'company' => $experience->company,
            'description' => $experience->description,
            'employment_type' => $experience->employment_type,
            'location' => $experience->location,
            'start_date' => $experience->start_date,
            'end_date' => $experience->end_date,
            'is_current' => $experience->is_current
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $experience = FreelancerExperience::findOrFail($id);

            // Check authorization
            $freelancer = $experience->freelancer;
            if (!$freelancer || Auth::id() !== $freelancer->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => __('profile.freelancer.languages.errors.unauthorized')
                ], 403);
            }

            // Convert is_current to proper boolean
            $isCurrent = filter_var($request->is_current, FILTER_VALIDATE_BOOLEAN);
            $request->merge(['is_current' => $isCurrent]);

            // Validate
            $validator = Validator::make($request->all(), [
                'job_role_id' => 'required|exists:job_roles,id',
                'company' => 'required|string|max:255',
                'location' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'is_current' => 'required|boolean',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after:start_date',
                'employment_type' => 'nullable|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => __('profile.freelancer.common.validation_failed'),
                    'errors' => $validator->errors()
                ], 422);
            }

            // Handle current job logic
            $validated = $validator->validated();
            if ($validated['is_current']) {
                $validated['end_date'] = null;
            }

            // Update the experience
            $experience->update($validated);

            // Load the job role for response
            $experience->load('jobRole');

            return response()->json([
                'success' => true,
                'message' => __('profile.freelancer.experience.messages.updated'),
                'experience' => [
                    'id' => $experience->id,
                    'job_role_id' => $experience->job_role_id,
                    'job_role_title' => $experience->jobRole ? $experience->jobRole->title : __('profile.freelancer.experience.job_role_not_found'),
                    'company' => $experience->company,
                    'location' => $experience->location,
                    'description' => $experience->description,
                    'is_current' => (bool)$experience->is_current,
                    'start_date' => $experience->start_date,
                    'end_date' => $experience->end_date,
                    'employment_type' => $experience->employment_type,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('profile.freelancer.common.server_error') . ': ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $experience = FreelancerExperience::findOrFail($id);

        if (Auth::user()->freelancer->id !== $experience->freelancer_id) {
            return response()->json([
                'success' => false,
                'message' => __('profile.freelancer.languages.errors.unauthorized')
            ], 403);
        }

        $experience->delete();

        return response()->json([
            'success' => true,
            'message' => __('profile.freelancer.experience.messages.deleted')
        ]);
    }
}
