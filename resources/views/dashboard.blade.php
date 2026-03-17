@extends('layouts.app')

@section('title', __('dashboard.meta.title'))

@section('content')
    <!-- Welcome Section -->
    <div class="mb-3">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ __('dashboard.welcome.title') }} {{ auth()->user()->name }}! &#128075;
                </h1>
                <p class="text-gray-600 mt-1">
                    @if (auth()->user()->role === 'freelancer')
                        {{ __('dashboard.welcome.subtitle') }}
                    @else
                        {{ __('dashboard.welcome.client_subtitle') }}
                    @endif
                </p>
            </div>
            <div class="text-sm text-gray-500">
                {{ now()->locale(app()->getLocale())->translatedFormat('l, F j, Y') }}
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
        @if (auth()->user()->role === 'freelancer')
            @php
                $formatTrend = function ($trend, $percent) {
                    $isDown = $trend === 'down';
                    $isNeutral = $trend === 'neutral';

                    return [
                        'direction' => $isDown ? "\u{2193}" : ($isNeutral ? "\u{2192}" : "\u{2191}"),
                        'color' => $isDown ? 'text-red-600' : ($isNeutral ? 'text-gray-600' : 'text-green-600'),
                        'percent' => number_format(abs($percent ?? 0), 2),
                    ];
                };

                $earningsUi = $formatTrend($earningsTrend ?? 'neutral', $earningsChangePercent ?? 0);
                $activeProjectsUi = $formatTrend($activeProjectsTrend ?? 'neutral', $activeProjectsChangePercent ?? 0);
                $proposalsUi = $formatTrend($proposalsSentTrend ?? 'neutral', $proposalsSentChangePercent ?? 0);
                $profileViewsUi = $formatTrend($profileViewsTrend ?? 'neutral', $profileViewsChangePercent ?? 0);
            @endphp
            <!-- Freelancer Stats -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ __('dashboard.freelancer.stats.total_earnings') }}
                        </p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">${{ number_format($totalEarnings ?? 0, 2) }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="w-9 h-9 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="{{ $earningsUi['color'] }} font-medium">{{ $earningsUi['direction'] }}
                            {{ $earningsUi['percent'] }}%</span>
                        <span class="text-gray-500 ml-2">{{ __('dashboard.freelancer.stats.period_last_month') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ __('dashboard.freelancer.stats.active_projects') }}
                        </p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $activeProjects ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="{{ $activeProjectsUi['color'] }} font-medium">{{ $activeProjectsUi['direction'] }}
                            {{ $activeProjectsUi['percent'] }}%</span>
                        <span class="text-gray-500 ml-2">{{ __('dashboard.freelancer.stats.period_last_month') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ __('dashboard.freelancer.stats.proposals_sent') }}
                        </p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $proposalsSent ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="{{ $proposalsUi['color'] }} font-medium">{{ $proposalsUi['direction'] }}
                            {{ $proposalsUi['percent'] }}%</span>
                        <span class="text-gray-500 ml-2">{{ __('dashboard.freelancer.stats.period_last_month') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ __('dashboard.freelancer.stats.profile_views') }}
                        </p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $profileViews ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="{{ $profileViewsUi['color'] }} font-medium">{{ $profileViewsUi['direction'] }}
                            {{ $profileViewsUi['percent'] }}%</span>
                        <span class="text-gray-500 ml-2">{{ __('dashboard.freelancer.stats.period_last_month') }}</span>
                    </div>
                </div>
            </div>
        @else
            <!-- Client Stats -->
            @php
                $formatClientTrend = function ($trend, $percent) {
                    $isDown = $trend === 'down';
                    $isNeutral = $trend === 'neutral';

                    return [
                        'direction' => $isDown ? "\u{2193}" : ($isNeutral ? "\u{2192}" : "\u{2191}"),
                        'color' => $isDown ? 'text-red-600' : ($isNeutral ? 'text-gray-600' : 'text-green-600'),
                        'percent' => number_format(abs($percent ?? 0), 2),
                    ];
                };

                $clientActiveJobsUi = $formatClientTrend(
                    $clientActiveJobsTrend ?? 'neutral',
                    $clientActiveJobsChangePercent ?? 0,
                );
                $clientTotalSpentUi = $formatClientTrend(
                    $clientTotalSpentTrend ?? 'neutral',
                    $clientTotalSpentChangePercent ?? 0,
                );
                $clientFreelancersHiredUi = $formatClientTrend(
                    $clientFreelancersHiredTrend ?? 'neutral',
                    $clientFreelancersHiredChangePercent ?? 0,
                );
                $clientProposalsUi = $formatClientTrend(
                    $clientProposalsReceivedTrend ?? 'neutral',
                    $clientProposalsReceivedChangePercent ?? 0,
                );
            @endphp
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Active Jobs</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $clientActiveJobs ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span
                            class="{{ $clientActiveJobsUi['color'] }} font-medium">{{ $clientActiveJobsUi['direction'] }}
                            {{ $clientActiveJobsUi['percent'] }}%</span>
                        <span class="text-gray-500 ml-2">{{ $statsPeriodLabel ?? 'from last month' }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Spent</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">${{ number_format($clientTotalSpent ?? 0, 2) }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="w-9 h-9 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span
                            class="{{ $clientTotalSpentUi['color'] }} font-medium">{{ $clientTotalSpentUi['direction'] }}
                            {{ $clientTotalSpentUi['percent'] }}%</span>
                        <span class="text-gray-500 ml-2">{{ $statsPeriodLabel ?? 'from last month' }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Freelancers Hired</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $clientFreelancersHired ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0a6 6 0 00-9 5.197">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="{{ $clientFreelancersHiredUi['color'] }} font-medium">
                            {{ $clientFreelancersHiredUi['direction'] }} {{ $clientFreelancersHiredUi['percent'] }}%
                        </span>
                        <span class="text-gray-500 ml-2">{{ $statsPeriodLabel ?? 'from last month' }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Proposals Received</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $clientProposalsReceived ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="{{ $clientProposalsUi['color'] }} font-medium">{{ $clientProposalsUi['direction'] }}
                            {{ $clientProposalsUi['percent'] }}%</span>
                        <span class="text-gray-500 ml-2">{{ number_format($clientAvgProposalsPerJob ?? 0, 1) }} avg. per
                            job</span>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-3">
            @if (auth()->user()->role === 'freelancer')
                <!-- Freelancer: Recommended Jobs -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6" id="freelancer-active-jobs">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">
                            {{ __('dashboard.freelancer.recommended_jobs.title') }}</h2>
                        <a href="{{ route('find-jobs') }}"
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">{{ __('dashboard.freelancer.recommended_jobs.view_all') }}
                            &rarr;</a>
                    </div>

                    <div id="recommended-jobs-container" class="space-y-4">
                        <!-- Loading skeleton -->
                        <div id="jobs-loading" class="space-y-4">
                            @for ($i = 1; $i <= 3; $i++)
                                <div class="p-4 border border-gray-200 rounded-lg animate-pulse">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-4">
                                                <div class="h-6 bg-gray-200 rounded w-24"></div>
                                                <div class="h-4 bg-gray-200 rounded w-32"></div>
                                            </div>
                                            <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
                                            <div class="h-3 bg-gray-200 rounded w-full mb-3"></div>
                                            <div class="h-3 bg-gray-200 rounded w-1/2 mb-3"></div>
                                            <div class="flex items-center justify-between mt-5">
                                                <div class="flex items-center space-x-4">
                                                    <div class="h-4 bg-gray-200 rounded w-20"></div>
                                                    <div class="h-4 bg-gray-200 rounded w-16"></div>
                                                </div>
                                                <div class="flex items-center">
                                                    <div class="h-4 bg-gray-200 rounded w-12"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="h-9 bg-gray-200 rounded w-24"></div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <!-- Dynamic content will be loaded here -->
                    </div>
                </div>
                <!-- Freelancer: Active Projects -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">{{ __('dashboard.freelancer.active_jobs.title') }}
                        </h2>
                        <a href="{{ route('freelancer.active-jobs') }}"
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">{{ __('dashboard.freelancer.active_jobs.view_all') }}
                            &rarr;</a>
                    </div>

                    <div class="space-y-4">
                        @forelse ($freelancerActiveJobs as $contract)
                            @php
                                $job = $contract->job;
                                $isInProgress = $job?->status === 'in_progress';
                                $statusLabel = $isInProgress
                                    ? __('dashboard.freelancer.active_jobs.in_progress')
                                    : __('dashboard.freelancer.active_jobs.active');
                                $dotColor = $isInProgress ? 'bg-amber-500' : 'bg-green-500';
                                $progressPercent = $isInProgress ? 65 : 35;
                                $progressBarColor = $isInProgress ? 'bg-amber-600' : 'bg-green-600';

                                $amountDisplay = __('dashboard.freelancer.active_jobs.negotiable');
                                if ($contract->total_amount) {
                                    $amountDisplay = '$' . number_format((float) $contract->total_amount, 2);
                                } elseif (!is_null($job?->budget_min) && !is_null($job?->budget_max)) {
                                    $amountDisplay =
                                        '$' .
                                        number_format((float) $job->budget_min, 0) .
                                        ' - $' .
                                        number_format((float) $job->budget_max, 0);
                                }

                                $deadlineDisplay = $job?->expires_at
                                    ? $job->expires_at->format('M d, Y')
                                    : __('dashboard.freelancer.active_jobs.no_deadline');
                            @endphp
                            <div class="project-card p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 mb-2">
                                            {{ $job?->title ?? __('dashboard.freelancer.active_jobs.untitled_job') }}
                                        </h3>
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-2 h-2 rounded-full {{ $dotColor }}"></div>
                                                <span class="text-gray-600 text-sm">{{ $statusLabel }}</span>
                                            </div>
                                            <span class="text-gray-700 font-medium">{{ $amountDisplay }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                                <span>{{ __('dashboard.freelancer.active_jobs.progress') }}</span>
                                                <span>{{ $progressPercent }}%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="{{ $progressBarColor }} h-2 rounded-full progress-bar"
                                                    style="width: {{ $progressPercent }}%"></div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between text-sm">
                                            <span
                                                class="text-gray-600">{{ __('dashboard.freelancer.active_jobs.deadline') }}:
                                                {{ $deadlineDisplay }}</span>
                                            <div class="flex items-center space-x-3">
                                                <button
                                                    class="text-blue-600 hover:text-blue-800 font-medium">{{ __('dashboard.freelancer.active_jobs.update') }}</button>
                                                <button
                                                    class="text-gray-600 hover:text-gray-800">{{ __('dashboard.freelancer.active_jobs.message') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 my-10 text-center text-gray-500 text-sm">
                                {{ __('dashboard.freelancer.active_jobs.no_active_jobs') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            @else
                <!-- Client: Recent Job Postings -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Your Job Postings</h2>
                        <a href="{{ route('my-jobs.index') }}"
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            View all &rarr;
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse ($clientJobPostings as $job)
                            @php
                                $status = $job->status ?? 'draft';
                                $statusClasses = match ($status) {
                                    'open' => 'bg-green-100 text-green-800',
                                    'in_progress' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-emerald-100 text-emerald-800',
                                    'closed' => 'bg-gray-100 text-gray-800',
                                    default => 'bg-amber-100 text-amber-800',
                                };

                                $statusLabel = \Illuminate\Support\Str::title(str_replace('_', ' ', $status));
                                $categoryName = $job->category?->name ?? 'General';
                                $postedText = $job->created_at
                                    ? 'Posted ' . $job->created_at->diffForHumans()
                                    : 'Recently posted';
                                $proposalsCount = (int) ($job->proposals_count ?? 0);
                                $description = $job->description
                                    ? \Illuminate\Support\Str::limit($job->description, 150)
                                    : 'No description provided.';

                                $budgetDisplay = 'Negotiable';
                                if (!is_null($job->budget_min) && !is_null($job->budget_max)) {
                                    $budgetDisplay =
                                        '$' .
                                        number_format((float) $job->budget_min, 0) .
                                        ' - $' .
                                        number_format((float) $job->budget_max, 0);
                                } elseif (!is_null($job->budget_min)) {
                                    $budgetDisplay = '$' . number_format((float) $job->budget_min, 0);
                                } elseif (!is_null($job->budget_max)) {
                                    $budgetDisplay = '$' . number_format((float) $job->budget_max, 0);
                                }

                                $typeLabel = $job->type === 'hourly' ? 'Hourly' : 'Fixed Price';
                            @endphp
                            <div
                                class="job-card p-4 border border-gray-200 rounded-lg hover:border-blue-300 transition-all duration-200">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-2 select-none">
                                            <span class="{{ $statusClasses }} text-xs font-semibold px-2 py-1 rounded">
                                                {{ $statusLabel }}
                                            </span>
                                            <span
                                                class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">
                                                {{ $categoryName }}
                                            </span>
                                            <span class="text-gray-500 text-xs">&bull; {{ $postedText }}</span>
                                        </div>
                                        <h3 class="font-semibold text-gray-900 mb-1">{{ $job->title ?? 'Untitled Job' }}
                                        </h3>
                                        <p class="text-gray-600 text-sm mb-3">{{ $description }}</p>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 text-gray-400 mr-1" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                        </path>
                                                    </svg>
                                                    <span class="text-gray-600 text-sm">{{ $proposalsCount }}
                                                        Proposals</span>
                                                </div>
                                                <span class="text-gray-700 font-medium">{{ $budgetDisplay }}</span>
                                                <span class="text-gray-500 text-sm">{{ $typeLabel }}</span>
                                            </div>
                                            <div class="flex items-center space-x-2 select-none">
                                                <a href="{{ route('my-jobs.index') }}" data-action="view-proposals"
                                                    data-job-id="{{ $job->id }}"
                                                    data-job-title="{{ $job->title ?? 'Untitled Job' }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-100 transition-all duration-200">
                                                    View Proposals
                                                    <span data-proposals-count
                                                        class="ml-2 bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">{{ $proposalsCount }}</span>
                                                </a>
                                                <a href="{{ route('my-jobs.edit', $job->id) }}"
                                                    class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-all duration-200">
                                                    Edit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 my-10 text-center text-gray-500 text-sm">
                                No job postings found yet.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Client: Recent Freelancer Applications -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Recent Applications</h2>
                        <a href="{{ route('my-jobs.index') }}"
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            View all &rarr;
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse ($clientRecentApplications as $application)
                            @php
                                $freelancer = $application->freelancer;
                                $freelancerUser = $freelancer?->user;
                                $freelancerName = $freelancerUser?->name ?? 'Unknown Freelancer';
                                $freelancerProfileUrl = $freelancerUser
                                    ? route('freelancer-profile', $freelancerUser->id)
                                    : null;
                                $nameParts = preg_split('/\s+/', trim($freelancerName)) ?: [];
                                $firstInitial = strtoupper(\Illuminate\Support\Str::substr($nameParts[0] ?? 'F', 0, 1));
                                $secondInitial = strtoupper(\Illuminate\Support\Str::substr($nameParts[1] ?? '', 0, 1));
                                $freelancerInitials = trim($firstInitial . $secondInitial);
                                $freelancerPhotoUrl = $freelancerUser?->profile_photo_url;
                                $applicationTime = $application->created_at
                                    ? $application->created_at->diffForHumans()
                                    : 'Recently';
                                $proposalSummary = \Illuminate\Support\Str::limit(
                                    $application->proposal_text ?? 'No proposal message provided.',
                                    140,
                                );
                                $rating = !is_null($freelancer?->rating)
                                    ? number_format((float) $freelancer->rating, 1)
                                    : '0.0';
                            @endphp
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center select-none">
                                        @if ($freelancerProfileUrl)
                                            <a href="{{ $freelancerProfileUrl }}" class="block">
                                        @endif
                                        @if ($freelancerPhotoUrl)
                                            <img src="{{ $freelancerPhotoUrl }}" alt="{{ $freelancerName }}"
                                                class="w-12 h-12 rounded-full object-cover">
                                        @else
                                            <span class="text-white font-bold text-sm">{{ $freelancerInitials }}</span>
                                        @endif
                                        @if ($freelancerProfileUrl)
                                            </a>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            @if ($freelancerProfileUrl)
                                                <a href="{{ $freelancerProfileUrl }}"
                                                    class="font-semibold text-gray-900 hover:text-blue-700">
                                                    {{ $freelancerName }}
                                                </a>
                                            @else
                                                <h3 class="font-semibold text-gray-900">{{ $freelancerName }}</h3>
                                            @endif
                                            <span class="text-gray-500 text-xs">{{ $applicationTime }}</span>
                                        </div>
                                        <p class="text-gray-500 text-xs mb-1">
                                            For: {{ $application->job?->title ?? 'Untitled Job' }}
                                        </p>
                                        <p class="text-gray-600 text-sm mb-3">{{ $proposalSummary }}</p>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                    <span class="text-gray-600 text-sm ml-1">{{ $rating }}</span>
                                                </div>
                                                <span class="text-gray-600 text-sm">Proposed: <span
                                                        class="font-medium">${{ number_format((float) ($application->bid_amount ?? 0), 2) }}</span></span>
                                            </div>
                                            <div class="flex items-center space-x-2 select-none">
                                                <a href="{{ route('my-jobs.index') }}"
                                                    class="px-3 py-1.5 bg-gray-800 text-white rounded-lg text-sm font-medium hover:bg-black transition-all duration-200">
                                                    Hire
                                                </a>
                                                <a href="{{ route('messages.index') }}"
                                                    class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-all duration-200">
                                                    Message
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 my-10 text-center text-gray-500 text-sm">
                                No recent applications found.
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="space-y-3">
            <!-- Upcoming Deadlines -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6" id="freelancer-upcoming-deadlines">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">{{ __('dashboard.freelancer.upcoming_deadlines.title') }}
                    </h2>
                    <a href="{{ route('freelancer.deadlines') }}"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        {{ __('dashboard.freelancer.upcoming_deadlines.view_all') }} &rarr;
                    </a>
                </div>
                @php
                    $upcomingDeadlines = trans('dashboard.freelancer.upcoming_deadlines.items');
                    if (!is_array($upcomingDeadlines)) {
                        $upcomingDeadlines = [];
                    }
                @endphp
                <div class="space-y-4 max-h-[392px] overflow-y-auto pr-1">
                    @foreach ($upcomingDeadlines as $deadline)
                        @php
                            $deadlineDate = $deadline['date'] ?? '';
                            try {
                                $formattedDeadlineDate = $deadlineDate
                                    ? \Illuminate\Support\Carbon::parse($deadlineDate)
                                        ->locale(app()->getLocale())
                                        ->translatedFormat('F j, Y')
                                    : '';
                            } catch (\Throwable $e) {
                                $formattedDeadlineDate = $deadlineDate;
                            }
                        @endphp
                        <div class="p-3 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-semibold text-gray-900 text-sm">{{ $deadline['title'] }}</h3>
                                <span class="text-red-600 text-xs font-medium">
                                    {{ __('dashboard.freelancer.upcoming_deadlines.due_in_days', ['count' => $deadline['days']]) }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-xs mb-2">{{ $deadline['desc'] }}</p>
                            <div class="flex items-center text-gray-500 text-xs">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ $formattedDeadlineDate }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    {{-- Proposals Modal For Client --}}
    <x-proposals-modal />

    {{-- Proposal Submit Modal For Freelancer --}}
    <x-proposal-submit-modal />

    <!-- Proposal Update Modal -->
    <div id="proposal-update-modal" class="fixed inset-0 z-[60] hidden transition-opacity duration-300">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300 ease-out"
            id="update-proposal-backdrop">
        </div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all duration-300 ease-out sm:my-8 sm:w-full sm:max-w-2xl w-full translate-y-4 opacity-0 scale-95"
                id="update-proposal-content">
                <!-- Modal Header -->
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-gray-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900">
                                {{ __('find-jobs.modals.update_proposal.title') }}
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">{{ __('find-jobs.modals.proposal.job_label') }}: <span
                                        id="update-proposal-job-title" class="font-medium"></span></p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ __('find-jobs.modals.update_proposal.help_text') }}</p>
                            </div>
                        </div>
                        <button type="button" id="close-update-proposal-modal"
                            class="text-gray-400 hover:text-gray-500 rounded-lg p-2 transition-colors duration-200">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Content - Form -->
                <form id="update-proposal-form">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-0 sm:pb-4 overflow-y-auto max-h-[60vh]">
                        <div class="space-y-4">
                            <!-- Hidden job ID and proposal ID -->
                            <input type="hidden" id="update-proposal-job-id" name="job_id">
                            <input type="hidden" id="update-proposal-id" name="proposal_id">

                            <!-- Proposal Text -->
                            <div>
                                <label for="update-proposal-text" class="block text-sm font-medium text-gray-900 mb-2">
                                    {{ __('find-jobs.modals.proposal.details_label') }} <span
                                        class="text-red-500">*</span>
                                </label>
                                <textarea id="update-proposal-text" name="proposal_text" rows="6"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 text-sm"
                                    placeholder="{{ __('find-jobs.modals.proposal.details_placeholder') }}"></textarea>
                            </div>

                            <!-- Bid Amount -->
                            <div>
                                <label for="update-bid-amount" class="block text-sm font-medium text-gray-900 mb-2">
                                    {{ __('find-jobs.modals.proposal.bid_amount_label') }} <span
                                        class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" id="update-bid-amount" name="bid_amount" step="0.01"
                                        min="1"
                                        class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 text-sm"
                                        placeholder="{{ __('find-jobs.common.amount_placeholder') }}">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ __('find-jobs.modals.proposal.bid_amount_help') }}
                                    <span id="update-min_max_budget"></span>
                                </p>
                            </div>

                            <!-- Estimated Timeline (Optional) -->
                            <div>
                                <label for="update-estimated-timeline"
                                    class="block text-sm font-medium text-gray-900 mb-2">
                                    {{ __('find-jobs.modals.proposal.estimated_timeline_label') }}
                                </label>
                                <select name="estimated_timeline" id="update-estimated-timeline"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 text-sm">
                                    <option value="2 weeks">{{ __('find-jobs.timeline.two_weeks') }}</option>
                                    <option value="3-4 weeks">{{ __('find-jobs.timeline.three_four_weeks') }}</option>
                                    <option value="1-2 months">{{ __('find-jobs.timeline.one_two_months') }}</option>
                                    <option value="3-6 months">{{ __('find-jobs.timeline.three_six_months') }}</option>
                                    <option value="more than 6 months">
                                        {{ __('find-jobs.timeline.more_than_six_months') }}
                                    </option>
                                    <option value="not sure">{{ __('find-jobs.timeline.not_sure') }}</option>
                                    <option value="ongoing support">{{ __('find-jobs.timeline.ongoing_support') }}
                                    </option>
                                    <option value="to be discussed">
                                        {{ __('find-jobs.timeline.to_be_discussed_default') }}
                                    </option>
                                </select>
                            </div>

                            <!-- Error Message Container -->
                            <div id="update-proposal-error" class="hidden p-3 bg-red-50 border border-red-200 rounded-lg">
                                <p class="text-sm text-red-600" id="update-proposal-error-text"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div
                        class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-3 border-t border-gray-200 select-none">
                        <button type="submit" id="submit-update-proposal-btn"
                            class="inline-flex w-full items-center justify-center rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-black sm:w-auto transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <div id="update-submitSpinner"
                                class="hidden w-5 h-5 border-t-2 border-white rounded-full animate-spin mr-2">
                            </div>
                            <span
                                id="submit-update-proposal-text">{{ __('find-jobs.modals.update_proposal.submit_button') }}</span>
                        </button>
                        <button type="submit" id="submit-withdraw-proposal-btn"
                            class="inline-flex w-full items-center justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 sm:w-auto transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <div id="withdraw-submitSpinner"
                                class="hidden w-5 h-5 border-t-2 border-white rounded-full animate-spin mr-2">
                            </div>
                            <span
                                id="submit-withdraw-proposal-text">{{ __('find-jobs.modals.update_proposal.withdraw_button') }}</span>
                        </button>
                        <button type="button" id="cancel-proposal-update-modal"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 text-sm font-medium">
                            {{ __('find-jobs.common.cancel') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const freelancerI18n = {
                postedHourAgo: @json(__('dashboard.freelancer.recommended_jobs.posted_hour_ago', ['count' => ':count'])),
                postedHoursAgo: @json(__('dashboard.freelancer.recommended_jobs.posted_hours_ago', ['count' => ':count'])),
                postedDayAgo: @json(__('dashboard.freelancer.recommended_jobs.posted_day_ago', ['count' => ':count'])),
                postedDaysAgo: @json(__('dashboard.freelancer.recommended_jobs.posted_days_ago', ['count' => ':count'])),
                emptyRecommended: @json(__('dashboard.freelancer.recommended_jobs.empty')),
                negotiable: @json(__('dashboard.freelancer.recommended_jobs.negotiable')),
                fixedPrice: @json(__('dashboard.freelancer.recommended_jobs.fixed_price')),
                hourlyRate: @json(__('dashboard.freelancer.recommended_jobs.hourly_rate')),
                general: @json(__('dashboard.freelancer.recommended_jobs.general')),
                untitledJob: @json(__('dashboard.freelancer.recommended_jobs.untitled_job')),
                noDescription: @json(__('dashboard.freelancer.recommended_jobs.no_description')),
                reviews: @json(__('dashboard.freelancer.recommended_jobs.reviews')),
                applyNow: @json(__('dashboard.freelancer.recommended_jobs.apply_now')),
                networkError: @json(__('dashboard.freelancer.recommended_jobs.network_error')),
                fetchFailed: @json(__('dashboard.freelancer.recommended_jobs.fetch_failed')),
                failedLoad: @json(__('dashboard.freelancer.recommended_jobs.failed_load')),
                retry: @json(__('dashboard.freelancer.recommended_jobs.retry')),
                applyingForJobId: @json(__('dashboard.freelancer.recommended_jobs.applying_for_job_id', ['id' => ':id'])),
            };

            const proposalI18n = {
                untitledJob: @json(__('find-jobs.job_card.untitled_job')),
                budgetNotSpecified: @json(__('find-jobs.job_card.budget_not_specified')),
                proposalMinValidation: @json(__('find-jobs.js.proposal_min_validation', ['min' => ':min'])),
                charactersCount: @json(__('find-jobs.js.characters_count', ['count' => ':count'])),
                charactersCountMinimum: @json(__('find-jobs.js.characters_count_minimum', ['count' => ':count', 'min' => ':min'])),
                validBidAmount: @json(__('find-jobs.js.valid_bid_amount')),
                submitting: @json(__('find-jobs.js.submitting')),
                submitProposal: @json(__('find-jobs.modals.proposal.submit_button')),
                proposalSubmitted: @json(__('find-jobs.js.proposal_submitted')),
                failedSubmitProposal: @json(__('find-jobs.js.failed_submit_proposal')),
                failedSubmitProposalRetry: @json(__('find-jobs.js.failed_submit_proposal_retry')),
                updating: @json(__('find-jobs.js.updating')),
                updateProposalButton: @json(__('find-jobs.modals.update_proposal.submit_button')),
                updateProposalLabel: @json(__('find-jobs.modals.job_details.update_proposal')),
                proposalUpdated: @json(__('find-jobs.js.proposal_updated')),
                failedUpdateProposal: @json(__('find-jobs.js.failed_update_proposal')),
                failedUpdateProposalRetry: @json(__('find-jobs.js.failed_update_proposal_retry')),
                withdrawConfirm: @json(__('find-jobs.js.withdraw_confirm')),
                withdrawing: @json(__('find-jobs.js.withdrawing')),
                withdrawProposalButton: @json(__('find-jobs.modals.update_proposal.withdraw_button')),
                proposalWithdrawn: @json(__('find-jobs.js.proposal_withdrawn')),
                failedWithdrawProposal: @json(__('find-jobs.js.failed_withdraw_proposal')),
                failedWithdrawProposalRetry: @json(__('find-jobs.js.failed_withdraw_proposal_retry')),
                failedFetchProposal: @json(__('find-jobs.js.failed_fetch_proposal')),
                proposalNotFound: @json(__('find-jobs.js.proposal_not_found')),
                failedLoadProposalDetails: @json(__('find-jobs.js.failed_load_proposal_details')),
                timelineDefaultValue: @json(__('find-jobs.timeline.to_be_discussed_value')),
                appliedStatus: {
                    viewed: @json(__('find-jobs.js.applied_status.viewed')),
                    shortlisted: @json(__('find-jobs.js.applied_status.shortlisted')),
                    interviewing: @json(__('find-jobs.js.applied_status.interviewing')),
                    revising: @json(__('find-jobs.js.applied_status.revising')),
                    reapply: @json(__('find-jobs.js.applied_status.reapply')),
                    offerAccepted: @json(__('find-jobs.js.applied_status.offer_accepted')),
                },
            };

            const recommendedJobsById = new Map();
            const jobDetailsUrlTemplate = @json(route('jobs.show', ['id' => '__ID__']));

            const proposalModal = document.getElementById('proposal-modal');
            const proposalBackdrop = document.getElementById('proposal-backdrop');
            const proposalContent = document.getElementById('proposal-content');
            const closeProposalModalBtn = document.getElementById('close-proposal-modal');
            const cancelProposalModalBtn = document.getElementById('cancel-proposal-modal');
            const proposalForm = document.getElementById('proposal-form');
            const minMaxBudget = document.getElementById('min_max_budget');
            const submitProposalBtn = document.getElementById('submit-proposal-btn');
            const submitProposalText = document.getElementById('submit-proposal-text');
            const submitProposalLoading = document.getElementById('submitSpinner');
            const proposalError = document.getElementById('proposal-error');
            const proposalErrorText = document.getElementById('proposal-error-text');
            const proposalUpdateModal = document.getElementById('proposal-update-modal');
            const updateProposalBackdrop = document.getElementById('update-proposal-backdrop');
            const updateProposalContent = document.getElementById('update-proposal-content');
            const closeUpdateProposalModalBtn = document.getElementById('close-update-proposal-modal');
            const cancelUpdateProposalModalBtn = document.getElementById('cancel-proposal-update-modal');
            const updateProposalForm = document.getElementById('update-proposal-form');
            const updateMinMaxBudget = document.getElementById('update-min_max_budget');
            const submitUpdateProposalBtn = document.getElementById('submit-update-proposal-btn');
            const submitUpdateProposalText = document.getElementById('submit-update-proposal-text');
            const submitUpdateProposalLoading = document.getElementById('update-submitSpinner');
            const submitWithdrawProposalBtn = document.getElementById('submit-withdraw-proposal-btn');
            const submitWithdrawProposalText = document.getElementById('submit-withdraw-proposal-text');
            const submitWithdrawProposalLoading = document.getElementById('withdraw-submitSpinner');
            const updateProposalError = document.getElementById('update-proposal-error');
            const updateProposalErrorText = document.getElementById('update-proposal-error-text');

            let currentJobForProposal = null;

            // Function to format date
            function formatDate(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const diffTime = Math.abs(now - date);
                const diffHours = Math.floor(diffTime / (1000 * 60 * 60));

                if (diffHours < 24) {
                    const template = diffHours === 1 ? freelancerI18n.postedHourAgo : freelancerI18n.postedHoursAgo;
                    return template.replace(':count', String(diffHours));
                } else {
                    const diffDays = Math.floor(diffHours / 24);
                    const template = diffDays === 1 ? freelancerI18n.postedDayAgo : freelancerI18n.postedDaysAgo;
                    return template.replace(':count', String(diffDays));
                }
            }

            function formatBudgetRange(minUsd, maxUsd) {
                const minAmount = parseFloat(minUsd);
                const maxAmount = parseFloat(maxUsd);

                if (!Number.isFinite(minAmount) || !Number.isFinite(maxAmount)) {
                    return proposalI18n.budgetNotSpecified;
                }

                return `$${minAmount.toLocaleString()} - $${maxAmount.toLocaleString()}`;
            }

            function getApplyButtonConfig(appliedStatus) {
                if (!appliedStatus || appliedStatus === 'withdrawn') {
                    return {
                        label: freelancerI18n.applyNow,
                        disabled: false,
                        mode: 'apply'
                    };
                }

                if (appliedStatus === 'rejected') {
                    return {
                        label: proposalI18n.appliedStatus.reapply,
                        disabled: false,
                        mode: 'apply'
                    };
                }

                if (appliedStatus === 'accepted') {
                    return {
                        label: proposalI18n.appliedStatus.offerAccepted,
                        disabled: true,
                        mode: 'none'
                    };
                }

                return {
                    label: proposalI18n.updateProposalLabel,
                    disabled: false,
                    mode: 'update'
                };
            }

            function updateCharCounter() {
                const text = this.value || '';
                const length = text.length;
                const minLength = 100;

                let counter = this.nextElementSibling;
                if (!counter || !counter.classList.contains('char-counter')) {
                    counter = document.createElement('div');
                    counter.className = 'char-counter text-xs text-right mt-1';
                    this.parentNode.insertBefore(counter, this.nextElementSibling);
                }

                counter.className = 'char-counter text-xs text-right mt-1';

                if (length < minLength) {
                    counter.classList.add('text-red-500');
                    counter.textContent = proposalI18n.charactersCountMinimum.replace(':count', length).replace(
                        ':min',
                        minLength);
                } else if (length < 150) {
                    counter.classList.add('text-amber-500');
                    counter.textContent = proposalI18n.charactersCount.replace(':count', length);
                } else {
                    counter.classList.add('text-emerald-500');
                    counter.textContent = proposalI18n.charactersCount.replace(':count', length);
                }
            }

            function updateUpdateCharCounter() {
                const text = this.value || '';
                const length = text.length;
                const minLength = 100;

                let counter = this.nextElementSibling;
                if (!counter || !counter.classList.contains('char-counter')) {
                    counter = document.createElement('div');
                    counter.className = 'char-counter text-xs text-right mt-1';
                    this.parentNode.insertBefore(counter, this.nextElementSibling);
                }

                counter.className = 'char-counter text-xs text-right mt-1';

                if (length < minLength) {
                    counter.classList.add('text-red-500');
                    counter.textContent = proposalI18n.charactersCountMinimum.replace(':count', length).replace(
                        ':min',
                        minLength);
                } else if (length < 150) {
                    counter.classList.add('text-amber-500');
                    counter.textContent = proposalI18n.charactersCount.replace(':count', length);
                } else {
                    counter.classList.add('text-emerald-500');
                    counter.textContent = proposalI18n.charactersCount.replace(':count', length);
                }
            }

            function showProposalError(message) {
                if (!proposalError || !proposalErrorText) {
                    return;
                }

                proposalErrorText.textContent = message;
                proposalError.classList.remove('hidden');
            }

            function hideProposalError() {
                if (!proposalError) {
                    return;
                }

                proposalError.classList.add('hidden');
            }

            function showUpdateProposalError(message) {
                if (!updateProposalError || !updateProposalErrorText) {
                    return;
                }

                updateProposalErrorText.textContent = message;
                updateProposalError.classList.remove('hidden');
            }

            function hideUpdateProposalError() {
                if (!updateProposalError) {
                    return;
                }

                updateProposalError.classList.add('hidden');
            }

            function validateProposalForm(formData) {
                const errors = [];

                const proposalTextValue = formData.get('proposal_text')?.trim() || '';
                if (proposalTextValue.length < 100) {
                    errors.push(proposalI18n.proposalMinValidation.replace(':min', 100));
                }

                const bidAmount = parseFloat(formData.get('bid_amount'));
                if (!bidAmount || bidAmount <= 0) {
                    errors.push(proposalI18n.validBidAmount);
                }

                return errors;
            }

            function validateUpdateProposalForm(formData) {
                const errors = [];

                const proposalTextValue = formData.get('proposal_text')?.trim() || '';
                if (proposalTextValue.length < 100) {
                    errors.push(proposalI18n.proposalMinValidation.replace(':min', 100));
                }

                const bidAmount = parseFloat(formData.get('bid_amount'));
                if (!bidAmount || bidAmount <= 0) {
                    errors.push(proposalI18n.validBidAmount);
                }

                return errors;
            }

            function showToast(message, type = 'success') {
                const existingToasts = document.querySelectorAll('.custom-toast');
                existingToasts.forEach(toast => toast.remove());

                const toast = document.createElement('div');
                toast.className =
                    `custom-toast fixed bottom-4 right-3 px-4 py-3 rounded-md shadow-md text-white font-medium transition-all duration-300 z-50 ${type === 'success' ? 'bg-green-400' : type === 'error' ? 'bg-red-400' : 'bg-blue-400'}`;
                toast.textContent = message;
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px)';

                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.style.opacity = '1';
                    toast.style.transform = 'translateY(0)';
                }, 10);

                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        if (toast.parentNode) {
                            toast.remove();
                        }
                    }, 300);
                }, 3000);
            }

            function openProposalModal(job) {
                if (!proposalModal || !proposalForm) {
                    return;
                }

                currentJobForProposal = job;

                const jobTitleElement = document.getElementById('proposal-job-title');
                const jobIdInput = document.getElementById('proposal-job-id');
                const proposalText = document.getElementById('proposal-text');
                const bidAmount = document.getElementById('bid-amount');

                if (jobTitleElement) {
                    jobTitleElement.textContent = job.title || proposalI18n.untitledJob;
                }
                if (jobIdInput) {
                    jobIdInput.value = job.id;
                }

                proposalForm.reset();
                hideProposalError();

                if (proposalText) {
                    proposalText.addEventListener('input', updateCharCounter);
                    updateCharCounter.call(proposalText);
                }

                const minBudget = parseFloat(job.budget_min);
                const maxBudget = parseFloat(job.budget_max);
                if (bidAmount) {
                    if (Number.isFinite(minBudget)) {
                        bidAmount.min = String(minBudget);
                        bidAmount.value = minBudget;
                    } else {
                        bidAmount.removeAttribute('min');
                        bidAmount.value = '';
                    }

                    if (Number.isFinite(maxBudget)) {
                        bidAmount.max = String(maxBudget);
                    } else {
                        bidAmount.removeAttribute('max');
                    }
                }

                if (minMaxBudget) {
                    minMaxBudget.textContent = formatBudgetRange(job.budget_min, job.budget_max);
                }

                proposalModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                void proposalModal.offsetWidth;

                setTimeout(() => {
                    if (proposalBackdrop) {
                        proposalBackdrop.classList.remove('opacity-0');
                        proposalBackdrop.classList.add('opacity-100');
                    }
                }, 10);

                setTimeout(() => {
                    if (proposalContent) {
                        proposalContent.classList.remove('translate-y-4', 'opacity-0', 'scale-95');
                        proposalContent.classList.add('translate-y-0', 'opacity-100', 'scale-100');
                    }
                }, 10);
            }

            function closeProposalModal() {
                if (!proposalModal) {
                    return;
                }

                if (proposalContent) {
                    proposalContent.classList.remove('translate-y-0', 'opacity-100', 'scale-100');
                    proposalContent.classList.add('translate-y-4', 'opacity-0', 'scale-95');
                }

                if (proposalBackdrop) {
                    proposalBackdrop.classList.remove('opacity-100');
                    proposalBackdrop.classList.add('opacity-0');
                }

                setTimeout(() => {
                    proposalModal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                    currentJobForProposal = null;

                    const proposalText = document.getElementById('proposal-text');
                    if (proposalText) {
                        proposalText.removeEventListener('input', updateCharCounter);

                        const existingCounter = proposalText.nextElementSibling;
                        if (existingCounter && existingCounter.classList.contains('char-counter')) {
                            existingCounter.remove();
                        }
                    }

                    proposalForm?.reset();
                }, 300);
            }

            async function openUpdateProposalModal(job, proposal) {
                if (!proposalUpdateModal || !updateProposalForm) {
                    return;
                }

                const updateJobTitle = document.getElementById('update-proposal-job-title');
                const updateJobIdInput = document.getElementById('update-proposal-job-id');
                const updateProposalIdInput = document.getElementById('update-proposal-id');
                const updateProposalText = document.getElementById('update-proposal-text');
                const updateBidAmount = document.getElementById('update-bid-amount');
                const updateEstimatedTimeline = document.getElementById('update-estimated-timeline');

                if (updateJobTitle) {
                    updateJobTitle.textContent = job.title || proposalI18n.untitledJob;
                }
                if (updateJobIdInput) {
                    updateJobIdInput.value = job.id;
                }

                if (proposal && updateProposalIdInput) {
                    updateProposalIdInput.value = proposal.id;
                }

                if (proposal && updateProposalText) {
                    updateProposalText.value = proposal.proposal_text || '';
                }

                if (updateBidAmount) {
                    updateBidAmount.value = proposal?.bid_amount ?? job.budget_min ?? '';
                    if (job.budget_min) {
                        updateBidAmount.min = String(job.budget_min);
                    } else {
                        updateBidAmount.removeAttribute('min');
                    }

                    if (job.budget_max) {
                        updateBidAmount.max = String(job.budget_max);
                    } else {
                        updateBidAmount.removeAttribute('max');
                    }
                }

                if (updateEstimatedTimeline) {
                    updateEstimatedTimeline.value = proposal?.estimated_timeline || proposalI18n
                        .timelineDefaultValue;
                }

                if (updateMinMaxBudget) {
                    updateMinMaxBudget.textContent = formatBudgetRange(job.budget_min, job.budget_max);
                }

                hideUpdateProposalError();

                if (updateProposalText) {
                    updateProposalText.addEventListener('input', updateUpdateCharCounter);
                    updateUpdateCharCounter.call(updateProposalText);
                }

                proposalUpdateModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                void proposalUpdateModal.offsetWidth;

                setTimeout(() => {
                    if (updateProposalBackdrop) {
                        updateProposalBackdrop.classList.remove('opacity-0');
                        updateProposalBackdrop.classList.add('opacity-100');
                    }
                }, 10);

                setTimeout(() => {
                    if (updateProposalContent) {
                        updateProposalContent.classList.remove('translate-y-4', 'opacity-0',
                            'scale-95');
                        updateProposalContent.classList.add('translate-y-0', 'opacity-100',
                            'scale-100');
                    }
                }, 10);
            }

            function closeUpdateProposalModal() {
                if (!proposalUpdateModal) {
                    return;
                }

                if (updateProposalContent) {
                    updateProposalContent.classList.remove('translate-y-0', 'opacity-100', 'scale-100');
                    updateProposalContent.classList.add('translate-y-4', 'opacity-0', 'scale-95');
                }

                if (updateProposalBackdrop) {
                    updateProposalBackdrop.classList.remove('opacity-100');
                    updateProposalBackdrop.classList.add('opacity-0');
                }

                setTimeout(() => {
                    proposalUpdateModal.classList.add('hidden');
                    document.body.style.overflow = 'auto';

                    const updateProposalText = document.getElementById('update-proposal-text');
                    if (updateProposalText) {
                        updateProposalText.removeEventListener('input', updateUpdateCharCounter);

                        const existingCounter = updateProposalText.nextElementSibling;
                        if (existingCounter && existingCounter.classList.contains('char-counter')) {
                            existingCounter.remove();
                        }
                    }

                    updateProposalForm?.reset();
                }, 300);
            }

            async function openUpdateProposalForJob(job) {
                try {
                    const response = await fetch(`/jobs/proposals/${job.id}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute(
                                    'content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error(proposalI18n.failedFetchProposal);
                    }

                    const data = await response.json();

                    if (data.success) {
                        openUpdateProposalModal(job, data.proposal);
                    } else {
                        throw new Error(data.message || proposalI18n.proposalNotFound);
                    }
                } catch (error) {
                    console.error('Error fetching proposal:', error);
                    showToast(error.message || proposalI18n.failedLoadProposalDetails, 'error');
                }
            }

            async function submitProposal(event) {
                event.preventDefault();

                if (!proposalForm) {
                    return;
                }

                const formData = new FormData(proposalForm);
                const errors = validateProposalForm(formData);
                if (errors.length > 0) {
                    showProposalError(errors.join(', '));
                    return;
                }

                if (submitProposalText) {
                    submitProposalText.textContent = proposalI18n.submitting;
                }
                submitProposalLoading?.classList.remove('hidden');
                if (submitProposalBtn) {
                    submitProposalBtn.disabled = true;
                }
                hideProposalError();

                try {
                    const response = await fetch('{{ route('find-jobs.proposals-save') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute(
                                    'content'),
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || proposalI18n.failedSubmitProposal);
                    }

                    if (data.success) {
                        showToast(proposalI18n.proposalSubmitted);
                        closeProposalModal();
                        fetchRecommendedJobs();
                    } else {
                        throw new Error(data.message || proposalI18n.failedSubmitProposal);
                    }
                } catch (error) {
                    console.error('Error submitting proposal:', error);
                    showProposalError(error.message || proposalI18n.failedSubmitProposalRetry);
                } finally {
                    if (submitProposalText) {
                        submitProposalText.textContent = proposalI18n.submitProposal;
                    }
                    submitProposalLoading?.classList.add('hidden');
                    if (submitProposalBtn) {
                        submitProposalBtn.disabled = false;
                    }
                }
            }

            async function submitUpdateProposal(event) {
                event.preventDefault();

                if (!updateProposalForm) {
                    return;
                }

                const formData = new FormData(updateProposalForm);
                const proposalId = document.getElementById('update-proposal-id')?.value;
                if (!proposalId) {
                    showUpdateProposalError(proposalI18n.failedUpdateProposal);
                    return;
                }

                const errors = validateUpdateProposalForm(formData);
                if (errors.length > 0) {
                    showUpdateProposalError(errors.join(', '));
                    return;
                }

                if (submitUpdateProposalText) {
                    submitUpdateProposalText.textContent = proposalI18n.updating;
                }
                submitUpdateProposalLoading?.classList.remove('hidden');
                if (submitUpdateProposalBtn) {
                    submitUpdateProposalBtn.disabled = true;
                }
                hideUpdateProposalError();

                try {
                    const response = await fetch(`/jobs/proposals/${proposalId}/update`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute(
                                    'content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            proposal_text: formData.get('proposal_text'),
                            bid_amount: formData.get('bid_amount'),
                            estimated_timeline: formData.get('estimated_timeline')
                        })
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || proposalI18n.failedUpdateProposal);
                    }

                    if (data.success) {
                        showToast(proposalI18n.proposalUpdated);
                        closeUpdateProposalModal();
                        fetchRecommendedJobs();
                    } else {
                        throw new Error(data.message || proposalI18n.failedUpdateProposal);
                    }
                } catch (error) {
                    console.error('Error updating proposal:', error);
                    showUpdateProposalError(error.message || proposalI18n.failedUpdateProposalRetry);
                } finally {
                    if (submitUpdateProposalText) {
                        submitUpdateProposalText.textContent = proposalI18n.updateProposalButton;
                    }
                    submitUpdateProposalLoading?.classList.add('hidden');
                    if (submitUpdateProposalBtn) {
                        submitUpdateProposalBtn.disabled = false;
                    }
                }
            }

            async function withdrawProposal(event) {
                event.preventDefault();

                const jobId = document.getElementById('update-proposal-job-id')?.value;
                if (!jobId) {
                    showUpdateProposalError(proposalI18n.failedWithdrawProposal);
                    return;
                }

                if (!confirm(proposalI18n.withdrawConfirm)) {
                    return;
                }

                if (submitWithdrawProposalText) {
                    submitWithdrawProposalText.textContent = proposalI18n.withdrawing;
                }
                submitWithdrawProposalLoading?.classList.remove('hidden');
                if (submitWithdrawProposalBtn) {
                    submitWithdrawProposalBtn.disabled = true;
                }
                hideUpdateProposalError();

                try {
                    const response = await fetch(`/jobs/proposals/${jobId}/withdraw`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute(
                                    'content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || proposalI18n.failedWithdrawProposal);
                    }

                    if (data.success) {
                        showToast(proposalI18n.proposalWithdrawn);
                        closeUpdateProposalModal();
                        fetchRecommendedJobs();
                    } else {
                        throw new Error(data.message || proposalI18n.failedWithdrawProposal);
                    }
                } catch (error) {
                    console.error('Error withdrawing proposal:', error);
                    showUpdateProposalError(error.message || proposalI18n.failedWithdrawProposalRetry);
                } finally {
                    if (submitWithdrawProposalText) {
                        submitWithdrawProposalText.textContent = proposalI18n.withdrawProposalButton;
                    }
                    submitWithdrawProposalLoading?.classList.add('hidden');
                    if (submitWithdrawProposalBtn) {
                        submitWithdrawProposalBtn.disabled = false;
                    }
                }
            }

            if (closeProposalModalBtn) {
                closeProposalModalBtn.addEventListener('click', closeProposalModal);
            }
            if (cancelProposalModalBtn) {
                cancelProposalModalBtn.addEventListener('click', closeProposalModal);
            }
            proposalForm?.addEventListener('submit', submitProposal);
            proposalBackdrop?.addEventListener('click', closeProposalModal);
            if (closeUpdateProposalModalBtn) {
                closeUpdateProposalModalBtn.addEventListener('click', closeUpdateProposalModal);
            }
            if (cancelUpdateProposalModalBtn) {
                cancelUpdateProposalModalBtn.addEventListener('click', closeUpdateProposalModal);
            }
            updateProposalForm?.addEventListener('submit', submitUpdateProposal);
            submitWithdrawProposalBtn?.addEventListener('click', withdrawProposal);
            updateProposalBackdrop?.addEventListener('click', closeUpdateProposalModal);

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && proposalModal && !proposalModal.classList.contains(
                        'hidden')) {
                    closeProposalModal();
                }
                if (event.key === 'Escape' && proposalUpdateModal && !proposalUpdateModal.classList
                    .contains(
                        'hidden')) {
                    closeUpdateProposalModal();
                }
            });

            // Function to render job cards
            function renderJobCards(jobs) {
                const container = document.getElementById('recommended-jobs-container');
                const loadingElement = document.getElementById('jobs-loading');

                // Remove loading skeleton
                if (loadingElement) {
                    loadingElement.remove();
                }

                // Clear existing content
                container.innerHTML = '';

                recommendedJobsById.clear();

                if (jobs.length === 0) {
                    container.innerHTML = `
                    <div class="text-center py-8">
                        <p class="text-gray-500">${freelancerI18n.emptyRecommended}</p>
                    </div>
                `;
                    return;
                }

                jobs.forEach(job => {
                    recommendedJobsById.set(job.id, job);
                    const jobCard = document.createElement('div');
                    jobCard.className =
                        'project-card p-4 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors duration-200';

                    // Format salary range
                    let salaryRange = freelancerI18n.negotiable;
                    if (job.type === 'fixed') {
                        salaryRange =
                            `$${parseFloat(job.budget_min).toLocaleString()} - $${parseFloat(job.budget_max).toLocaleString()}`;
                    } else if (job.type === 'hourly' && job.budget_min && job.budget_max) {
                        salaryRange =
                            `$${parseFloat(job.budget_min).toLocaleString()}/hr - $${parseFloat(job.budget_max).toLocaleString()}/hr`;
                    } else if (job.budget_min && job.budget_max) {
                        salaryRange =
                            `$${parseFloat(job.budget_min).toLocaleString()} - $${parseFloat(job.budget_max).toLocaleString()}`;
                    }

                    // Format job type display
                    let jobTypeDisplay = freelancerI18n.fixedPrice;
                    if (job.type === 'hourly') {
                        jobTypeDisplay = freelancerI18n.hourlyRate;
                    }

                    // Get category name from server response
                    const categoryName = job.category?.name || freelancerI18n.general;

                    const applyConfig = getApplyButtonConfig(job.applied_status);
                    const applyButtonClasses = applyConfig.disabled ?
                        'ml-4 bg-gray-800 text-white px-4 py-2 rounded-lg transition duration-300 text-sm font-medium select-none opacity-50 cursor-not-allowed' :
                        'ml-4 bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-black transition duration-300 text-sm font-medium select-none';
                    const applyButtonDisabled = applyConfig.disabled ? 'disabled' : '';

                    jobCard.innerHTML = `
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">
                                    ${categoryName}
                                </span>
                                <span class="text-gray-500 text-xs">&bull; ${formatDate(job.created_at)}</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-1">${job.title || freelancerI18n.untitledJob}</h3>
                            <p class="text-gray-600 text-sm mb-3">${job.description ? (job.description.length > 150 ? job.description.substring(0, 150) + '...' : job.description) : freelancerI18n.noDescription}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <span class="text-gray-700 font-medium">${salaryRange}</span>
                                    <span class="text-gray-500 text-sm">${jobTypeDisplay}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="text-gray-600 text-sm ml-1">${job.average_rating || '0.0'}</span>
                                    <span class="text-gray-500 text-sm ml-2">(${job.review_count || '0  '} ${freelancerI18n.reviews})</span>
                                </div>
                            </div>
                        </div>
                        <button onclick="applyForJob(${job.id})" ${applyButtonDisabled}
                            class="${applyButtonClasses}">
                            ${applyConfig.label}
                        </button>
                    </div>
                `;

                    container.appendChild(jobCard);
                });
            }

            // Function to fetch recommended jobs
            async function fetchRecommendedJobs() {
                try {
                    const response = await fetch('{{ route('recommended-jobs') }}', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error(freelancerI18n.networkError);
                    }

                    const data = await response.json();

                    if (data.success && data.jobs) {
                        // Render the job cards with the fetched data
                        renderJobCards(data.jobs);
                    } else {
                        throw new Error(data.message || freelancerI18n.fetchFailed);
                    }
                } catch (error) {
                    console.error('Error fetching job details:', error);

                    // Show error message and keep loading skeleton
                    const container = document.getElementById('recommended-jobs-container');
                    const loadingElement = document.getElementById('jobs-loading');

                    if (loadingElement) {
                        loadingElement.innerHTML = `
                        <div class="text-center py-8">
                            <p class="text-red-500">${freelancerI18n.failedLoad}</p>
                            <button onclick="fetchRecommendedJobs()" class="mt-2 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                ${freelancerI18n.retry}
                            </button>
                        </div>
                    `;
                    }
                }
            }

            // Function to handle job application
            window.applyForJob = async function(jobId) {
                const job = recommendedJobsById.get(jobId);
                if (job) {
                    const applyConfig = getApplyButtonConfig(job.applied_status);
                    if (applyConfig.disabled || applyConfig.mode === 'none') {
                        return;
                    }

                    if (applyConfig.mode === 'update') {
                        await openUpdateProposalForJob(job);
                    } else {
                        openProposalModal(job);
                    }
                    return;
                }

                if (!jobDetailsUrlTemplate) {
                    showToast(freelancerI18n.fetchFailed, 'error');
                    return;
                }

                try {
                    const response = await fetch(jobDetailsUrlTemplate.replace('__ID__', String(jobId)), {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success || !data.job) {
                        throw new Error(data.message || freelancerI18n.fetchFailed);
                    }

                    const applyConfig = getApplyButtonConfig(data.job?.applied_status);
                    if (applyConfig.disabled || applyConfig.mode === 'none') {
                        return;
                    }

                    if (applyConfig.mode === 'update') {
                        await openUpdateProposalForJob(data.job);
                    } else {
                        openProposalModal(data.job);
                    }
                } catch (error) {
                    console.error('Error fetching job details for proposal:', error);
                    showToast(error.message || freelancerI18n.fetchFailed, 'error');
                }
            };

            // Fetch jobs when page loads (only for freelancers)
            @if (auth()->user()->role === 'freelancer')
                fetchRecommendedJobs();
            @endif
        });
    </script>
@endpush
