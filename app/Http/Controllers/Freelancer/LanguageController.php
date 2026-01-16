<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\UserLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Get the authenticated user
            $user = Auth::user();

            // Get languages for the user
            $languages = UserLanguage::where('user_id', $user->id)
                ->get();

            return response()->json([
                'success' => true,
                'languages' => $languages
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching languages: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $userId = Auth::id();
            $languages = $request->languages;

            $createdLanguages = [];

            foreach ($languages as $lang) {
                $language = UserLanguage::create([
                    'user_id' => $userId,
                    'language' => $lang['language'],
                    'proficiency' => $lang['proficiency'],
                ]);

                $createdLanguages[] = [
                    'id' => $language->id,
                    'language' => $language->language,
                    'proficiency' => $language->proficiency
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Languages added successfully',
                'languages' => $createdLanguages
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding languages: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $language = UserLanguage::findOrFail($id);

            if (Auth::id() !== $language->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action'
                ], 403);
            }

            // Validate the request
            $validated = $request->validate([
                'language' => 'required|string|max:255',
                'proficiency' => 'required|in:native,fluent,professional,intermediate,basic'
            ]);

            // Update the language
            $language->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Language updated successfully',
                'language' => $language
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating language: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $language = UserLanguage::findOrFail($id);

            if (Auth::id() !== $language->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action'
                ], 403);
            }

            $language->delete();

            return response()->json([
                'success' => true,
                'message' => 'Language deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting language: ' . $e->getMessage()
            ], 500);
        }
    }
}
