@extends('layouts.app')

@section('title', 'My Jobs')

@section('content')
    @php
        $client = auth()->user()->client;
        $averageBudget =
            (float) ($client
                ->jobs()
                ->selectRaw('AVG(COALESCE(budget_max, budget_min, 0)) as average_budget')
                ->value('average_budget') ?? 0);
    @endphp

    <!-- Page Header -->
    <div class="mb-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Jobs</h1>
            <p class="text-gray-600 mt-1">
                Manage and track all your posted jobs in one place
            </p>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
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

            $totalJobsUi = $formatTrend($totalJobsTrend ?? 'neutral', $totalJobsChangePercent ?? 0);
            $activeJobsUi = $formatTrend($activeJobsTrend ?? 'neutral', $activeJobsChangePercent ?? 0);
            $totalProposalsUi = $formatTrend($totalProposalsTrend ?? 'neutral', $totalProposalsChangePercent ?? 0);
            $avgBudgetUi = $formatTrend($avgBudgetTrend ?? 'neutral', $avgBudgetChangePercent ?? 0);
        @endphp
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Jobs</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $client->all_jobs }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm">
                    <span class="{{ $totalJobsUi['color'] }} font-medium">{{ $totalJobsUi['direction'] }}
                        {{ $totalJobsUi['percent'] }}%</span>
                    <span class="text-gray-500 ml-2">
                        {{ $statsPeriodLabel ?? 'from last month' }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Active Jobs</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $client->active_jobs }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm">
                    <span class="{{ $activeJobsUi['color'] }} font-medium">{{ $activeJobsUi['direction'] }}
                        {{ $activeJobsUi['percent'] }}%</span>
                    <span class="text-gray-500 ml-2">{{ $statsPeriodLabel ?? 'from last month' }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Proposals</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $client->total_proposals }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm">
                    <span class="{{ $totalProposalsUi['color'] }} font-medium">{{ $totalProposalsUi['direction'] }}
                        {{ $totalProposalsUi['percent'] }}%</span>
                    <span class="text-gray-500 ml-2">
                        {{ $client->all_jobs > 0 ? number_format($client->total_proposals / $client->all_jobs, 1) : 0 }}
                        avg. per job | {{ $statsPeriodLabel ?? 'from last month' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Avg. Budget</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">${{ number_format($averageBudget, 2) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                    <svg class="w-9 h-9 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm">
                    <span class="{{ $avgBudgetUi['color'] }} font-medium">{{ $avgBudgetUi['direction'] }}
                        {{ $avgBudgetUi['percent'] }}%</span>
                    <span class="text-gray-500 ml-2">
                        {{ $statsPeriodLabel ?? 'from last month' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-3">
        <div class="flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0">
            <div class="flex space-x-6 overflow-x-auto select-none">
                <button type="button" data-tab="all" id="tab-all"
                    class="pb-2 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap border-b-2 border-blue-600 text-blue-600">
                    All Jobs (<span data-tab-count="all">{{ $client->all_jobs }}</span>)
                </button>
                <button type="button" data-tab="open" id="tab-open"
                    class="pb-2 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap border-b-2 border-transparent">
                    Open (<span data-tab-count="open">{{ $client->open_jobs }}</span>)
                </button>
                <button type="button" data-tab="in_progress" id="tab-in_progress"
                    class="pb-2 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap border-b-2 border-transparent">
                    In Progress (<span data-tab-count="in_progress">{{ $client->in_progress_jobs }}</span>)
                </button>
                <button type="button" data-tab="completed" id="tab-completed"
                    class="pb-2 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap border-b-2 border-transparent">
                    Completed (<span data-tab-count="completed">{{ $client->completed_jobs }}</span>)
                </button>
                <button type="button" data-tab="draft" id="tab-draft"
                    class="pb-2 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap border-b-2 border-transparent">
                    Draft (<span data-tab-count="draft">{{ $client->draft_jobs }}</span>)
                </button>
            </div>

            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search jobs..." id="job-search"
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm w-64">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <button id="filter-toggle"
                    class="flex items-center space-x-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm select-none">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span>Filter</span>
                </button>
            </div>
        </div>

        <div id="advanced-filters" class="hidden mt-4 pt-4 border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Job Type</label>
                    <select id="filter-type"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">All Types</option>
                        <option value="fixed">Fixed Price</option>
                        <option value="hourly">Hourly</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Experience Level</label>
                    <select id="filter-experience"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">All Levels</option>
                        <option value="entry">Entry Level</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="expert">Expert</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Duration</label>
                    <select id="filter-duration"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">Any Duration</option>
                        <option value="less_than_1_month">Less than 1 month</option>
                        <option value="1_to_3_months">1 to 3 months</option>
                        <option value="3_to_6_months">3 to 6 months</option>
                        <option value="more_than_6_months">More than 6 months</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                    <select id="filter-sort"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="budget_high">Budget (High to Low)</option>
                        <option value="budget_low">Budget (Low to High)</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-4 select-none">
                <button id="clear-filters" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm">
                    Clear All
                </button>
                <button id="apply-filters" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm">
                    Apply Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Loading Skeleton -->
    <div id="jobs-loading" class="grid grid-cols-1 lg:grid-cols-2 gap-3">
        @for ($i = 0; $i < 4; $i++)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 animate-pulse">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-6 bg-gray-200 rounded-full w-20"></div>
                    <div class="h-4 bg-gray-200 rounded w-24"></div>
                </div>
                <div class="h-5 bg-gray-200 rounded w-3/4 mb-3"></div>
                <div class="h-4 bg-gray-200 rounded w-full mb-2"></div>
                <div class="h-4 bg-gray-200 rounded w-5/6 mb-4"></div>
                <div class="flex gap-2 mb-4">
                    <div class="h-6 bg-gray-200 rounded w-16"></div>
                    <div class="h-6 bg-gray-200 rounded w-20"></div>
                    <div class="h-6 bg-gray-200 rounded w-14"></div>
                </div>
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <div class="space-y-2">
                        <div class="h-4 bg-gray-200 rounded w-32"></div>
                        <div class="h-4 bg-gray-200 rounded w-24"></div>
                    </div>
                    <div class="flex gap-2">
                        <div class="h-9 bg-gray-200 rounded w-28"></div>
                        <div class="h-9 bg-gray-200 rounded w-16"></div>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <!-- Jobs Grid -->
    <div id="jobs-container" class="grid grid-cols-1 lg:grid-cols-2 gap-3 hidden"></div>

    <!-- Empty State -->
    <div id="empty-state" class="hidden text-center py-12">
        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No jobs found</h3>
        <p class="text-gray-600 mb-6 max-w-md mx-auto">
            No jobs match your current filters. Try adjusting your search criteria or clear all filters.
        </p>
        <button id="clear-all-filters"
            class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm font-medium select-none">
            Clear All Filters
        </button>
    </div>

    <div class="mt-4 pt-3 border-t border-gray-200">
        <div class="text-sm text-gray-700">
            Showing <span id="showing-count">0</span> of <span id="total-jobs">{{ $client->all_jobs }}</span> jobs
        </div>
    </div>

    <!-- Proposals Modal -->
    <div id="proposalModal" class="fixed inset-0 z-50 hidden transition-opacity duration-300">
        <div id="proposalBackdrop"
            class="fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300 ease-out opacity-0"></div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div id="proposalModalContent"
                class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-lg transition-all duration-300 ease-out sm:my-8 sm:w-full sm:max-w-4xl w-full translate-y-4 opacity-0 scale-95">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 id="proposalModalTitle" class="text-xl font-bold text-gray-900">Proposals</h3>
                            <p id="proposalModalSubtitle" class="text-sm text-gray-600 mt-1"></p>
                        </div>
                        <button id="closeProposalModal" type="button" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div id="proposalModalFeedback" class="hidden mb-4 rounded-lg border px-4 py-2 text-sm"></div>
                    <div id="proposalModalBody" class="space-y-4 max-h-[70vh] overflow-y-auto">
                        <!-- Proposal content will render here -->
                    </div>
                    <div class="mt-6 flex justify-end select-none">
                        <button id="closeProposalModalBtn" type="button"
                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const jobsEndpoint = @json(route('my-jobs.jobs'));
            const editJobRouteTemplate = @json(route('my-jobs.edit', ['my_job' => '__JOB__']));
            const proposalsEndpointTemplate = @json(route('my-jobs.proposals', ['my_job' => '__JOB__']));
            const proposalStatusEndpointTemplate = @json(route('my-jobs.proposals.status', ['my_job' => '__JOB__', 'proposal' => '__PROPOSAL__']));
            const messagesUrl = @json(route('messages.index'));
            const csrfToken = @json(csrf_token());

            const tabs = document.querySelectorAll('[data-tab]');
            const jobsLoading = document.getElementById('jobs-loading');
            const jobsContainer = document.getElementById('jobs-container');
            const emptyState = document.getElementById('empty-state');
            const searchInput = document.getElementById('job-search');
            const filterType = document.getElementById('filter-type');
            const filterExperience = document.getElementById('filter-experience');
            const filterDuration = document.getElementById('filter-duration');
            const filterSort = document.getElementById('filter-sort');
            const filterPanel = document.getElementById('advanced-filters');
            const showingCount = document.getElementById('showing-count');
            const totalJobsCount = document.getElementById('total-jobs');
            const proposalModal = document.getElementById('proposalModal');
            const proposalBackdrop = document.getElementById('proposalBackdrop');
            const proposalModalContent = document.getElementById('proposalModalContent');
            const proposalModalBody = document.getElementById('proposalModalBody');
            const proposalModalTitle = document.getElementById('proposalModalTitle');
            const proposalModalSubtitle = document.getElementById('proposalModalSubtitle');
            const proposalModalFeedback = document.getElementById('proposalModalFeedback');
            const closeProposalModalBtn = document.getElementById('closeProposalModal');
            const closeProposalModalFooterBtn = document.getElementById('closeProposalModalBtn');

            let currentTab = 'all';
            let searchTimer = null;
            let allJobsData = [];
            let hasFetchedJobs = false;
            let isFetchingJobs = false;
            let totalJobsFromServer = Number(document.querySelector('[data-tab-count="all"]')?.textContent || 0);
            let activeProposalTrigger = null;
            let activeProposalJobId = null;
            let activeProposalJobTitle = null;
            let activeProposalJobBudget = null;

            function escapeHtml(value) {
                return String(value ?? '')
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#39;');
            }

            function truncate(text, max = 180) {
                if (!text) {
                    return 'No description provided.';
                }

                if (text.length <= max) {
                    return text;
                }

                return `${text.substring(0, max)}...`;
            }

            function renderFormattedDescriptionPreview(text, max = 180) {
                const truncated = truncate(text, max);
                let formatted = escapeHtml(String(truncated)).replace(/\r\n/g, '\n');
                formatted = formatted.replace(/^\s*-\s+(.*)$/gm, '&bull; $1');
                formatted = formatted.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
                formatted = formatted.replace(/\*(.+?)\*/g, '<em>$1</em>');
                formatted = formatted.replace(/\n/g, ' ');
                return formatted;
            }

            function formatTimeAgo(dateString) {
                if (!dateString) {
                    return 'Just now';
                }

                const date = new Date(dateString);
                const now = new Date();
                const diffInSeconds = Math.floor((now - date) / 1000);

                if (diffInSeconds < 60) return 'Just now';

                if (diffInSeconds < 3600) {
                    const minutes = Math.floor(diffInSeconds / 60);
                    return `${minutes} minute${minutes === 1 ? '' : 's'} ago`;
                }

                if (diffInSeconds < 86400) {
                    const hours = Math.floor(diffInSeconds / 3600);
                    return `${hours} hour${hours === 1 ? '' : 's'} ago`;
                }

                if (diffInSeconds < 604800) {
                    const days = Math.floor(diffInSeconds / 86400);
                    return `${days} day${days === 1 ? '' : 's'} ago`;
                }

                if (diffInSeconds < 2592000) {
                    const weeks = Math.floor(diffInSeconds / 604800);
                    return `${weeks} week${weeks === 1 ? '' : 's'} ago`;
                }

                const months = Math.floor(diffInSeconds / 2592000);
                return `${months} month${months === 1 ? '' : 's'} ago`;
            }

            function formatCurrency(amount, suffix = '') {
                const value = Number(amount);
                if (!Number.isFinite(value)) {
                    return 'Negotiable';
                }

                return `$${value.toLocaleString()}${suffix}`;
            }

            function getInitials(name) {
                const parts = String(name || '').trim().split(/\s+/).filter(Boolean);
                if (parts.length === 0) {
                    return 'F';
                }

                const first = parts[0].charAt(0).toUpperCase();
                const second = parts[1] ? parts[1].charAt(0).toUpperCase() : '';
                return `${first}${second}`.trim();
            }

            function formatProposalText(text) {
                if (!text) {
                    return '<span class="text-gray-500 italic">No proposal message provided.</span>';
                }

                return escapeHtml(String(text)).replace(/\n/g, '<br>');
            }

            function getProposalStatusMeta(status) {
                const normalized = status || 'pending';
                const map = {
                    accepted: {
                        label: 'Accepted',
                        className: 'bg-green-100 text-green-800 select-none'
                    },
                    declined: {
                        label: 'Declined',
                        className: 'bg-red-100 text-red-800 select-none'
                    },
                    pending: {
                        label: 'Pending',
                        className: 'bg-amber-100 text-amber-800 select-none'
                    },
                };

                return map[normalized] || map.pending;
            }

            function getBudgetFitMeta(bidAmount) {
                if (!activeProposalJobBudget) {
                    return null;
                }

                const min = Number(activeProposalJobBudget.budget_min);
                const max = Number(activeProposalJobBudget.budget_max);
                const bid = Number(bidAmount);

                if (!Number.isFinite(bid)) {
                    return null;
                }

                if (Number.isFinite(min) && bid < min) {
                    return {
                        label: 'Below budget',
                        className: 'bg-blue-50 text-blue-700 select-none',
                    };
                }

                if (Number.isFinite(max) && bid > max) {
                    return {
                        label: 'Above budget',
                        className: 'bg-red-50 text-red-700 select-none',
                    };
                }

                if (Number.isFinite(min) || Number.isFinite(max)) {
                    return {
                        label: 'Within budget',
                        className: 'bg-green-50 text-green-700 select-none',
                    };
                }

                return null;
            }

            function buildMessageTemplate(name, jobTitle) {
                const safeName = name || 'there';
                const safeJobTitle = jobTitle || 'your proposal';
                return `Hi ${safeName},\n\nThanks for submitting your proposal for "${safeJobTitle}". I reviewed your bid and would like to discuss next steps.\n\n- ${document.title}`;
            }

            function setProposalModalTitle(title, count) {
                if (proposalModalTitle) {
                    proposalModalTitle.textContent = title || 'Proposals';
                }

                if (!proposalModalSubtitle) {
                    return;
                }

                if (count === null || typeof count === 'undefined') {
                    proposalModalSubtitle.textContent = 'Loading proposals...';
                    return;
                }

                proposalModalSubtitle.textContent = `${count} proposal${count === 1 ? '' : 's'} received`;
            }

            function showProposalFeedback(type, message) {
                if (!proposalModalFeedback) {
                    return;
                }

                proposalModalFeedback.classList.remove(
                    'hidden',
                    'border-red-200',
                    'bg-red-50',
                    'text-red-700',
                    'border-green-200',
                    'bg-green-50',
                    'text-green-700'
                );

                if (type === 'success') {
                    proposalModalFeedback.classList.add('border-green-200', 'bg-green-50', 'text-green-700');
                } else {
                    proposalModalFeedback.classList.add('border-red-200', 'bg-red-50', 'text-red-700');
                }

                proposalModalFeedback.textContent = message;
            }

            function clearProposalFeedback() {
                if (!proposalModalFeedback) {
                    return;
                }

                proposalModalFeedback.textContent = '';
                proposalModalFeedback.classList.add('hidden');
            }

            function openProposalModal() {
                if (!proposalModal || !proposalBackdrop || !proposalModalContent) {
                    return;
                }

                proposalModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                void proposalModal.offsetWidth;

                setTimeout(() => {
                    proposalBackdrop.classList.remove('opacity-0');
                    proposalBackdrop.classList.add('opacity-100');
                }, 10);

                setTimeout(() => {
                    proposalModalContent.classList.remove('translate-y-4', 'opacity-0', 'scale-95');
                    proposalModalContent.classList.add('translate-y-0', 'opacity-100', 'scale-100');
                }, 10);
            }

            function closeProposalModal() {
                if (!proposalModal || !proposalBackdrop || !proposalModalContent) {
                    return;
                }

                proposalModalContent.classList.remove('translate-y-0', 'opacity-100', 'scale-100');
                proposalModalContent.classList.add('translate-y-4', 'opacity-0', 'scale-95');

                proposalBackdrop.classList.remove('opacity-100');
                proposalBackdrop.classList.add('opacity-0');

                setTimeout(() => {
                    proposalModal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }, 300);
            }

            function renderProposalLoading() {
                if (!proposalModalBody) {
                    return;
                }

                proposalModalBody.innerHTML = `
                    <div class="border border-gray-200 rounded-lg p-4 animate-pulse">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-4 bg-gray-200 rounded w-1/3"></div>
                            <div class="h-4 bg-gray-200 rounded w-20"></div>
                        </div>
                        <div class="h-3 bg-gray-200 rounded w-2/3 mb-2"></div>
                        <div class="h-3 bg-gray-200 rounded w-full mb-2"></div>
                        <div class="h-3 bg-gray-200 rounded w-5/6"></div>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4 animate-pulse">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-4 bg-gray-200 rounded w-1/3"></div>
                            <div class="h-4 bg-gray-200 rounded w-20"></div>
                        </div>
                        <div class="h-3 bg-gray-200 rounded w-2/3 mb-2"></div>
                        <div class="h-3 bg-gray-200 rounded w-full mb-2"></div>
                        <div class="h-3 bg-gray-200 rounded w-5/6"></div>
                    </div>
                `;
            }

            function renderProposalEmpty() {
                if (!proposalModalBody) {
                    return;
                }

                proposalModalBody.innerHTML = `
                    <div class="text-center py-10">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900">No proposals yet</h4>
                        <p class="text-sm text-gray-600 mt-1">Freelancers have not submitted proposals for this job.</p>
                    </div>
                `;
            }

            function renderProposalError(message) {
                if (!proposalModalBody) {
                    return;
                }

                proposalModalBody.innerHTML = `
                    <div class="border border-red-200 bg-red-50 text-red-700 rounded-lg p-4 text-center">
                        <p class="font-medium">${escapeHtml(message)}</p>
                        <button type="button" data-action="retry-proposals"
                            class="mt-3 px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm font-medium">
                            Retry
                        </button>
                    </div>
                `;

                proposalModalBody.querySelector('[data-action="retry-proposals"]')?.addEventListener('click',
                    () => {
                        if (activeProposalJobId) {
                            fetchProposals(activeProposalJobId, activeProposalJobTitle, activeProposalTrigger);
                        }
                    });
            }

            function updateProposalButtonCount(button, count) {
                if (!button) {
                    return;
                }

                const countElement = button.querySelector('[data-proposals-count]');
                if (countElement) {
                    countElement.textContent = String(count);
                }
            }

            function renderProposalsList(proposals) {
                if (!proposalModalBody) {
                    return;
                }

                const cards = proposals.map((proposal) => {
                    const freelancer = proposal.freelancer || {};
                    const name = freelancer.name || 'Unknown Freelancer';
                    const initials = getInitials(name);
                    const photoUrl = freelancer.profile_photo_url;
                    const profileUrl = freelancer.profile_url;
                    const jobTitle = freelancer.job_title || 'Freelancer';
                    const status = proposal.status || 'pending';
                    const statusMeta = getProposalStatusMeta(status);
                    const isAccepted = status === 'accepted';
                    const isDeclined = status === 'declined';
                    const ratingValue = Number(freelancer.rating);
                    const ratingCount = Number(freelancer.rating_count);
                    const ratingText = Number.isFinite(ratingValue) && ratingValue > 0 ?
                        `${ratingValue.toFixed(1)} (${Number.isFinite(ratingCount) ? ratingCount : 0})` :
                        'No ratings';
                    const yearsExp = freelancer.years_experience ?
                        `${freelancer.years_experience} yrs exp` :
                        null;
                    const availability = freelancer.availability || null;
                    const hourlyRate = freelancer.hourly_rate ?
                        `${formatCurrency(freelancer.hourly_rate, '/hr')}` :
                        null;
                    const jobSuccess = freelancer.job_success_rate ?
                        `${Number(freelancer.job_success_rate).toFixed(0)}% job success` :
                        null;
                    const totalEarned = freelancer.total_earned ?
                        `${formatCurrency(freelancer.total_earned)} earned` :
                        null;
                    const completedProjects = freelancer.completed_projects ?
                        `${freelancer.completed_projects} completed` :
                        null;
                    const responseTime = freelancer.response_time ?
                        `Responds in ${freelancer.response_time} hr` :
                        null;
                    const languages = Array.isArray(freelancer.languages) && freelancer.languages.length ?
                        `Languages: ${freelancer.languages.join(', ')}` :
                        null;
                    const submitted = formatTimeAgo(proposal.created_at);
                    const bid = formatCurrency(proposal.bid_amount);
                    const timeline = proposal.estimated_timeline ?
                        escapeHtml(String(proposal.estimated_timeline)) :
                        'Timeline not specified';
                    const proposalText = formatProposalText(proposal.proposal_text);
                    const budgetFit = getBudgetFitMeta(proposal.bid_amount);
                    const metaItems = [ratingText, yearsExp, availability].filter(Boolean);
                    const metaHtml = metaItems.length ?
                        metaItems.map((item, index) =>
                            `${index > 0 ? '<span class="text-gray-300">•</span>' : ''}<span class="text-xs text-gray-500">${escapeHtml(String(item))}</span>`
                        ).join(' ') :
                        '<span class="text-xs text-gray-500">No additional details</span>';
                    const statChips = [hourlyRate, jobSuccess, totalEarned, completedProjects, responseTime]
                        .filter(Boolean)
                        .map((item) =>
                            `<span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">${escapeHtml(String(item))}</span>`
                        ).join('');

                    const avatarHtml = photoUrl ?
                        `<img src="${escapeHtml(photoUrl)}" alt="${escapeHtml(name)}" class="w-12 h-12 rounded-full object-cover">` :
                        `<span class="text-white font-bold text-sm">${escapeHtml(initials)}</span>`;

                    const nameHtml = profileUrl ?
                        `<a href="${escapeHtml(profileUrl)}" class="text-gray-900 hover:text-blue-600">${escapeHtml(name)}</a>` :
                        escapeHtml(name);

                    return `
                        <div class="border border-gray-200 rounded-lg p-4" data-proposal-id="${escapeHtml(proposal.id)}">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-3">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center select-none">
                                        ${avatarHtml}
                                    </div>
                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h4 class="font-semibold text-gray-900">${nameHtml}</h4>
                                            <span class="px-2 py-1 rounded-full text-xs font-medium ${statusMeta.className}"
                                                data-proposal-status>${statusMeta.label}</span>
                                            ${budgetFit ? `<span class="px-2 py-1 rounded-full text-xs font-medium ${budgetFit.className}">${budgetFit.label}</span>` : ''}
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">${escapeHtml(jobTitle)}</p>
                                        <div class="flex items-center space-x-2 mt-2">
                                            ${metaHtml}
                                        </div>
                                        ${languages ? `<div class="text-xs text-gray-500 mt-2">${escapeHtml(languages)}</div>` : ''}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">Bid</p>
                                    <p class="text-sm font-semibold text-gray-900">${bid}</p>
                                    <p class="text-xs text-gray-500 mt-1">${timeline}</p>
                                    <p class="text-xs text-gray-400 mt-2">${submitted}</p>
                                </div>
                            </div>
                            ${statChips ? `<div class="mt-3 flex flex-wrap gap-2 select-none">${statChips}</div>` : ''}
                            <div class="mt-4 text-sm text-gray-700 leading-relaxed">
                                ${proposalText}
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2 select-none">
                                <button type="button" data-proposal-action="accept" data-proposal-id="${escapeHtml(proposal.id)}"
                                    class="px-3 py-1.5 text-sm font-medium rounded-lg border border-emerald-200 text-emerald-700 hover:bg-emerald-50 transition ${isAccepted || isDeclined ? 'opacity-50 cursor-not-allowed' : ''}"
                                    ${isAccepted || isDeclined ? 'disabled' : ''}>
                                    Accept
                                </button>
                                <button type="button" data-proposal-action="decline" data-proposal-id="${escapeHtml(proposal.id)}"
                                    class="px-3 py-1.5 text-sm font-medium rounded-lg border border-red-200 text-red-700 hover:bg-red-50 transition ${isAccepted || isDeclined ? 'opacity-50 cursor-not-allowed' : ''}"
                                    ${isAccepted || isDeclined ? 'disabled' : ''}>
                                    Decline
                                </button>
                                <button type="button" data-proposal-action="message" data-proposal-id="${escapeHtml(proposal.id)}"
                                    data-freelancer-name="${escapeHtml(name)}" data-freelancer-user-id="${escapeHtml(freelancer.user_id || '')}"
                                    class="px-3 py-1.5 text-sm font-medium rounded-lg border border-blue-200 text-blue-700 hover:bg-blue-50 transition">
                                    Message
                                </button>
                                ${profileUrl ? `<a href="${escapeHtml(profileUrl)}"
                                                                                                                class="px-3 py-1.5 text-sm font-medium rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50 transition">View Profile</a>` : ''}
                            </div>
                        </div>
                    `;
                }).join('');

                proposalModalBody.innerHTML = cards;
            }

            async function fetchProposals(jobId, jobTitle, triggerButton) {
                if (!jobId) {
                    return;
                }

                activeProposalTrigger = triggerButton || null;
                activeProposalJobId = jobId;
                activeProposalJobTitle = jobTitle || 'Proposals';
                activeProposalJobBudget = null;

                clearProposalFeedback();
                setProposalModalTitle(activeProposalJobTitle, null);
                renderProposalLoading();
                openProposalModal();

                const endpoint = proposalsEndpointTemplate.replace('__JOB__', encodeURIComponent(String(
                    jobId)));

                try {
                    const response = await fetch(endpoint, {
                        method: 'GET',
                        headers: {
                            Accept: 'application/json',
                        },
                    });

                    const data = await response.json().catch(() => ({}));

                    if (!response.ok || !data.success) {
                        throw new Error(data.message || 'Failed to load proposals.');
                    }

                    const proposals = Array.isArray(data.proposals) ? data.proposals : [];
                    const count = proposals.length;
                    activeProposalJobBudget = data.job || null;

                    setProposalModalTitle(data.job?.title || activeProposalJobTitle, count);
                    updateProposalButtonCount(activeProposalTrigger, count);

                    if (count === 0) {
                        renderProposalEmpty();
                        return;
                    }

                    renderProposalsList(proposals);
                } catch (error) {
                    console.error('Proposal load failed:', error);
                    renderProposalError(error.message || 'Failed to load proposals.');
                }
            }

            function updateProposalCardStatus(proposalId, status) {
                if (!proposalModalBody) {
                    return;
                }

                const card = proposalModalBody.querySelector(`[data-proposal-id="${proposalId}"]`);
                if (!card) {
                    return;
                }

                const statusMeta = getProposalStatusMeta(status);
                const statusBadge = card.querySelector('[data-proposal-status]');
                if (statusBadge) {
                    statusBadge.textContent = statusMeta.label;
                    statusBadge.className = `px-2 py-1 rounded-full text-xs font-medium ${statusMeta.className}`;
                }

                card.querySelectorAll('[data-proposal-action="accept"], [data-proposal-action="decline"]').forEach(
                    (button) => {
                        button.disabled = true;
                        button.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                );
            }

            async function updateProposalStatus(proposalId, status) {
                if (!proposalId || !activeProposalJobId) {
                    return;
                }

                clearProposalFeedback();

                const endpoint = proposalStatusEndpointTemplate
                    .replace('__JOB__', encodeURIComponent(String(activeProposalJobId)))
                    .replace('__PROPOSAL__', encodeURIComponent(String(proposalId)));

                try {
                    const response = await fetch(endpoint, {
                        method: 'PATCH',
                        headers: {
                            Accept: 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({
                            status,
                        }),
                    });

                    const data = await response.json().catch(() => ({}));

                    if (!response.ok || !data.success) {
                        throw new Error(data.message || 'Unable to update proposal.');
                    }

                    updateProposalCardStatus(proposalId, data.proposal?.status || status);
                    showProposalFeedback('success', data.message || 'Proposal updated successfully.');
                } catch (error) {
                    console.error('Proposal status update failed:', error);
                    showProposalFeedback('error', error.message || 'Failed to update proposal status.');
                }
            }

            async function handleProposalMessage(button) {
                if (!button) {
                    return;
                }

                const freelancerName = button.dataset.freelancerName || 'there';
                const template = buildMessageTemplate(freelancerName, activeProposalJobTitle);

                try {
                    await navigator.clipboard.writeText(template);
                    showProposalFeedback('success', 'Message template copied. Opening messages...');
                    window.open(messagesUrl, '_blank');
                } catch (error) {
                    showProposalFeedback('error',
                        'Unable to copy message. You can still message from the inbox.');
                    window.open(messagesUrl, '_blank');
                }
            }

            function getStatusLabel(status) {
                const statusMap = {
                    open: 'Open',
                    in_progress: 'In Progress',
                    completed: 'Completed',
                    draft: 'Draft',
                    closed: 'Closed',
                };

                return statusMap[status] || 'Unknown';
            }

            function getStatusBadgeClass(status) {
                const classMap = {
                    open: 'bg-green-100 text-green-800',
                    in_progress: 'bg-blue-100 text-blue-800',
                    completed: 'bg-emerald-100 text-emerald-800',
                    draft: 'bg-amber-100 text-amber-800',
                    closed: 'bg-gray-100 text-gray-800',
                };

                return classMap[status] || 'bg-gray-100 text-gray-800';
            }

            function getTypeLabel(type) {
                return type === 'hourly' ? 'Hourly' : 'Fixed Price';
            }

            function getDurationLabel(duration) {
                const durationMap = {
                    less_than_1_month: 'Less than 1 month',
                    '1_to_3_months': '1 to 3 months',
                    '3_to_6_months': '3 to 6 months',
                    more_than_6_months: 'More than 6 months',
                };

                return durationMap[duration] || 'Not specified';
            }

            function normalizeSkills(skills) {
                if (Array.isArray(skills)) {
                    return skills.filter((skill) => typeof skill === 'string' && skill.trim() !== '');
                }

                return [];
            }

            function formatBudget(job) {
                const min = Number(job.budget_min);
                const max = Number(job.budget_max);

                if (Number.isFinite(min) && Number.isFinite(max) && min > 0 && max > 0) {
                    const suffix = job.type === 'hourly' ? '/hr' : '';
                    return `$${min.toLocaleString()} - $${max.toLocaleString()}${suffix}`;
                }

                if (Number.isFinite(min) && min > 0) {
                    const suffix = job.type === 'hourly' ? '/hr' : '';
                    return `$${min.toLocaleString()}${suffix}`;
                }

                return 'Negotiable';
            }

            function updateSummary(showing, total) {
                showingCount.textContent = String(showing);
                totalJobsCount.textContent = String(total);
            }

            function updateTabCounts(stats) {
                if (!stats || typeof stats !== 'object') {
                    return;
                }

                ['all', 'open', 'in_progress', 'completed', 'draft'].forEach((key) => {
                    const countEl = document.querySelector(`[data-tab-count="${key}"]`);
                    if (countEl && typeof stats[key] !== 'undefined') {
                        countEl.textContent = String(stats[key]);
                    }
                });
            }

            function setActiveTab(tab) {
                tabs.forEach((button) => {
                    button.classList.remove('border-blue-600', 'text-blue-600');
                    button.classList.add('border-transparent', 'text-gray-600');
                });

                const activeButton = document.querySelector(`[data-tab="${tab}"]`);
                if (activeButton) {
                    activeButton.classList.remove('border-transparent', 'text-gray-600');
                    activeButton.classList.add('border-blue-600', 'text-blue-600');
                }
            }

            function showLoading() {
                jobsLoading.classList.remove('hidden');
                jobsContainer.classList.add('hidden');
                emptyState.classList.add('hidden');
            }

            function hideLoading() {
                jobsLoading.classList.add('hidden');
            }

            function renderError(message) {
                jobsContainer.classList.remove('hidden');
                emptyState.classList.add('hidden');
                jobsContainer.innerHTML = `
                    <div class="col-span-full bg-white rounded-xl border border-red-200 p-6 text-center">
                        <p class="text-red-600 font-medium">${escapeHtml(message)}</p>
                        <button id="retry-load-jobs" type="button"
                            class="mt-3 px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm font-medium">
                            Retry
                        </button>
                    </div>
                `;

                document.getElementById('retry-load-jobs')?.addEventListener('click', fetchJobsOnce);
            }

            function renderJobs(jobs) {
                if (!Array.isArray(jobs) || jobs.length === 0) {
                    jobsContainer.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                    jobsContainer.innerHTML = '';
                    return;
                }

                const cardsHtml = jobs.map((job) => {
                    const skills = normalizeSkills(job.skills_required);
                    const skillsHtml = skills.length > 0 ?
                        skills.slice(0, 6).map((skill) =>
                            `<span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">${escapeHtml(skill)}</span>`
                        ).join('') :
                        '<span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded">No skills specified</span>';
                    const jobId = job?.id ?? '';
                    const editUrl = jobId ?
                        editJobRouteTemplate.replace('__JOB__', encodeURIComponent(String(jobId))) :
                        '#';

                    return `
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium select-none ${getStatusBadgeClass(job.status)}">
                                            ${getStatusLabel(job.status)}
                                        </span>
                                        <span class="text-xs text-gray-500">Posted: ${formatTimeAgo(job.created_at)}</span>
                                    </div>
                                    <h3 class="font-bold text-gray-900 mb-2 text-lg">${escapeHtml(job.title || 'Untitled job')}</h3>
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        ${renderFormattedDescriptionPreview(job.description)}
                                    </p>
                                    <div class="flex flex-wrap gap-2 mb-4 select-none">
                                        ${skillsHtml}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-center space-x-6">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                        </svg>
                                        <span class="font-semibold text-gray-900">${formatBudget(job)}</span>
                                        <span class="text-gray-500 text-sm ml-2">${getTypeLabel(job.type)}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-gray-600 text-sm">${getDurationLabel(job.duration)}</span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 select-none">
                                    <button type="button" data-action="view-proposals"
                                        data-job-id="${jobId}" data-job-title="${escapeHtml(job.title || 'Untitled job')}"
                                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition duration-200">
                                        View Proposals
                                        <span data-proposals-count
                                            class="ml-2 bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">${Number(job.proposals_count || 0)}</span>
                                    </button>
                                    <a href="${editUrl}"
                                        class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm font-medium transition duration-200">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');

                jobsContainer.innerHTML = cardsHtml;
                jobsContainer.classList.remove('hidden');
                emptyState.classList.add('hidden');
            }

            function computeStats(jobs) {
                return {
                    all: jobs.length,
                    open: jobs.filter((job) => job.status === 'open').length,
                    in_progress: jobs.filter((job) => job.status === 'in_progress').length,
                    completed: jobs.filter((job) => job.status === 'completed').length,
                    draft: jobs.filter((job) => job.status === 'draft').length,
                };
            }

            function sortJobs(jobs, sort) {
                const sortedJobs = [...jobs];

                const getBudgetHigh = (job) => {
                    const max = Number(job.budget_max);
                    const min = Number(job.budget_min);
                    if (Number.isFinite(max)) return max;
                    if (Number.isFinite(min)) return min;
                    return 0;
                };

                const getBudgetLow = (job) => {
                    const min = Number(job.budget_min);
                    const max = Number(job.budget_max);
                    if (Number.isFinite(min)) return min;
                    if (Number.isFinite(max)) return max;
                    return 0;
                };

                switch (sort) {
                    case 'oldest':
                        sortedJobs.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                        break;
                    case 'budget_high':
                        sortedJobs.sort((a, b) => {
                            const diff = getBudgetHigh(b) - getBudgetHigh(a);
                            if (diff !== 0) return diff;
                            return new Date(b.created_at) - new Date(a.created_at);
                        });
                        break;
                    case 'budget_low':
                        sortedJobs.sort((a, b) => {
                            const diff = getBudgetLow(a) - getBudgetLow(b);
                            if (diff !== 0) return diff;
                            return new Date(b.created_at) - new Date(a.created_at);
                        });
                        break;
                    default:
                        sortedJobs.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                        break;
                }

                return sortedJobs;
            }

            function applyCurrentFilters() {
                if (!hasFetchedJobs) {
                    return;
                }

                const searchValue = searchInput.value.trim().toLowerCase();
                const selectedType = filterType.value;
                const selectedExperience = filterExperience.value;
                const selectedDuration = filterDuration.value;
                const selectedSort = filterSort.value || 'newest';

                let filteredJobs = allJobsData.filter((job) => {
                    if (currentTab !== 'all' && job.status !== currentTab) {
                        return false;
                    }

                    if (selectedType && job.type !== selectedType) {
                        return false;
                    }

                    if (selectedExperience && job.experience_level !== selectedExperience) {
                        return false;
                    }

                    if (selectedDuration && job.duration !== selectedDuration) {
                        return false;
                    }

                    if (searchValue !== '') {
                        const title = (job.title || '').toLowerCase();
                        const description = (job.description || '').toLowerCase();
                        const category = (job.category?.name || '').toLowerCase();
                        const skills = normalizeSkills(job.skills_required).join(' ').toLowerCase();

                        if (!title.includes(searchValue) && !description.includes(searchValue) && !category
                            .includes(
                                searchValue) && !skills.includes(searchValue)) {
                            return false;
                        }
                    }

                    return true;
                });

                filteredJobs = sortJobs(filteredJobs, selectedSort);

                renderJobs(filteredJobs);
                updateSummary(filteredJobs.length, totalJobsFromServer);
            }

            async function fetchJobsOnce() {
                if (hasFetchedJobs || isFetchingJobs) {
                    applyCurrentFilters();
                    return;
                }

                isFetchingJobs = true;
                showLoading();

                try {
                    const response = await fetch(jobsEndpoint, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                        },
                    });

                    const data = await response.json();
                    if (!response.ok || !data.success) {
                        throw new Error(data.message || 'Failed to fetch jobs.');
                    }

                    allJobsData = Array.isArray(data.jobs) ? data.jobs : [];
                    hasFetchedJobs = true;

                    const stats = (data.stats && typeof data.stats === 'object') ? data.stats : computeStats(
                        allJobsData);
                    totalJobsFromServer = Number(stats.all ?? allJobsData.length);

                    updateTabCounts(stats);
                    applyCurrentFilters();
                } catch (error) {
                    console.error('Error loading my jobs:', error);
                    renderError(error.message || 'Failed to load jobs.');
                    updateSummary(0, totalJobsFromServer);
                } finally {
                    isFetchingJobs = false;
                    hideLoading();
                }
            }

            tabs.forEach((button) => {
                button.addEventListener('click', () => {
                    currentTab = button.dataset.tab || 'all';
                    setActiveTab(currentTab);
                    applyCurrentFilters();
                });
            });

            jobsContainer?.addEventListener('click', (event) => {
                const button = event.target.closest('[data-action="view-proposals"]');
                if (!button) {
                    return;
                }

                const jobId = button.dataset.jobId;
                if (!jobId) {
                    return;
                }

                const jobTitle = button.dataset.jobTitle || 'Proposals';
                fetchProposals(jobId, jobTitle, button);
            });

            proposalModalBody?.addEventListener('click', (event) => {
                const button = event.target.closest('[data-proposal-action]');
                if (!button || button.disabled) {
                    return;
                }

                const proposalId = button.dataset.proposalId;
                if (!proposalId) {
                    return;
                }

                const action = button.dataset.proposalAction;
                if (action === 'accept') {
                    updateProposalStatus(proposalId, 'accepted');
                } else if (action === 'decline') {
                    updateProposalStatus(proposalId, 'declined');
                } else if (action === 'message') {
                    handleProposalMessage(button);
                }
            });

            closeProposalModalBtn?.addEventListener('click', closeProposalModal);
            closeProposalModalFooterBtn?.addEventListener('click', closeProposalModal);
            proposalBackdrop?.addEventListener('click', closeProposalModal);

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && proposalModal && !proposalModal.classList.contains(
                        'hidden')) {
                    closeProposalModal();
                }
            });

            document.getElementById('filter-toggle')?.addEventListener('click', () => {
                filterPanel.classList.toggle('hidden');
            });

            document.getElementById('apply-filters')?.addEventListener('click', () => {
                applyCurrentFilters();
            });

            function resetAllFilters() {
                filterType.value = '';
                filterExperience.value = '';
                filterDuration.value = '';
                filterSort.value = 'newest';
                searchInput.value = '';
                currentTab = 'all';
                setActiveTab(currentTab);
            }

            document.getElementById('clear-filters')?.addEventListener('click', () => {
                resetAllFilters();
                applyCurrentFilters();
            });

            document.getElementById('clear-all-filters')?.addEventListener('click', () => {
                resetAllFilters();
                applyCurrentFilters();
            });

            searchInput.addEventListener('input', () => {
                if (searchTimer) {
                    clearTimeout(searchTimer);
                }

                searchTimer = setTimeout(() => {
                    applyCurrentFilters();
                }, 350);
            });

            setActiveTab(currentTab);
            fetchJobsOnce();
        });
    </script>
@endpush
