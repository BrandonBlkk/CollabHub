@extends('layouts.admin')

@section('title', 'Client Management')
@section('description', 'Manage all registered clients and their information')

@section('content')
    <!-- Dashboard Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Clients</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $data['totalClients'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-600 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    8.5%
                </span>
                <span class="text-gray-500 ml-2">from last month</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Active Projects</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $data['totalActiveJobs'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-600 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    12.3%
                </span>
                <span class="text-gray-500 ml-2">from last month</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Spent</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">${{ $data['totalSpent'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-600 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    15.7%
                </span>
                <span class="text-gray-500 ml-2">from last month</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Avg. Rating</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">4.6</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-600 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    2.3%
                </span>
                <span class="text-gray-500 ml-2">from last month</span>
            </div>
        </div>
    </div>

    <!-- Client Management Section -->
    <div x-data="{ activeFilter: 'all', searchTerm: '', selectedClients: [] }" class="bg-white rounded-2xl shadow-sm border border-gray-200">
        <!-- Header and Filters -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Manage Clients</h3>
                    <p class="text-gray-600 text-sm mt-1">View, edit, and manage all client accounts</p>
                </div>
                <button
                    class="px-4 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-50 transition flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                        </path>
                    </svg>
                    <span>Export</span>
                </button>
            </div>

            <!-- Filter Tabs and Search -->
            <div class="flex flex-col md:flex-row gap-4 mt-6">
                <!-- Filter Tabs -->
                <div class="flex flex-wrap gap-2">
                    <button @click="activeFilter = 'all'"
                        :class="activeFilter === 'all' ? 'bg-gray-800 text-white' :
                            'bg-gray-100 text-gray-800 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg transition text-sm">
                        All Clients
                    </button>
                    <button @click="activeFilter = 'active'"
                        :class="activeFilter === 'active' ? 'bg-green-600 text-white' :
                            'bg-gray-100 text-gray-800 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg transition text-sm">
                        Active
                    </button>
                    <button @click="activeFilter = 'inactive'"
                        :class="activeFilter === 'inactive' ? 'bg-gray-600 text-white' :
                            'bg-gray-100 text-gray-800 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg transition text-sm">
                        Inactive
                    </button>
                    <button @click="activeFilter = 'premium'"
                        :class="activeFilter === 'premium' ? 'bg-amber-500 text-white' :
                            'bg-gray-100 text-gray-800 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg transition text-sm">
                        Premium
                    </button>
                    <button @click="activeFilter = 'suspended'"
                        :class="activeFilter === 'suspended' ? 'bg-red-600 text-white' :
                            'bg-gray-100 text-gray-800 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg transition text-sm">
                        Suspended
                    </button>
                </div>

                <!-- Search Box -->
                <div class="flex-1">
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input x-model="searchTerm" type="text"
                            placeholder="Search clients by name, email, or company..."
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                    </div>
                </div>
            </div>
        </div>

        <!-- Clients Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center gap-2">
                                <input type="checkbox"
                                    @change="selectedClients = selectedClients.length === clients.length ? [] : clients.map(c => c.id)"
                                    class="rounded border-gray-300">
                                <span>Client</span>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Company
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total Spent
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Active Projects
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Rating
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Joined Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Client -->
                    @foreach ($data['clients'] as $client)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" value="1" x-model="selectedClients"
                                            class="rounded border-gray-300">
                                        @if ($client->user->profile_photo_path)
                                            <div class="w- h-8 rounded-full">
                                                <img src="{{ $client->user->profile_photo_url }}" alt="Profile Image"
                                                    class="w-full h-full object-cover rounded-full">
                                            </div>
                                        @else
                                            <div
                                                class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-400 to-teal-400 flex items-center justify-center">
                                                <span
                                                    class="text-white font-bold text-sm">{{ Str::ucfirst(substr($client->user->name, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $client->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $client->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $client->company ?? 'Individual' }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $client->user->location ?? 'Not Specified' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">${{ $client->total_spent }}
                                </div>
                                <div class="text-xs text-gray-500">{{ $client->all_jobs }} projects</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">{{ $client->active_jobs }}
                                    projects</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-gray-900">4.8</span>
                                    <span class="ml-1 text-xs text-gray-500">(24)</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">{{ Str::ucfirst($client->user->status) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $client->user->created_at->format('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <button class="text-blue-600 hover:text-blue-900 transition p-1" title="View Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button class="text-blue-600 hover:text-blue-900 transition p-1" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button class="text-red-600 hover:text-red-900 transition p-1" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200">
            <div class="text-sm text-gray-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium">5</span>
                of <span class="font-medium">1,248</span> clients
            </div>
            <div class="flex items-center gap-2">
                <button
                    class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">1</button>
                <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">2</button>
                <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">3</button>
                <span class="px-2 text-gray-500">...</span>
                <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">25</button>
                <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Client Insights -->
    <div class="mt-3 grid grid-cols-1 lg:grid-cols-3 gap-3">
        <!-- Top Clients by Spending -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Top Clients by Spending</h3>
                    <p class="text-gray-600 text-sm mt-1">Highest total project expenditure</p>
                </div>
                <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    View All
                </button>
            </div>

            <div class="space-y-4">
                <!-- Client -->
                @forelse($data['topClients'] as $client)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            @if ($client->user->profile_photo_path)
                                <div class="w-8 h-8 rounded-full">
                                    <img src="{{ $client->user->profile_photo_url }}" alt="Profile Image"
                                        class="w-full h-full object-cover rounded-full">
                                </div>
                            @else
                                <div
                                    class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-400 to-teal-400 flex items-center justify-center select-none">
                                    <span class="text-white font-bold text-sm">
                                        {{ strtoupper(substr($client->user->name ?? 'U', 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $client->user->name ?? 'Unknown Client' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $client->company ?? 'Individual' }}
                                </p>
                            </div>
                        </div>

                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">
                                ${{ number_format($client->total_spent ?? 0, 2) }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $client->all_jobs ?? 0 }}
                                {{ Str::plural('project', $client->all_jobs ?? 0) }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 text-gray-500">
                        <p class="text-sm">No clients have spent money yet.</p>
                        <p class="text-xs mt-1">Top spenders will appear here once payments are made.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Client Status Distribution -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-900">Client Status Distribution</h3>
                <p class="text-gray-600 text-sm mt-1">Overview of client account statuses</p>
            </div>

            <div class="space-y-4">
                <!-- Status Item -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-900">Active</span>
                        <span class="text-sm text-gray-900">{{ $data['activeClientsPercentage'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full"
                            style="width: {{ $data['activeClientsPercentage'] }}%"></div>
                    </div>
                </div>

                <!-- Status Item -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-900">Inactive</span>
                        <span class="text-sm text-gray-900">{{ $data['inactiveClientsPercentage'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gray-600 h-2 rounded-full"
                            style="width: {{ $data['inactiveClientsPercentage'] }}%"></div>
                    </div>
                </div>

                <!-- Status Item -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-900">Suspended</span>
                        <span class="text-sm text-gray-900">{{ $data['suspendedClientsPercentage'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-red-600 h-2 rounded-full"
                            style="width: {{ $data['suspendedClientsPercentage'] }}%"></div>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-900">{{ $data['activeClients'] }}</p>
                        <p class="text-xs text-gray-500">Active Clients</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $data['activeClientsPercentage'] }}%
                        </p>
                        <p class="text-xs text-gray-500">Active Rate</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Client Registrations -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Recent Registrations</h3>
                    <p class="text-gray-600 text-sm mt-1">New clients joined this week</p>
                </div>
                <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    View All
                </button>
            </div>

            <div class="space-y-6">
                <div class="flex flex-col items-center justify-center min-h-48">
                    @if ($data['recentClients'] && $data['recentClients']->count() > 0)
                        <!-- Recent Clients List -->
                        @foreach ($data['recentClients'] as $client)
                            <div
                                class="flex items-center justify-between w-full max-w-md p-4 bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow transition">
                                <div class="flex items-center gap-3">
                                    @if ($client->user->profile_photo_path)
                                        <div class="w-10 h-10 rounded-full">
                                            <img src="{{ $client->user->profile_photo_url }}" alt="Profile Image"
                                                class="w-full h-full object-cover rounded-full">
                                        </div>
                                    @else
                                        <div
                                            class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-400 to-purple-400 flex items-center justify-center flex-shrink-0 select-none">
                                            <span class="text-white font-bold text-sm">
                                                {{ strtoupper(substr($client->user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $client->user->name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $client->company ?? 'Individual' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">
                                        {{ $client->created_at->diffForHumans() }}</p>
                                    <p class="text-xs font-medium text-green-600">
                                        {{ ucfirst($client->user->status) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                        <!-- Total Count -->
                        <div class="w-full max-w-md mt-6 pt-6 border-t border-gray-200">
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Total new clients this week:</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">
                                    {{ $data['recentClients']->count() }}
                                </p>
                            </div>
                        </div>
                    @else
                        <!-- Perfectly Centered "No clients" Message -->
                        <div class="text-center py-12">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <p class="text-lg font-medium text-gray-900">No recent clients yet</p>
                            <p class="text-sm text-gray-500 mt-1">New registrations will appear here</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('clientManagement', () => ({
                clients: [{
                        id: 1,
                        name: 'John Smith',
                        email: 'john@techcorp.com',
                        company: 'TechCorp Inc.',
                        status: 'active'
                    },
                    {
                        id: 2,
                        name: 'Sarah Johnson',
                        email: 'sarah@designstudio.com',
                        company: 'Creative Studio',
                        status: 'premium'
                    },
                    {
                        id: 3,
                        name: 'Robert Chen',
                        email: 'robert@startupx.com',
                        company: 'StartupX',
                        status: 'active'
                    },
                    {
                        id: 4,
                        name: 'Maria Garcia',
                        email: 'maria@retailco.com',
                        company: 'RetailCo International',
                        status: 'premium'
                    },
                    {
                        id: 5,
                        name: 'Thomas Wilson',
                        email: 'thomas@oldcorp.com',
                        company: 'Traditional Corp',
                        status: 'suspended'
                    }
                ],
                selectedClients: [],
                searchTerm: '',
                activeFilter: 'all'
            }));
        });

        // Simple confirmation for delete actions
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('button').forEach(button => {
                const svg = button.querySelector('svg');
                if (svg && svg.innerHTML.includes('M19 7l-.867 12.142A2')) {
                    button.addEventListener('click', function(e) {
                        if (!confirm(
                                'Are you sure you want to delete this client? This action cannot be undone.'
                            )) {
                            e.preventDefault();
                            e.stopPropagation();
                        }
                    });
                }
            });
        });
    </script>
@endpush
