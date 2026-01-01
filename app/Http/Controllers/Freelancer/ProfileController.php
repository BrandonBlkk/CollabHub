<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\User;
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

        return view('freelancer.freelancer-profile', compact("freelancer", "similarFreelancers"));
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
