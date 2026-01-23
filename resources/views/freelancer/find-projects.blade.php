@extends('layouts.app')

@section('title', 'Find Projects')

@section('content')
    <!-- Page Header -->
    <div class="mb-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Find Projects</h1>
            <p class="text-gray-600 mt-1">
                Browse and apply for freelance projects
            </p>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-3">
        <div class="flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0">
            <!-- Tabs -->
            <div class="flex space-x-6 overflow-x-auto select-none">
                <button onclick="filterJobs('all')" id="tab-all"
                    class="pb-2 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap border-b-2 border-blue-6000">
                    All Jobs
                </button>
            </div>

            <!-- Search and Filter -->
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

        <!-- Advanced Filters (Hidden by default) -->
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
                <button id="apply-filters" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                    Apply Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Job Details Modal -->
    <div id="job-details-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden z-50 transition-opacity duration-300">
        <div class="fixed inset-0 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl w-full">
                    <!-- Modal Header -->
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-gray-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-gray-900" id="modal-title">Project Details</h3>
                                <div class="mt-2">
                                    <div class="flex items-center space-x-2">
                                        <span id="modal-status" class="px-2 py-1 rounded-full text-xs font-medium"></span>
                                        <span class="text-sm text-gray-500" id="modal-posted-time"></span>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="close-modal"
                                class="text-gray-400 hover:text-gray-500 rounded-lg p-2">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Modal Content -->
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 overflow-y-auto max-h-[70vh]">
                        <div class="space-y-6">
                            <!-- Project Title -->
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900" id="modal-job-title"></h2>
                                <div class="mt-1 flex items-center space-x-4">
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                        </svg>
                                        <span class="font-medium" id="modal-budget"></span>
                                        <span class="text-gray-500 ml-2" id="modal-type"></span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span id="modal-duration"></span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span id="modal-experience"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Project Description -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Project Description</h3>
                                <div class="prose max-w-none text-gray-700" id="modal-description"></div>
                            </div>

                            <!-- Skills Required -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Skills Required</h3>
                                <div class="flex flex-wrap gap-2" id="modal-skills"></div>
                            </div>

                            <!-- Project Details Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h4 class="font-semibold text-gray-900 mb-2">Project Type</h4>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <span id="modal-detail-type" class="text-gray-700"></span>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h4 class="font-semibold text-gray-900 mb-2">Experience Level</h4>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span id="modal-detail-experience" class="text-gray-700"></span>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h4 class="font-semibold text-gray-900 mb-2">Timeline</h4>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span id="modal-detail-duration" class="text-gray-700"></span>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h4 class="font-semibold text-gray-900 mb-2">Proposals</h4>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span id="modal-proposals-count" class="text-gray-700"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Posted Information -->
                            <div class="border-t border-gray-200 pt-4">
                                <div class="text-sm text-gray-500">
                                    <p>Project posted: <span id="modal-created-at"></span></p>
                                    <p>Expires: <span id="modal-expires-at"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-3 border-t border-gray-200">
                        <button type="button" id="apply-project-btn"
                            class="inline-flex w-full justify-center rounded-md bg-gray-800 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-black sm:w-auto transition duration-200">
                            Submit Proposal
                        </button>
                        <button type="button" id="save-project-btn"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                            Save Project
                        </button>
                        <button type="button" id="cancel-modal"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition duration-200">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jobs Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3" id="jobs-container">
        <!-- Job Card Template (Hidden) -->
        <template id="job-card-template">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200 cursor-pointer h-full flex flex-col"
                data-status="open" data-type="fixed" data-experience="expert" data-duration="3_to_6_months">
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 select-none status-badge">
                                    Open
                                </span>
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs text-gray-500 posted-time">Posted: Just now</span>
                                    <button class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2 text-lg job-title">Untitled Project</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2 job-description">
                                No description provided.
                            </p>
                            <div class="flex flex-wrap gap-2 mb-4 select-none skills-container">
                                <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">No Skills
                                    Required</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-6 space-y-3 sm:space-y-0">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                    <span class="font-semibold text-gray-900 budget-amount">Budget not specified</span>
                                    <span class="text-gray-500 text-sm ml-2 job-type">Not specified</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-gray-600 text-sm duration-text">Duration not specified</span>
                                </div>
                            </div>
                            <button
                                class="flex-1 xs:flex-none px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm font-medium transition duration-200 flex items-center justify-center select-none view-project-btn">
                                <span>View Project</span>
                                <span
                                    class="ml-2 bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full proposals-count">0</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Skeleton Loading Template -->
        <template id="skeleton-template">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 h-full flex flex-col">
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <!-- Status Badge Skeleton -->
                                <div class="w-16 h-6 bg-gray-200 rounded-full animate-pulse"></div>
                                <div class="flex items-center space-x-2">
                                    <!-- Posted Time Skeleton -->
                                    <div class="w-24 h-4 bg-gray-200 rounded animate-pulse"></div>
                                    <!-- Menu Button Skeleton -->
                                    <div class="w-5 h-5 bg-gray-200 rounded animate-pulse"></div>
                                </div>
                            </div>
                            <!-- Title Skeleton -->
                            <div class="w-3/4 h-6 bg-gray-200 rounded mb-2 animate-pulse"></div>
                            <!-- Description Skeleton -->
                            <div class="space-y-2 mb-4">
                                <div class="w-full h-4 bg-gray-200 rounded animate-pulse"></div>
                                <div class="w-2/3 h-4 bg-gray-200 rounded animate-pulse"></div>
                            </div>
                            <!-- Skills Skeleton -->
                            <div class="flex flex-wrap gap-2 mb-3">
                                <div class="w-20 h-6 bg-gray-200 rounded animate-pulse"></div>
                                <div class="w-16 h-6 bg-gray-200 rounded animate-pulse"></div>
                                <div class="w-24 h-6 bg-gray-200 rounded animate-pulse"></div>
                            </div>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <div class="w-20 h-6 bg-gray-200 rounded animate-pulse"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-6 space-y-3 sm:space-y-0">
                                <!-- Budget Section Skeleton -->
                                <div class="flex items-center">
                                    <div class="w-5 h-5 bg-gray-200 rounded mr-2 animate-pulse"></div>
                                    <div class="w-32 h-5 bg-gray-200 rounded animate-pulse"></div>
                                </div>
                                <!-- Duration Section Skeleton -->
                                <div class="flex items-center">
                                    <div class="w-5 h-5 bg-gray-200 rounded mr-2 animate-pulse"></div>
                                    <div class="w-24 h-4 bg-gray-200 rounded animate-pulse"></div>
                                </div>
                            </div>
                            <!-- View Project Button Skeleton -->
                            <div class="flex-1 xs:flex-none">
                                <div class="w-full h-10 bg-gray-200 rounded-lg animate-pulse"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        {{-- Container for displaying jobs --}}
        <div id="jobs-container" class="space-y-6">
            <!-- Jobs will be dynamically inserted here -->
        </div>

        {{-- <script>
            const jobsContainer = document.getElementById('jobs-container');
            const jobCardTemplate = document.getElementById('job-card-template');
            const skeletonTemplate = document.getElementById('skeleton-template');

            // Function to show skeleton loading animation
            function showSkeletonLoading(count = 4) {
                jobsContainer.innerHTML = '';

                for (let i = 0; i < count; i++) {
                    const skeleton = skeletonTemplate.content.cloneNode(true);
                    jobsContainer.appendChild(skeleton);
                }
            }

            async function fetchJobs() {
                // Skeleton loading
                showSkeletonLoading();

                try {
                    const response = await fetch('{{ route('find-projects.jobs') }}', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const data = await response.json();

                    if (data.success) {
                        displayJobs(data.jobs);
                    } else {
                        throw new Error(data.message || 'Failed to fetch jobs');
                    }
                } catch (error) {
                    console.error('Error fetching jobs:', error);
                    jobsContainer.innerHTML =
                        '<div class="text-center p-8 bg-white rounded-xl shadow-sm border border-gray-200 h-full flex items-center justify-center">' +
                        '<div>' +
                        '<p class="text-gray-600 mb-2">Error loading projects. Please try again.</p>' +
                        '<button onclick="fetchJobs()" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm font-medium transition duration-200">' +
                        'Retry' +
                        '</button>' +
                        '</div>' +
                        '</div>';
                }
            }

            function displayJobs(jobs) {
                if (!jobs || jobs.length === 0) {
                    jobsContainer.innerHTML =
                        '<div class="text-center p-8 bg-white rounded-xl shadow-sm border border-gray-200 h-full flex items-center justify-center"><p class="text-gray-600">No open projects found.</p></div>';
                    return;
                }

                // Clear existing content
                jobsContainer.innerHTML = '';

                jobs.forEach(job => {
                    // Clone the template
                    const jobCard = jobCardTemplate.content.cloneNode(true);
                    const cardElement = jobCard.querySelector('div');

                    // Set data attributes
                    cardElement.setAttribute('data-status', job.status || 'open');
                    cardElement.setAttribute('data-type', job.type || 'fixed');
                    cardElement.setAttribute('data-experience', job.experience_level || 'expert');
                    cardElement.setAttribute('data-duration', job.duration || '3_to_6_months');

                    // Set status badge
                    const statusBadge = cardElement.querySelector('.status-badge');
                    if (job.status) {
                        statusBadge.textContent = job.status.charAt(0).toUpperCase() + job.status.slice(1);
                        // Update badge color based on status
                        if (job.status === 'open') {
                            statusBadge.className =
                                'px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 select-none status-badge';
                        } else if (job.status === 'closed') {
                            statusBadge.className =
                                'px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 select-none status-badge';
                        } else if (job.status === 'in_progress') {
                            statusBadge.className =
                                'px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 select-none status-badge';
                        }
                    }

                    // Set posted time
                    const postedTime = cardElement.querySelector('.posted-time');
                    postedTime.textContent = `Posted: ${formatTimeAgo(job.created_at)}`;

                    // Set job title
                    const jobTitle = cardElement.querySelector('.job-title');
                    jobTitle.textContent = job.title || 'Untitled Project';

                    // Set job description
                    const jobDescription = cardElement.querySelector('.job-description');
                    jobDescription.textContent = job.description || 'No description provided.';

                    // Set skills
                    const skillsContainer = cardElement.querySelector('.skills-container');
                    skillsContainer.innerHTML = '';

                    if (job.skills_required && job.skills_required.length > 0) {
                        job.skills_required.forEach(skill => {
                            const skillElement = document.createElement('span');
                            skillElement.className =
                                'px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded';
                            skillElement.textContent = skill;
                            skillsContainer.appendChild(skillElement);
                        });
                    } else {
                        const noSkillElement = document.createElement('span');
                        noSkillElement.className = 'px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded';
                        noSkillElement.textContent = 'No Skills Required';
                        skillsContainer.appendChild(noSkillElement);
                    }

                    // Set budget and job type
                    const budgetAmount = cardElement.querySelector('.budget-amount');
                    const jobType = cardElement.querySelector('.job-type');

                    if (job.budget_min && job.budget_max) {
                        budgetAmount.textContent = `$${job.budget_min} - $${job.budget_max}`;
                    } else {
                        budgetAmount.textContent = 'Budget not specified';
                    }

                    if (job.type) {
                        jobType.textContent = job.type.charAt(0).toUpperCase() + job.type.slice(1);
                    } else {
                        jobType.textContent = 'Not specified';
                    }

                    // Set duration
                    const durationText = cardElement.querySelector('.duration-text');
                    durationText.textContent = job.duration || 'Duration not specified';

                    // Set proposals count
                    const proposalsCount = cardElement.querySelector('.proposals-count');
                    proposalsCount.textContent = job.proposals_count || 0;

                    // Append to container
                    jobsContainer.appendChild(jobCard);
                });
            }

            function formatTimeAgo(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const diffInSeconds = Math.floor((now - date) / 1000);

                if (diffInSeconds < 60) return 'Just now';
                if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} minutes ago`;
                if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} hours ago`;
                if (diffInSeconds < 604800) return `${Math.floor(diffInSeconds / 86400)} days ago`;
                if (diffInSeconds < 2592000) return `${Math.floor(diffInSeconds / 604800)} weeks ago`;
                return `${Math.floor(diffInSeconds / 2592000)} months ago`;
            }

            // Call fetchJobs when the page loads
            document.addEventListener('DOMContentLoaded', fetchJobs);
        </script> --}}

        <script>
            const jobsContainer = document.getElementById('jobs-container');
            const jobCardTemplate = document.getElementById('job-card-template');
            const skeletonTemplate = document.getElementById('skeleton-template');

            // Modal elements
            const jobDetailsModal = document.getElementById('job-details-modal');
            const closeModalBtn = document.getElementById('close-modal');
            const cancelModalBtn = document.getElementById('cancel-modal');
            const applyProjectBtn = document.getElementById('apply-project-btn');
            const saveProjectBtn = document.getElementById('save-project-btn');

            // Function to show skeleton loading animation
            function showSkeletonLoading(count = 4) {
                jobsContainer.innerHTML = '';

                for (let i = 0; i < count; i++) {
                    const skeleton = skeletonTemplate.content.cloneNode(true);
                    jobsContainer.appendChild(skeleton);
                }
            }

            // Modal functions
            function openModal() {
                jobDetailsModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }

            function closeModal() {
                jobDetailsModal.classList.add('hidden');
                document.body.style.overflow = 'auto'; // Restore scrolling
            }

            // Event listeners for modal
            closeModalBtn.addEventListener('click', closeModal);
            cancelModalBtn.addEventListener('click', closeModal);

            // Close modal when clicking outside the modal content
            jobDetailsModal.addEventListener('click', (e) => {
                if (e.target === jobDetailsModal) {
                    closeModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !jobDetailsModal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            async function fetchJobs() {
                // Skeleton loading
                showSkeletonLoading();

                try {
                    const response = await fetch('{{ route('find-projects.jobs') }}', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const data = await response.json();

                    if (data.success) {
                        displayJobs(data.jobs);
                    } else {
                        throw new Error(data.message || 'Failed to fetch jobs');
                    }
                } catch (error) {
                    console.error('Error fetching jobs:', error);
                    jobsContainer.innerHTML =
                        '<div class="text-center p-8 bg-white rounded-xl shadow-sm border border-gray-200 h-full flex items-center justify-center">' +
                        '<div>' +
                        '<p class="text-gray-600 mb-2">Error loading projects. Please try again.</p>' +
                        '<button onclick="fetchJobs()" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm font-medium transition duration-200">' +
                        'Retry' +
                        '</button>' +
                        '</div>' +
                        '</div>';
                }
            }

            async function fetchJobDetails(jobId) {
                try {
                    const response = await fetch(`/find-projects/jobs/${jobId}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const data = await response.json();

                    if (data.success) {
                        displayJobDetails(data.job);
                        openModal();
                    } else {
                        throw new Error(data.message || 'Failed to fetch job details');
                    }
                } catch (error) {
                    console.error('Error fetching job details:', error);
                    alert('Failed to load project details. Please try again.');
                }
            }

            function displayJobDetails(job) {
                // Set modal title
                document.getElementById('modal-title').textContent = 'Project Details';
                document.getElementById('modal-job-title').textContent = job.title || 'Untitled Project';

                // Set status badge
                const statusBadge = document.getElementById('modal-status');
                statusBadge.textContent = job.status ? job.status.charAt(0).toUpperCase() + job.status.slice(1) : 'Open';

                // Update badge color based on status
                if (job.status === 'open') {
                    statusBadge.className = 'px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800';
                } else if (job.status === 'closed') {
                    statusBadge.className = 'px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800';
                } else if (job.status === 'in_progress') {
                    statusBadge.className = 'px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
                } else {
                    statusBadge.className = 'px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
                }

                // Set posted time
                document.getElementById('modal-posted-time').textContent = `Posted: ${formatTimeAgo(job.created_at)}`;

                // Set budget and type
                const budgetElement = document.getElementById('modal-budget');
                if (job.budget_min && job.budget_max) {
                    budgetElement.textContent = `$${job.budget_min} - $${job.budget_max}`;
                } else {
                    budgetElement.textContent = 'Budget not specified';
                }

                const typeElement = document.getElementById('modal-type');
                typeElement.textContent = job.type ? job.type.charAt(0).toUpperCase() + job.type.slice(1) : 'Not specified';

                // Set duration
                document.getElementById('modal-duration').textContent = job.duration ? formatDuration(job.duration) :
                    'Duration not specified';
                document.getElementById('modal-detail-duration').textContent = job.duration ? formatDuration(job.duration) :
                    'Not specified';

                // Set experience level
                const experienceElement = document.getElementById('modal-experience');
                const detailExperienceElement = document.getElementById('modal-detail-experience');
                if (job.experience_level) {
                    const experienceText = formatExperienceLevel(job.experience_level);
                    experienceElement.textContent = experienceText;
                    detailExperienceElement.textContent = experienceText;
                } else {
                    experienceElement.textContent = 'Experience not specified';
                    detailExperienceElement.textContent = 'Not specified';
                }

                // Set description
                const descriptionElement = document.getElementById('modal-description');
                descriptionElement.innerHTML = job.description ?
                    job.description.replace(/\n/g, '<br>') :
                    '<p class="text-gray-500 italic">No description provided.</p>';

                // Set skills
                const skillsContainer = document.getElementById('modal-skills');
                skillsContainer.innerHTML = '';

                if (job.skills_required && job.skills_required.length > 0) {
                    // Parse skills if it's a JSON string
                    let skills = job.skills_required;
                    if (typeof skills === 'string') {
                        try {
                            skills = JSON.parse(skills);
                        } catch (e) {
                            skills = skills.split(',').map(skill => skill.trim());
                        }
                    }

                    skills.forEach(skill => {
                        const skillElement = document.createElement('span');
                        skillElement.className =
                            'px-3 py-1.5 bg-blue-50 text-blue-700 text-sm font-medium rounded-full border border-blue-100';
                        skillElement.textContent = skill;
                        skillsContainer.appendChild(skillElement);
                    });
                } else {
                    const noSkillElement = document.createElement('span');
                    noSkillElement.className =
                        'px-3 py-1.5 bg-gray-50 text-gray-700 text-sm font-medium rounded-full border border-gray-200';
                    noSkillElement.textContent = 'No skills specified';
                    skillsContainer.appendChild(noSkillElement);
                }

                // Set detail type
                document.getElementById('modal-detail-type').textContent = job.type ?
                    job.type.charAt(0).toUpperCase() + job.type.slice(1) : 'Not specified';

                // Set proposals count
                const proposalsElement = document.getElementById('modal-proposals-count');
                proposalsElement.textContent = job.proposals_count ? `${job.proposals_count} proposals` : '0 proposals';

                // Set dates
                document.getElementById('modal-created-at').textContent = formatDate(job.created_at);
                document.getElementById('modal-expires-at').textContent = job.expires_at ? formatDate(job.expires_at) :
                    'No expiration date';

                // Update button actions
                applyProjectBtn.onclick = () => {
                    alert(`Applying to: ${job.title}`);
                    // You can redirect to application page or show application form here
                    // window.location.href = `/jobs/${job.id}/apply`;
                };

                saveProjectBtn.onclick = () => {
                    alert(`Project "${job.title}" saved to your list!`);
                    // Add save functionality here
                };
            }

            function displayJobs(jobs) {
                if (!jobs || jobs.length === 0) {
                    jobsContainer.innerHTML =
                        '<div class="text-center p-8 bg-white rounded-xl shadow-sm border border-gray-200 h-full flex items-center justify-center"><p class="text-gray-600">No open projects found.</p></div>';
                    return;
                }

                // Clear existing content
                jobsContainer.innerHTML = '';

                jobs.forEach(job => {
                    // Clone the template
                    const jobCard = jobCardTemplate.content.cloneNode(true);
                    const cardElement = jobCard.querySelector('div');

                    // Set data attributes
                    cardElement.setAttribute('data-id', job.id);
                    cardElement.setAttribute('data-status', job.status || 'open');
                    cardElement.setAttribute('data-type', job.type || 'fixed');
                    cardElement.setAttribute('data-experience', job.experience_level || 'expert');
                    cardElement.setAttribute('data-duration', job.duration || '3_to_6_months');

                    // Set status badge
                    const statusBadge = cardElement.querySelector('.status-badge');
                    if (job.status) {
                        statusBadge.textContent = job.status.charAt(0).toUpperCase() + job.status.slice(1);
                        // Update badge color based on status
                        if (job.status === 'open') {
                            statusBadge.className =
                                'px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 select-none status-badge';
                        } else if (job.status === 'closed') {
                            statusBadge.className =
                                'px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 select-none status-badge';
                        } else if (job.status === 'in_progress') {
                            statusBadge.className =
                                'px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 select-none status-badge';
                        }
                    }

                    // Set posted time
                    const postedTime = cardElement.querySelector('.posted-time');
                    postedTime.textContent = `Posted: ${formatTimeAgo(job.created_at)}`;

                    // Set job title
                    const jobTitle = cardElement.querySelector('.job-title');
                    jobTitle.textContent = job.title || 'Untitled Project';

                    // Set job description
                    const jobDescription = cardElement.querySelector('.job-description');
                    jobDescription.textContent = job.description || 'No description provided.';

                    // Set skills
                    const skillsContainer = cardElement.querySelector('.skills-container');
                    skillsContainer.innerHTML = '';

                    if (job.skills_required && job.skills_required.length > 0) {
                        // Parse skills if it's a JSON string
                        let skills = job.skills_required;
                        if (typeof skills === 'string') {
                            try {
                                skills = JSON.parse(skills);
                            } catch (e) {
                                skills = skills.split(',').map(skill => skill.trim());
                            }
                        }

                        skills.forEach(skill => {
                            const skillElement = document.createElement('span');
                            skillElement.className =
                                'px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded';
                            skillElement.textContent = skill;
                            skillsContainer.appendChild(skillElement);
                        });
                    } else {
                        const noSkillElement = document.createElement('span');
                        noSkillElement.className = 'px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded';
                        noSkillElement.textContent = 'No Skills Required';
                        skillsContainer.appendChild(noSkillElement);
                    }

                    // Set budget and job type
                    const budgetAmount = cardElement.querySelector('.budget-amount');
                    const jobType = cardElement.querySelector('.job-type');

                    if (job.budget_min && job.budget_max) {
                        budgetAmount.textContent = `$${job.budget_min} - $${job.budget_max}`;
                    } else {
                        budgetAmount.textContent = 'Budget not specified';
                    }

                    if (job.type) {
                        jobType.textContent = job.type.charAt(0).toUpperCase() + job.type.slice(1);
                    } else {
                        jobType.textContent = 'Not specified';
                    }

                    // Set duration
                    const durationText = cardElement.querySelector('.duration-text');
                    durationText.textContent = formatDuration(job.duration) || 'Duration not specified';

                    // Set proposals count
                    const proposalsCount = cardElement.querySelector('.proposals-count');
                    proposalsCount.textContent = job.proposals_count || 0;

                    // Add click event to "View Project" button
                    const viewProjectBtn = cardElement.querySelector('.view-project-btn');
                    viewProjectBtn.addEventListener('click', () => {
                        fetchJobDetails(job.id);
                    });

                    // Make entire card clickable (optional)
                    cardElement.addEventListener('click', (e) => {
                        // Don't trigger if clicking on the view project button or menu button
                        if (!e.target.closest('.view-project-btn') && !e.target.closest(
                                'button.text-gray-400')) {
                            fetchJobDetails(job.id);
                        }
                    });

                    // Append to container
                    jobsContainer.appendChild(jobCard);
                });
            }

            function formatTimeAgo(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const diffInSeconds = Math.floor((now - date) / 1000);

                if (diffInSeconds < 60) return 'Just now';
                if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} minutes ago`;
                if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} hours ago`;
                if (diffInSeconds < 604800) return `${Math.floor(diffInSeconds / 86400)} days ago`;
                if (diffInSeconds < 2592000) return `${Math.floor(diffInSeconds / 604800)} weeks ago`;
                return `${Math.floor(diffInSeconds / 2592000)} months ago`;
            }

            function formatDate(dateString) {
                if (!dateString) return 'Not specified';
                const date = new Date(dateString);
                return date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            function formatDuration(duration) {
                if (!duration) return 'Not specified';

                const durationMap = {
                    'less_than_1_month': 'Less than 1 month',
                    '1_to_3_months': '1-3 months',
                    '3_to_6_months': '3-6 months',
                    '6_months_to_1_year': '6 months - 1 year',
                    'more_than_1_year': 'More than 1 year'
                };

                return durationMap[duration] || duration.replace(/_/g, ' ');
            }

            function formatExperienceLevel(experience) {
                if (!experience) return 'Not specified';

                const experienceMap = {
                    'entry': 'Entry Level',
                    'intermediate': 'Intermediate',
                    'expert': 'Expert'
                };

                return experienceMap[experience] || experience.charAt(0).toUpperCase() + experience.slice(1);
            }

            // Call fetchJobs when the page loads
            document.addEventListener('DOMContentLoaded', fetchJobs);
        </script>
    </div>

    <!-- Empty State (Hidden by default) -->
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
            class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm font-medium">
            Clear All Filters
        </button>
    </div>

    <!-- Pagination -->
    <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-200">
        <div class="text-sm text-gray-700">
            Showing <span id="showing-from">1</span> to <span id="showing-to">6</span> of <span id="total-jobs">12</span>
            jobs
        </div>
        <div class="flex items-center space-x-2">
            <button
                class="px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                id="prev-page" disabled>
                Previous
            </button>
            <div class="flex items-center space-x-1">
                <button class="w-8 h-8 rounded-lg bg-blue-600 text-white text-sm font-medium">1</button>
                <button class="w-8 h-8 rounded-lg text-gray-700 hover:bg-gray-100 text-sm font-medium">2</button>
            </div>
            <button class="px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50"
                id="next-page">
                Next
            </button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar')?.classList.toggle('active');
        });

        // Filter toggle functionality
        document.getElementById('filter-toggle')?.addEventListener('click', function() {
            const filters = document.getElementById('advanced-filters');
            filters.classList.toggle('hidden');
        });

        // Tab filtering
        function filterJobs(status) {
            // Update active tab
            document.querySelectorAll('[id^="tab-"]').forEach(tab => {
                tab.classList.remove('border-blue-600', 'text-blue-600');
                tab.classList.add('border-transparent');
            });
            const activeTab = document.getElementById(`tab-${status}`);
            activeTab.classList.add('border-blue-600', 'text-blue-600');
            activeTab.classList.remove('border-transparent');

            // Filter job cards
            const jobCards = document.querySelectorAll('[data-status]');
            const emptyState = document.getElementById('empty-state');
            const jobsContainer = document.getElementById('jobs-container');
            let visibleCount = 0;

            jobCards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            // Show/hide empty state
            if (visibleCount === 0) {
                jobsContainer.classList.add('hidden');
                emptyState.classList.remove('hidden');
            } else {
                jobsContainer.classList.remove('hidden');
                emptyState.classList.add('hidden');
            }

            // Update showing counts
            updateShowingCounts(visibleCount);
        }

        // Search functionality
        document.getElementById('job-search')?.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const jobCards = document.querySelectorAll('[data-status]');
            const activeTab = document.querySelector('[id^="tab-"]:not(.border-transparent)')?.id?.replace('tab-',
                '') || 'all';
            let visibleCount = 0;

            jobCards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const description = card.querySelector('p').textContent.toLowerCase();
                const skills = Array.from(card.querySelectorAll('[class*="bg-blue-50"]')).map(tag => tag
                    .textContent.toLowerCase()).join(' ');

                const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm) ||
                    skills.includes(searchTerm);
                const matchesTab = activeTab === 'all' || card.dataset.status === activeTab;

                if (matchesSearch && matchesTab) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            updateEmptyState(visibleCount);
            updateShowingCounts(visibleCount);
        });

        // Advanced filtering
        document.getElementById('apply-filters')?.addEventListener('click', function() {
            const type = document.getElementById('filter-type').value;
            const experience = document.getElementById('filter-experience').value;
            const duration = document.getElementById('filter-duration').value;
            const sort = document.getElementById('filter-sort').value;
            const searchTerm = document.getElementById('job-search').value.toLowerCase();
            const activeTab = document.querySelector('[id^="tab-"]:not(.border-transparent)')?.id?.replace('tab-',
                '') || 'all';

            let jobs = Array.from(document.querySelectorAll('[data-status]'));
            let visibleCount = 0;

            jobs.forEach(card => {
                const matchesTab = activeTab === 'all' || card.dataset.status === activeTab;
                const matchesType = !type || card.dataset.type === type;
                const matchesExperience = !experience || card.dataset.experience === experience;
                const matchesDuration = !duration || card.dataset.duration === duration;
                const title = card.querySelector('h3').textContent.toLowerCase();

                const matchesSearch = !searchTerm || title.includes(searchTerm) ||
                    card.querySelector('p').textContent.toLowerCase().includes(searchTerm);

                if (matchesTab && matchesType && matchesExperience && matchesDuration && matchesSearch) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            // Sort jobs
            if (sort) {
                const container = document.getElementById('jobs-container');
                const sortedJobs = jobs
                    .filter(card => !card.classList.contains('hidden'))
                    .sort((a, b) => {
                        switch (sort) {
                            case 'newest':
                                return 0; // Would need actual date data
                            case 'oldest':
                                return 0; // Would need actual date data
                            case 'budget_high':
                                const aBudget = parseFloat(a.querySelector('.font-semibold.text-gray-900')
                                    .textContent.replace(/[^0-9.-]+/g, ""));
                                const bBudget = parseFloat(b.querySelector('.font-semibold.text-gray-900')
                                    .textContent.replace(/[^0-9.-]+/g, ""));
                                return bBudget - aBudget;
                            case 'budget_low':
                                const aBudget2 = parseFloat(a.querySelector('.font-semibold.text-gray-900')
                                    .textContent.replace(/[^0-9.-]+/g, ""));
                                const bBudget2 = parseFloat(b.querySelector('.font-semibold.text-gray-900')
                                    .textContent.replace(/[^0-9.-]+/g, ""));
                                return aBudget2 - bBudget2;
                            default:
                                return 0;
                        }
                    });

                // Reorder DOM
                sortedJobs.forEach(job => {
                    container.appendChild(job);
                });
            }

            updateEmptyState(visibleCount);
            updateShowingCounts(visibleCount);
        });

        // Clear filters
        document.getElementById('clear-filters')?.addEventListener('click', function() {
            document.getElementById('filter-type').value = '';
            document.getElementById('filter-experience').value = '';
            document.getElementById('filter-duration').value = '';
            document.getElementById('filter-sort').value = 'newest';
            document.getElementById('job-search').value = '';
            document.getElementById('advanced-filters').classList.add('hidden');
            filterJobs('all');
        });

        document.getElementById('clear-all-filters')?.addEventListener('click', function() {
            document.getElementById('filter-type').value = '';
            document.getElementById('filter-experience').value = '';
            document.getElementById('filter-duration').value = '';
            document.getElementById('filter-sort').value = 'newest';
            document.getElementById('job-search').value = '';
            filterJobs('all');
        });

        // Update showing counts
        function updateShowingCounts(visibleCount) {
            const totalJobs = document.querySelectorAll('[data-status]').length;
            document.getElementById('showing-from').textContent = visibleCount > 0 ? '1' : '0';
            document.getElementById('showing-to').textContent = visibleCount;
            document.getElementById('total-jobs').textContent = totalJobs;
        }

        // Update empty state
        function updateEmptyState(visibleCount) {
            const emptyState = document.getElementById('empty-state');
            const jobsContainer = document.getElementById('jobs-container');

            if (visibleCount === 0) {
                jobsContainer.classList.add('hidden');
                emptyState.classList.remove('hidden');
            } else {
                jobsContainer.classList.remove('hidden');
                emptyState.classList.add('hidden');
            }
        }

        // Pagination
        document.getElementById('next-page')?.addEventListener('click', function() {
            // Implement pagination logic here
            console.log('Next page clicked');
        });

        document.getElementById('prev-page')?.addEventListener('click', function() {
            // Implement pagination logic here
            console.log('Previous page clicked');
        });

        // Initialize counts
        document.addEventListener('DOMContentLoaded', function() {
            updateShowingCounts(6); // Initial visible count
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');

            if (window.innerWidth <= 1024 &&
                sidebar &&
                !sidebar.contains(event.target) &&
                toggleBtn &&
                !toggleBtn.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
    </script>
@endpush
