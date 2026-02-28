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
                                                <a href="{{ route('my-jobs.index') }}"
                                                    class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-100 transition-all duration-200">
                                                    View Proposals
                                                </a>
                                                <a href="{{ route('my-jobs.index') }}"
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

                if (jobs.length === 0) {
                    container.innerHTML = `
                    <div class="text-center py-8">
                        <p class="text-gray-500">${freelancerI18n.emptyRecommended}</p>
                    </div>
                `;
                    return;
                }

                jobs.forEach(job => {
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
                                    <span class="text-gray-600 text-sm ml-1">${job.average_rating || '4.5'}</span>
                                    <span class="text-gray-500 text-sm ml-2">(${job.review_count || '12'} ${freelancerI18n.reviews})</span>
                                </div>
                            </div>
                        </div>
                        <button onclick="applyForJob(${job.id})"
                            class="ml-4 bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-black transition duration-300 text-sm font-medium select-none">
                            ${freelancerI18n.applyNow}
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
            window.applyForJob = function(jobId) {
                // Implement your job application logic here
                alert(freelancerI18n.applyingForJobId.replace(':id', String(jobId)));
                // You can redirect to application page or open a modal
                // window.location.href = `/jobs/${jobId}/apply`;
            };

            // Fetch jobs when page loads (only for freelancers)
            @if (auth()->user()->role === 'freelancer')
                fetchRecommendedJobs();
            @endif
        });
    </script>
@endpush
