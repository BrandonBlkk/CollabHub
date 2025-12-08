<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::where('role', 'client')->latest()->get();
        $totalClients = User::where('role', 'client')->count() ?: 1;

        $activeClients = User::where('role', 'client')->where('status', 'active')->count();
        $inactiveClients = User::where('role', 'client')->where('status', 'inactive')->count();
        $suspendedClients = User::where('role', 'client')->where('status', 'suspended')->count();

        $recentClients = User::where('role', 'client')->latest()->take(4)->get();

        $data = [
            'clients' => $clients,
            'totalClients' => $totalClients,
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
