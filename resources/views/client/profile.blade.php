<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile | CollabHub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
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

                            <form id="profileForm" method="POST" action="" enctype="multipart/form-data"
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
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Full Name
                                            </label>
                                            <input type="text" name="name"
                                                value="{{ old('name', auth()->user()->name) }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 outline-none"
                                                required>
                                            @error('name')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Email Address
                                            </label>
                                            <input type="email" name="email"
                                                value="{{ old('email', auth()->user()->email) }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 outline-none"
                                                required>
                                            @error('email')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Phone Number
                                            </label>
                                            <div class="flex">
                                                <select name="country_code"
                                                    class="px-3 py-2 border border-gray-300 rounded-l-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
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
                                                    class="flex-1 px-4 py-2 border border-l-0 border-gray-300 rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
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
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Country
                                            </label>
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
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                City/Location
                                            </label>
                                            <input type="text" name="location"
                                                value="{{ old('location', auth()->user()->location) }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 outline-none"
                                                placeholder="e.g., New York, London">
                                            @error('location')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Timezone
                                            </label>
                                            <select name="timezone"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 outline-none">
                                                <option value="America/New_York" selected>Eastern Time (ET)</option>
                                                <option value="America/Chicago">Central Time (CT)</option>
                                                <option value="America/Denver">Mountain Time (MT)</option>
                                                <option value="America/Los_Angeles">Pacific Time (PT)</option>
                                                <option value="Europe/London">London (GMT)</option>
                                                <option value="Europe/Paris">Paris (CET)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Client Specific Information -->
                                <div class="pt-6 border-t">
                                    <h3 class="font-semibold text-gray-900 mb-4">Client Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Company Name
                                            </label>
                                            <input type="text" name="company"
                                                value="{{ old('company', auth()->user()->client->company ?? '') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 outline-none"
                                                placeholder="Your company name">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Website
                                            </label>
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
                                    <button type="submit"
                                        class="px-6 py-2 bg-gray-800 text-white rounded-lg hover:bg-black transition duration-300 font-medium select-none">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Replace the entire Security Settings section with this: -->

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

                        <!-- Quick Actions -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h2>

                            <div class="grid grid-cols-2 gap-3">
                                <button type="button"
                                    class="p-3 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition duration-300 flex flex-col items-center">
                                    <svg class="w-6 h-6 text-blue-600 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    <span class="text-blue-700 text-sm font-medium">Post Job</span>
                                </button>

                                <button type="button"
                                    class="p-3 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition duration-300 flex flex-col items-center">
                                    <svg class="w-6 h-6 text-green-600 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <span class="text-green-700 text-sm font-medium">Notifications</span>
                                </button>

                                <button type="button"
                                    class="p-3 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition duration-300 flex flex-col items-center">
                                    <svg class="w-6 h-6 text-purple-600 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-purple-700 text-sm font-medium">Settings</span>
                                </button>

                                <button type="button"
                                    class="p-3 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition duration-300 flex flex-col items-center">
                                    <svg class="w-6 h-6 text-red-600 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span class="text-red-700 text-sm font-medium">Delete Account</span>
                                </button>
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
            const form = document.getElementById(formId + 'Form');
            const inputs = form.querySelectorAll('input, select, textarea');

            inputs.forEach(input => {
                input.disabled = !input.disabled;
            });
        }

        // Reset form to original values
        function resetForm() {
            document.getElementById('profileForm').reset();
            const inputs = document.getElementById('profileForm').querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.disabled = true;
            });
        }

        // Form validation
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Basic validation
            const name = this.querySelector('input[name="name"]').value;
            const email = this.querySelector('input[name="email"]').value;

            if (!name || !email) {
                alert('Please fill in all required fields');
                return;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address');
                return;
            }

            // If all validations pass, submit the form
            this.submit();
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

        // Request password reset
        function requestPasswordReset() {
            if (confirm('We will send a password reset link to your email. Continue?')) {
                // Show loading state
                const button = event.target;
                const originalText = button.textContent;
                button.textContent = 'Sending...';
                button.disabled = true;

                // Send request to backend
                fetch('{{ route('password.email') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            email: '{{ auth()->user()->email }}'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success' || data.message) {
                            alert('Password reset link sent to your email. Please check your inbox.');
                        } else {
                            throw new Error('Failed to send reset link');
                        }
                    })
                    .catch(error => {
                        alert('Error: ' + error.message);
                    })
                    .finally(() => {
                        button.textContent = originalText;
                        button.disabled = false;
                    });
            }
        }
    </script>
</body>

</html>
