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

            $dashboardData = array_replace($dashboardData, [
                'profileViews' => $currentMonthProfileViews,
                'profileViewsChangePercent' => $this->calculateChangePercent($currentMonthProfileViews, $previousMonthProfileViews),
                'profileViewsTrend' => $this->resolveTrend($currentMonthProfileViews, $previousMonthProfileViews),
                'statsPeriodLabel' => 'from last month',
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
