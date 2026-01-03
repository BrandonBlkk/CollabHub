<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

            <!-- Add Certification Modal -->
            <div id="addCertificationModal"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50"
                style="display: none;">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900">Add New Certification</h3>
                    </div>

                    <form id="certificationForm" method="POST"
                        action="{{ route('freelancer-profile.certificate.store') }}" class="p-6 space-y-4">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="freelancer_id" value="{{ $freelancer->id }}">

                        <div>
                            <label for="certification_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Certification Name *
                            </label>
                            <input type="text" id="certification_name" name="name"
                                placeholder="Enter your certificate name" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="issuer" class="block text-sm font-medium text-gray-700 mb-1">
                                Issuing Organization *
                            </label>
                            <input type="text" id="issuer" name="issuer" placeholder="Enter your issuer" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="issued_year" class="block text-sm font-medium text-gray-700 mb-1">
                                    Issued Year
                                </label>
                                <select id="issued_year" name="issued_year"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Year</option>
                                    @for ($year = date('Y'); $year >= 1990; $year--)
                                        <option value="{{ $year }}">{{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div>
                                <label for="expiry_year" class="block text-sm font-medium text-gray-700 mb-1">
                                    Expiry Year
                                </label>
                                <select id="expiry_year" name="expiry_year"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">No Expiry</option>
                                    @for ($year = date('Y'); $year <= date('Y') + 10; $year++)
                                        <option value="{{ $year }}">{{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="certificate_url" class="block text-sm font-medium text-gray-700 mb-1">
                                Certificate URL
                            </label>
                            <input type="url" id="certificate_url" name="certificate_url"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="https://example.com/verify">
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <button type="button" onclick="hideAddCertificationModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-gray-800 hover:bg-black rounded-lg transition flex items-center gap-2">
                                Save Certification
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Main Content Area -->
            <form action="{{ route('freelancer-profile.update', $freelancer->id) }}" method="POST"
                class="flex-1 overflow-y-auto p-3">
                @csrf
                @method('PUT')

                <!-- Profile Header -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-3">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-3">
                        <!-- Profile Info -->
                        <div class="flex items-start space-x-4 flex-1 min-w-0">
                            <!-- Avatar with Verification Badge -->
                            <div class="relative">
                                @if ($freelancer->profile_photo_path)
                                    <div class="w-32 h-32 rounded-full flex-shrink-0 select-none">
                                        <img src="{{ $freelancer->profile_photo_path }}" alt="Profile Image"
                                            class="w-full h-full rounded-full object-cover border-4 border-white shadow">
                                    </div>
                                @else
                                    <div
                                        class="w-32 h-32 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center select-none border-4 border-white shadow">
                                        <span
                                            class="text-white font-bold text-4xl">{{ strtoupper(substr($freelancer->name, 0, 1)) }}</span>
                                    </div>
                                @endif

                                <!-- Edit Photo Button (Only for freelancer viewing their own profile) -->
                                @auth
                                    @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                        <button type="button"
                                            onclick="document.getElementById('profile-photo-upload').click()"
                                            class="absolute bottom-0 right-0 bg-gray-800 text-white p-2 rounded-full hover:bg-black transition shadow-lg"
                                            title="Change profile photo">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                        <input type="file" id="profile-photo-upload" class="hidden" accept="image/*">
                                    @endif
                                @endauth
                            </div>

                            <!-- Basic Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-2">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h1 class="text-2xl font-bold text-gray-900">{{ $freelancer->name }}</h1>
                                        </div>
                                        <div class="flex items-center flex-wrap gap-2 mt-1">
                                            <span
                                                class="text-gray-700 font-medium">{{ $freelancer->freelancer->job_title }}</span>
                                            <span class="text-gray-500">•</span>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                <span
                                                    class="font-semibold text-gray-900">{{ number_format($freelancer->freelancer->rating, 1) }}</span>
                                                <span
                                                    class="text-gray-600 ml-1 text-sm">({{ $freelancer->freelancer->rating_count }}
                                                    reviews)</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hourly Rate & Availability -->
                                    <div class="flex flex-col items-start md:items-end gap-2">
                                        <div class="text-2xl font-bold text-gray-900">
                                            ${{ number_format($freelancer->freelancer->hourly_rate, 2) }}/hr</div>

                                        @switch($freelancer->freelancer->availability)
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
                                            @auth
                                                {{ $freelancer->location }}
                                            @endauth
                                        </div>
                                    @endif

                                    @if ($freelancer->freelancer->years_experience)
                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            @auth
                                                @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                                    <input type="number"
                                                        value="{{ $freelancer->freelancer->years_experience }}"
                                                        class="bg-transparent border-b border-transparent hover:border-gray-300 focus:border-blue-500 focus:outline-none px-1 py-0.5 w-20"
                                                        id="years-experience">
                                                    <span class="ml-1">+ years experience</span>
                                                @else
                                                    {{ $freelancer->freelancer->years_experience }}+ years experience
                                                @endif
                                            @else
                                                {{ $freelancer->freelancer->years_experience }}+ years experience
                                            @endauth
                                        </div>
                                    @endif

                                    <!-- Member Since -->
                                    @if ($freelancer->created_at)
                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Member since {{ date('Y', strtotime($freelancer->created_at)) }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Social Links -->
                                <div class="flex items-center gap-3 mt-3">
                                    @auth
                                        @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                            <!-- LinkedIn -->
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-gray-400" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                                </svg>
                                                <input type="url" value="{{ $freelancer->linkedin_url }}"
                                                    placeholder="LinkedIn URL"
                                                    class="ml-1 text-sm bg-transparent border-b border-transparent hover:border-gray-300 focus:border-blue-500 focus:outline-none px-1 py-0.5 w-40"
                                                    id="linkedin-url">
                                            </div>
                                            <!-- GitHub -->
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-gray-400" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                                </svg>
                                                <input type="url" value="{{ $freelancer->github_url }}"
                                                    placeholder="GitHub URL"
                                                    class="ml-1 text-sm bg-transparent border-b border-transparent hover:border-gray-300 focus:border-blue-500 focus:outline-none px-1 py-0.5 w-40"
                                                    id="github-url">
                                            </div>
                                        @else
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
                                        @endif
                                    @else
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
                                    @endauth
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-3 w-full md:w-auto">
                            @auth
                                @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                    <!-- Save All Button for freelancer -->
                                    <button type="submit"
                                        class="flex-1 md:flex-none bg-gray-800 hover:bg-black text-white font-medium py-3 px-6 rounded-lg transition duration-300 text-sm select-none">
                                        Save All Changes
                                    </button>
                                @else
                                    <!-- Hire Button for other users -->
                                    @if ($freelancer->freelancer->availability === 'unavailable')
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
                                @endif
                            @else
                                <!-- Hire Button for guests -->
                                @if ($freelancer->freelancer->availability === 'unavailable')
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
                            @endauth

                            @if (auth()->user()->role === 'clients')
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
                            @endif
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
                                    <button type="button" @click="activeTab = 'overview'"
                                        :class="activeTab === 'overview' ?
                                            'border-b-3 border-blue-500 text-blue-600 font-semibold' : 'text-gray-600'"
                                        class="px-4 py-3 text-sm font-medium hover:text-blue-600 transition duration-300 whitespace-nowrap">
                                        Overview
                                    </button>
                                    <button type="button" @click="activeTab = 'portfolio'"
                                        :class="activeTab === 'portfolio' ?
                                            'border-b-3 border-blue-500 text-blue-600 font-semibold' : 'text-gray-600'"
                                        class="px-4 py-3 text-sm font-medium hover:text-blue-600 transition duration-300 whitespace-nowrap">
                                        Portfolio
                                    </button>
                                    <button type="button" @click="activeTab = 'reviews'"
                                        :class="activeTab === 'reviews' ?
                                            'border-b-3 border-blue-500 text-blue-600 font-semibold' : 'text-gray-600'"
                                        class="px-4 py-3 text-sm font-medium hover:text-blue-600 transition duration-300 whitespace-nowrap">
                                        Reviews
                                    </button>
                                    <button type="button" @click="activeTab = 'experience'"
                                        :class="activeTab === 'experience' ?
                                            'border-b-3 border-blue-500 text-blue-600 font-semibold' : 'text-gray-600'"
                                        class="px-4 py-3 text-sm font-medium hover:text-blue-600 transition duration-300 whitespace-nowrap">
                                        Experience
                                    </button>
                                    <button type="button" @click="activeTab = 'education'"
                                        :class="activeTab === 'education' ?
                                            'border-b-3 border-blue-500 text-blue-600 font-semibold' : 'text-gray-600'"
                                        class="px-4 py-3 text-sm font-medium hover:text-blue-600 transition duration-300 whitespace-nowrap">
                                        Education
                                    </button>
                                    <button type="button" @click="activeTab = 'certifications'"
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
                                            <div class="flex items-center justify-between mb-3">
                                                <h3 class="text-lg font-bold text-gray-900">About Me</h3>
                                                @auth
                                                    @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                                        <button type="button" onclick="editBio()"
                                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                @endauth
                                            </div>
                                            @auth
                                                @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                                    <p id="bio" class="text-gray-600 text-sm leading-relaxed">
                                                        {{ $freelancer->freelancer->bio ?: 'Talented freelancer ready to help bring your project to life with clean, efficient solutions.' }}
                                                    </p>
                                                    <div id="bio-container" class="hidden">
                                                        <textarea id="bio-text" name="bio"
                                                            class="w-full text-gray-600 text-sm leading-relaxed bg-transparent border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 min-h-[120px]"
                                                            placeholder="Tell clients about yourself, your experience, and what you can do...">{{ $freelancer->freelancer->bio ?: 'Talented freelancer ready to help bring your project to life with clean, efficient solutions.' }}</textarea>
                                                        <div class="flex justify-end gap-2 mt-2">
                                                            <button type="button" onclick="cancelEditBio()"
                                                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg transition duration-300 text-sm">
                                                                Cancel
                                                            </button>
                                                            <button type="submit"
                                                                class="bg-gray-800 hover:bg-black text-white font-medium px-4 py-2 rounded-lg transition duration-300 text-sm select-none">
                                                                Save Bio
                                                            </button>
                                                        </div>
                                                    </div>
                                                @else
                                                    <p class="text-gray-600 text-sm leading-relaxed">
                                                        {{ $freelancer->freelancer->bio ?: 'Talented freelancer ready to help bring your project to life with clean, efficient solutions.' }}
                                                    </p>
                                                @endif
                                            @else
                                                <p class="text-gray-600 text-sm leading-relaxed">
                                                    {{ $freelancer->freelancer->bio ?: 'Talented freelancer ready to help bring your project to life with clean, efficient solutions.' }}
                                                </p>
                                            @endauth
                                        </div>

                                        <!-- Skills -->
                                        <div>
                                            <div class="flex items-center justify-between mb-3">
                                                <h3 class="text-lg font-bold text-gray-900">Skills & Expertise</h3>
                                                @auth
                                                    @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                                        <button type="button" onclick="editSkills()"
                                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                @endauth
                                            </div>
                                            @auth
                                                @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                                    <div id="skills-edit-mode" class="hidden">
                                                        <div class="flex flex-wrap gap-2 mb-3">
                                                            @forelse($freelancer->skills as $skill)
                                                                <span
                                                                    class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full flex items-center">
                                                                    {{ $skill->name }}
                                                                    <button type="button" onclick="removeSkill(this)"
                                                                        class="ml-2 text-blue-600 hover:text-blue-800">
                                                                        <svg class="w-4 h-4" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M6 18L18 6M6 6l12 12" />
                                                                        </svg>
                                                                    </button>
                                                                </span>
                                                            @empty
                                                                <p class="text-gray-500 text-sm">No skills added yet.</p>
                                                            @endforelse
                                                        </div>
                                                        <div class="flex gap-2">
                                                            <input type="text" id="new-skill-input"
                                                                placeholder="Add a new skill..."
                                                                class="flex-1 text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                                                            <button type="button" onclick="addSkill()"
                                                                class="bg-gray-800 hover:bg-black text-white font-medium px-4 py-2 rounded-lg transition duration-300 text-sm">
                                                                Add
                                                            </button>
                                                        </div>
                                                        <div class="flex justify-end gap-2 mt-3">
                                                            <button type="button" onclick="cancelEditSkills()"
                                                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg transition duration-300 text-sm">
                                                                Cancel
                                                            </button>
                                                            <button type="button" onclick="saveSkills()"
                                                                class="bg-gray-800 hover:bg-black text-white font-medium px-4 py-2 rounded-lg transition duration-300 text-sm">
                                                                Save Skills
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div id="skills-view-mode">
                                                        <div class="flex flex-wrap gap-2">
                                                            @forelse($freelancer->skills as $skill)
                                                                <span
                                                                    class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full transition-all duration-200 ease-in-out cursor-pointer hover:bg-blue-200">
                                                                    {{ $skill->name }}
                                                                </span>
                                                            @empty
                                                                <!-- Fallback skills when none are added -->
                                                                <span
                                                                    class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">React.js</span>
                                                                <span
                                                                    class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">TypeScript</span>
                                                                <span
                                                                    class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">Next.js</span>
                                                                <span
                                                                    class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">Node.js</span>
                                                                <span
                                                                    class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">MongoDB</span>
                                                                <span
                                                                    class="bg-purple-100 text-purple-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">Tailwind
                                                                    CSS</span>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="flex flex-wrap gap-2">
                                                        @forelse($freelancer->skills as $skill)
                                                            <span
                                                                class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full transition-all duration-200 ease-in-out cursor-pointer hover:bg-blue-200">
                                                                {{ $skill->name }}
                                                            </span>
                                                        @empty
                                                            <!-- Fallback skills when none are added -->
                                                            <span
                                                                class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">React.js</span>
                                                            <span
                                                                class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">TypeScript</span>
                                                            <span
                                                                class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">Next.js</span>
                                                            <span
                                                                class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">Node.js</span>
                                                            <span
                                                                class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">MongoDB</span>
                                                            <span
                                                                class="bg-purple-100 text-purple-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">Tailwind
                                                                CSS</span>
                                                        @endforelse
                                                    </div>
                                                @endif
                                            @else
                                                <div class="flex flex-wrap gap-2">
                                                    @forelse($freelancer->skills as $skill)
                                                        <span
                                                            class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full transition-all duration-200 ease-in-out cursor-pointer hover:bg-blue-200">
                                                            {{ $skill->name }}
                                                        </span>
                                                    @empty
                                                        <!-- Fallback skills when none are added -->
                                                        <span
                                                            class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">React.js</span>
                                                        <span
                                                            class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">TypeScript</span>
                                                        <span
                                                            class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">Next.js</span>
                                                        <span
                                                            class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">Node.js</span>
                                                        <span
                                                            class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">MongoDB</span>
                                                        <span
                                                            class="bg-purple-100 text-purple-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">Tailwind
                                                            CSS</span>
                                                    @endforelse
                                                </div>
                                            @endauth
                                        </div>

                                        <!-- Stats -->
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                                <div class="text-2xl font-bold text-gray-900">
                                                    {{ $freelancer->freelancer->total_projects ?: '0' }}</div>
                                                <div class="text-gray-500 text-sm mt-1">Total Projects</div>
                                            </div>
                                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                                <div class="text-2xl font-bold text-gray-900">
                                                    {{ $freelancer->freelancer->job_success_rate ?: '0' }}%</div>
                                                <div class="text-gray-500 text-sm mt-1">Job Success</div>
                                            </div>
                                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                                <div class="text-2xl font-bold text-gray-900">
                                                    {{ number_format($freelancer->freelancer->total_hours) }}</div>
                                                <div class="text-gray-500 text-sm mt-1">Hours Worked</div>
                                            </div>
                                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                                <div class="text-2xl font-bold text-gray-900">
                                                    ${{ number_format($freelancer->freelancer->total_earned) }}</div>
                                                <div class="text-gray-500 text-sm mt-1">Total Earned</div>
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

                                                    @if ($freelancer->freelancer->portfolio_url)
                                                        <p class="text-gray-500 text-sm mt-1">
                                                            {{ $freelancer->freelancer->portfolio_url }}</p>
                                                    @else
                                                        <p class="text-gray-500 text-sm mt-1">No portfolio website
                                                            added yet.</p>
                                                    @endif
                                                </div>

                                                @if ($freelancer->freelancer->portfolio_url)
                                                    <a href="{{ $freelancer->freelancer->portfolio_url }}"
                                                        target="_blank" rel="noopener noreferrer"
                                                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-3 rounded-lg transition duration-300 shadow-md text-sm select-none">
                                                        <p>Visit
                                                            Portfolio</p><svg class="w-4 h-4" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                        </svg>
                                                    </a>
                                                @endif
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
                                                        {{ number_format($freelancer->freelancer->rating, 1) }}</div>
                                                    <div class="flex items-center mt-1">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= floor($freelancer->freelancer->rating))
                                                                <svg class="w-5 h-5 text-yellow-500"
                                                                    fill="currentColor" viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @elseif($i - 0.5 <= $freelancer->freelancer->rating)
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
                                                            class="ml-2 text-gray-600 text-sm">{{ $freelancer->freelancer->rating_count }}
                                                            reviews</span>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-gray-600 text-sm">Job Success</div>
                                                    <div class="text-2xl font-bold text-gray-900">
                                                        {{ $freelancer->freelancer->job_success_rate ?? '0' }}%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Experience Tab -->
                                <div x-show="activeTab === 'experience'" x-transition>
                                    <div class="space-y-6">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-bold text-gray-900">Work Experience</h3>
                                            @auth
                                                @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                                    <button type="button" onclick="addExperience()"
                                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            @endauth
                                        </div>
                                        <div class="space-y-4" id="experience-list">
                                            <!-- Experience items will be loaded here -->
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
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-bold text-gray-900">Education</h3>
                                            @auth
                                                @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                                    <button type="button" onclick="addEducation()"
                                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            @endauth
                                        </div>
                                        <div class="space-y-4" id="education-list">
                                            <!-- Education items will be loaded here -->
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
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-bold text-gray-900">Certifications</h3>
                                            @auth
                                                @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                                    <button type="button" onclick="showAddCertificationModal()"
                                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            @endauth
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="certifications-list">
                                            @forelse ($certificates as $certificate)
                                                <div class="border border-gray-200 rounded-xl p-4 relative group"
                                                    data-certificate-id="{{ $certificate->id }}">
                                                    <div class="absolute top-3 right-3 flex gap-1">
                                                        <!-- Edit Button -->
                                                        <button type="button"
                                                            onclick="showEditCertificationModal({{ $certificate->id }})"
                                                            class="text-gray-400 hover:text-blue-600 transition-colors duration-200 p-1 rounded-full hover:bg-blue-50"
                                                            title="Edit certification">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </button>

                                                        <!-- Remove Button -->
                                                        <button type="button"
                                                            onclick="confirmRemoveCertification({{ $certificate->id }})"
                                                            class="text-gray-400 hover:text-red-600 transition-colors duration-200 p-1 rounded-full hover:bg-red-50"
                                                            title="Remove certification">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <div class="flex items-start gap-3 pr-8">
                                                        <div
                                                            class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-green-600" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                            </svg>
                                                        </div>
                                                        <div class="flex-1">
                                                            <h4 class="font-bold text-gray-900">
                                                                {{ $certificate->name }}</h4>
                                                            <p class="text-gray-600 text-sm">
                                                                {{ $certificate->issuer }}</p>
                                                            <p class="text-gray-500 text-xs mt-1">Issued:
                                                                {{ $certificate->issued_year ?? 'No Issued Date' }} |
                                                                {{ $certificate->expiry_year ?? 'No Expiry' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-span-2 text-center py-8">
                                                    <p class="text-gray-500 text-sm">No certifications added yet</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>

                                <!-- Success Message Toast -->
                                <div id="successToast"
                                    class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-y-full opacity-0 transition-all duration-300 z-50">
                                    Certification added successfully!
                                </div>

                                <script>
                                    function showAddCertificationModal() {
                                        document.getElementById('addCertificationModal').style.display = 'flex';
                                        document.body.style.overflow = 'hidden';
                                    }

                                    function hideAddCertificationModal() {
                                        document.getElementById('addCertificationModal').style.display = 'none';
                                        document.body.style.overflow = 'auto';
                                        document.getElementById('certificationForm').reset();
                                    }

                                    // Close modal when clicking outside
                                    document.getElementById('addCertificationModal').addEventListener('click', function(e) {
                                        if (e.target === this) {
                                            hideAddCertificationModal();
                                        }
                                    })

                                    function addCertificationToDOM(certificate) {
                                        const certificationsList = document.getElementById('certifications-list');

                                        const certificationHTML = `
        <div class="border border-gray-200 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">${certificate.name}</h4>
                    <p class="text-gray-600 text-sm">${certificate.issuer}</p>
                    <p class="text-gray-500 text-xs mt-1">
                        Issued: ${certificate.issued_year || 'No Issued Date'} |
                        ${certificate.expiry_year || 'No Expiry'}
                    </p>
                </div>
            </div>
        </div>
    `;

                                        // Add new certification at the beginning of the list
                                        certificationsList.insertAdjacentHTML('afterbegin', certificationHTML);
                                    }

                                    function confirmRemoveCertification(certificateId) {
                                        if (!confirm('Are you sure you want to remove this certification?')) {
                                            return;
                                        }

                                        // Get the base URL dynamically
                                        const baseUrl = window.location.origin;

                                        // Get CSRF token safely
                                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                                        if (!csrfToken) {
                                            alert('Security token not found. Please refresh the page.');
                                            return;
                                        }

                                        // Make the AJAX request
                                        fetch(`${baseUrl}/freelancer-profile/certificate/${certificateId}`, {
                                                method: 'DELETE',
                                                headers: {
                                                    'X-CSRF-TOKEN': csrfToken,
                                                    'Content-Type': 'application/json',
                                                    'Accept': 'application/json',
                                                    'X-Requested-With': 'XMLHttpRequest'
                                                },
                                                credentials: 'same-origin'
                                            })
                                            .then(response => {
                                                // Check if response is JSON
                                                const contentType = response.headers.get('content-type');
                                                if (contentType && contentType.includes('application/json')) {
                                                    return response.json();
                                                }
                                                return response.text().then(text => {
                                                    throw new Error(`Server returned: ${text.substring(0, 200)}`);
                                                });
                                            })
                                            .then(data => {
                                                if (data.success) {
                                                    // Find and remove the card with animation
                                                    const card = document.querySelector(`[data-certificate-id="${certificateId}"]`);
                                                    if (card) {
                                                        card.remove();
                                                    }
                                                } else {
                                                    throw new Error(data.message || 'Failed to remove certificate');
                                                }
                                            })
                                            .catch(error => {
                                                console.error('Delete error:', error);
                                            })
                                    }
                                </script>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-3">
                        <!-- Contact Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-gray-900">Contact Information</h3>
                                @auth
                                    @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                        <button type="button" onclick="editContactInfo()"
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                    @endif
                                @endauth
                            </div>
                            <div class="space-y-3 text-sm" id="contact-info-view">
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
                                @if ($freelancer->freelancer->portfolio_url)
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                        </svg>
                                        <a href="{{ $freelancer->freelancer->portfolio_url }}" target="_blank"
                                            class="text-blue-600 hover:text-blue-800 text-sm">
                                            {{ parse_url($freelancer->freelancer->portfolio_url, PHP_URL_HOST) }}
                                        </a>
                                    </div>
                                @endif
                            </div>

                            @auth
                                @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                    <div id="contact-info-edit" class="hidden space-y-3">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89-5.26a2 2 0 012.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <input type="email" value="{{ $freelancer->email }}"
                                                class="flex-1 text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                                id="edit-email" placeholder="Email" disabled>
                                            <input type="hidden" value="{{ $freelancer->email }}">
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            <input type="tel" value="{{ $freelancer->phone }}"
                                                class="flex-1 text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                                id="edit-phone" name="phone" placeholder="Phone number">
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <input type="tel" value="{{ $freelancer->location }}"
                                                class="flex-1 text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                                id="edit-phone" name="location" placeholder="Location">
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                            </svg>
                                            <input type="text" value="{{ $freelancer->freelancer->portfolio_url }}"
                                                class="flex-1 text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                                id="edit-phone" name="portfolio_url" placeholder="Portfolio URL">
                                        </div>
                                        <div class="flex justify-end gap-2 mt-3">
                                            <button type="button" onclick="cancelEditContactInfo()"
                                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg transition duration-300 text-sm select-none">
                                                Cancel
                                            </button>
                                            <button type="submit"
                                                class="bg-gray-800 hover:bg-black text-white font-medium px-4 py-2 rounded-lg transition duration-300 text-sm select-none">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endauth

                            @if (auth()->user()->role === 'clients')
                                <button
                                    class="w-full mt-6 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 rounded-lg transition duration-300 text-sm select-none">
                                    Send Message
                                </button>
                            @endif
                        </div>

                        <!-- Hourly Rate Breakdown -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-bold text-gray-900">Hourly Rate Breakdown</h3>
                                @auth
                                    @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                        <button type="button" onclick="editHourlyRate()" id="edit-hourly-rate-btn"
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                    @endif
                                @endauth
                            </div>

                            <!-- View Mode -->
                            <div class="space-y-3" id="hourly-rate-view">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 text-sm">Base Rate</span>
                                    <span class="text-gray-900 font-medium">
                                        ${{ number_format($freelancer->freelancer->hourly_rate, 2) }}/hr
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 text-sm">Minimum Hours</span>
                                    <span class="text-gray-900 text-sm font-medium">
                                        {{ $freelancer->freelancer->minimum_hours ?? '10' }} hours
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 text-sm">Response Time</span>
                                    <span class="text-gray-900 text-sm font-medium">
                                        {{ $freelancer->freelancer->response_time ?? '2' }} hours
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 text-sm">Revision Limit</span>
                                    <span class="text-gray-900 text-sm font-medium">
                                        {{ $freelancer->freelancer->revision_limit ?? '3' }} revisions
                                    </span>
                                </div>
                                <div class="pt-3 border-t border-gray-100">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-900 text-sm font-medium">Estimated 20-hour
                                            project</span>
                                        <span class="text-xl font-bold text-gray-900">
                                            ${{ number_format($freelancer->freelancer->hourly_rate * 20, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Mode (Only for freelancer viewing their own profile) -->
                            @auth
                                @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                    <div id="hourly-rate-edit" class="hidden space-y-4">
                                        <div class="space-y-3">
                                            <div class="flex flex-col">
                                                <label class="text-gray-600 text-sm mb-1">Base Rate ($/hr)</label>
                                                <div class="flex items-center">
                                                    <span class="text-gray-500 mr-2">$</span>
                                                    <input type="number"
                                                        value="{{ $freelancer->freelancer->hourly_rate }}" step="0.01"
                                                        min="0"
                                                        class="flex-1 text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                                        id="edit-hourly-rate" name="hourly_rate">
                                                </div>
                                            </div>

                                            <div class="flex flex-col">
                                                <label class="text-gray-600 text-sm mb-1">Minimum Hours</label>
                                                <input type="number"
                                                    value="{{ $freelancer->freelancer->minimum_hours ?? '10' }}"
                                                    min="1"
                                                    class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                                    id="edit-minimum-hours" name="minimum_hours">
                                            </div>

                                            <div class="flex flex-col">
                                                <label class="text-gray-600 text-sm mb-1">Response Time (hours)</label>
                                                <input type="number"
                                                    value="{{ $freelancer->freelancer->response_time ?? '2' }}"
                                                    min="1" max="24"
                                                    class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                                    id="edit-response-time" name="response_time">
                                            </div>

                                            <div class="flex flex-col">
                                                <label class="text-gray-600 text-sm mb-1">Revision Limit</label>
                                                <input type="number"
                                                    value="{{ $freelancer->freelancer->revision_limit ?? '3' }}"
                                                    min="0"
                                                    class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                                    id="edit-revision-limit">
                                            </div>
                                        </div>

                                        <!-- Preview of estimated project cost -->
                                        <div class="pt-3 border-t border-gray-100 bg-gray-50 rounded-lg p-3">
                                            <div class="text-sm text-gray-600 mb-1">Estimated 20-hour project cost:</div>
                                            <div class="text-lg font-bold text-gray-900" id="estimated-cost-preview">
                                                ${{ number_format($freelancer->freelancer->hourly_rate * 20, 2) }}
                                            </div>
                                        </div>

                                        <div class="flex justify-end gap-2 pt-3">
                                            <button type="button" onclick="cancelEditHourlyRate()"
                                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg transition duration-300 text-sm">
                                                Cancel
                                            </button>
                                            <button type="submit"
                                                class="bg-gray-800 hover:bg-black text-white font-medium px-4 py-2 rounded-lg transition duration-300 text-sm">
                                                Save Changes
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endauth
                        </div>

                        <script>
                            function editHourlyRate() {
                                document.getElementById('hourly-rate-view').classList.add('hidden');
                                document.getElementById('hourly-rate-edit').classList.remove('hidden');
                                document.getElementById('edit-hourly-rate-btn').classList.add('hidden');

                                // Add event listener for real-time calculation
                                document.getElementById('edit-hourly-rate').addEventListener('input', updateEstimatedCost);
                            }

                            function cancelEditHourlyRate() {
                                document.getElementById('hourly-rate-edit').classList.add('hidden');
                                document.getElementById('hourly-rate-view').classList.remove('hidden');
                                document.getElementById('edit-hourly-rate-btn').classList.remove('hidden');

                                // Remove event listener
                                document.getElementById('edit-hourly-rate').removeEventListener('input', updateEstimatedCost);
                            }

                            function updateEstimatedCost() {
                                const hourlyRate = parseFloat(document.getElementById('edit-hourly-rate').value) || 0;
                                const estimatedCost = hourlyRate * 20;
                                document.getElementById('estimated-cost-preview').textContent = `$${estimatedCost.toFixed(2)}`;
                            }

                            function saveHourlyRate() {
                                const hourlyRate = document.getElementById('edit-hourly-rate').value;
                                const minimumHours = document.getElementById('edit-minimum-hours').value;
                                const responseTime = document.getElementById('edit-response-time').value;
                                const revisionLimit = document.getElementById('edit-revision-limit').value;

                                // Prepare form data
                                const formData = new FormData();
                                formData.append('hourly_rate', hourlyRate);
                                formData.append('minimum_hours', minimumHours);
                                formData.append('response_time_hours', responseTime);
                                formData.append('revision_limit', revisionLimit);
                                formData.append('_method', 'PUT');

                                // Get the CSRF token
                                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                                // Make the API call
                                fetch("{{ route('freelancer-profile.update', $freelancer->id) }}", {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            'Accept': 'application/json',
                                        },
                                        body: formData
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            // Update the view with new values
                                            document.querySelector('#hourly-rate-view div:nth-child(1) span:nth-child(2)').textContent =
                                                `$${parseFloat(hourlyRate).toFixed(2)}/hr`;
                                            document.querySelector('#hourly-rate-view div:nth-child(2) span:nth-child(2)').textContent =
                                                `${minimumHours} hours`;
                                            document.querySelector('#hourly-rate-view div:nth-child(3) span:nth-child(2)').textContent =
                                                `${responseTime} hours`;
                                            document.querySelector('#hourly-rate-view div:nth-child(4) span:nth-child(2)').textContent =
                                                `${revisionLimit} revisions`;
                                            document.querySelector('#hourly-rate-view div:nth-child(5) div span:nth-child(2)').textContent =
                                                `$${(parseFloat(hourlyRate) * 20).toFixed(2)}`;

                                            cancelEditHourlyRate();
                                            alert('Hourly rate breakdown updated successfully!');
                                        } else {
                                            alert('Error updating hourly rate: ' + (data.message || 'Unknown error'));
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('Error updating hourly rate. Please try again.');
                                    });
                            }
                        </script>

                        <!-- Availability Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Availability</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 text-sm">Current Status:</span>
                                    @switch($freelancer->freelancer->availability)
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
                                        <span>Usually responds within
                                            {{ $freelancer->freelancer->response_time ?? '2' }} hours</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Languages Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-gray-900">Languages</h3>
                                @auth
                                    @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                        <div class="flex gap-3">
                                            <button type="button" onclick="addEducation()"
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                            <button type="button" onclick="editLanguages()"
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                            <div class="space-y-3 text-sm" id="languages-view">
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

                            @auth
                                @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                    <div id="languages-edit" class="hidden space-y-3">
                                        <div class="grid grid-cols-2 gap-2">
                                            <input type="text" value="Myanmar"
                                                class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                                placeholder="Language">
                                            <select
                                                class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                                                <option value="fluent" selected>Fluent</option>
                                                <option value="professional">Professional</option>
                                                <option value="intermediate">Intermediate</option>
                                                <option value="basic">Basic</option>
                                            </select>
                                        </div>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input type="text" value="English"
                                                class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                                placeholder="Language">
                                            <select
                                                class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                                                <option value="fluent">Fluent</option>
                                                <option value="professional" selected>Professional</option>
                                                <option value="intermediate">Intermediate</option>
                                                <option value="basic">Basic</option>
                                            </select>
                                        </div>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input type="text" value="French"
                                                class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                                placeholder="Language">
                                            <select
                                                class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                                                <option value="fluent">Fluent</option>
                                                <option value="professional">Professional</option>
                                                <option value="intermediate" selected>Intermediate</option>
                                                <option value="basic">Basic</option>
                                            </select>
                                        </div>
                                        <div class="flex justify-end gap-2 mt-3 select-none">
                                            <button type="button" onclick="cancelEditLanguages()"
                                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg transition duration-300 text-sm">
                                                Cancel
                                            </button>
                                            <button type="button" onclick="saveLanguages()"
                                                class="bg-gray-800 hover:bg-black text-white font-medium px-4 py-2 rounded-lg transition duration-300 text-sm select-none">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endauth
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
            availability: '{{ $freelancer->freelancer->availability }}',
            isOwner: {{ auth()->check() && auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer' ? 'true' : 'false' }}
        });

        // Edit functions for freelancer
        function editBio() {
            const bio = document.getElementById('bio');
            const bioTextarea = document.getElementById('bio-text');
            const bioContainer = document.getElementById('bio-container');
            if (bioTextarea && bioContainer) {
                bioTextarea.focus();

                bio.classList.add('hidden');
                bioContainer.classList.remove('hidden');
            }
        }

        function cancelEditBio() {
            const bio = document.getElementById('bio');
            const bioContainer = document.getElementById('bio-container');
            if (bio && bioContainer) {
                bio.classList.remove('hidden');
                bioContainer.classList.add('hidden');
            }
        }

        function editSkills() {
            document.getElementById('skills-view-mode').classList.add('hidden');
            document.getElementById('skills-edit-mode').classList.remove('hidden');
        }

        function cancelEditSkills() {
            document.getElementById('skills-edit-mode').classList.add('hidden');
            document.getElementById('skills-view-mode').classList.remove('hidden');
        }

        function addSkill() {
            const input = document.getElementById('new-skill-input');
            const skill = input.value.trim();
            if (skill) {
                // Here you would add the skill to the list and make an API call
                console.log('Adding skill:', skill);
                input.value = '';
            }
        }

        function removeSkill(button) {
            const skillElement = button.parentElement;
            skillElement.remove();
            console.log('Removing skill');
        }

        function saveSkills() {
            console.log('Saving skills');
            // Here you would make an API call to save all skills
            alert('Skills saved successfully!');
            cancelEditSkills();
        }

        function editContactInfo() {
            document.getElementById('contact-info-view').classList.add('hidden');
            document.getElementById('contact-info-edit').classList.remove('hidden');
        }

        function cancelEditContactInfo() {
            document.getElementById('contact-info-edit').classList.add('hidden');
            document.getElementById('contact-info-view').classList.remove('hidden');
        }

        function editLanguages() {
            document.getElementById('languages-view').classList.add('hidden');
            document.getElementById('languages-edit').classList.remove('hidden');
        }

        function cancelEditLanguages() {
            document.getElementById('languages-edit').classList.add('hidden');
            document.getElementById('languages-view').classList.remove('hidden');
        }

        function saveLanguages() {
            console.log('Saving languages');
            // Here you would make an API call to save languages
            alert('Languages saved successfully!');
            cancelEditLanguages();
        }

        function saveSocialLinks() {
            const linkedinUrl = document.getElementById('linkedin-url').value;
            const githubUrl = document.getElementById('github-url').value;

            console.log('Saving social links:', {
                linkedinUrl,
                githubUrl
            });
            // Here you would make an API call to save social links
            alert('Social links saved successfully!');
        }

        function addExperience() {
            console.log('Adding new experience');
            // Here you would show a modal or form to add new experience
            alert('Feature: Add new work experience');
        }

        function addEducation() {
            console.log('Adding new education');
            // Here you would show a modal or form to add new education
            alert('Feature: Add new education');
        }

        function addCertification() {
            console.log('Adding new certification');
            // Here you would show a modal or form to add new certification
            alert('Feature: Add new certification');
        }

        // Profile photo upload
        document.getElementById('profile-photo-upload')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                console.log('Uploading profile photo:', file.name);
                // Here you would upload the file to your server
                alert('Profile photo uploaded successfully!');
            }
        });
    </script>
</body>

</html>
