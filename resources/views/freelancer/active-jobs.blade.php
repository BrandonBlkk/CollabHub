@extends('layouts.app')

@section('title', 'Active Jobs')

@section('content')
    <div class="mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Active Jobs</h1>
                <p class="text-gray-600 mt-1">Track progress and manage your active contracts.</p>
            </div>
        </div>
    </div>

    @php
        $activeJobs = [
            [
                'title' => 'Landing Page Revamp',
                'status' => 'In Progress',
                'amount' => '$2,400',
                'progress' => 65,
                'deadline' => 'Feb 19, 2026',
                'client' => 'Nova Studio',
            ],
            [
                'title' => 'API Integration Support',
                'status' => 'Active',
                'amount' => '$1,200',
                'progress' => 35,
                'deadline' => 'Feb 24, 2026',
                'client' => 'BrightPay',
            ],
            [
                'title' => 'Mobile QA Audit',
                'status' => 'In Progress',
                'amount' => '$900',
                'progress' => 80,
                'deadline' => 'Feb 15, 2026',
                'client' => 'ShipMate',
            ],
        ];
    @endphp

    <div class="grid gap-4">
        @foreach ($activeJobs as $job)
            @php
                $isInProgress = $job['status'] === 'In Progress';
                $dotColor = $isInProgress ? 'bg-amber-500' : 'bg-green-500';
                $progressColor = $isInProgress ? 'bg-amber-600' : 'bg-green-600';
            @endphp
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $job['title'] }}</h3>
                            <span class="text-gray-700 font-medium">{{ $job['amount'] }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600 mt-2">
                            <span class="inline-flex items-center">
                                <span class="w-2 h-2 rounded-full {{ $dotColor }} mr-2"></span>
                                {{ $job['status'] }}
                            </span>
                            <span class="text-gray-300">|</span>
                            <span>Client: {{ $job['client'] }}</span>
                            <span class="text-gray-300">|</span>
                            <span>Deadline: {{ $job['deadline'] }}</span>
                        </div>
                        <div class="mt-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>Progress</span>
                                <span>{{ $job['progress'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="h-2 rounded-full {{ $progressColor }}" style="width: {{ $job['progress'] }}%;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button"
                            class="px-3 py-2 text-sm font-medium bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100">
                            View details
                        </button>
                        <button type="button"
                            class="px-3 py-2 text-sm font-medium bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            Message
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
