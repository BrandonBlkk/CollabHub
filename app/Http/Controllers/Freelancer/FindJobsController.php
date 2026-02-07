<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\AppliedJob;
use App\Models\FavoriteJob;
use App\Models\Freelancer;
use App\Models\InProgressJob;
use App\Models\Job;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FindJobsController extends Controller
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

    // Get in applied jobs
    public function getAppliedJobs(Request $request)
    {
        $user = Auth::user();

        // Get all favorite job IDs for the current user
        $appliedJobIds = AppliedJob::where('user_id', $user->id)
            ->pluck('job_id')
            ->toArray();

        $jobs = Job::whereIn('id', $appliedJobIds)
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

    // Proposal
    public function storeProposal(Request $request)
    {
        // First, validate the request data
        $validated = $request->validate([
            'job_id' => 'required|integer|exists:jobs,id',
            'proposal_text' => 'required|string|min:10|max:5000',
            'bid_amount' => 'required|numeric|min:1|max:999999',
        ]);

        $user = Auth::user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $freelancer = Freelancer::where('user_id', $user->id)->first();

        // Check if freelancer exists
        if (!$freelancer) {
            return response()->json([
                'success' => false,
                'message' => 'Freelancer profile not found. Please complete your profile first.'
            ], 404);
        }

        // Check if proposal already exists for this job
        $existingProposal = $freelancer->proposals()
            ->where('job_id', $validated['job_id'])
            ->where('freelancer_id', $freelancer->id)
            ->first();

        if ($existingProposal) {
            return response()->json([
                'success' => false,
                'message' => 'You have already submitted a proposal for this job'
            ], 409);
        }

        try {
            // Create the proposal
            $proposal = $freelancer->proposals()->create([
                'job_id' => $validated['job_id'],
                'freelancer_id' => $freelancer->id,
                'proposal_text' => $validated['proposal_text'],
                'bid_amount' => $validated['bid_amount'],
            ]);

            AppliedJob::create([
                'user_id' => $user->id,
                'job_id' => $validated['job_id']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Proposal submitted successfully',
                'data' => [
                    'proposal_id' => $proposal->id,
                    'job_id' => $proposal->job_id,
                    'submitted_at' => $proposal->submitted_at
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit proposal. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function getProposal($jobId)
    {
        try {
            // Check if user is authenticated first
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $userId = Auth::id();
            $freelancerId = Freelancer::where('user_id', $userId)->value('id');

            $proposal = Proposal::where('job_id', $jobId)
                ->where('freelancer_id', $freelancerId)
                ->first();

            if (!$proposal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proposal not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'proposal' => $proposal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch proposal',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function updateProposal($proposalId)
    {
        try {
            $userId = Auth::id();
            $freelancerId = Freelancer::where('user_id', $userId)->value('id');

            $proposal = Proposal::where('id', $proposalId)
                ->where('freelancer_id', $freelancerId)
                ->first();

            if (!$proposal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proposal not found'
                ], 404);
            }

            // Validate the request
            $validated = request()->validate([
                'proposal_text' => 'required|min:100',
                'bid_amount' => 'required|numeric|min:1',
                'estimated_timeline' => 'sometimes|string'
            ]);

            // Update the proposal
            $proposal->update([
                'proposal_text' => $validated['proposal_text'],
                'bid_amount' => $validated['bid_amount'],
                'estimated_timeline' => $validated['estimated_timeline'] ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Proposal updated successfully',
                'proposal' => $proposal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update proposal'
            ], 500);
        }
    }

    public function withdrawProposal($jobId)
    {
        try {
            $userId = Auth::id();

            $appliedJob = AppliedJob::where('user_id', $userId)
                ->where('job_id', $jobId)
                ->first();

            if (!$appliedJob) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proposal not found'
                ], 404);
            }

            // Update proposal status to withdrawn
            $appliedJob->update([
                'status' => 'withdrawn',
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Proposal withdrawn successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to withdraw proposal'
            ], 500);
        }
    }

    // Get a specific job
    public function getJob($id)
    {
        try {
            $job = Job::findOrFail($id);
            $appliedJob = AppliedJob::where('user_id', Auth::user()->id)
                ->where('job_id', $job->id)
                ->first();
            $proposal_count = Proposal::where('job_id', $job->id)->count();

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
                    'proposals_count' => $proposal_count ?? 0,
                    'created_at' => $job->created_at,
                    'expires_at' => $job->expires_at,
                    'posted_at' => $job->posted_at,
                    'applied_status' => $appliedJob ? $appliedJob->status : null
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
