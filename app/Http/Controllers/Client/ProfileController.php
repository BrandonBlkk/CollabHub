<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\UpdateProfileRequest;
use App\Models\ProfileView;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country_code' => $request->country_code,
            'country' => $request->country,
            'location' => $request->location,
            'timezone' => $request->timezone,
            'updated_at' => now(),
        ]);

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
