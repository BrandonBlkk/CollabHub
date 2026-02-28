<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\FreelancerEducation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'university_id' => 'required|exists:universities,id',
            'major_id' => 'required|exists:majors,id',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_year' => 'required|integer|min:1900|max:' . date('Y'),
            'end_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'grade' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_current' => 'boolean'
        ]);

        // Handle is_current checkbox
        if ($request->has('is_current') && $request->input('is_current')) {
            $validated['is_current'] = true;
            $validated['end_year'] = null;
        } else {
            $validated['is_current'] = false;
        }

        // Handle "present" end_year
        if ($request->input('end_year') === 'present') {
            $validated['end_year'] = null;
            $validated['is_current'] = true;
        }

        // Create education through the relationship
        $education = Auth::user()->freelancer->educations()->create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'education' => $education->load(['university', 'major'])
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $education = FreelancerEducation::findOrFail($id);

        if (Auth::user()->freelancer->id !== $education->freelancer_id) {
            return response()->json([
                'success' => false,
                'message' => __('profile.freelancer.languages.errors.unauthorized')
            ]);
        }

        return response()->json($education);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $education = FreelancerEducation::findOrFail($id);

        if (Auth::user()->freelancer->id !== $education->freelancer_id) {
            return response()->json([
                'success' => false,
                'message' => __('profile.freelancer.languages.errors.unauthorized')
            ]);
        }

        $validated = $request->validate([
            'university_id' => 'required|exists:universities,id',
            'major_id' => 'required|exists:majors,id',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_year' => 'required|integer|min:1900|max:' . date('Y'),
            'end_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'grade' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Handle "present" end_year
        if ($request->input('end_year') === 'present') {
            $validated['end_year'] = null;
            $validated['is_current'] = true;
        } else {
            // Handle is_current checkbox - check if it exists in request
            if ($request->has('is_current') && $request->input('is_current') === 'on') {
                $validated['is_current'] = true;
                $validated['end_year'] = null;
            } else {
                $validated['is_current'] = false;
            }
        }

        $education->update($validated);

        return response()->json([
            'success' => true,
            'message' => __('profile.freelancer.education.messages.updated'),
            'education' => $education->load(['university', 'major'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $education = FreelancerEducation::findOrFail($id);

        if (Auth::user()->freelancer->id !== $education->freelancer_id) {
            return response()->json([
                'success' => false,
                'message' => __('profile.freelancer.languages.errors.unauthorized')
            ]);
        }

        $education->delete();

        return response()->json([
            'success' => true,
            'message' => __('profile.freelancer.education.messages.deleted')
        ]);
    }
}
