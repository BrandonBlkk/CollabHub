<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\PostJobRequest;
use App\Http\Requests\Client\UpdateJobRequest;
use App\Models\Category;
use App\Models\Job;
use App\Models\Proposal;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('client.my-jobs');
    }

    public function getJobs(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'nullable|in:all,open,in_progress,completed,draft,closed',
            'search' => 'nullable|string|max:255',
            'type' => 'nullable|in:fixed,hourly',
            'experience' => 'nullable|in:entry,intermediate,expert',
            'duration' => 'nullable|in:less_than_1_month,1_to_3_months,3_to_6_months,more_than_6_months',
            'sort' => 'nullable|in:newest,oldest,budget_high,budget_low',
        ]);

        $client = Auth::user()?->client;

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client account not found.',
            ], 404);
        }

        $query = $client->jobs()
            ->with('category:id,name')
            ->select([
                'id',
                'client_id',
                'title',
                'description',
                'type',
                'status',
                'budget_min',
                'budget_max',
                'duration',
                'experience_level',
                'skills_required',
                'category_id',
                'created_at',
            ])
            ->withCount('proposals');

        $status = $validated['status'] ?? 'all';
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $search = trim((string) ($validated['search'] ?? ''));
        if ($search !== '') {
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if (!empty($validated['type'])) {
            $query->where('type', $validated['type']);
        }

        if (!empty($validated['experience'])) {
            $query->where('experience_level', $validated['experience']);
        }

        if (!empty($validated['duration'])) {
            $query->where('duration', $validated['duration']);
        }

        $sort = $validated['sort'] ?? 'newest';
        switch ($sort) {
            case 'oldest':
                $query->oldest('created_at');
                break;
            case 'budget_high':
                $query->orderByRaw('COALESCE(budget_max, budget_min, 0) DESC')
                    ->orderByDesc('created_at');
                break;
            case 'budget_low':
                $query->orderByRaw('COALESCE(budget_min, budget_max, 0) ASC')
                    ->orderByDesc('created_at');
                break;
            default:
                $query->latest('created_at');
                break;
        }

        $jobs = $query->get();

        return response()->json([
            'success' => true,
            'jobs' => $this->transformJobs($jobs),
            'stats' => [
                'all' => (int) $client->jobs()->count(),
                'open' => (int) $client->jobs()->where('status', 'open')->count(),
                'in_progress' => (int) $client->jobs()->where('status', 'in_progress')->count(),
                'completed' => (int) $client->jobs()->where('status', 'completed')->count(),
                'draft' => (int) $client->jobs()->where('status', 'draft')->count(),
            ],
        ]);
    }

    public function getProposals(Request $request, string $id): JsonResponse
    {
        $client = Auth::user()?->client;

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client account not found.',
            ], 404);
        }

        $job = $client->jobs()->whereKey($id)->first();

        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => 'Job not found.',
            ], 404);
        }

        $proposals = $job->proposals()
            ->with(['freelancer.user'])
            ->latest('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'job' => [
                'id' => $job->id,
                'title' => $job->title,
                'status' => $job->status,
                'proposals_count' => $proposals->count(),
                'budget_min' => $job->budget_min,
                'budget_max' => $job->budget_max,
                'type' => $job->type,
            ],
            'proposals' => $proposals
                ->map(function (Proposal $proposal) {
                    $freelancer = $proposal->freelancer;
                    $user = $freelancer?->user;

                    return [
                        'id' => $proposal->id,
                        'proposal_text' => $proposal->proposal_text,
                        'bid_amount' => $proposal->bid_amount,
                        'estimated_timeline' => $proposal->estimated_timeline,
                        'status' => $proposal->status ?? 'pending',
                        'created_at' => optional($proposal->created_at)->toIso8601String(),
                        'freelancer' => $freelancer ? [
                            'id' => $freelancer->id,
                            'user_id' => $user?->id,
                            'name' => $user?->name,
                            'profile_photo_url' => $user?->profile_photo_url,
                            'job_title' => $freelancer->job_title,
                            'hourly_rate' => $freelancer->hourly_rate,
                            'rating' => $freelancer->rating,
                            'rating_count' => $freelancer->rating_count,
                            'job_success_rate' => $freelancer->job_success_rate,
                            'total_earned' => $freelancer->total_earned,
                            'total_hours' => $freelancer->total_hours,
                            'completed_projects' => $freelancer->completed_projects,
                            'total_projects' => $freelancer->total_projects,
                            'availability' => $freelancer->availability,
                            'years_experience' => $freelancer->years_experience,
                            'response_time' => $freelancer->response_time,
                            'languages' => $freelancer->languages,
                            'profile_url' => $user ? route('freelancer-profile', $user->id) : null,
                        ] : null,
                    ];
                })
                ->values(),
        ]);
    }

    public function updateProposalStatus(Request $request, string $jobId, string $proposalId): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:accepted,declined',
        ]);

        $client = Auth::user()?->client;

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client account not found.',
            ], 404);
        }

        $job = $client->jobs()->whereKey($jobId)->first();

        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => 'Job not found.',
            ], 404);
        }

        $proposal = $job->proposals()->whereKey($proposalId)->first();

        if (!$proposal) {
            return response()->json([
                'success' => false,
                'message' => 'Proposal not found.',
            ], 404);
        }

        $proposal->status = $validated['status'];
        $proposal->save();

        return response()->json([
            'success' => true,
            'message' => 'Proposal status updated.',
            'proposal' => [
                'id' => $proposal->id,
                'status' => $proposal->status,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('client.post-job', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostJobRequest $request)
    {
        $validated = $request->validated();

        $clientId = Auth::user()?->client?->id;
        if (!$clientId) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to determine the client account for this user.',
                ], 422);
            }

            return back()
                ->withErrors(['client' => 'Unable to determine the client account for this user.'])
                ->withInput();
        }

        $validated['client_id'] = $clientId;
        $validated['status'] = $validated['status'] ?? 'open';

        $job = Job::create($validated);

        $statusLabel = $job->status === 'draft' ? 'draft' : 'published';
        $successMessage = "Job {$statusLabel} successfully.";

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $successMessage,
                'job' => [
                    'id' => $job->id,
                    'title' => $job->title,
                    'status' => $job->status,
                    'created_at' => optional($job->created_at)->toIso8601String(),
                ],
            ], 201);
        }

        return redirect()
            ->route('my-jobs.index')
            ->with('success', $successMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = Auth::user()?->client;

        if (!$client) {
            abort(404);
        }

        $job = $client->jobs()->findOrFail($id);
        $categories = Category::orderBy('name')->get();

        return view('client.post-job', compact('categories', 'job'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobRequest $request, string $id)
    {
        $client = Auth::user()?->client;

        if (!$client) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Client account not found.',
                ], 404);
            }

            return redirect()
                ->route('my-jobs.index')
                ->withErrors(['client' => 'Client account not found.']);
        }

        $job = $client->jobs()->whereKey($id)->first();

        if (!$job) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Job not found.',
                ], 404);
            }

            return redirect()
                ->route('my-jobs.index')
                ->withErrors(['job' => 'Job not found.']);
        }

        $validated = $request->validated();
        $job->update($validated);

        $successMessage = 'Job updated successfully.';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $successMessage,
                'job' => [
                    'id' => $job->id,
                    'title' => $job->title,
                    'status' => $job->status,
                    'updated_at' => optional($job->updated_at)->toIso8601String(),
                ],
            ]);
        }

        return redirect()
            ->route('my-jobs.index')
            ->with('success', $successMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function transformJobs(Collection $jobs): array
    {
        return $jobs
            ->map(function (Job $job) {
                return [
                    'id' => $job->id,
                    'title' => $job->title,
                    'description' => $job->description,
                    'type' => $job->type,
                    'status' => $job->status,
                    'budget_min' => $job->budget_min,
                    'budget_max' => $job->budget_max,
                    'duration' => $job->duration,
                    'experience_level' => $job->experience_level,
                    'skills_required' => $job->skills_required ?? [],
                    'proposals_count' => (int) ($job->proposals_count ?? 0),
                    'category' => $job->category ? [
                        'id' => $job->category->id,
                        'name' => $job->category->name,
                    ] : null,
                    'created_at' => optional($job->created_at)->toIso8601String(),
                ];
            })
            ->values()
            ->all();
    }
}
