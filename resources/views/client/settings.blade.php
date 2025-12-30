<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Settings | CollabHub</title>

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
                <!-- Page Header -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Account Settings</h1>
                        <p class="text-gray-600 mt-1">
                            Manage your account preferences and application settings
                        </p>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ now()->format('l, F j, Y') }}
                    </div>
                </div>

                <!-- Settings Content -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                    <!-- Main Form for all settings -->
                    <form id="preferencesForm" method="POST" action="{{ route('settings.update') }}"
                        class="lg:col-span-2 space-y-3">
                        @csrf
                        @method('PUT')

                        <!-- Application Preferences -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Application Preferences</h2>

                            <div>
                                <div class="space-y-6">
                                    <!-- Language & Region -->
                                    <div class="space-y-4">
                                        <h3 class="font-semibold text-gray-900">Language & Region</h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Interface
                                                    Language</label>
                                                <select name="language"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-300 setting-select">
                                                    <option value="en"
                                                        {{ (auth()->user()->settings->language ?? 'en') == 'en' ? 'selected' : '' }}>
                                                        English</option>
                                                    <option value="my"
                                                        {{ (auth()->user()->settings->language ?? 'en') == 'my' ? 'selected' : '' }}>
                                                        Burmese</option>
                                                </select>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Time
                                                    Zone</label>
                                                <select name="timezone"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-300 setting-select">
                                                    <option value="UTC"
                                                        {{ (auth()->user()->settings->timezone ?? 'UTC') == 'UTC' ? 'selected' : '' }}>
                                                        UTC (Coordinated Universal Time)</option>
                                                    <option value="America/New_York"
                                                        {{ (auth()->user()->settings->timezone ?? 'UTC') == 'America/New_York' ? 'selected' : '' }}>
                                                        Eastern Time (ET)</option>
                                                    <option value="America/Chicago"
                                                        {{ (auth()->user()->settings->timezone ?? 'UTC') == 'America/Chicago' ? 'selected' : '' }}>
                                                        Central Time (CT)</option>
                                                    <option value="America/Los_Angeles"
                                                        {{ (auth()->user()->settings->timezone ?? 'UTC') == 'America/Los_Angeles' ? 'selected' : '' }}>
                                                        Pacific Time (PT)</option>
                                                    <option value="Europe/London"
                                                        {{ (auth()->user()->settings->timezone ?? 'UTC') == 'Europe/London' ? 'selected' : '' }}>
                                                        London (GMT)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Currency Settings -->
                                    <div class="pt-6 border-t border-gray-200">
                                        <h3 class="font-semibold text-gray-900 mb-4">Currency Settings</h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Default
                                                    Currency</label>
                                                <select name="currency"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-300 setting-select">
                                                    <option value="USD"
                                                        {{ (auth()->user()->settings->currency ?? 'USD') == 'USD' ? 'selected' : '' }}>
                                                        US Dollar ($)</option>
                                                    <option value="MMK"
                                                        {{ (auth()->user()->settings->currency ?? 'USD') == 'MMK' ? 'selected' : '' }}>
                                                        Myanmar Kyat (MMK)</option>
                                                    <option value="EUR"
                                                        {{ (auth()->user()->settings->currency ?? 'USD') == 'EUR' ? 'selected' : '' }}>
                                                        Euro (€)</option>
                                                    <option value="GBP"
                                                        {{ (auth()->user()->settings->currency ?? 'USD') == 'GBP' ? 'selected' : '' }}>
                                                        British Pound (£)</option>
                                                    <option value="CAD"
                                                        {{ (auth()->user()->settings->currency ?? 'USD') == 'CAD' ? 'selected' : '' }}>
                                                        Canadian Dollar ($)</option>
                                                    <option value="AUD"
                                                        {{ (auth()->user()->settings->currency ?? 'USD') == 'AUD' ? 'selected' : '' }}>
                                                        Australian Dollar ($)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Display Preferences -->
                                    <div class="pt-6 border-t border-gray-200">
                                        <h3 class="font-semibold text-gray-900 mb-4">Display Preferences</h3>

                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h4 class="font-medium text-gray-900">Dark Mode</h4>
                                                    <p class="text-gray-500 text-sm">Use dark theme across the
                                                        application</p>
                                                </div>
                                                <div class="relative">
                                                    <input type="checkbox" name="dark_mode" value="1"
                                                        id="darkModeToggle" class="sr-only setting-checkbox"
                                                        {{ auth()->user()->settings->dark_mode ?? false ? 'checked' : '' }}>
                                                    <label for="darkModeToggle"
                                                        class="toggle-label flex items-center w-12 h-6 rounded-full cursor-pointer transition duration-300 {{ auth()->user()->settings->dark_mode ?? false ? 'bg-gray-600' : 'bg-gray-300' }}">
                                                        <span
                                                            class="toggle-span block w-4 h-4 rounded-full bg-white transition duration-300 transform {{ auth()->user()->settings->dark_mode ?? false ? 'translate-x-7' : 'translate-x-1' }}"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notification Settings -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Notification Settings</h2>

                            <div class="space-y-6">
                                <!-- Email Notifications -->
                                <div class="space-y-4">
                                    <h3 class="font-semibold text-gray-900">Email Notifications</h3>

                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900">Project Updates</h4>
                                                <p class="text-gray-500 text-sm">Get notified about project
                                                    milestones and changes</p>
                                            </div>
                                            <div class="relative">
                                                <input type="checkbox" name="email_project_updates" value="1"
                                                    id="emailProjectUpdates" class="sr-only setting-checkbox"
                                                    {{ auth()->user()->settings->email_project_updates ?? true ? 'checked' : '' }}>
                                                <label for="emailProjectUpdates"
                                                    class="toggle-label flex items-center w-12 h-6 rounded-full cursor-pointer transition duration-300 {{ auth()->user()->settings->email_project_updates ?? true ? 'bg-green-500' : 'bg-gray-300' }}">
                                                    <span
                                                        class="toggle-span block w-4 h-4 rounded-full bg-white transition duration-300 transform {{ auth()->user()->settings->email_project_updates ?? true ? 'translate-x-7' : 'translate-x-1' }}"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900">New Messages</h4>
                                                <p class="text-gray-500 text-sm">Receive email alerts for new
                                                    messages</p>
                                            </div>
                                            <div class="relative">
                                                <input type="checkbox" name="email_new_messages" value="1"
                                                    id="emailNewMessages" class="sr-only setting-checkbox"
                                                    {{ auth()->user()->settings->email_new_messages ?? true ? 'checked' : '' }}>
                                                <label for="emailNewMessages"
                                                    class="toggle-label flex items-center w-12 h-6 rounded-full cursor-pointer transition duration-300 {{ auth()->user()->settings->email_new_messages ?? true ? 'bg-green-500' : 'bg-gray-300' }}">
                                                    <span
                                                        class="toggle-span block w-4 h-4 rounded-full bg-white transition duration-300 transform {{ auth()->user()->settings->email_new_messages ?? true ? 'translate-x-7' : 'translate-x-1' }}"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900">Payment Notifications
                                                </h4>
                                                <p class="text-gray-500 text-sm">Get notified about payments
                                                    and
                                                    invoices</p>
                                            </div>
                                            <div class="relative">
                                                <input type="checkbox" name="email_payments" value="1"
                                                    id="emailPayments" class="sr-only setting-checkbox"
                                                    {{ auth()->user()->settings->email_payments ?? true ? 'checked' : '' }}>
                                                <label for="emailPayments"
                                                    class="toggle-label flex items-center w-12 h-6 rounded-full cursor-pointer transition duration-300 {{ auth()->user()->settings->email_payments ?? true ? 'bg-green-500' : 'bg-gray-300' }}">
                                                    <span
                                                        class="toggle-span block w-4 h-4 rounded-full bg-white transition duration-300 transform {{ auth()->user()->settings->email_payments ?? true ? 'translate-x-7' : 'translate-x-1' }}"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900">Marketing Emails</h4>
                                                <p class="text-gray-500 text-sm">Receive updates about new
                                                    features
                                                    and promotions</p>
                                            </div>
                                            <div class="relative">
                                                <input type="checkbox" name="email_marketing" value="1"
                                                    id="emailMarketing" class="sr-only setting-checkbox"
                                                    {{ auth()->user()->settings->email_marketing ?? false ? 'checked' : '' }}>
                                                <label for="emailMarketing"
                                                    class="toggle-label flex items-center w-12 h-6 rounded-full cursor-pointer transition duration-300 {{ auth()->user()->settings->email_marketing ?? false ? 'bg-green-500' : 'bg-gray-300' }}">
                                                    <span
                                                        class="toggle-span block w-4 h-4 rounded-full bg-white transition duration-300 transform {{ auth()->user()->settings->email_marketing ?? false ? 'translate-x-7' : 'translate-x-1' }}"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Privacy & Security -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Privacy & Security</h2>

                            <div class="space-y-6">
                                <!-- Account Visibility -->
                                <div class="space-y-4">
                                    <h3 class="font-semibold text-gray-900">Account Visibility</h3>

                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900">Profile Visibility</h4>
                                                <p class="text-gray-500 text-sm">Who can see your profile</p>
                                            </div>
                                            <select name="profile_visibility"
                                                class="setting-select px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                                                <option value="public"
                                                    {{ (auth()->user()->settings->profile_visibility ?? 'public') == 'public' ? 'selected' : '' }}>
                                                    Public</option>
                                                <option value="clients_only"
                                                    {{ (auth()->user()->settings->profile_visibility ?? 'public') == 'clients_only' ? 'selected' : '' }}>
                                                    Only Clients</option>
                                                <option value="freelancers_only"
                                                    {{ (auth()->user()->settings->profile_visibility ?? 'public') == 'freelancers_only' ? 'selected' : '' }}>
                                                    Only Freelancers</option>
                                                <option value="private"
                                                    {{ (auth()->user()->settings->profile_visibility ?? 'public') == 'private' ? 'selected' : '' }}>
                                                    Private</option>
                                            </select>
                                        </div>

                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900">Show Online Status</h4>
                                                <p class="text-gray-500 text-sm">Display when you're online to
                                                    others
                                                </p>
                                            </div>
                                            <div class="relative">
                                                <input type="checkbox" name="show_online_status" value="1"
                                                    id="showOnlineStatus" class="sr-only setting-checkbox"
                                                    {{ auth()->user()->settings->show_online_status ?? true ? 'checked' : '' }}>
                                                <label for="showOnlineStatus"
                                                    class="toggle-label flex items-center w-12 h-6 rounded-full cursor-pointer transition duration-300 {{ auth()->user()->settings->show_online_status ?? true ? 'bg-green-500' : 'bg-gray-300' }}">
                                                    <span
                                                        class="toggle-span block w-4 h-4 rounded-full bg-white transition duration-300 transform {{ auth()->user()->settings->show_online_status ?? true ? 'translate-x-7' : 'translate-x-1' }}"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Right Column - Account Actions & Status -->
                    <div class="space-y-3 mt-3">
                        <!-- Account Status -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Account Status</h2>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-700">Account Type</span>
                                    <span class="font-medium">{{ ucfirst(auth()->user()->role) }}</span>
                                </div>

                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-700">Member Since</span>
                                    <span
                                        class="font-medium">{{ auth()->user()->created_at->format('M d, Y') }}</span>
                                </div>

                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-700">Account Status</span>
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">
                                        {{ ucfirst(auth()->user()->status) }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-700">Email Verification</span>
                                    @if (auth()->user()->email_verified_at)
                                        <span class="text-green-600 font-medium">✓ Verified</span>
                                    @else
                                        <button type="button" onclick="verifyEmail()"
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Verify Now
                                        </button>
                                    @endif
                                </div>

                                <div class="pt-4 border-t border-gray-200">
                                    <div class="text-center">
                                        <div
                                            class="w-16 h-16 mx-auto mb-3 rounded-full bg-blue-50 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h3 class="font-medium text-gray-900">Account Secure</h3>
                                        <p class="text-gray-500 text-sm mt-1">All security settings are up to date
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Danger Zone -->
                        <div class="bg-white rounded-xl shadow-sm border border-red-200 p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Danger Zone</h2>

                            <div class="space-y-4">
                                <div>
                                    <h3 class="font-medium text-gray-900 mb-2">Deactivate Account</h3>
                                    <p class="text-gray-500 text-sm mb-3">Temporarily disable your account</p>
                                    <button onclick="deactivateAccount()"
                                        class="w-full px-4 py-2 border border-yellow-300 text-yellow-700 rounded-lg hover:bg-yellow-50 transition duration-300 text-sm font-medium">
                                        Deactivate Account
                                    </button>
                                </div>

                                <div class="pt-4 border-t border-red-100">
                                    <h3 class="font-medium text-gray-900 mb-2">Delete Account</h3>
                                    <p class="text-gray-500 text-sm mb-3">Permanently delete your account and data
                                    </p>
                                    <button onclick="deleteAccount()"
                                        class="w-full px-4 py-2 bg-red-50 border border-red-200 text-red-600 rounded-lg hover:bg-red-100 transition duration-300 text-sm font-medium">
                                        Delete Account
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Save All Changes -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Save Changes</h2>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900">Apply Settings</h3>
                                        <p class="text-gray-500 text-sm mt-1">Save all your preferences</p>
                                    </div>
                                    <button id="saveAllSettings" type="button"
                                        class="flex items-center px-6 py-2 bg-gray-800 text-white rounded-lg hover:bg-black transition duration-300 font-medium select-none">
                                        <div id="submitSpinner"
                                            class="hidden w-5 h-5 border-t-2 border-white rounded-full animate-spin mr-2">
                                        </div>
                                        <span id="submitText">Save Changes</span>
                                    </button>
                                </div>

                                <div class="pt-4 border-t border-gray-200">
                                    <button onclick="resetToDefaults()" type="button"
                                        class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 text-sm font-medium">
                                        Reset to Defaults
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- JavaScript for Settings Page -->
    <script>
        // Initialize toggle switches on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeToggleSwitches();
        });

        // Toggle switch functionality
        function initializeToggleSwitches() {
            document.querySelectorAll('.toggle-label').forEach(label => {
                // Set initial state from checkbox
                const checkbox = label.previousElementSibling;
                const span = label.querySelector('.toggle-span');

                // Ensure proper initial state
                if (checkbox.checked) {
                    label.classList.remove('bg-gray-300');
                    label.classList.add('bg-green-500');
                    span.classList.remove('translate-x-1');
                    span.classList.add('translate-x-7');
                } else {
                    label.classList.remove('bg-green-500');
                    label.classList.add('bg-gray-300');
                    span.classList.remove('translate-x-7');
                    span.classList.add('translate-x-1');
                }

                // Add click handler
                label.addEventListener('click', function() {
                    const checkbox = this.previousElementSibling;
                    const span = this.querySelector('.toggle-span');

                    // Toggle checkbox state
                    checkbox.checked = !checkbox.checked;

                    // Update checkbox value for form submission
                    if (checkbox.checked) {
                        checkbox.setAttribute('value', '1');
                    } else {
                        checkbox.setAttribute('value', '0');
                    }

                    // Update visual state
                    if (checkbox.checked) {
                        this.classList.remove('bg-gray-300');
                        this.classList.add('bg-green-500');
                        span.classList.remove('translate-x-1');
                        span.classList.add('translate-x-7');
                    } else {
                        this.classList.remove('bg-green-500');
                        this.classList.add('bg-gray-300');
                        span.classList.remove('translate-x-7');
                        span.classList.add('translate-x-1');
                    }
                });
            });
        }

        // Save all settings
        document.getElementById('saveAllSettings').addEventListener('click', async function(e) {
            e.preventDefault();

            const saveAllBtn = this;
            const submitText = document.getElementById('submitText');
            const submitSpinner = document.getElementById('submitSpinner');
            const originalText = submitText.textContent;

            // Show loading state
            submitText.textContent = 'Saving...';
            submitSpinner.classList.remove('hidden');
            submitSpinner.classList.add('block');
            saveAllBtn.disabled = true;

            try {
                // Get the main form
                const form = document.getElementById('preferencesForm');

                // Create FormData object from the form
                const formData = new FormData(form);

                // For checkboxes that are unchecked, ensure they're included with value '0'
                document.querySelectorAll('.setting-checkbox').forEach(checkbox => {
                    if (!checkbox.checked && !formData.has(checkbox.name)) {
                        formData.append(checkbox.name, '0');
                    }
                });

                // Send the request
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    // Show success state
                    showToast(result.message || 'All settings saved successfully!', 'success');
                } else {
                    throw new Error(result.message || 'Failed to save settings');
                }
            } catch (error) {
                console.error('Save error:', error);
                showToast(error.message || 'An error occurred while saving settings', 'error');
            } finally {
                // Reset button after 2 seconds
                setTimeout(() => {
                    submitText.textContent = originalText;
                    submitSpinner.classList.add('hidden');
                    submitSpinner.classList.remove('block');
                    saveAllBtn.disabled = false;
                }, 2000);
            }
        });

        // Account actions
        function verifyEmail() {
            //
        }

        function deactivateAccount() {
            //
        }

        function deleteAccount() {
            //
        }

        function resetToDefaults() {
            if (confirm('Reset all settings to default values?')) {
                fetch('{{ route('settings.reset') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            _method: 'PUT'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Settings reset to defaults!', 'success');
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showToast(data.message || 'Failed to reset settings', 'error');
                        }
                    })
                    .catch(error => {
                        showToast('An error occurred. Please try again.', 'error');
                    });
            }
        }

        // Toast notification function
        function showToast(message, type = 'success') {
            // Remove existing toasts
            const existingToasts = document.querySelectorAll('.custom-toast');
            existingToasts.forEach(toast => toast.remove());

            const toast = document.createElement('div');
            toast.className =
                `custom-toast fixed top-4 right-3 px-4 py-3 rounded-md shadow-md text-white font-medium transition-all duration-300 z-50 ${type === 'success' ? 'bg-green-400' : type === 'error' ? 'bg-red-400' : 'bg-blue-400'}`;
            toast.textContent = message;
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-20px)';

            document.body.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.style.opacity = '1';
                toast.style.transform = 'translateY(0)';
            }, 10);

            // Remove after 3 seconds
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
    </script>
</body>

</html>
