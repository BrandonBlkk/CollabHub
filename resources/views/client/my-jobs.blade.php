<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Jobs | CollabHub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-['Figtree'] text-gray-800 bg-gray-50">
    <!-- Main Container -->
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar Component -->
        <x-sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <x-header />

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-3">
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
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Jobs</p>
                                <h3 class="text-2xl font-bold text-gray-900 mt-1">
                                    {{ auth()->user()->client->all_jobs }}
                                </h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center text-sm">
                                <span class="text-green-600 font-medium">↑ 3</span>
                                <span class="text-gray-500 ml-2">this month</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Active Jobs</p>
                                <h3 class="text-2xl font-bold text-gray-900 mt-1">
                                    {{ auth()->user()->client->active_jobs }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center text-sm">
                                <span class="text-green-600 font-medium">↑ 1</span>
                                <span class="text-gray-500 ml-2">from last week</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Proposals</p>
                                <h3 class="text-2xl font-bold text-gray-900 mt-1">
                                    {{ auth()->user()->client->total_proposals }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center text-sm">
                                <span class="text-gray-500">48 avg. per job</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Avg. Budget</p>
                                <h3 class="text-2xl font-bold text-gray-900 mt-1">$3,500</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center text-sm">
                                <span class="text-green-600 font-medium">↑ 12%</span>
                                <span class="text-gray-500 ml-2">from last month</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters and Search -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-3">
                    <div class="flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0">
                        <!-- Tabs -->
                        <div class="flex space-x-6 overflow-x-auto">
                            <button onclick="filterJobs('all')" id="tab-all"
                                class="pb-2 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap border-b-2 border-blue-6000">
                                All Jobs ({{ auth()->user()->client->all_jobs }})
                            </button>
                            <button onclick="filterJobs('open')" id="tab-open"
                                class="pb-2 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap border-b-2 border-transparent">
                                Open ({{ auth()->user()->client->open_jobs }})
                            </button>
                            <button onclick="filterJobs('in_progress')" id="tab-in_progress"
                                class="pb-2 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap border-b-2 border-transparent">
                                In Progress ({{ auth()->user()->client->in_progress_jobs }})
                            </button>
                            <button onclick="filterJobs('completed')" id="tab-completed"
                                class="pb-2 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap border-b-2 border-transparent">
                                Completed ({{ auth()->user()->client->completed_jobs }})
                            </button>
                            <button onclick="filterJobs('draft')" id="tab-draft"
                                class="pb-2 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap border-b-2 border-transparent">
                                Draft ({{ auth()->user()->client->draft_jobs }})
                            </button>
                        </div>

                        <!-- Search and Filter -->
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <input type="text" placeholder="Search jobs..." id="job-search"
                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm w-64">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <button id="filter-toggle"
                                class="flex items-center space-x-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
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
                        <div class="flex justify-end space-x-3 mt-4">
                            <button id="clear-filters"
                                class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm">
                                Clear All
                            </button>
                            <button id="apply-filters"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Jobs Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3" id="jobs-container">
                    <!-- Job Card 1 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200 cursor-pointer"
                        data-status="open" data-type="fixed" data-experience="expert" data-duration="3_to_6_months">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Open
                                    </span>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs text-gray-500">Posted: 2 days ago</span>
                                        <button class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-2 text-lg">Senior React Developer with TypeScript
                                </h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    Looking for an experienced React developer with TypeScript expertise to build a
                                    complex dashboard application. Must have experience with Redux, Material-UI, and
                                    modern React patterns.
                                </p>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        React
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        TypeScript
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        Redux
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        Material-UI
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        GraphQL
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center space-x-6">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                    <span class="font-semibold text-gray-900">$5,000 - $8,000</span>
                                    <span class="text-gray-500 text-sm ml-2">Fixed Price</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-gray-600 text-sm">3-6 months</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition duration-200">
                                    View Proposals
                                    <span
                                        class="ml-2 bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">24</span>
                                </button>
                                <button
                                    class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm font-medium transition duration-200">
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Job Card 2 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200 cursor-pointer"
                        data-status="in_progress" data-type="hourly" data-experience="intermediate"
                        data-duration="1_to_3_months">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        In Progress
                                    </span>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs text-gray-500">Posted: 1 week ago</span>
                                        <button class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-2 text-lg">Full Stack Laravel Developer</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    Need a full-stack Laravel developer to build and maintain a SaaS application.
                                    Experience with Vue.js, MySQL, and AWS deployment required.
                                </p>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        Laravel
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        Vue.js
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        MySQL
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        AWS
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        REST API
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center space-x-6">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                    <span class="font-semibold text-gray-900">$35 - $50/hr</span>
                                    <span class="text-gray-500 text-sm ml-2">Hourly</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-gray-600 text-sm">1-3 months</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center mr-4">
                                    <div class="w-8 h-8 rounded-full overflow-hidden mr-2">
                                        <img src="https://ui-avatars.com/api/?name=John+Smith&background=4F46E5&color=fff"
                                            alt="Freelancer" class="w-full h-full object-cover">
                                    </div>
                                    <span class="text-sm text-gray-700">Hired: John Smith</span>
                                </div>
                                <button
                                    class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm font-medium transition duration-200">
                                    Manage
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Job Card 3 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200 cursor-pointer"
                        data-status="completed" data-type="fixed" data-experience="entry"
                        data-duration="less_than_1_month">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        Completed
                                    </span>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs text-gray-500">Posted: 2 months ago</span>
                                        <button class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-2 text-lg">UI/UX Design for Mobile App</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    Design a modern and user-friendly interface for a fitness tracking mobile
                                    application. Focus on intuitive navigation and engaging visual elements.
                                </p>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        Figma
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        UI Design
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        UX Research
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        Prototyping
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        Mobile Design
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center space-x-6">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                    <span class="font-semibold text-gray-900">$1,200</span>
                                    <span class="text-gray-500 text-sm ml-2">Fixed Price</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-gray-600 text-sm">Completed: Nov 15</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center mr-4">
                                    <svg class="w-5 h-5 text-green-600 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm text-gray-700">Payment: $1,200</span>
                                </div>
                                <button
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition duration-200">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Job Card 4 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200 cursor-pointer"
                        data-status="draft" data-type="fixed" data-experience="intermediate"
                        data-duration="more_than_6_months">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Draft
                                    </span>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs text-gray-500">Last edited: 5 days ago</span>
                                        <button class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-2 text-lg">E-commerce Platform Development</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    Build a complete e-commerce solution with product management, shopping cart,
                                    payment integration, and admin dashboard. Looking for a team with e-commerce
                                    experience.
                                </p>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        PHP
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        MySQL
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        JavaScript
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        Payment Gateway
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        E-commerce
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center space-x-6">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                    <span class="font-semibold text-gray-900">$10,000 - $15,000</span>
                                    <span class="text-gray-500 text-sm ml-2">Fixed Price</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-gray-600 text-sm">More than 6 months</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition duration-200">
                                    Continue Editing
                                </button>
                                <button
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium transition duration-200">
                                    Publish
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Job Card 5 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200 cursor-pointer"
                        data-status="open" data-type="hourly" data-experience="intermediate"
                        data-duration="3_to_6_months">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Open
                                    </span>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs text-gray-500">Posted: 1 day ago</span>
                                        <button class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-2 text-lg">Content Writer for Tech Blog</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    Looking for a technical content writer to create articles about web development,
                                    programming, and technology trends. Must have experience writing for tech audiences.
                                </p>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        Content Writing
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        SEO
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        Technical Writing
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        Blogging
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center space-x-6">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                    <span class="font-semibold text-gray-900">$25 - $40/hr</span>
                                    <span class="text-gray-500 text-sm ml-2">Hourly</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-gray-600 text-sm">3-6 months</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition duration-200">
                                    View Proposals
                                    <span
                                        class="ml-2 bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">8</span>
                                </button>
                                <button
                                    class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm font-medium transition duration-200">
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Job Card 6 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200 cursor-pointer"
                        data-status="closed" data-type="fixed" data-experience="expert"
                        data-duration="1_to_3_months">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Closed
                                    </span>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs text-gray-500">Closed: 3 weeks ago</span>
                                        <button class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-2 text-lg">DevOps Engineer for AWS Migration</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    Need a DevOps expert to migrate our existing infrastructure to AWS. Must have
                                    experience with Docker, Kubernetes, Terraform, and CI/CD pipelines.
                                </p>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        AWS
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        Docker
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        Kubernetes
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        Terraform
                                    </span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                        CI/CD
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center space-x-6">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                    <span class="font-semibold text-gray-900">$8,000</span>
                                    <span class="text-gray-500 text-sm ml-2">Fixed Price</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span class="text-gray-600 text-sm">No hires</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition duration-200">
                                    View Archive
                                </button>
                                <button
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium transition duration-200">
                                    Repost
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State (Hidden by default) -->
                <div id="empty-state" class="hidden text-center py-12">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
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
                        Showing <span id="showing-from">1</span> to <span id="showing-to">6</span> of <span
                            id="total-jobs">12</span> jobs
                    </div>
                    <div class="flex items-center space-x-2">
                        <button
                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                            id="prev-page" disabled>
                            Previous
                        </button>
                        <div class="flex items-center space-x-1">
                            <button class="w-8 h-8 rounded-lg bg-blue-600 text-white text-sm font-medium">1</button>
                            <button
                                class="w-8 h-8 rounded-lg text-gray-700 hover:bg-gray-100 text-sm font-medium">2</button>
                        </div>
                        <button
                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50"
                            id="next-page">
                            Next
                        </button>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- JavaScript for My Jobs Page -->
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
</body>

</html>
