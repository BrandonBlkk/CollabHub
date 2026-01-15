<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\FreelancerCertification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
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
