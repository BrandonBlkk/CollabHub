<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Payment;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $dashboardData = [
            'totalEarnings' => 0,
            'earningsChangePercent' => 0,
            'earningsTrend' => 'neutral',
            'activeProjects' => 0,
            'activeProjectsChangePercent' => 0,
            'activeProjectsTrend' => 'neutral',
            'proposalsSent' => 0,
            'proposalsSentChangePercent' => 0,
            'proposalsSentTrend' => 'neutral',
            'profileViews' => 0,
            'profileViewsChangePercent' => 0,
            'profileViewsTrend' => 'neutral',
            'statsPeriodLabel' => 'from last month',
            'freelancerActiveJobs' => collect(),
            'clientJobPostings' => collect(),
            'clientActiveJobs' => 0,
            'clientActiveJobsChangePercent' => 0,
            'clientActiveJobsTrend' => 'neutral',
            'clientTotalSpent' => 0,
            'clientTotalSpentChangePercent' => 0,
            'clientTotalSpentTrend' => 'neutral',
            'clientFreelancersHired' => 0,
            'clientFreelancersHiredChangePercent' => 0,
            'clientFreelancersHiredTrend' => 'neutral',
            'clientProposalsReceived' => 0,
            'clientProposalsReceivedChangePercent' => 0,
            'clientProposalsReceivedTrend' => 'neutral',
            'clientAvgProposalsPerJob' => 0,
            'clientRecentApplications' => collect(),
        ];

        if ($user->role === 'freelancer' && $user->freelancer) {
            $freelancerId = $user->freelancer->id;
            $currentMonthStart = now()->startOfMonth();
            $currentMonthEnd = now()->endOfMonth();
            $previousMonthStart = now()->subMonthNoOverflow()->startOfMonth();
            $previousMonthEnd = now()->subMonthNoOverflow()->endOfMonth();

            $currentMonthEarnings = (float) Payment::query()
                ->whereHas('contract', fn($query) => $query->where('freelancer_id', $freelancerId))
                ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
                ->sum('amount');

            $previousMonthEarnings = (float) Payment::query()
                ->whereHas('contract', fn($query) => $query->where('freelancer_id', $freelancerId))
                ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
                ->sum('amount');

            $currentMonthActiveProjects = Contract::query()
                ->where('freelancer_id', $freelancerId)
                ->whereHas('job', fn($query) => $query->whereIn('status', ['open', 'in_progress']))
                ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
                ->count();

            $previousMonthActiveProjects = Contract::query()
                ->where('freelancer_id', $freelancerId)
                ->whereHas('job', fn($query) => $query->whereIn('status', ['open', 'in_progress']))
                ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
                ->count();

            $currentMonthProposals = Proposal::query()
                ->where('freelancer_id', $freelancerId)
                ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
                ->count();

            $previousMonthProposals = Proposal::query()
                ->where('freelancer_id', $freelancerId)
                ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
                ->count();

            $currentMonthProfileViews = 0;
            $previousMonthProfileViews = 0;

            if (Schema::hasTable('profile_views')) {
                $currentMonthProfileViews = DB::table('profile_views')
                    ->where('profile_user_id', $user->id)
                    ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
                    ->count();

                $previousMonthProfileViews = DB::table('profile_views')
                    ->where('profile_user_id', $user->id)
                    ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
                    ->count();
            }

            $dashboardData = [
                'totalEarnings' => (float) $user->freelancer->total_earned,
                'earningsChangePercent' => $this->calculateChangePercent($currentMonthEarnings, $previousMonthEarnings),
                'earningsTrend' => $this->resolveTrend($currentMonthEarnings, $previousMonthEarnings),
                'activeProjects' => $currentMonthActiveProjects,
                'activeProjectsChangePercent' => $this->calculateChangePercent($currentMonthActiveProjects, $previousMonthActiveProjects),
                'activeProjectsTrend' => $this->resolveTrend($currentMonthActiveProjects, $previousMonthActiveProjects),
                'proposalsSent' => $currentMonthProposals,
                'proposalsSentChangePercent' => $this->calculateChangePercent($currentMonthProposals, $previousMonthProposals),
                'proposalsSentTrend' => $this->resolveTrend($currentMonthProposals, $previousMonthProposals),
                'profileViews' => $currentMonthProfileViews,
                'profileViewsChangePercent' => $this->calculateChangePercent($currentMonthProfileViews, $previousMonthProfileViews),
                'profileViewsTrend' => $this->resolveTrend($currentMonthProfileViews, $previousMonthProfileViews),
                'statsPeriodLabel' => 'from last month',
                'freelancerActiveJobs' => Contract::query()
                    ->where('freelancer_id', $freelancerId)
                    ->whereHas('job', fn($query) => $query->whereIn('status', ['open', 'in_progress']))
                    ->with([
                        'job:id,title,status,budget_min,budget_max,expires_at',
                    ])
                    ->latest('updated_at')
                    ->limit(5)
                    ->get(),
            ];
        }
        if ($user->role === 'client' && $user->client) {
            $currentMonthStart = now()->startOfMonth();
            $currentMonthEnd = now()->endOfMonth();
            $previousMonthStart = now()->subMonthNoOverflow()->startOfMonth();
            $previousMonthEnd = now()->subMonthNoOverflow()->endOfMonth();
            $clientId = $user->client->id;
            $currentMonthProfileViews = 0;
            $previousMonthProfileViews = 0;

            if (Schema::hasTable('profile_views')) {
                $currentMonthProfileViews = DB::table('profile_views')
                    ->where('profile_user_id', $user->id)
                    ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
                    ->count();

                $previousMonthProfileViews = DB::table('profile_views')
                    ->where('profile_user_id', $user->id)
                    ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
                    ->count();
            }

            $clientJobsQuery = $user->client->jobs();

            $clientActiveJobs = (clone $clientJobsQuery)
                ->whereIn('status', ['open', 'in_progress'])
                ->count();
            $currentMonthActiveJobs = (clone $clientJobsQuery)
                ->whereIn('status', ['open', 'in_progress'])
                ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
                ->count();
            $previousMonthActiveJobs = (clone $clientJobsQuery)
                ->whereIn('status', ['open', 'in_progress'])
                ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
                ->count();

            $clientTotalSpent = (float) Payment::query()
                ->whereHas('contract', fn($query) => $query->where('client_id', $clientId))
                ->sum('amount');
            $currentMonthSpent = (float) Payment::query()
                ->whereHas('contract', fn($query) => $query->where('client_id', $clientId))
                ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
                ->sum('amount');
            $previousMonthSpent = (float) Payment::query()
                ->whereHas('contract', fn($query) => $query->where('client_id', $clientId))
                ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
                ->sum('amount');

            $clientFreelancersHired = Contract::query()
                ->where('client_id', $clientId)
                ->distinct()
                ->count('freelancer_id');
            $currentMonthFreelancersHired = Contract::query()
                ->where('client_id', $clientId)
                ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
                ->distinct()
                ->count('freelancer_id');
            $previousMonthFreelancersHired = Contract::query()
                ->where('client_id', $clientId)
                ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
                ->distinct()
                ->count('freelancer_id');

            $clientProposalsReceived = Proposal::query()
                ->whereHas('job', fn($query) => $query->where('client_id', $clientId))
                ->count();
            $currentMonthProposalsReceived = Proposal::query()
                ->whereHas('job', fn($query) => $query->where('client_id', $clientId))
                ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
                ->count();
            $previousMonthProposalsReceived = Proposal::query()
                ->whereHas('job', fn($query) => $query->where('client_id', $clientId))
                ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
                ->count();

            $totalClientJobs = (clone $clientJobsQuery)->count();
            $clientAvgProposalsPerJob = $totalClientJobs > 0
                ? round($clientProposalsReceived / $totalClientJobs, 1)
                : 0;

            $clientJobPostings = $user->client
                ->jobs()
                ->with([
                    'category:id,name',
                ])
                ->withCount('proposals')
                ->latest('created_at')
                ->limit(5)
                ->get([
                    'id',
                    'client_id',
                    'title',
                    'description',
                    'type',
                    'status',
                    'budget_min',
                    'budget_max',
                    'category_id',
                    'created_at',
                ]);

            $clientRecentApplications = Proposal::query()
                ->whereHas('job', fn($query) => $query->where('client_id', $clientId))
                ->with([
                    'job:id,client_id,title',
                    'freelancer:id,user_id,rating,rating_count',
                    'freelancer.user:id,name,profile_photo_path',
                ])
                ->latest('created_at')
                ->limit(5)
                ->get([
                    'id',
                    'job_id',
                    'freelancer_id',
                    'proposal_text',
                    'bid_amount',
                    'estimated_timeline',
                    'created_at',
                ]);

            $dashboardData = array_replace($dashboardData, [
                'clientActiveJobs' => $clientActiveJobs,
                'clientActiveJobsChangePercent' => $this->calculateChangePercent($currentMonthActiveJobs, $previousMonthActiveJobs),
                'clientActiveJobsTrend' => $this->resolveTrend($currentMonthActiveJobs, $previousMonthActiveJobs),
                'clientTotalSpent' => $clientTotalSpent,
                'clientTotalSpentChangePercent' => $this->calculateChangePercent($currentMonthSpent, $previousMonthSpent),
                'clientTotalSpentTrend' => $this->resolveTrend($currentMonthSpent, $previousMonthSpent),
                'clientFreelancersHired' => $clientFreelancersHired,
                'clientFreelancersHiredChangePercent' => $this->calculateChangePercent($currentMonthFreelancersHired, $previousMonthFreelancersHired),
                'clientFreelancersHiredTrend' => $this->resolveTrend($currentMonthFreelancersHired, $previousMonthFreelancersHired),
                'clientProposalsReceived' => $clientProposalsReceived,
                'clientProposalsReceivedChangePercent' => $this->calculateChangePercent($currentMonthProposalsReceived, $previousMonthProposalsReceived),
                'clientProposalsReceivedTrend' => $this->resolveTrend($currentMonthProposalsReceived, $previousMonthProposalsReceived),
                'clientAvgProposalsPerJob' => $clientAvgProposalsPerJob,
                'profileViews' => $currentMonthProfileViews,
                'profileViewsChangePercent' => $this->calculateChangePercent($currentMonthProfileViews, $previousMonthProfileViews),
                'profileViewsTrend' => $this->resolveTrend($currentMonthProfileViews, $previousMonthProfileViews),
                'statsPeriodLabel' => 'from last month',
                'clientJobPostings' => $clientJobPostings,
                'clientRecentApplications' => $clientRecentApplications,
            ]);
        }

        return view('dashboard', $dashboardData);
    }

    private function calculateChangePercent(float|int $current, float|int $previous): float
    {
        if ((float) $previous === 0.0) {
            return (float) $current > 0 ? 100.0 : 0.0;
        }

        return round((((float) $current - (float) $previous) / (float) $previous) * 100, 2);
    }

    private function resolveTrend(float|int $current, float|int $previous): string
    {
        if ((float) $current > (float) $previous) {
            return 'up';
        }

        if ((float) $current < (float) $previous) {
            return 'down';
        }

        return 'neutral';
    }
}
