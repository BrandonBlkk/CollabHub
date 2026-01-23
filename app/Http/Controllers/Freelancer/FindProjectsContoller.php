<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class FindProjectsContoller extends Controller
{
    public function index()
    {
        return view('freelancer.find-projects');
    }

    // Get all jobs
    public function getJobs(Request $request)
    {
        $jobs = Job::all();

        return response()->json(
            [
                'success' => true,
                'jobs' => $jobs
            ]
        );
    }

    // Get a specific job
    public function getJob($id)
    {
        try {
            $job = Job::findOrFail($id);

            return response()->json([
                'success' => true,
                'job' => [
                    'id' => $job->id,
                    'title' => $job->title,
                    'description' => $job->description,
                    'type' => $job->type,
                    'status' => $job->status,
                    'budget_min' => $job->budget_min,
                    'budget_max' => $job->budget_max,
                    'duration' => $job->duration,
                    'experience_level' => $job->experience_level,
                    'skills_required' => $job->skills_required,
                    'proposals_count' => $job->proposals_count ?? 0,
                    'created_at' => $job->created_at,
                    'expires_at' => $job->expires_at,
                    'posted_at' => $job->posted_at
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Job not found'
            ], 404);
        }
    }
}
