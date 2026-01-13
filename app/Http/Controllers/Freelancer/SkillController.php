<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    public function searchSkill(Request $request)
    {
        $user = Auth::user();
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $skills = Skill::where('name', 'LIKE', '%' . $query . '%')
            ->whereNotIn('id', $user->skills->pluck('id'))
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($skills);
    }

    public function relatedSkills($skillId)
    {
        $skill = Skill::find($skillId);

        if (!$skill) {
            return response()->json([]);
        }

        $relatedSkills = Skill::where('category_id', $skill->category_id)
            ->where('id', '!=', $skillId)
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($relatedSkills);
    }

    public function storeSkills(Request $request)
    {
        try {
            $request->validate([
                'skill_ids' => 'array',
                'skill_ids.*' => 'exists:skills,id'
            ]);

            $user = Auth::user();

            // Sync the skills through user relationship
            $user->skills()->sync($request->skill_ids);

            return response()->json([
                'success' => true,
                'message' => 'Skills updated successfully',
                'skills' => $user->skills->pluck('name', 'id')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating skills: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeSkill(Request $request, $skillId)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        $deleted = $user->skills()
            ->wherePivot('skill_id', $skillId)
            ->detach($skillId);

        if ($deleted === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Skill not found or already removed for this user',
                'remaining_skills' => $user->skills->pluck('name', 'id')->toArray()
            ], 404);
        }

        // Force reload fresh data from database
        $user->load('skills');

        return response()->json([
            'success' => true,
            'message' => 'Skill removed successfully',
            'remaining_skills' => $user->skills
                ->pluck('name', 'id')
                ->toArray()
        ]);
    }
}
