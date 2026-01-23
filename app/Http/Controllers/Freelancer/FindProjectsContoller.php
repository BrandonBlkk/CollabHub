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
}
