<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Freelancer;
use App\Models\Skill;

class FreelancerController extends Controller
{
    /**
     * Display a listing of the freelancers.
     */
    public function index()
    {
        $freelancers = Freelancer::with('user')
            ->whereHas('user', fn($q) => $q->where('role', 'freelancer'))
            ->get();

        $topEarners = Freelancer::with('user')
            ->whereHas('user', fn($q) => $q->where('role', 'freelancer'))
            ->where('total_earned', '>', 0)
            ->orderByDesc('total_earned')
            ->take(4)
            ->get();

        $totalHourlyRate = Freelancer::where('hourly_rate', '>', 0)->sum('hourly_rate');
        $totalEarned = Freelancer::where('total_earned', '>', 0)->sum('total_earned');

        $totalSkills = Skill::count();
        $totalFreelancers = $freelancers->count();
        $activeFreelancers = $freelancers->where('status', 'active')->count();
        $availableFreelancers = $freelancers->where('status', 'available')->count();

        return view('admin.manage-freelancers', [
            'data' => [
                'freelancers' => $freelancers,
                'topEarners' => $topEarners,
                'totalHourlyRate' => $totalHourlyRate,
                'totalEarned' => $totalEarned,
                'totalSkills' => $totalSkills,
                'totalFreelancers' => $totalFreelancers,
                'activeFreelancers' => $activeFreelancers,
                'availableFreelancers' => $availableFreelancers
            ]
        ]);
    }
}
