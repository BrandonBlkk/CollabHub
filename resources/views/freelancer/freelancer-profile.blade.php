<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $freelancer->name }} | Freelancer Profile | CollabHub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-['Figtree'] text-gray-800 bg-gray-50">
    <!-- Main Container -->
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <x-sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <x-header />

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-3">
                <!-- Profile Header -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-3">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-3">
                        <!-- Profile Info -->
                        <div class="flex items-start space-x-4 flex-1 min-w-0">
                            <!-- Avatar with Verification Badge -->
                            <div class="relative">
                                @if ($freelancer->profile_photo_path)
                                    <div class="w-20 h-20 rounded-full flex-shrink-0 select-none">
                                        <img src="{{ $freelancer->profile_photo_path }}" alt="Profile Image"
                                            class="w-full h-full rounded-full object-cover border-4 border-white shadow">
                                    </div>
                                @else
                                    <div
                                        class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center select-none border-4 border-white shadow">
                                        <span
                                            class="text-white font-bold text-2xl">{{ strtoupper(substr($freelancer->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                                <!-- Verification Badge -->
                                @if ($freelancer->is_verified)
                                    <div
                                        class="absolute -bottom-1 -right-1 bg-blue-500 rounded-full p-1 border-2 border-white">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Basic Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-2">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h1 class="text-2xl font-bold text-gray-900">{{ $freelancer->name }}</h1>
                                            @if ($freelancer->is_verified)
                                                <span
                                                    class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Verified
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center flex-wrap gap-2 mt-1">
                                            <span class="text-gray-700 font-medium">{{ $freelancer->job_title }}</span>
                                            <span class="text-gray-500">•</span>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                <span
                                                    class="font-semibold text-gray-900">{{ number_format($freelancer->rating, 1) }}</span>
                                                <span
                                                    class="text-gray-600 ml-1 text-sm">({{ $freelancer->rating_count }}
                                                    reviews)</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hourly Rate & Availability -->
                                    <div class="flex flex-col items-start md:items-end gap-2">
                                        <div class="text-2xl font-bold text-gray-900">
                                            ${{ number_format($freelancer->hourly_rate, 2) }}/hr</div>
                                        @switch($freelancer->availability)
                                            @case('available')
                                                <div
                                                    class="flex items-center text-green-600 bg-green-50 px-3 py-1 rounded-full">
                                                    <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div>
                                                    <span class="font-medium text-sm">Available Now</span>
                                                </div>
                                            @break

                                            @case('busy')
                                                <div
                                                    class="flex items-center text-amber-600 bg-amber-50 px-3 py-1 rounded-full">
                                                    <div class="w-2 h-2 rounded-full bg-amber-500 mr-2"></div>
                                                    <span class="font-medium text-sm">Busy</span>
                                                </div>
                                            @break

                                            @case('unavailable')
                                                <div class="flex items-center text-red-600 bg-red-50 px-3 py-1 rounded-full">
                                                    <div class="w-2 h-2 rounded-full bg-red-500 mr-2"></div>
                                                    <span class="font-medium text-sm">Unavailable</span>
                                                </div>
                                            @break
                                        @endswitch
                                    </div>
                                </div>

                                <!-- Location & Experience -->
                                <div class="flex flex-wrap items-center gap-4 mt-3 text-sm">
                                    @if ($freelancer->location)
                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $freelancer->location }}
                                        </div>
                                    @endif

                                    @if ($freelancer->years_experience)
                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $freelancer->years_experience }}+ years experience
                                        </div>
                                    @endif

                                    <!-- Member Since -->
                                    @if ($freelancer->member_since)
                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Member since {{ date('Y', strtotime($freelancer->member_since)) }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Social Links -->
                                <div class="flex items-center gap-3 mt-3">
                                    @if ($freelancer->linkedin_url)
                                        <a href="{{ $freelancer->linkedin_url }}" target="_blank"
                                            class="text-gray-400 hover:text-blue-700 transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                            </svg>
                                        </a>
                                    @endif
                                    @if ($freelancer->github_url)
                                        <a href="{{ $freelancer->github_url }}" target="_blank"
                                            class="text-gray-400 hover:text-gray-900 transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                            </svg>
                                        </a>
                                    @endif
                                    @if ($freelancer->twitter_url)
                                        <a href="{{ $freelancer->twitter_url }}" target="_blank"
                                            class="text-gray-400 hover:text-blue-500 transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.213c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-3 w-full md:w-auto">
                            @if ($freelancer->availability === 'unavailable')
                                <button
                                    class="flex-1 md:flex-none bg-gray-300 text-gray-500 font-medium py-3 px-6 rounded-lg cursor-not-allowed text-sm"
                                    disabled title="This freelancer is currently unavailable for hire">
                                    Unavailable
                                </button>
                            @else
                                <button
                                    class="flex-1 md:flex-none bg-gray-800 hover:bg-black text-white font-medium py-3 px-6 rounded-lg transition duration-300 text-sm select-none">
                                    Hire Now
                                </button>
                            @endif
                            <button
                                class="p-3 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                            <button
                                class="p-3 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                    <!-- Left Column -->
                    <div class="lg:col-span-2 space-y-3">
                        <!-- Navigation Tabs -->
                        <div x-data="{ activeTab: 'overview' }" class="bg-white rounded-2xl shadow-sm border border-gray-200">
                            <!-- Tab Headers -->
                            <div class="border-b border-gray-200">
                                <nav class="flex space-x-1 px-6 pt-2 overflow-x-auto">
                                    <button @click="activeTab = 'overview'"
                                        :class="activeTab === 'overview' ?
                                            'border-b-3 border-blue-500 text-blue-600 font-semibold' : 'text-gray-600'"
                                        class="px-4 py-3 text-sm font-medium hover:text-blue-600 transition duration-300 whitespace-nowrap">
                                        Overview
                                    </button>
                                    <button @click="activeTab = 'portfolio'"
                                        :class="activeTab === 'portfolio' ?
                                            'border-b-3 border-blue-500 text-blue-600 font-semibold' : 'text-gray-600'"
                                        class="px-4 py-3 text-sm font-medium hover:text-blue-600 transition duration-300 whitespace-nowrap">
                                        Portfolio
                                    </button>
                                    <button @click="activeTab = 'reviews'"
                                        :class="activeTab === 'reviews' ?
                                            'border-b-3 border-blue-500 text-blue-600 font-semibold' : 'text-gray-600'"
                                        class="px-4 py-3 text-sm font-medium hover:text-blue-600 transition duration-300 whitespace-nowrap">
                                        Reviews
                                    </button>
                                    <button @click="activeTab = 'experience'"
                                        :class="activeTab === 'experience' ?
                                            'border-b-3 border-blue-500 text-blue-600 font-semibold' : 'text-gray-600'"
                                        class="px-4 py-3 text-sm font-medium hover:text-blue-600 transition duration-300 whitespace-nowrap">
                                        Experience
                                    </button>
                                    <button @click="activeTab = 'education'"
                                        :class="activeTab === 'education' ?
                                            'border-b-3 border-blue-500 text-blue-600 font-semibold' : 'text-gray-600'"
                                        class="px-4 py-3 text-sm font-medium hover:text-blue-600 transition duration-300 whitespace-nowrap">
                                        Education
                                    </button>
                                    <button @click="activeTab = 'certifications'"
                                        :class="activeTab === 'certifications' ?
                                            'border-b-3 border-blue-500 text-blue-600 font-semibold' : 'text-gray-600'"
                                        class="px-4 py-3 text-sm font-medium hover:text-blue-600 transition duration-300 whitespace-nowrap">
                                        Certifications
                                    </button>
                                </nav>
                            </div>

                            <!-- Tab Content -->
                            <div class="p-6">
                                <!-- Overview Tab -->
                                <div x-show="activeTab === 'overview'" x-transition>
                                    <div class="space-y-6">
                                        <!-- Bio -->
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900 mb-3">About Me</h3>
                                            <p class="text-gray-600 text-sm leading-relaxed">
                                                {{ $freelancer->bio ?: 'Talented freelancer ready to help bring your project to life with clean, efficient solutions.' }}
                                            </p>
                                        </div>

                                        <!-- Skills -->
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900 mb-3">Skills & Expertise</h3>
                                            <div class="flex flex-wrap gap-2">
                                                @if ($freelancer->skills)
                                                    @php
                                                        $skills = json_decode($freelancer->skills, true);
                                                    @endphp
                                                    @foreach ($skills as $skill)
                                                        <span
                                                            class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full transition-all duration-200 ease-in-out cursor-pointer">
                                                            {{ $skill }}
                                                        </span>
                                                    @endforeach
                                                @else
                                                    <span
                                                        class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full transition-all duration-200 ease-in-out cursor-pointer select-none">React.js</span>
                                                    <span
                                                        class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full transition-all duration-200 ease-in-out cursor-pointer select-none">TypeScript</span>
                                                    <span
                                                        class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full transition-all duration-200 ease-in-out cursor-pointer select-none">Next.js</span>
                                                    <span
                                                        class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full transition-all duration-200 ease-in-out cursor-pointer select-none">Node.js</span>
                                                    <span
                                                        class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1.5 rounded-full transition-all duration-200 ease-in-out cursor-pointer select-none">MongoDB</span>
                                                    <span
                                                        class="bg-purple-100 text-purple-800 text-sm font-medium px-3 py-1.5 rounded-full transition-all duration-200 ease-in-out cursor-pointer select-none">Tailwind
                                                        CSS</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Stats -->
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                                <div class="text-2xl font-bold text-gray-900">
                                                    {{ $freelancer->total_projects }}</div>
                                                <div class="text-gray-500 text-sm mt-1">Total Projects</div>
                                            </div>
                                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                                <div class="text-2xl font-bold text-gray-900">
                                                    {{ $freelancer->job_success_rate ?: '0' }}%</div>
                                                <div class="text-gray-500 text-sm mt-1">Job Success</div>
                                            </div>
                                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                                <div class="text-2xl font-bold text-gray-900">
                                                    {{ number_format($freelancer->total_hours) }}</div>
                                                <div class="text-gray-500 text-sm mt-1">Hours Worked</div>
                                            </div>
                                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                                <div class="text-2xl font-bold text-gray-900">
                                                    ${{ number_format($freelancer->total_earned) }}</div>
                                                <div class="text-gray-500 text-sm mt-1">Total Earned</div>
                                            </div>
                                        </div>

                                        <!-- Project History Timeline -->
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900 mb-4">Project History Timeline
                                            </h3>
                                            <div class="relative pl-8">
                                                <!-- Timeline line -->
                                                <div class="absolute left-3 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                                                <!-- Timeline items -->
                                                <div class="relative mb-6">
                                                    <div
                                                        class="absolute left-0 w-6 h-6 bg-blue-500 rounded-full border-4 border-white">
                                                    </div>
                                                    <div class="ml-10">
                                                        <h4 class="font-bold text-gray-900">E-commerce Platform</h4>
                                                        <p class="text-gray-500 text-sm">Completed 2 weeks ago</p>
                                                        <p class="text-gray-600 text-sm mt-1">Built a full-featured
                                                            e-commerce platform with payment integration</p>
                                                    </div>
                                                </div>
                                                <div class="relative mb-6">
                                                    <div
                                                        class="absolute left-0 w-6 h-6 bg-green-500 rounded-full border-4 border-white">
                                                    </div>
                                                    <div class="ml-10">
                                                        <h4 class="font-bold text-gray-900">SaaS Dashboard</h4>
                                                        <p class="text-gray-500 text-sm">Completed 1 month ago</p>
                                                        <p class="text-gray-600 text-sm mt-1">Developed analytics
                                                            dashboard with real-time data visualization</p>
                                                    </div>
                                                </div>
                                                <div class="relative">
                                                    <div
                                                        class="absolute left-0 w-6 h-6 bg-purple-500 rounded-full border-4 border-white">
                                                    </div>
                                                    <div class="ml-10">
                                                        <h4 class="font-bold text-gray-900">Mobile App</h4>
                                                        <p class="text-gray-500 text-sm">Completed 2 months ago</p>
                                                        <p class="text-gray-600 text-sm mt-1">Created cross-platform
                                                            mobile application with React Native</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Portfolio Tab -->
                                <div x-show="activeTab === 'portfolio'" x-transition>
                                    <div class="space-y-8">
                                        <!-- Portfolio Website Section -->
                                        <div
                                            class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-2xl p-6">
                                            <div
                                                class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                                <div>
                                                    <h3
                                                        class="text-xl font-bold text-gray-900 flex items-center gap-3">
                                                        <svg class="w-6 h-6 text-indigo-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                                        </svg>
                                                        Portfolio Website
                                                    </h3>
                                                    <p class="text-gray-600 text-sm mt-1">View my complete work and
                                                        case studies</p>
                                                    <p class="text-gray-500 text-sm mt-1">
                                                        {{ $freelancer->website ?? 'No portfolio website added yet.' }}
                                                    </p>
                                                </div>
                                                <a href="{{ $freelancer->website ?? '#' }}" target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="{{ $freelancer->website ? 'inline-flex' : 'hidden' }} items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-3 rounded-lg transition duration-300 shadow-md text-sm select-none">
                                                    <span>Visit Portfolio</span>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Featured Projects -->
                                        <div class="space-y-4">
                                            <h3 class="text-lg font-bold text-gray-900">Featured Projects</h3>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div
                                                    class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition-all duration-200 ease-in-out">
                                                    <div
                                                        class="h-40 bg-gradient-to-r from-blue-400 to-purple-500 rounded-lg mb-3">
                                                    </div>
                                                    <h4 class="font-bold text-gray-900 mb-1 text-base">E-commerce
                                                        Platform</h4>
                                                    <p class="text-gray-600 text-sm mb-3">Full-stack e-commerce
                                                        solution with React, Node.js, and MongoDB</p>
                                                    <div class="flex flex-wrap gap-1">
                                                        <span
                                                            class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">React</span>
                                                        <span
                                                            class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Node.js</span>
                                                        <span
                                                            class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">MongoDB</span>
                                                    </div>
                                                </div>
                                                <div
                                                    class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition-all duration-200 ease-in-out">
                                                    <div
                                                        class="h-40 bg-gradient-to-r from-green-400 to-teal-500 rounded-lg mb-3">
                                                    </div>
                                                    <h4 class="font-bold text-gray-900 mb-1 text-base">SaaS Dashboard
                                                    </h4>
                                                    <p class="text-gray-600 text-sm mb-3">Analytics dashboard with
                                                        real-time data visualization</p>
                                                    <div class="flex flex-wrap gap-1">
                                                        <span
                                                            class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Next.js</span>
                                                        <span
                                                            class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded">TypeScript</span>
                                                        <span
                                                            class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded">Chart.js</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Reviews Tab -->
                                <div x-show="activeTab === 'reviews'" x-transition>
                                    <div class="space-y-6">
                                        <h3 class="text-lg font-bold text-gray-900">Client Reviews</h3>
                                        <div class="bg-gray-50 rounded-xl p-4">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <div class="text-3xl font-bold text-gray-900">
                                                        {{ number_format($freelancer->rating, 1) }}</div>
                                                    <div class="flex items-center mt-1">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= floor($freelancer->rating))
                                                                <svg class="w-5 h-5 text-yellow-500"
                                                                    fill="currentColor" viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @elseif($i - 0.5 <= $freelancer->rating)
                                                                <svg class="w-5 h-5 text-yellow-500"
                                                                    fill="currentColor" viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M10 1l2.5 6.5H19l-5 4.5 2 6.5-6-4.5-6 4.5 2-6.5-5-4.5h6.5L10 1z" />
                                                                </svg>
                                                            @else
                                                                <svg class="w-5 h-5 text-gray-300" fill="currentColor"
                                                                    viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @endif
                                                        @endfor
                                                        <span
                                                            class="ml-2 text-gray-600 text-sm">{{ $freelancer->rating_count }}
                                                            reviews</span>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-gray-600 text-sm">Job Success</div>
                                                    <div class="text-2xl font-bold text-gray-900">
                                                        {{ $freelancer->job_success_rate }}%</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="space-y-4">
                                            <div class="border border-gray-200 rounded-xl p-4">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex items-center">
                                                        <div
                                                            class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-400 to-purple-500">
                                                        </div>
                                                        <div class="ml-3">
                                                            <h4 class="font-bold text-gray-900 text-base">Sarah Johnson
                                                            </h4>
                                                            <div class="flex items-center">
                                                                <div class="flex text-yellow-500">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <svg class="w-4 h-4" fill="currentColor"
                                                                            viewBox="0 0 20 20">
                                                                            <path
                                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                        </svg>
                                                                    @endfor
                                                                </div>
                                                                <span class="text-gray-500 text-sm ml-2">2 weeks
                                                                    ago</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-gray-600 text-sm">$2,500 project</div>
                                                </div>
                                                <p class="text-gray-600 text-sm mt-3">Excellent work! Delivered ahead
                                                    of schedule with exceptional quality. Communication was perfect
                                                    throughout the project.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Experience Tab -->
                                <div x-show="activeTab === 'experience'" x-transition>
                                    <div class="space-y-6">
                                        <h3 class="text-lg font-bold text-gray-900">Work Experience</h3>
                                        <div class="space-y-4">
                                            <div class="border-l-4 border-blue-500 pl-4 py-2">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h4 class="font-bold text-gray-900 text-base">Senior Frontend
                                                            Developer</h4>
                                                        <p class="text-gray-600 text-sm">TechCorp Inc.</p>
                                                    </div>
                                                    <span class="text-sm text-gray-500">2019 - Present</span>
                                                </div>
                                                <p class="text-gray-600 text-sm mt-2">Led frontend development for
                                                    multiple enterprise applications using React and TypeScript.</p>
                                            </div>
                                            <div class="border-l-4 border-green-500 pl-4 py-2">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h4 class="font-bold text-gray-900 text-base">Full Stack
                                                            Developer</h4>
                                                        <p class="text-gray-600 text-sm">StartupXYZ</p>
                                                    </div>
                                                    <span class="text-sm text-gray-500">2017 - 2019</span>
                                                </div>
                                                <p class="text-gray-600 text-sm mt-2">Built and maintained full-stack
                                                    applications using Node.js, React, and MongoDB.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Education Tab -->
                                <div x-show="activeTab === 'education'" x-transition>
                                    <div class="space-y-6">
                                        <h3 class="text-lg font-bold text-gray-900">Education</h3>
                                        <div class="space-y-4">
                                            <div class="border-l-4 border-indigo-500 pl-4 py-2">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h4 class="font-bold text-gray-900 text-base">Master of
                                                            Computer Science</h4>
                                                        <p class="text-gray-600 text-sm">Stanford University</p>
                                                    </div>
                                                    <span class="text-sm text-gray-500">2014 - 2016</span>
                                                </div>
                                                <p class="text-gray-600 text-sm mt-2">Specialized in Software
                                                    Engineering and Machine Learning</p>
                                            </div>
                                            <div class="border-l-4 border-purple-500 pl-4 py-2">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h4 class="font-bold text-gray-900 text-base">Bachelor of
                                                            Information Technology</h4>
                                                        <p class="text-gray-600 text-sm">MIT</p>
                                                    </div>
                                                    <span class="text-sm text-gray-500">2010 - 2014</span>
                                                </div>
                                                <p class="text-gray-600 text-sm mt-2">Graduated with Honors, GPA:
                                                    3.8/4.0</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Certifications Tab -->
                                <div x-show="activeTab === 'certifications'" x-transition>
                                    <div class="space-y-6">
                                        <h3 class="text-lg font-bold text-gray-900">Certifications</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="border border-gray-200 rounded-xl p-4">
                                                <div class="flex items-start gap-3">
                                                    <div
                                                        class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-blue-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-bold text-gray-900">AWS Certified Solutions
                                                            Architect</h4>
                                                        <p class="text-gray-600 text-sm">Amazon Web Services</p>
                                                        <p class="text-gray-500 text-xs mt-1">Issued: 2022 | Expires:
                                                            2025</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="border border-gray-200 rounded-xl p-4">
                                                <div class="flex items-start gap-3">
                                                    <div
                                                        class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-green-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-bold text-gray-900">Google Cloud Professional
                                                            Developer</h4>
                                                        <p class="text-gray-600 text-sm">Google Cloud</p>
                                                        <p class="text-gray-500 text-xs mt-1">Issued: 2021 | No
                                                            Expiration</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-3">
                        <!-- Contact Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Contact Information</h3>
                            <div class="space-y-3 text-sm">
                                @if ($freelancer->email)
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89-5.26a2 2 0 012.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        {{ $freelancer->email }}
                                    </div>
                                @endif
                                @if ($freelancer->phone)
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ $freelancer->phone }}
                                    </div>
                                @endif
                                @if ($freelancer->location)
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $freelancer->location }}
                                    </div>
                                @endif
                                @if ($freelancer->website)
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                        </svg>
                                        <a href="{{ $freelancer->website }}" target="_blank"
                                            class="text-blue-600 hover:text-blue-800 text-sm">
                                            {{ parse_url($freelancer->website, PHP_URL_HOST) }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <button
                                class="w-full mt-6 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 rounded-lg transition duration-300 text-sm select-none">
                                Send Message
                            </button>
                        </div>

                        <!-- Hourly Rate Breakdown -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Hourly Rate Breakdown</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 text-sm">Base Rate</span>
                                    <span
                                        class="text-gray-900 font-medium">${{ number_format($freelancer->hourly_rate, 2) }}/hr</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 text-sm">Minimum Hours</span>
                                    <span class="text-gray-900 font-medium">10 hours</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 text-sm">Response Time</span>
                                    <span class="text-gray-900 font-medium">2 hours</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 text-sm">Revision Limit</span>
                                    <span class="text-gray-900 font-medium">3 revisions</span>
                                </div>
                                <div class="pt-3 border-t border-gray-100">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-900 font-medium">Estimated 20-hour project</span>
                                        <span
                                            class="text-xl font-bold text-gray-900">${{ number_format($freelancer->hourly_rate * 20, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Availability Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Availability</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 text-sm">Current Status:</span>
                                    @switch($freelancer->availability)
                                        @case('available')
                                            <span
                                                class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium select-none">Available</span>
                                        @break

                                        @case('busy')
                                            <span
                                                class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm font-medium select-none">Busy</span>
                                        @break

                                        @case('unavailable')
                                            <span
                                                class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium select-none">Unavailable</span>
                                        @break
                                    @endswitch
                                </div>
                                <div class="pt-4 border-t border-gray-100">
                                    <h4 class="font-medium text-gray-900 text-sm mb-2">Response Time</h4>
                                    <div class="flex items-center text-gray-600 text-sm">
                                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Usually responds within 2 hours</span>
                                    </div>
                                </div>
                                <div class="pt-4 border-t border-gray-100">
                                    <h4 class="font-medium text-gray-900 text-sm mb-2">Working Hours</h4>
                                    <div class="text-gray-600 text-sm">
                                        <div class="flex justify-between">
                                            <span>Monday - Friday</span>
                                            <span>9:00 AM - 6:00 PM</span>
                                        </div>
                                        <div class="flex justify-between mt-1">
                                            <span>Saturday</span>
                                            <span>10:00 AM - 2:00 PM</span>
                                        </div>
                                        <div class="flex justify-between mt-1">
                                            <span>Sunday</span>
                                            <span class="text-gray-400">Not Available</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Languages Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Languages</h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Myanmar</span>
                                    <span class="text-gray-900 font-medium">Fluent</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">English</span>
                                    <span class="text-gray-900 font-medium">Professional</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">French</span>
                                    <span class="text-gray-900 font-medium">Intermediate</span>
                                </div>
                            </div>
                        </div>

                        <!-- Similar Freelancers -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Similar Freelancers</h3>
                            <div class="space-y-3 mb-5">
                                @foreach ($similarFreelancers as $freelancer)
                                    <div class="flex items-center gap-3 px-3 hover:bg-gray-50 rounded-lg transition">
                                        {{-- Profile Photo --}}
                                        @if ($freelancer->profile_photo_path)
                                            <div class="w-10 rounded-full select-none">
                                                <img src="{{ $freelancer->profile_photo_path }}" alt="Profile Image"
                                                    class="w-full h-full object-cover rounded-full">
                                            </div>
                                        @else
                                            <div
                                                class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center select-none">
                                                <span
                                                    class="text-white font-bold text-sm">{{ strtoupper(substr($freelancer->name, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-medium text-gray-900 text-sm truncate">
                                                {{ $freelancer->name }}</h4>
                                            <p class="text-gray-500 text-xs truncate">Full Stack Developer</p>
                                        </div>
                                        <span
                                            class="text-gray-900 font-medium text-sm">${{ $freelancer->hourly_rate }}/hr</span>
                                    </div>
                                @endforeach
                            </div>
                            <a href="{{ route('find-freelancers') }}"
                                class="w-full text-blue-600 hover:text-blue-800 text-sm font-medium py-2">
                                View All Similar Freelancers →
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {});
        console.log('Freelancer profile loaded:', {
            name: '{{ $freelancer->name }}',
            availability: '{{ $freelancer->availability }}'
        });
    </script>
</body>

</html>
