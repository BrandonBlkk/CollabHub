<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\FreelancerCertification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

        $certificates = $user->freelancer->certificates;

        return view('freelancer.freelancer-profile', compact("freelancer", "similarFreelancers", "certificates"));
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

        if (Auth::user()->id !== $certicate->freelancer_id) {
            return back();
        }

        return response()->json($certicate);
    }

    public function updateCertificate(Request $request, $id)
    {
        $certificate = FreelancerCertification::findOrFail($id);

        // Check authorization
        if (Auth::user()->id !== $certificate->freelancer_id) {
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
        if (Auth::user()->id !== $certificate->freelancer_id) {
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
