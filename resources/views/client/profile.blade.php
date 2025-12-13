<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile | CollabHub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional styles -->
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
                <!-- Profile Header -->
                <div class="mb-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">My Profile</h1>
                            <p class="text-gray-600 mt-1">
                                Manage your profile information and settings
                            </p>
                        </div>
                        <div class="text-sm text-gray-500">
                            Last updated: {{ auth()->user()->updated_at->format('F j, Y') }}
                        </div>
                    </div>
                </div>

                <!-- Profile Content -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                    <!-- Left Column - Profile Overview -->
                    <div class="lg:col-span-2 space-y-3">
                        <!-- Profile Information Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-bold text-gray-900">Profile Information</h2>
                                <button type="button" onclick="toggleEditMode('profile')"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Profile
                                </button>
                            </div>

                            <form id="profileForm" method="POST"
                                action="{{ route('profile.update', auth()->user()->id) }}" enctype="multipart/form-data"
                                class="space-y-6">
                                @csrf
                                @method('PUT')

                                <!-- Profile Photo Section -->
                                <div class="flex items-center space-x-6">
                                    <div class="relative">
                                        <div
                                            class="w-32 h-32 rounded-full overflow-hidden bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center select-none">
                                            @if (auth()->user()->profile_photo_path)
                                                <img id="profileImagePreview"
                                                    src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}"
                                                    alt="Profile Photo" class="w-full h-full object-cover">
                                            @else
                                                <span id="profileInitials" class="text-white text-4xl font-bold">
                                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                                </span>
                                            @endif
                                        </div>
                                        <label for="profile_photo"
                                            class="absolute bottom-0 right-0 bg-gray-800 text-white p-2 rounded-full cursor-pointer hover:bg-black transition duration-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </label>
                                        <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                                            class="hidden" onchange="previewImage(event)">
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                                        <p class="text-gray-600">{{ auth()->user()->email }}</p>
                                        <div class="flex items-center mt-2 select-none">
                                            <span
                                                class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">
                                                {{ ucfirst(auth()->user()->role) }}
                                            </span>
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded ml-2">
                                                {{ ucfirst(auth()->user()->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Basic Information -->
                                    <div class="space-y-4 pt-1">
                                        <h3 class="font-semibold text-gray-900 border-b pb-2">Basic Information</h3>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Full
                                                Name</label>
                                            <div class="relative">
                                                <input type="text" name="name"
                                                    value="{{ old('name', auth()->user()->name) }}"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 outline-none">
                                                @error('name')
                                                    <p class="absolute -bottom-2 left-4 bg-white text-red-500 text-xs mt-1">
                                                        {{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Email
                                                Address</label>
                                            <input type="email" name="email"
                                                value="{{ old('email', auth()->user()->email) }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 outline-none">
                                            @error('email')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone
                                                Number</label>
                                            <div class="flex">
                                                <select name="country_code"
                                                    class="px-3 py-2 border border-gray-300 rounded-l-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 outline-none">
                                                    <option value="+1"
                                                        {{ auth()->user()->country_code == '+1' ? 'selected' : '' }}>+1
                                                        US</option>
                                                    <option value="+44"
                                                        {{ auth()->user()->country_code == '+44' ? 'selected' : '' }}>
                                                        +44 UK</option>
                                                    <option value="+91"
                                                        {{ auth()->user()->country_code == '+91' ? 'selected' : '' }}>
                                                        +91 IN</option>
                                                    <option value="+61"
                                                        {{ auth()->user()->country_code == '+61' ? 'selected' : '' }}>
                                                        +61 AU</option>
                                                </select>
                                                <input type="text" name="phone"
                                                    value="{{ old('phone', auth()->user()->phone) }}"
                                                    class="flex-1 px-4 py-2 border border-l-0 border-gray-300 rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 outline-none"
                                                    placeholder="1234567890">
                                            </div>
                                            @error('phone')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Location Information -->
                                    <div class="space-y-4 pt-1">
                                        <h3 class="font-semibold text-gray-900 border-b pb-2">Location Information</h3>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                            <select name="country"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 outline-none">
                                                <option value="">Select Country</option>
                                                <option value="United States"
                                                    {{ auth()->user()->country == 'United States' ? 'selected' : '' }}>
                                                    United States</option>
                                                <option value="United Kingdom"
                                                    {{ auth()->user()->country == 'United Kingdom' ? 'selected' : '' }}>
                                                    United Kingdom</option>
                                                <option value="Canada"
                                                    {{ auth()->user()->country == 'Canada' ? 'selected' : '' }}>Canada
                                                </option>
                                                <option value="Australia"
                                                    {{ auth()->user()->country == 'Australia' ? 'selected' : '' }}>
                                                    Australia</option>
                                                <option value="India"
                                                    {{ auth()->user()->country == 'India' ? 'selected' : '' }}>India
                                                </option>
                                            </select>
                                            @error('country')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 mb-1">City/Location</label>
                                            <input type="text" name="location"
                                                value="{{ old('location', auth()->user()->location) }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 outline-none"
                                                placeholder="e.g., New York, London">
                                            @error('location')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 mb-1">Timezone</label>
                                            <select name="timezone"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 outline-none">
                                                <option value="America/New_York"
                                                    {{ auth()->user()->timezone == 'America/New_York' ? 'selected' : '' }}>
                                                    Eastern Time (ET)</option>
                                                <option value="America/Chicago"
                                                    {{ auth()->user()->timezone == 'America/Chicago' ? 'selected' : '' }}>
                                                    Central Time (CT)</option>
                                                <option value="America/Denver"
                                                    {{ auth()->user()->timezone == 'America/Denver' ? 'selected' : '' }}>
                                                    Mountain Time (MT)</option>
                                                <option value="America/Los_Angeles"
                                                    {{ auth()->user()->timezone == 'America/Los_Angeles' ? 'selected' : '' }}>
                                                    Pacific Time (PT)</option>
                                                <option value="Europe/London"
                                                    {{ auth()->user()->timezone == 'Europe/London' ? 'selected' : '' }}>
                                                    London (GMT)</option>
                                                <option value="Europe/Paris"
                                                    {{ auth()->user()->timezone == 'Europe/Paris' ? 'selected' : '' }}>
                                                    Paris (CET)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Client Specific Information -->
                                <div class="pt-6 border-t">
                                    <h3 class="font-semibold text-gray-900 mb-4">Client Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Company
                                                Name</label>
                                            <input type="text" name="company"
                                                value="{{ old('company', auth()->user()->client->company ?? '') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 outline-none"
                                                placeholder="Your company name">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                                            <input type="url" name="website"
                                                value="{{ old('website', auth()->user()->client->website ?? '') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 outline-none"
                                                placeholder="https://example.com">
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="flex justify-end space-x-3 pt-6 border-t">
                                    <button type="button" onclick="resetForm()"
                                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 font-medium select-none">
                                        Cancel
                                    </button>
                                    <button type="submit" id="submitBtn"
                                        class="flex items-center px-6 py-2 bg-gray-800 text-white rounded-lg hover:bg-black transition duration-300 font-medium select-none">
                                        <div id="submitSpinner"
                                            class="hidden w-5 h-5 border-t-2 border-white rounded-full animate-spin mr-2">
                                        </div>
                                        <span id="submitText">Save Changes</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Security Settings -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Security Settings</h2>

                            <div class="space-y-6">
                                <!-- Password Reset Card -->
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="font-medium text-gray-900 mb-1">Password</h3>
                                            <p class="text-sm text-gray-600">
                                                To change your password, we'll send you a secure link to your email
                                            </p>
                                        </div>
                                        <button type="button" onclick="requestPasswordReset()"
                                            class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black transition duration-300 font-medium text-sm select-none">
                                            Change Password
                                        </button>
                                    </div>
                                </div>

                                <!-- Two-Factor Authentication -->
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="font-medium text-gray-900 mb-1">Two-Factor Authentication</h3>
                                            <p class="text-sm text-gray-600">
                                                Add an extra layer of security to your account
                                            </p>
                                        </div>
                                        <button type="button" onclick="toggle2FA()"
                                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 font-medium text-sm select-none">
                                            {{ auth()->user()->two_factor_enabled ? 'Disable' : 'Enable' }} 2FA
                                        </button>
                                    </div>
                                </div>

                                <!-- Recent Sessions -->
                                <div class="space-y-3">
                                    <h3 class="font-medium text-gray-900">Recent Sessions</h3>
                                    <div class="space-y-2">
                                        <div
                                            class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                                    <svg class="w-4 h-4 text-blue-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Chrome on Windows</p>
                                                    <p class="text-xs text-gray-500">Current session •
                                                        {{ request()->ip() }}</p>
                                                </div>
                                            </div>
                                            <span class="text-xs font-medium text-green-600">Active</span>
                                        </div>

                                        <button type="button" onclick="logoutOtherSessions()"
                                            class="w-full text-sm text-red-600 hover:text-red-800 font-medium py-2">
                                            Log out from all other devices
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Stats & Actions -->
                    <div class="space-y-3">
                        <!-- Account Stats -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Account Stats</h2>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Account Balance</p>
                                            <p class="text-lg font-bold text-gray-900">
                                                ${{ number_format(auth()->user()->balance, 2) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Total Spent</p>
                                            <p class="text-lg font-bold text-gray-900">
                                                ${{ number_format(auth()->user()->client->total_spent ?? 0, 2) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0a6 6 0 00-9 5.197" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Freelancers Hired</p>
                                            <p class="text-lg font-bold text-gray-900">15</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Status -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Account Status</h2>

                            <div class="space-y-4 select-none">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-700">Email Verification</span>
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">
                                        Verified
                                    </span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-700">Phone Verification</span>
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">
                                        Verified
                                    </span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-700">2FA Authentication</span>
                                    <button type="button"
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Enable
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Recent Activity</h2>

                            <div class="space-y-4">
                                <!-- Activity Timeline -->
                                <div class="space-y-3">
                                    <div class="flex items-start">
                                        <div
                                            class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Profile Updated</p>
                                            <p class="text-xs text-gray-500">You updated your profile information</p>
                                            <p class="text-xs text-gray-400">
                                                {{ auth()->user()->updated_at->diffForHumans() }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div
                                            class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Password Changed</p>
                                            <p class="text-xs text-gray-500">You updated your account password</p>
                                            <p class="text-xs text-gray-400">3 days ago</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div
                                            class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Profile Photo Updated</p>
                                            <p class="text-xs text-gray-500">You changed your profile picture</p>
                                            <p class="text-xs text-gray-400">1 week ago</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div
                                            class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Session Expired</p>
                                            <p class="text-xs text-gray-500">A session was automatically logged out</p>
                                            <p class="text-xs text-gray-400">2 weeks ago</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- View All Activity Button -->
                                <button type="button"
                                    class="w-full py-2 text-center text-sm font-medium text-blue-600 hover:text-blue-800 border border-blue-200 rounded-lg hover:bg-blue-50 transition duration-300 select-none">
                                    View All Activity
                                </button>

                                <!-- Activity Summary -->
                                <div class="mt-4 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Activity This Month</p>
                                            <p class="text-xs text-gray-500">8 profile updates</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-gray-900">Active Days</p>
                                            <p class="text-xs text-gray-500">14/30 days</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Actions -->
                                <div class="pt-4 mt-4 border-t border-gray-200">
                                    <h3 class="text-sm font-medium text-gray-900 mb-3">Account Actions</h3>
                                    <button type="button" id="deleteAccountBtn"
                                        class="w-full py-2.5 text-center text-sm font-medium text-red-600 hover:text-red-800 border border-red-200 rounded-lg hover:bg-red-50 transition duration-300 flex items-center justify-center select-none">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete Account
                                    </button>
                                    <p class="text-xs text-gray-500 mt-2 text-center">
                                        This action cannot be undone. All your data will be permanently deleted.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Toggle edit mode
        function toggleEditMode(formId) {
            const inputs = form.querySelectorAll('input, select, textarea');

            inputs.forEach(input => {
                input.disabled = !input.disabled;
            });
        }

        // Reset form to original values
        function resetForm() {
            document.getElementById('profileForm').reset();
        }

        const form = document.getElementById('profileForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitSpinner = document.getElementById('submitSpinner');

        // Function to set loading state
        function setLoading(isLoading) {
            if (isLoading) {
                submitBtn.disabled = true;
                submitText.textContent = 'Saving...';
                submitSpinner.classList.remove('hidden');
                submitSpinner.classList.add('block'); // Show spinner
            } else {
                submitBtn.disabled = false;
                submitText.textContent = 'Save Changes';
                submitSpinner.classList.remove('block');
                submitSpinner.classList.add('hidden'); // Hide spinner
            }
        }

        // Profile Form
        document.getElementById('profileForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            setLoading(true);

            const formData = new FormData(this);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    if (data.status === 'success') {
                        // Update name in sidebar
                        document.getElementById('name').textContent = formData.get('name');

                        // Update the "Last updated" timestamp at the top of the page
                        const lastUpdatedElement = document.querySelector('.text-sm.text-gray-500');
                        if (lastUpdatedElement) {
                            const now = new Date();
                            const formattedDate = now.toLocaleDateString('en-US', {
                                month: 'long',
                                day: 'numeric',
                                year: 'numeric'
                            });
                            lastUpdatedElement.textContent = `Last updated: ${formattedDate}`;
                        }

                        // Update the "Profile Updated" timestamp in Recent Activity
                        const profileUpdateElements = document.querySelectorAll(
                            '.flex-1 .text-xs.text-gray-400');
                        if (profileUpdateElements.length > 0) {
                            profileUpdateElements[0].textContent = 'Just now';
                        }

                        // Show success message
                        showToast('Profile updated successfully!', 'success');
                    } else {
                        alert(data.message);
                    }
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert(error);
            } finally {
                setLoading(false);
            }
        });

        // Delete Account button
        const deleteAccountBtn = document.getElementById('deleteAccountBtn');

        deleteAccountBtn.addEventListener('click', async function(e) {
            if (!confirm(
                    'Are you sure you want to delete your account?\n\n' +
                    'This action will:\n' +
                    '• Permanently delete your account\n' +
                    '• Remove all your data from the system\n' +
                    '• Cancel any active projects\n' +
                    '• This action cannot be undone!\n\n' +
                    'Type "DELETE" to confirm:'
                )) {
                e.preventDefault();
                e.stopPropagation();
                return;
            }

            const userInput = prompt('Please type "DELETE" to confirm account deletion:');
            if (userInput !== 'DELETE') {
                alert('Account deletion cancelled. The text did not match.');
                return;
            }

            // Show loading state on the delete button
            const originalText = deleteAccountBtn.innerHTML;
            deleteAccountBtn.innerHTML = `
                <div class="w-4 h-4 border-t-2 border-red-600 rounded-full animate-spin mr-2"></div>
                Deleting Account...
            `;
            deleteAccountBtn.disabled = true;

            try {
                const response = await fetch('{{ route('profile.destroy', auth()->user()->id) }}', {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    if (data.status === 'success') {
                        // Redirect to logout route
                    } else {
                        alert(data.message || 'Failed to delete account.');
                        // Reset button state
                        deleteAccountBtn.innerHTML = originalText;
                        deleteAccountBtn.disabled = false;
                    }
                } else {
                    alert(data.message || 'Failed to delete account.');
                    // Reset button state
                    deleteAccountBtn.innerHTML = originalText;
                    deleteAccountBtn.disabled = false;
                }
            } catch (error) {
                alert('An error occurred while deleting your account. Please try again.');
                // Reset button state
                deleteAccountBtn.innerHTML = originalText;
                deleteAccountBtn.disabled = false;
            }
        });

        // Format phone number
        const phoneInput = document.querySelector('input[name="phone"]');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 10) value = value.substring(0, 10);

                // Format as (XXX) XXX-XXXX
                if (value.length > 3 && value.length <= 6) {
                    value = `(${value.substring(0,3)}) ${value.substring(3)}`;
                } else if (value.length > 6) {
                    value = `(${value.substring(0,3)}) ${value.substring(3,6)}-${value.substring(6)}`;
                }

                e.target.value = value;
            });
        }

        // Toast notification function
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-3 px-4 py-3 rounded-md shadow-md text-white font-medium transition-opacity duration-300 z-50 ${
                type === 'success' ? 'bg-green-400' : 'bg-red-400'
            }`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => document.body.removeChild(toast), 300);
            }, 3000);
        }
    </script>
</body>

</html>
