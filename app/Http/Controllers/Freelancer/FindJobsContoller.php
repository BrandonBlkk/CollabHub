<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\FavoriteJob;
use App\Models\InProgressJob;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FindJobsContoller extends Controller
{
    public function index()
    {
        return view('freelancer.find-jobs');
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

    // Get saved jobs
    public function getSavedJobs(Request $request)
    {
        $user = Auth::user();

        // Get all favorite job IDs for the current user
        $favoriteJobIds = FavoriteJob::where('user_id', $user->id)
            ->pluck('job_id')
            ->toArray();

        $jobs = Job::whereIn('id', $favoriteJobIds)
            ->get();

        $jobs->each(function ($job) {
            $job->is_saved = true;
        });

        return response()->json([
            'success' => true,
            'jobs' => $jobs
        ]);
    }

    // Get in progress jobs
    public function getInProgressJobs(Request $request)
    {
        $user = Auth::user();

        // Get all favorite job IDs for the current user
        $inProgressJobIds = InProgressJob::where('user_id', $user->id)
            ->pluck('job_id')
            ->toArray();

        $jobs = Job::whereIn('id', $inProgressJobIds)
            ->get();

        $jobs->each(function ($job) {
            $job->is_saved = true;
        });

        return response()->json([
            'success' => true,
            'jobs' => $jobs
        ]);
    }

    // Toggle save job
    public function toggleSaveJob(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id'
        ]);

        $user = Auth::user();
        $jobId = $request->job_id;

        $existing = FavoriteJob::where('user_id', $user->id)
            ->where('job_id', $jobId)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'success' => true,
                'message' => 'Job removed from saved jobs',
                'action' => 'removed'
            ]);
        } else {
            FavoriteJob::create([
                'user_id' => $user->id,
                'job_id' => $jobId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Job saved successfully',
                'action' => 'saved'
            ]);
        }
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
