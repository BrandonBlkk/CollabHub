<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\FreelancerCertification;
use App\Models\FreelancerEducation;
use App\Models\FreelancerExperience;
use App\Models\JobRole;
use App\Models\Major;
use App\Models\Skill;
use App\Models\University;
use App\Models\User;
use App\Models\UserLanguage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    // Experiences
    public function storeExperience(Request $request)
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
                'job_role_title' => $experience->jobRole ? $experience->jobRole->title : 'Job Role Not Found',
                'job_role' => $experience->jobRole,
                'company' => $experience->company,
                'location' => $experience->location,
                'description' => $experience->description,
                'is_current' => $experience->is_current,
                'start_date' => $experience->start_date,
                'end_date' => $experience->end_date,
                'employment_type' => $experience->employment_type,
            ],
            'message' => 'Experience added successfully!'
        ]);
    }

    public function editExperience($id)
    {
        $experience = FreelancerExperience::findOrFail($id);

        if (Auth::user()->freelancer->id !== $experience->freelancer_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
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

    public function updateExperience(Request $request, $id)
    {
        try {
            $experience = FreelancerExperience::findOrFail($id);

            // Check authorization
            $freelancer = $experience->freelancer;
            if (!$freelancer || Auth::id() !== $freelancer->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action'
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
                    'message' => 'Validation failed',
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
                'message' => 'Experience updated successfully',
                'experience' => [
                    'id' => $experience->id,
                    'job_role_id' => $experience->job_role_id,
                    'job_role_title' => $experience->jobRole ? $experience->jobRole->title : 'Unknown',
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
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteExperience($id)
    {
        $experience = FreelancerExperience::findOrFail($id);

        if (Auth::user()->freelancer->id !== $experience->freelancer_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        $experience->delete();

        return response()->json([
            'success' => true,
            'message' => 'Experience deleted successfully'
        ]);
    }

    public function storeEducation(Request $request)
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

        return redirect()->back()->with('success', 'Education added successfully');
    }

    public function editEducation($id)
    {
        $education = FreelancerEducation::findOrFail($id);

        if (Auth::user()->freelancer->id !== $education->freelancer_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ]);
        }

        return response()->json($education);
    }

    public function updateEducation(Request $request, $id)
    {
        $education = FreelancerEducation::findOrFail($id);

        if (Auth::user()->freelancer->id !== $education->freelancer_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
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
            'message' => 'Education updated successfully',
            'education' => $education->load(['university', 'major'])
        ]);
    }

    public function deleteEducation($id)
    {
        $education = FreelancerEducation::findOrFail($id);

        if (Auth::user()->freelancer->id !== $education->freelancer_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ]);
        }

        $education->delete();

        return response()->json([
            'success' => true,
            'message' => 'Education deleted successfully'
        ]);
    }

    // Certifications
    public function storeCertificate(Request $request)
    {
        $certificate = FreelancerCertification::create([
            'name' => $request->name,
            'freelancer_id' => $request->freelancer_id,
            'issuer' => $request->issuer,
            'issued_year' => $request->issued_year,
            'expiry_year' => $request->expiry_year,
            'certificate_url' => $request->certificate_url,
        ]);

        return response()->json([
            'success' => true,
            'certificate' => [
                'id' => $certificate->id,
                'name' => $certificate->name,
                'issuer' => $certificate->issuer,
                'issued_year' => $certificate->issued_year,
                'expiry_year' => $certificate->expiry_year,
                'certificate_url' => $certificate->certificate_url,
            ],
            'message' => 'Certification added successfully!'
        ]);
    }

    public function editCertificate($id)
    {
        $certicate = FreelancerCertification::findOrFail($id);

        if (Auth::user()->freelancer->id !== $certicate->freelancer_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ]);
        }

        return response()->json($certicate);
    }

    public function updateCertificate(Request $request, $id)
    {
        $certificate = FreelancerCertification::findOrFail($id);

        // Check authorization
        if (Auth::user()->freelancer->id !== $certificate->freelancer_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'certificate_url' => 'nullable|url',
            'issued_year' => 'nullable|integer|min:1990|max:' . date('Y'),
            'expiry_year' => 'nullable|integer|min:' . date('Y'),
        ]);

        $certificate->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Certification updated successfully',
            'certificate' => $certificate
        ]);
    }

    public function deleteCertificate($id)
    {
        $certificate = FreelancerCertification::findOrFail($id);

        // Check authorization
        if (Auth::user()->freelancer->id !== $certificate->freelancer_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        $certificate->delete();

        return response()->json([
            'success' => true,
            'message' => 'Certification deleted successfully'
        ]);
    }
}
