<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Job;
use App\Models\User;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('user')->whereHas('user', fn($q) => $q->where('role', 'client'))->get();
        $totalClients = User::where('role', 'client')->count() ?: 1;

        $activeClients = User::where('role', 'client')->where('status', 'active')->count();
        $inactiveClients = User::where('role', 'client')->where('status', 'inactive')->count();
        $suspendedClients = User::where('role', 'client')->where('status', 'suspended')->count();

        $topClients = Client::with('user')
            ->whereHas('user', fn($q) => $q->where('role', 'client'))
            ->where('total_spent', '>', 0)
            ->orderByDesc('total_spent')
            ->take(4)
            ->get();

        $recentClients = Client::with('user')
            ->whereHas('user', fn($q) => $q->where('role', 'client'))
            ->orderByDesc('created_at')
            ->take(4)
            ->get();

        $totalActiveJobs = Job::active()->count();
        $totalSpent = Client::with('user')
            ->whereHas('user', fn($q) => $q->where('role', 'client'))
            ->where('total_spent', '>', 0)
            ->sum('total_spent');

        $data = [
            'clients' => $clients,
            'totalClients' => $totalClients,
            'totalSpent' => $totalSpent,
            'topClients' => $topClients,
            'totalActiveJobs' => $totalActiveJobs,
            'recentClients' => $recentClients,
            'activeClients' => $activeClients,
            'inactiveClients' => $inactiveClients,
            'suspendedClients' => $suspendedClients,
            'activeClientsPercentage' => $totalClients > 0 ? ($activeClients / $totalClients) * 100 : 0,
            'inactiveClientsPercentage' => $totalClients > 0 ? ($inactiveClients / $totalClients) * 100 : 0,
            'suspendedClientsPercentage' => $totalClients > 0 ? ($suspendedClients / $totalClients) * 100 : 0,
        ];

        return view('admin.manage-clients', compact('data'));
    }
}
