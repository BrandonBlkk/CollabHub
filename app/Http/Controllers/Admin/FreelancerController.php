<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FreelancerController extends Controller
{
    /**
     * Display a listing of the freelancers.
     */
    public function index()
    {
        $freelancers = User::where('role', 'freelancer')->get();
        $totalFreelancers = $freelancers->count();
        $activeFreelancers = $freelancers->where('status', 'active')->count();
        $availableFreelancers = $freelancers->where('status', 'available')->count();

        return view('admin.manage-freelancers', [
            'data' => [
                'freelancers' => $freelancers,
                'totalFreelancers' => $totalFreelancers,
                'activeFreelancers' => $activeFreelancers,
                'availableFreelancers' => $availableFreelancers
            ]
        ]);
    }
}
