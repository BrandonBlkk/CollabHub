<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\PostJobRequest;
use App\Models\Category;
use App\Models\Job;
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
            ->withCount('proposals')
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
            ]);

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
            return back()
                ->withErrors(['client' => 'Unable to determine the client account for this user.'])
                ->withInput();
        }

        $validated['client_id'] = $clientId;

        Job::create($validated);

        return redirect()->route('my-jobs.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
