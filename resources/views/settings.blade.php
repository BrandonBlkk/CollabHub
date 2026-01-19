@extends('layouts.app')

@section('title', 'Your Profile')

@auth
    <meta name="user-role" content="{{ Auth::user()->role }}">
@endauth

@section('content')
    {{-- Dark overlay --}}
    <div id="darkoverlay" class="hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 z-10"></div>

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
        <form id="preferencesForm" method="POST" action="{{ route('settings.update') }}" class="lg:col-span-2 space-y-3">
            @csrf
            @method('PUT')

            <!-- Application Preferences -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Application Preferences</h2>

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
                                        <input type="checkbox" name="dark_mode" value="1" id="darkModeToggle"
                                            class="sr-only setting-checkbox"
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
                <h2 class="text-lg font-bold text-gray-900 mb-6">Notification Settings</h2>

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
                                    <input type="checkbox" name="email_new_messages" value="1" id="emailNewMessages"
                                        class="sr-only setting-checkbox"
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
                                    <input type="checkbox" name="email_payments" value="1" id="emailPayments"
                                        class="sr-only setting-checkbox"
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
                                    <input type="checkbox" name="email_marketing" value="1" id="emailMarketing"
                                        class="sr-only setting-checkbox"
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
                <h2 class="text-lg font-bold text-gray-900 mb-6">Privacy & Security</h2>

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
                <h2 class="text-lg font-bold text-gray-900 mb-6">Account Status</h2>

                <div class="space-y-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-700">Account Type</span>
                        <span class="font-medium">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-700">Member Since</span>
                        <span class="font-medium">{{ auth()->user()->created_at->format('M d, Y') }}</span>
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
                            <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-blue-50 flex items-center justify-center">
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

            <!-- Trash / Archive Section -->
            @if (auth()->user()->role === 'freelancer')
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="mb-6">
                        <h2 class="text-lg font-bold text-gray-900">Trash / Archive</h2>
                        <p class="text-gray-600 text-sm mt-1">Manage deleted items</p>
                    </div>

                    <!-- Summary Stats - Initially loading -->
                    <div id="trash-summary-container">
                        <div class="grid grid-cols-3 gap-3 mb-4">
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <div class="text-lg font-semibold text-gray-900">
                                    <div class="animate-pulse bg-gray-200 h-6 w-8 mx-auto rounded"></div>
                                </div>
                                <div class="text-xs text-gray-600">Experiences</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <div class="text-lg font-semibold text-gray-900">
                                    <div class="animate-pulse bg-gray-200 h-6 w-8 mx-auto rounded"></div>
                                </div>
                                <div class="text-xs text-gray-600">Education</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <div class="text-lg font-semibold text-gray-900">
                                    <div class="animate-pulse bg-gray-200 h-6 w-8 mx-auto rounded"></div>
                                </div>
                                <div class="text-xs text-gray-600">Certificates</div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 text-center py-4">
                            <div class="item-start animate-pulse bg-gray-200 h-4 w-52 rounded mb-2"></div>
                            <div class="flex space-x-2 justify-center">
                                <div class="animate-pulse bg-blue-100 h-9 w-full rounded-lg"></div>
                                <div class="animate-pulse bg-gray-100 h-9 w-36 rounded-lg"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            @endif

            <!-- Trash Modal -->
            <div id="trashModal" class="fixed inset-0 z-50 hidden transition-opacity duration-300">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col">
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between p-6">
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Trash / Archive</h2>
                                <p class="text-gray-600 text-sm mt-1">Restore or permanently delete items</p>
                            </div>
                            <button onclick="closeTrashModal()"
                                class="text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100 transition duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Modal Content -->
                        <div class="flex-1 overflow-hidden flex flex-col">
                            <!-- Tab Navigation -->
                            <div class="border-b border-gray-200">
                                <nav class="flex space-x-4 px-6 overflow-x-auto select-none" id="trash-modal-tabs">
                                    <!-- Tabs will be populated by JavaScript -->
                                </nav>
                            </div>

                            <!-- Tab Content -->
                            <div class="flex-1 overflow-y-auto p-3 px-6">
                                <div id="modal-loading" class="text-center py-12">
                                    <div
                                        class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto mb-4">
                                    </div>
                                    <p class="text-gray-500 text-sm">Loading trash data...</p>
                                </div>

                                <!-- Tab contents will be populated by JavaScript -->
                                <div id="modal-experiences-trash" class="h-full overflow-y-auto hidden"></div>
                                <div id="modal-educations-trash" class="h-full overflow-hidden hidden"></div>
                                <div id="modal-certificates-trash" class="h-full overflow-hidden hidden"></div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="p-6 border-t border-gray-200 flex justify-between items-center">
                            <div class="text-sm text-gray-600" id="modal-footer-count">
                                Loading...
                            </div>
                            <div class="flex space-x-3 select-none">
                                <button onclick="closeTrashModal()"
                                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 text-sm font-medium">
                                    Close
                                </button>
                                <button id="empty-all-trash-btn" onclick="emptyTrash()"
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300 text-sm font-medium hidden">
                                    Empty All Trash
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-white rounded-xl shadow-sm border border-red-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Danger Zone</h2>

                <div class="space-y-4">
                    <div>
                        <h3 class="font-medium text-gray-900 mb-2">Deactivate Account</h3>
                        <p class="text-gray-500 text-sm mb-3">Temporarily disable your account</p>
                        <button onclick="deactivateAccount()"
                            class="w-full px-4 py-2 border border-yellow-300 text-yellow-700 rounded-lg hover:bg-yellow-50 transition duration-300 text-sm font-medium select-none">
                            Deactivate Account
                        </button>
                    </div>

                    <div class="pt-4 border-t border-red-100">
                        <h3 class="font-medium text-gray-900 mb-2">Delete Account</h3>
                        <p class="text-gray-500 text-sm mb-3">Permanently delete your account and data
                        </p>
                        @if (auth()->user()->role === 'client')
                            <button onclick="deleteAccount()"
                                class="w-full px-4 py-2 bg-red-50 border border-red-200 text-red-600 rounded-lg hover:bg-red-100 transition duration-300 text-sm font-medium select-none">
                                Delete Account
                            </button>
                        @elseif (auth()->user()->role === 'freelancer')
                            <form action="{{ route('freelancer-profile.destroy', auth()->user()->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-red-50 border border-red-200 text-red-600 rounded-lg hover:bg-red-100 transition duration-300 text-sm font-medium select-none">
                                    Delete Account
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Save All Changes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Save Changes</h2>

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
                            class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 text-sm font-medium select-none">
                            Reset to Defaults
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Global variables to store trash data
        let trashData = {
            summary: {
                experiences: 0,
                educations: 0,
                certificates: 0,
                total: 0
            },
            experiences: [],
            educations: [],
            certificates: []
        };

        // Track current active tab in modal
        let currentActiveTab = 'experiences';

        // Load trash data on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadTrashData();
        });

        // Function to load trash data from backend
        async function loadTrashData() {
            try {
                // Get user role from meta tag
                const userRoleMeta = document.querySelector('meta[name="user-role"]');
                const userRole = userRoleMeta ? userRoleMeta.content : null;

                // Only proceed if user is freelancer
                if (userRole !== 'freelancer') {
                    console.log('User is not a freelancer, skipping trash data fetch');
                    return;
                }

                const response = await fetch('/settings/trash-data', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Ensure all arrays exist before assigning
                    trashData = {
                        summary: data.data.summary || {
                            experiences: 0,
                            educations: 0,
                            certificates: 0,
                            total: 0
                        },
                        experiences: data.data.experiences || [],
                        educations: data.data.educations || [],
                        certificates: data.data.certificates || []
                    };
                    renderTrashSummary();
                } else {
                    showToast('Failed to load trash data: ' + data.message, 'error');
                }
            } catch (error) {
                console.error('Load trash data error:', error);
                showToast('Error loading trash data', 'error');
            }
        }

        // Initialize only if needed
        document.addEventListener('DOMContentLoaded', function() {
            loadTrashData();
        });

        // Render summary section
        function renderTrashSummary() {
            const summary = trashData.summary;
            const container = document.getElementById('trash-summary-container');

            // Ensure summary exists
            if (!summary || typeof summary !== 'object') {
                container.innerHTML = `
            <div class="text-center py-6">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <p class="text-gray-500 text-sm">Failed to load trash data</p>
                <button onclick="loadTrashData()" class="mt-2 text-blue-600 text-sm hover:text-blue-800">
                    Retry
                </button>
            </div>
        `;
                return;
            }

            if (summary.total > 0) {
                container.innerHTML = `
            <div class="grid grid-cols-3 gap-3 mb-4">
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <div class="text-lg font-semibold text-gray-900">${summary.experiences || 0}</div>
                    <div class="text-xs text-gray-600">Experiences</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <div class="text-lg font-semibold text-gray-900">${summary.educations || 0}</div>
                    <div class="text-xs text-gray-600">Education</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <div class="text-lg font-semibold text-gray-900">${summary.certificates || 0}</div>
                    <div class="text-xs text-gray-600">Certificates</div>
                </div>
            </div>
            <div class="text-sm text-gray-600 mb-3">
                You have ${summary.total} deleted item${summary.total > 1 ? 's' : ''} in trash
            </div>
            <div class="flex space-x-2 select-none">
                <button onclick="openTrashModal()"
                    class="flex-1 px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg text-sm font-medium transition duration-300">
                    Manage Items
                </button>
                <button onclick="emptyTrash()"
                    class="px-4 py-2 bg-red-50 text-red-700 hover:bg-red-100 rounded-lg text-sm font-medium transition duration-300">
                    Empty All
                </button>
            </div>
        `;
            } else {
                container.innerHTML = `
            <div class="text-center py-6">
                <p class="text-gray-500 text-sm">Trash is empty</p>
                <p class="text-gray-400 text-xs mt-1">Deleted items will appear here</p>
            </div>
        `;
            }
        }

        // Modal functions
        function openTrashModal() {
            const modal = document.getElementById('trashModal');
            const darkoverlay = document.getElementById('darkoverlay');
            modal.classList.remove('hidden');
            if (darkoverlay) {
                darkoverlay.classList.remove('hidden');
            }

            setTimeout(() => {
                modal.style.opacity = '1';
            }, 10);

            // Render modal content
            renderModalContent();
        }

        function closeTrashModal() {
            const modal = document.getElementById('trashModal');
            modal.style.opacity = '0';
            const darkoverlay = document.getElementById('darkoverlay');
            if (darkoverlay) {
                darkoverlay.classList.add('hidden');
            }

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Render modal content
        function renderModalContent() {
            if (!trashData) {
                console.error('trashData is not defined');
                return;
            }

            const summary = trashData.summary || {
                experiences: 0,
                educations: 0,
                certificates: 0,
                total: 0
            };

            // Render tabs
            const tabsContainer = document.getElementById('trash-modal-tabs');
            tabsContainer.innerHTML = `
        <button type="button" onclick="showTrashTab('experiences')" id="tab-experiences"
            class="tab-button pb-3 px-1 text-sm font-medium border-b-2 ${currentActiveTab === 'experiences' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'} hover:text-gray-700 whitespace-nowrap">
            Work Experience
            ${summary.experiences > 0 ? `
                                                                                                                                                                                                                        <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded-full">
                                                                                                                                                                                                                            ${summary.experiences}
                                                                                                                                                                                                                        </span>
                                                                                                                                                                                                                 ` : ''}
        </button>
        <button type="button" onclick="showTrashTab('educations')" id="tab-educations"
            class="tab-button pb-3 px-1 text-sm font-medium border-b-2 ${currentActiveTab === 'educations' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'} hover:text-gray-700 whitespace-nowrap">
            Education
            ${summary.educations > 0 ? `
                                                                                                                                                                                                                        <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded-full">
                                                                                                                                                                                                                            ${summary.educations}
                                                                                                                                                                                                                        </span>
                                                                                                                                                                                                                    ` : ''}
        </button>
        <button type="button" onclick="showTrashTab('certificates')" id="tab-certificates"
            class="tab-button pb-3 px-1 text-sm font-medium border-b-2 ${currentActiveTab === 'certificates' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'} hover:text-gray-700 whitespace-nowrap">
            Certifications
            ${summary.certificates > 0 ? `
                                                                                                                                                                                                                        <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded-full">
                                                                                                                                                                                                                            ${summary.certificates}
                                                                                                                                                                                                                        </span>
                                                                                                                                                                                                                    ` : ''}
        </button>
    `;

            // Render experiences tab content
            renderTrashTabContent('experiences');
            renderTrashTabContent('educations');
            renderTrashTabContent('certificates');

            // Update footer
            updateModalFooter();

            // Show/hide empty all button
            const emptyBtn = document.getElementById('empty-all-trash-btn');
            if (summary.total > 0) {
                emptyBtn.classList.remove('hidden');
            } else {
                emptyBtn.classList.add('hidden');
            }

            // Hide loading and show content
            const modalLoading = document.getElementById('modal-loading');
            if (modalLoading) {
                modalLoading.classList.add('hidden');
            }

            // Show the current active tab
            showTrashTab(currentActiveTab);
        }

        // Render individual tab content
        function renderTrashTabContent(tabType) {
            const tabElement = document.getElementById(`modal-${tabType}-trash`);
            const items = trashData[tabType] || [];

            if (items.length > 0) {
                let html = '';
                items.forEach(item => {
                    if (tabType === 'experiences') {
                        html += `
                    <div class="border border-gray-200 rounded-lg p-4 mb-3 hover:border-gray-300 transition-colors"
                        data-item-id="${item.id}" data-item-type="experience">
                        <div class="flex justify-between items-start">
                            <div class="flex-1 min-w-0 mr-4">
                                <h4 class="font-semibold text-gray-900 text-sm truncate">${item.job_title || 'No Title'}</h4>
                                <p class="text-gray-600 text-xs truncate">${item.company || 'No Company'}</p>
                                <p class="text-gray-500 text-xs mt-1">
                                    ${item.formatted_dates?.start || 'N/A'} - ${item.formatted_dates?.end || 'Present'}
                                </p>
                                <p class="text-red-500 text-xs mt-1">
                                    Deleted: ${item.deleted_at || 'Unknown'}
                                </p>
                            </div>
                            <div class="flex items-center space-x-2 min-w-[120px] select-none">
                                <button onclick="restoreItem('experience', ${item.id})"
                                    class="text-green-600 hover:text-green-800 text-xs p-2 hover:bg-green-50 rounded transition-colors flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                    </svg>
                                    Restore
                                </button>
                                <button onclick="permanentlyDelete('experience', ${item.id})"
                                    class="text-red-600 hover:text-red-800 text-xs p-2 hover:bg-red-50 rounded transition-colors flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete Forever
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                    } else if (tabType === 'educations') {
                        html += `
                    <div class="border border-gray-200 rounded-lg p-4 mb-3 hover:border-gray-300 transition-colors"
                        data-item-id="${item.id}" data-item-type="education">
                        <div class="flex justify-between items-start">
                            <div class="flex-1 min-w-0 mr-4">
                                <h4 class="font-semibold text-gray-900 text-sm truncate">${item.degree || 'No Degree'}</h4>
                                <p class="text-gray-600 text-xs truncate">${item.university || 'No University'}</p>
                                ${item.major ? `<p class="text-gray-500 text-xs">${item.major}</p>` : ''}
                                <p class="text-gray-500 text-xs mt-1">
                                    ${item.formatted_years?.start || 'N/A'} - ${item.formatted_years?.end || 'Present'}
                                </p>
                                <p class="text-red-500 text-xs mt-1">
                                    Deleted: ${item.deleted_at || 'Unknown'}
                                </p>
                            </div>
                            <div class="flex flex-col space-y-2 min-w-[120px] select-none">
                                <button onclick="restoreItem('education', ${item.id})"
                                    class="text-green-600 hover:text-green-800 text-xs p-2 hover:bg-green-50 rounded transition-colors flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                    </svg>
                                    Restore
                                </button>
                                <button onclick="permanentlyDelete('education', ${item.id})"
                                    class="text-red-600 hover:text-red-800 text-xs p-2 hover:bg-red-50 rounded transition-colors flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete Forever
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                    } else if (tabType === 'certificates') {
                        html += `
                    <div class="border border-gray-200 rounded-lg p-4 mb-3 hover:border-gray-300 transition-colors"
                        data-item-id="${item.id}" data-item-type="certificate">
                        <div class="flex justify-between items-start">
                            <div class="flex-1 min-w-0 mr-4">
                                <h4 class="font-semibold text-gray-900 text-sm truncate">${item.name || 'No Name'}</h4>
                                <p class="text-gray-600 text-xs truncate">${item.issuer || 'No Issuer'}</p>
                                <p class="text-gray-500 text-xs mt-1">
                                    Issued: ${item.formatted_dates?.issued || 'N/A'} | Expires: ${item.formatted_dates?.expires || 'No Expiry'}
                                </p>
                                <p class="text-red-500 text-xs mt-1">
                                    Deleted: ${item.deleted_at || 'Unknown'}
                                </p>
                            </div>
                            <div class="flex flex-col space-y-2 min-w-[120px] select-none">
                                <button onclick="restoreItem('certificate', ${item.id})"
                                    class="text-green-600 hover:text-green-800 text-xs p-2 hover:bg-green-50 rounded transition-colors flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                    </svg>
                                    Restore
                                </button>
                                <button onclick="permanentlyDelete('certificate', ${item.id})"
                                    class="text-red-600 hover:text-red-800 text-xs p-2 hover:bg-red-50 rounded transition-colors flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete Forever
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                    }
                });
                tabElement.innerHTML = html;
            } else {
                let emptyMessage = '';
                if (tabType === 'experiences') {
                    emptyMessage = 'No deleted experiences';
                } else if (tabType === 'educations') {
                    emptyMessage = 'No deleted education';
                } else if (tabType === 'certificates') {
                    emptyMessage = 'No deleted certificates';
                }

                tabElement.innerHTML = `
            <div class="text-center py-20">
                <p class="text-gray-500 text-sm">${emptyMessage}</p>
                <p class="text-gray-400 text-xs mt-1">Deleted ${tabType} will appear here</p>
            </div>
        `;
            }
        }

        // Update modal footer
        function updateModalFooter() {
            const summary = trashData.summary || {
                total: 0
            };
            document.getElementById('modal-footer-count').textContent =
                `${summary.total || 0} item${summary.total !== 1 ? 's' : ''} in trash`;
        }

        // Tab switching for modal
        function showTrashTab(tab) {
            currentActiveTab = tab;

            // Hide all tab contents
            document.querySelectorAll('[id^="modal-"][id$="-trash"]').forEach(el => {
                el.classList.add('hidden');
            });

            // Show selected tab content
            const selectedTab = document.getElementById(`modal-${tab}-trash`);
            if (selectedTab) {
                selectedTab.classList.remove('hidden');
            }

            // Update active tab styling
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-blue-500', 'text-blue-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });

            // Set active tab
            const activeTab = document.getElementById(`tab-${tab}`);
            if (activeTab) {
                activeTab.classList.remove('border-transparent', 'text-gray-500');
                activeTab.classList.add('border-blue-500', 'text-blue-600');
            }
        }

        // Action functions
        async function restoreItem(type, id) {
            if (!confirm('Are you sure you want to restore this item?')) {
                return;
            }

            try {
                const response = await fetch(`/settings/restore/${type}/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Remove item from trash data
                    removeItemFromTrashData(type, id);

                    // Re-render UI
                    renderTrashSummary();

                    // If modal is open, update it
                    const modal = document.getElementById('trashModal');
                    if (!modal.classList.contains('hidden')) {
                        // Re-render only the affected tab
                        renderTrashTabContent(type + 's'); // Add 's' to match array name
                        updateModalTabs();
                        updateModalFooter();

                        // Update empty all button visibility
                        const emptyBtn = document.getElementById('empty-all-trash-btn');
                        if (trashData.summary.total > 0) {
                            emptyBtn.classList.remove('hidden');
                        } else {
                            emptyBtn.classList.add('hidden');
                        }
                    }

                    showToast(data.message || 'Item restored successfully!', 'success');
                } else {
                    throw new Error(data.message || 'Failed to restore item');
                }
            } catch (error) {
                console.error('Restore error:', error);
                showToast('Error: ' + error.message, 'error');
            }
        }

        async function permanentlyDelete(type, id) {
            if (!confirm('Are you sure you want to permanently delete this item? This action cannot be undone.')) {
                return;
            }

            try {
                const response = await fetch(`/settings/delete-permanently/${type}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Remove item from trash data
                    removeItemFromTrashData(type, id);

                    // Re-render UI
                    renderTrashSummary();

                    // If modal is open, update it
                    const modal = document.getElementById('trashModal');
                    if (!modal.classList.contains('hidden')) {
                        // Re-render only the affected tab
                        renderTrashTabContent(type + 's'); // Add 's' to match array name
                        updateModalTabs();
                        updateModalFooter();

                        // Update empty all button visibility
                        const emptyBtn = document.getElementById('empty-all-trash-btn');
                        if (trashData.summary.total > 0) {
                            emptyBtn.classList.remove('hidden');
                        } else {
                            emptyBtn.classList.add('hidden');
                        }
                    }

                    showToast(data.message || 'Item permanently deleted!', 'success');
                } else {
                    throw new Error(data.message || 'Failed to delete item');
                }
            } catch (error) {
                console.error('Delete error:', error);
                showToast('Error: ' + error.message, 'error');
            }
        }

        async function emptyTrash() {
            if (!confirm(
                    'Are you sure you want to permanently delete ALL items in trash? This action cannot be undone.')) {
                return;
            }

            try {
                const response = await fetch('/settings/trash/empty', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Clear all trash data
                    trashData = {
                        summary: {
                            experiences: 0,
                            educations: 0,
                            certificates: 0,
                            total: 0
                        },
                        experiences: [],
                        educations: [],
                        certificates: []
                    };

                    // Re-render UI
                    renderTrashSummary();

                    // If modal is open, update it
                    const modal = document.getElementById('trashModal');
                    if (!modal.classList.contains('hidden')) {
                        // Re-render all tabs
                        renderTrashTabContent('experiences');
                        renderTrashTabContent('educations');
                        renderTrashTabContent('certificates');
                        updateModalTabs();
                        updateModalFooter();

                        // Hide empty all button
                        const emptyBtn = document.getElementById('empty-all-trash-btn');
                        emptyBtn.classList.add('hidden');
                    }

                    showToast(data.message || 'All trash emptied successfully!', 'success');
                } else {
                    throw new Error(data.message || 'Failed to empty trash');
                }
            } catch (error) {
                console.error('Empty trash error:', error);
                showToast('Error: ' + error.message, 'error');
            }
        }

        // Helper function to remove item from trash data
        function removeItemFromTrashData(type, id) {
            if (!trashData || typeof trashData !== 'object') {
                console.error('trashData is not defined or not an object');
                return;
            }

            const arrayName = type + 's'; // Convert 'experience' to 'experiences'

            // Ensure the array exists
            if (!trashData[arrayName] || !Array.isArray(trashData[arrayName])) {
                console.error(`trashData.${arrayName} is not an array`);
                trashData[arrayName] = [];
            }

            // Remove from array
            const index = trashData[arrayName].findIndex(item => item && item.id === id);
            if (index !== -1) {
                trashData[arrayName].splice(index, 1);
            }

            // Ensure summary exists
            if (!trashData.summary || typeof trashData.summary !== 'object') {
                trashData.summary = {
                    experiences: 0,
                    educations: 0,
                    certificates: 0,
                    total: 0
                };
            }

            // Update summary counts
            trashData.summary[arrayName] = trashData[arrayName].length;
            trashData.summary.total =
                (trashData.summary.experiences || 0) +
                (trashData.summary.educations || 0) +
                (trashData.summary.certificates || 0);
        }

        // Update modal tabs (just the count badges)
        function updateModalTabs() {
            const summary = trashData.summary || {
                experiences: 0,
                educations: 0,
                certificates: 0,
                total: 0
            };

            // Update experiences tab
            const expTab = document.getElementById('tab-experiences');
            if (expTab) {
                const span = expTab.querySelector('span');
                if (span) {
                    if (summary.experiences > 0) {
                        span.textContent = summary.experiences;
                        span.classList.remove('hidden');
                    } else {
                        span.remove();
                    }
                } else if (summary.experiences > 0) {
                    expTab.innerHTML =
                        `Work Experience <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded-full">${summary.experiences}</span>`;
                }
            }

            // Update educations tab
            const eduTab = document.getElementById('tab-educations');
            if (eduTab) {
                const span = eduTab.querySelector('span');
                if (span) {
                    if (summary.educations > 0) {
                        span.textContent = summary.educations;
                        span.classList.remove('hidden');
                    } else {
                        span.remove();
                    }
                } else if (summary.educations > 0) {
                    eduTab.innerHTML =
                        `Education <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded-full">${summary.educations}</span>`;
                }
            }

            // Update certificates tab
            const certTab = document.getElementById('tab-certificates');
            if (certTab) {
                const span = certTab.querySelector('span');
                if (span) {
                    if (summary.certificates > 0) {
                        span.textContent = summary.certificates;
                        span.classList.remove('hidden');
                    } else {
                        span.remove();
                    }
                } else if (summary.certificates > 0) {
                    certTab.innerHTML =
                        `Certifications <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded-full">${summary.certificates}</span>`;
                }
            }
        }

        // Close modal on outside click
        const trashModal = document.getElementById('trashModal');
        if (trashModal) {
            trashModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeTrashModal();
                }
            });
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('trashModal');
            if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                closeTrashModal();
            }
        });

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
                `custom-toast fixed bottom-4 right-3 px-4 py-3 rounded-md shadow-md text-white font-medium transition-all duration-300 z-50 ${type === 'success' ? 'bg-green-400' : type === 'error' ? 'bg-red-400' : 'bg-blue-400'}`;
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
@endpush
