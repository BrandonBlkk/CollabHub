<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use App\Models\Job;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function index()
    {
        $totalEarnings = Freelancer::where('id', Auth::user()->freelancer->id)->pluck('total_earned')->first();
        $activeJobs = Job::where('status', 'open')->count();
        $proposalSent = Proposal::where('freelancer_id', Auth::user()->freelancer->id)->count();

        return view('dashboard', compact('totalEarnings', 'activeJobs', 'proposalSent'));
    }
}
