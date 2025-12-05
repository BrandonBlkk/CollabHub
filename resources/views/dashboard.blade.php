<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | CollabHub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional styles for dashboard -->
    <style>
        .sidebar {
            transition: all 0.3s ease;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }
        }

        .notification-dot {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .5;
            }
        }

        .progress-bar {
            transition: width 1s ease-in-out;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .chart-container {
            position: relative;
            height: 300px;
        }
    </style>
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
                <!-- Welcome Section -->
                <div class="mb-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}! 👋
                            </h1>
                            <p class="text-gray-600 mt-1">
                                @if (auth()->user()->user_type === 'freelancer')
                                    Here's what's happening with your freelance work today.
                                @else
                                    Here's an overview of your hiring activities.
                                @endif
                            </p>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ now()->format('l, F j, Y') }}
                        </div>
                    </div>
                </div>

                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
                    @if (auth()->user()->user_type === 'freelancer')
                        <!-- Freelancer Stats -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Total Earnings</p>
                                    <h3 class="text-2xl font-bold text-gray-900 mt-1">$12,580</h3>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center text-sm">
                                    <span class="text-green-600 font-medium">↑ 18%</span>
                                    <span class="text-gray-500 ml-2">from last month</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Active Projects</p>
                                    <h3 class="text-2xl font-bold text-gray-900 mt-1">4</h3>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center text-sm">
                                    <span class="text-green-600 font-medium">↑ 2</span>
                                    <span class="text-gray-500 ml-2">from last week</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Proposals Sent</p>
                                    <h3 class="text-2xl font-bold text-gray-900 mt-1">12</h3>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center text-sm">
                                    <span class="text-green-600 font-medium">30%</span>
                                    <span class="text-gray-500 ml-2">acceptance rate</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Profile Views</p>
                                    <h3 class="text-2xl font-bold text-gray-900 mt-1">245</h3>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
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
                                    <span class="text-green-600 font-medium">↑ 42%</span>
                                    <span class="text-gray-500 ml-2">from last month</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Client Stats -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Active Jobs</p>
                                    <h3 class="text-2xl font-bold text-gray-900 mt-1">8</h3>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center text-sm">
                                    <span class="text-green-600 font-medium">↑ 3</span>
                                    <span class="text-gray-500 ml-2">from last week</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Total Spent</p>
                                    <h3 class="text-2xl font-bold text-gray-900 mt-1">$45,200</h3>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center text-sm">
                                    <span class="text-green-600 font-medium">↑ 22%</span>
                                    <span class="text-gray-500 ml-2">from last month</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Freelancers Hired</p>
                                    <h3 class="text-2xl font-bold text-gray-900 mt-1">15</h3>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0a6 6 0 00-9 5.197">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center text-sm">
                                    <span class="text-green-600 font-medium">↑ 5</span>
                                    <span class="text-gray-500 ml-2">this quarter</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Proposals Received</p>
                                    <h3 class="text-2xl font-bold text-gray-900 mt-1">128</h3>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center text-sm">
                                    <span class="text-green-600 font-medium">48 avg.</span>
                                    <span class="text-gray-500 ml-2">per job</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                    <!-- Left Column -->
                    <div class="lg:col-span-2 space-y-3">
                        @if (auth()->user()->user_type === 'freelancer')
                            <!-- Freelancer: Recent Projects -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-xl font-bold text-gray-900">Recommended Projects</h2>
                                    <a href=""
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">View all →</a>
                                </div>

                                <div class="space-y-4">
                                    @for ($i = 1; $i <= 3; $i++)
                                        <div
                                            class="project-card p-4 border border-gray-200 rounded-lg hover:border-blue-300">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <div class="flex items-center space-x-2 mb-2">
                                                        <span
                                                            class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">Web
                                                            Development</span>
                                                        <span class="text-gray-500 text-xs">• Posted 2 hours ago</span>
                                                    </div>
                                                    <h3 class="font-semibold text-gray-900 mb-1">Build a responsive
                                                        e-commerce website</h3>
                                                    <p class="text-gray-600 text-sm mb-3">Looking for an experienced
                                                        frontend developer to build a modern e-commerce site with
                                                        React.js and Tailwind CSS...</p>
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center space-x-4">
                                                            <span class="text-gray-700 font-medium">$1,500 -
                                                                $3,000</span>
                                                            <span class="text-gray-500 text-sm">Fixed Price</span>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path
                                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                            <span class="text-gray-600 text-sm ml-1">4.8</span>
                                                            <span class="text-gray-500 text-sm ml-2">(12
                                                                reviews)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button
                                                    class="ml-4 bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-black transition duration-300 text-sm font-medium select-none">
                                                    Apply Now
                                                </button>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>

                            <!-- Freelancer: Active Projects -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-xl font-bold text-gray-900">Active Projects</h2>
                                    <a href=""
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">View all →</a>
                                </div>

                                <div class="space-y-4">
                                    @for ($i = 1; $i <= 2; $i++)
                                        <div class="project-card p-4 border border-gray-200 rounded-lg">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h3 class="font-semibold text-gray-900 mb-2">Mobile App Development
                                                    </h3>
                                                    <div class="flex items-center justify-between mb-3">
                                                        <div class="flex items-center space-x-2">
                                                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                                            <span class="text-gray-600 text-sm">In Progress</span>
                                                        </div>
                                                        <span class="text-gray-700 font-medium">$2,500</span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                                                            <span>Progress</span>
                                                            <span>60%</span>
                                                        </div>
                                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                                            <div class="bg-green-600 h-2 rounded-full progress-bar"
                                                                style="width: 60%"></div>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center justify-between text-sm">
                                                        <span class="text-gray-600">Deadline: Dec 15, 2023</span>
                                                        <div class="flex items-center space-x-3">
                                                            <button
                                                                class="text-blue-600 hover:text-blue-800 font-medium">Update</button>
                                                            <button
                                                                class="text-gray-600 hover:text-gray-800">Message</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        @else
                            <!-- Client: Recent Job Postings -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-xl font-bold text-gray-900">Your Job Postings</h2>
                                    <a href=""
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">View all →</a>
                                </div>

                                <div class="space-y-4">
                                    @for ($i = 1; $i <= 3; $i++)
                                        <div
                                            class="job-card p-4 border border-gray-200 rounded-lg hover:border-blue-300 transition-all duration-200">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <div class="flex items-center space-x-2 mb-2 select-none">
                                                        <span
                                                            class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Active</span>
                                                        <span
                                                            class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">Web
                                                            Development</span>
                                                        <span class="text-gray-500 text-xs">• Posted 1 day ago</span>
                                                    </div>
                                                    <h3 class="font-semibold text-gray-900 mb-1">Senior React Developer
                                                        Needed</h3>
                                                    <p class="text-gray-600 text-sm mb-3">Looking for a senior React
                                                        developer with TypeScript experience to join our team for a
                                                        3-month project...</p>
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center space-x-4">
                                                            <div class="flex items-center">
                                                                <svg class="w-4 h-4 text-gray-400 mr-1" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                                    </path>
                                                                </svg>
                                                                <span class="text-gray-600 text-sm">12 Proposals</span>
                                                            </div>
                                                            <span class="text-gray-700 font-medium">$5,000 -
                                                                $8,000</span>
                                                        </div>
                                                        <div class="flex items-center space-x-2 select-none">
                                                            <button
                                                                class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-100 transition-all duration-200">
                                                                View Proposals
                                                            </button>
                                                            <button
                                                                class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-all duration-200">
                                                                Edit
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>

                            <!-- Client: Recent Freelancer Applications -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-xl font-bold text-gray-900">Recent Applications</h2>
                                    <a href=""
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">View all →</a>
                                </div>

                                <div class="space-y-4">
                                    @for ($i = 1; $i <= 3; $i++)
                                        <div class="p-4 border border-gray-200 rounded-lg">
                                            <div class="flex items-start space-x-4">
                                                <div
                                                    class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center select-none">
                                                    <span class="text-white font-bold text-sm">JD</span>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <h3 class="font-semibold text-gray-900">John Doe</h3>
                                                        <span class="text-gray-500 text-xs">2 hours ago</span>
                                                    </div>
                                                    <p class="text-gray-600 text-sm mb-3">Senior React Developer with
                                                        5+ years of experience. Previously worked at Google and
                                                        Facebook...</p>
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="flex items-center">
                                                                <svg class="w-4 h-4 text-yellow-400"
                                                                    fill="currentColor" viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                                <span class="text-gray-600 text-sm ml-1">4.9</span>
                                                            </div>
                                                            <span class="text-gray-600 text-sm">Proposed: <span
                                                                    class="font-medium">$6,500</span></span>
                                                        </div>
                                                        <div class="flex items-center space-x-2 select-none">
                                                            <button
                                                                class="px-3 py-1.5 bg-gray-800 text-white rounded-lg text-sm font-medium hover:bg-black transition-all duration-200">
                                                                Hire
                                                            </button>
                                                            <button
                                                                class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-all duration-200">
                                                                Message
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-3">
                        <!-- Upcoming Deadlines -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Upcoming Deadlines</h2>
                            <div class="space-y-4">
                                @for ($i = 1; $i <= 3; $i++)
                                    <div class="p-3 border border-gray-200 rounded-lg">
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="font-semibold text-gray-900 text-sm">Project Deliverable
                                                {{ $i }}</h3>
                                            <span class="text-red-600 text-xs font-medium">Due in {{ $i }}
                                                days</span>
                                        </div>
                                        <p class="text-gray-600 text-xs mb-2">Final design review and deployment</p>
                                        <div class="flex items-center text-gray-500 text-xs">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            Dec {{ 10 + $i }}, 2023
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <!-- Notifications -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Recent Notifications</h2>
                            <div class="space-y-4">
                                <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                    <div class="flex items-start">
                                        <div
                                            class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3 flex-shrink-0">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-sm">Meeting Reminder</h3>
                                            <p class="text-gray-600 text-xs">Project review meeting in 30 minutes</p>
                                            <span class="text-gray-500 text-xs">10 min ago</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-green-50 border border-green-200 rounded-lg">
                                    <div class="flex items-start">
                                        <div
                                            class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3 flex-shrink-0">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-sm">Payment Received</h3>
                                            <p class="text-gray-600 text-xs">$1,500 payment has been deposited</p>
                                            <span class="text-gray-500 text-xs">2 hours ago</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-purple-50 border border-purple-200 rounded-lg">
                                    <div class="flex items-start">
                                        <div
                                            class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-3 flex-shrink-0">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-sm">New Proposal</h3>
                                            <p class="text-gray-600 text-xs">You have received a new proposal</p>
                                            <span class="text-gray-500 text-xs">5 hours ago</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h2>
                            <div class="grid grid-cols-2 gap-3">
                                <button
                                    class="p-3 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition duration-300">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-6 h-6 text-blue-600 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        <span class="text-blue-700 text-sm font-medium">
                                            @if (auth()->user()->user_type === 'freelancer')
                                                Send Proposal
                                            @else
                                                Post a Job
                                            @endif
                                        </span>
                                    </div>
                                </button>

                                <button
                                    class="p-3 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition duration-300">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-6 h-6 text-green-600 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                            </path>
                                        </svg>
                                        <span class="text-green-700 text-sm font-medium">Messages</span>
                                    </div>
                                </button>

                                <button
                                    class="p-3 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition duration-300">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-6 h-6 text-purple-600 mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                            </path>
                                        </svg>
                                        <span class="text-purple-700 text-sm font-medium">Reports</span>
                                    </div>
                                </button>

                                <button
                                    class="p-3 bg-amber-50 border border-amber-200 rounded-lg hover:bg-amber-100 transition duration-300">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-6 h-6 text-amber-600 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="text-amber-700 text-sm font-medium">Settings</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- JavaScript for Dashboard -->
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');

            if (window.innerWidth <= 1024 &&
                !sidebar.contains(event.target) &&
                !toggleBtn.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // Initialize progress bars animation
        document.addEventListener('DOMContentLoaded', function() {
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            });
        });

        // Notification bell animation
        const notificationBell = document.querySelector('button.relative.text-gray-500');
        if (notificationBell) {
            notificationBell.addEventListener('click', function() {
                const notificationDot = this.querySelector('span.bg-red-500');
                if (notificationDot) {
                    notificationDot.remove();
                }
            });
        }

        // Search functionality
        const searchInput = document.querySelector('input[type="search"]');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const query = this.value.trim();
                    if (query) {
                        // Implement search logic here
                        console.log('Searching for:', query);
                        // You can redirect to search results page or filter content
                    }
                }
            });
        }

        // Smooth hover effects for cards
        const statCards = document.querySelectorAll('.);
                statCards.forEach(card => {
                    card.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-2px)';
                    });

                    card.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0)';
                    });
                });

                // Auto-update time
                function updateTime() {
                    const timeElement = document.querySelector('.text-sm.text-gray-500');
                    if (timeElement) {
                        const now = new Date();
                        const options = {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        };
                        timeElement.textContent = now.toLocaleDateString('en-US', options);
                    }
                }

                // Update time on load and every minute
                updateTime(); setInterval(updateTime, 60000);
    </script>
</body>

</html>
