@extends('layouts.app')

@section('title', __('settings.meta.title'))

@auth
    <meta name="user-role" content="{{ Auth::user()->role }}">
@endauth

@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('settings.header.title') }}</h1>
            <p class="text-gray-600 mt-1">
                {{ __('settings.header.subtitle') }}
            </p>
        </div>
        <div class="text-sm text-gray-500">
            {{ now()->locale(app()->getLocale())->translatedFormat('l, F j, Y') }}
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
                <h2 class="text-lg font-bold text-gray-900 mb-6">{{ __('settings.application.title') }}</h2>

                <div>
                    <div class="space-y-6">
                        <!-- Language & Region -->
                        <div class="space-y-4">
                            <h3 class="font-semibold text-gray-900">{{ __('settings.application.language_region') }}</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-2">{{ __('settings.application.interface_language') }}</label>
                                    <select name="language"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-300 setting-select">
                                        <option value="en"
                                            {{ (auth()->user()->settings->language ?? 'en') == 'en' ? 'selected' : '' }}>
                                            {{ __('settings.application.language_english') }}</option>
                                        <option value="my"
                                            {{ (auth()->user()->settings->language ?? 'en') == 'my' ? 'selected' : '' }}>
                                            {{ __('settings.application.language_burmese') }}</option>
                                    </select>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-2">{{ __('settings.application.time_zone') }}</label>
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
                        <div id="currency-settings" class="pt-6 border-t border-gray-200">
                            <h3 class="font-semibold text-gray-900 mb-4">{{ __('settings.application.currency_settings') }}
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-2">{{ __('settings.application.default_currency') }}</label>
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
                            <h3 class="font-semibold text-gray-900 mb-4">
                                {{ __('settings.application.display_preferences') }}</h3>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ __('settings.application.dark_mode') }}
                                        </h4>
                                        <p class="text-gray-500 text-sm">{{ __('settings.application.dark_mode_help') }}
                                        </p>
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
                <h2 class="text-lg font-bold text-gray-900 mb-6">{{ __('settings.notifications.title') }}</h2>

                <div class="space-y-6">
                    <!-- Email Notifications -->
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-900">{{ __('settings.notifications.email_title') }}</h3>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium text-gray-900">
                                        {{ __('settings.notifications.project_updates') }}</h4>
                                    <p class="text-gray-500 text-sm">
                                        {{ __('settings.notifications.project_updates_help') }}</p>
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
                                    <h4 class="font-medium text-gray-900">{{ __('settings.notifications.new_messages') }}
                                    </h4>
                                    <p class="text-gray-500 text-sm">{{ __('settings.notifications.new_messages_help') }}
                                    </p>
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
                                    <h4 class="font-medium text-gray-900">
                                        {{ __('settings.notifications.payment_notifications') }}</h4>
                                    <p class="text-gray-500 text-sm">
                                        {{ __('settings.notifications.payment_notifications_help') }}</p>
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
                                    <h4 class="font-medium text-gray-900">
                                        {{ __('settings.notifications.marketing_emails') }}</h4>
                                    <p class="text-gray-500 text-sm">
                                        {{ __('settings.notifications.marketing_emails_help') }}</p>
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
                <h2 class="text-lg font-bold text-gray-900 mb-6">{{ __('settings.privacy.title') }}</h2>

                <div class="space-y-6">
                    <!-- Account Visibility -->
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-900">{{ __('settings.privacy.account_visibility') }}</h3>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ __('settings.privacy.profile_visibility') }}
                                    </h4>
                                    <p class="text-gray-500 text-sm">{{ __('settings.privacy.profile_visibility_help') }}
                                    </p>
                                </div>
                                <select name="profile_visibility"
                                    class="setting-select px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                                    <option value="public"
                                        {{ (auth()->user()->settings->profile_visibility ?? 'public') == 'public' ? 'selected' : '' }}>
                                        {{ __('settings.privacy.public') }}</option>
                                    <option value="clients_only"
                                        {{ (auth()->user()->settings->profile_visibility ?? 'public') == 'clients_only' ? 'selected' : '' }}>
                                        {{ __('settings.privacy.clients_only') }}</option>
                                    <option value="freelancers_only"
                                        {{ (auth()->user()->settings->profile_visibility ?? 'public') == 'freelancers_only' ? 'selected' : '' }}>
                                        {{ __('settings.privacy.freelancers_only') }}</option>
                                    <option value="private"
                                        {{ (auth()->user()->settings->profile_visibility ?? 'public') == 'private' ? 'selected' : '' }}>
                                        {{ __('settings.privacy.private') }}</option>
                                </select>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ __('settings.privacy.show_online_status') }}
                                    </h4>
                                    <p class="text-gray-500 text-sm">{{ __('settings.privacy.show_online_status_help') }}
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
                <h2 class="text-lg font-bold text-gray-900 mb-6">{{ __('settings.account.title') }}</h2>

                <div class="space-y-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-700">{{ __('settings.account.account_type') }}</span>
                        <span class="font-medium">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-700">{{ __('settings.account.member_since') }}</span>
                        <span class="font-medium">
                            {{ auth()->user()->created_at->locale(app()->getLocale())->translatedFormat('F j, Y') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-700">{{ __('settings.account.account_status') }}</span>
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">
                            {{ ucfirst(auth()->user()->status) }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-700">{{ __('settings.account.email_verification') }}</span>
                        @if (auth()->user()->email_verified_at)
                            <span class="text-green-600 font-medium">&#10003; {{ __('settings.account.verified') }}</span>
                        @else
                            <button type="button" onclick="verifyEmail()"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                {{ __('settings.account.verify_now') }}
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
                            <h3 class="font-medium text-gray-900">{{ __('settings.account.secure_title') }}</h3>
                            <p class="text-gray-500 text-sm mt-1">{{ __('settings.account.secure_help') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trash / Archive Section -->
            @if (auth()->user()->role === 'freelancer')
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="mb-6">
                        <h2 class="text-lg font-bold text-gray-900">{{ __('settings.trash.title') }}</h2>
                        <p class="text-gray-600 text-sm mt-1">{{ __('settings.trash.manage_deleted') }}</p>
                    </div>

                    <!-- Summary Stats - Initially loading -->
                    <div id="trash-summary-container">
                        <div class="grid grid-cols-3 gap-3 mb-4">
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <div class="text-lg font-semibold text-gray-900">
                                    <div class="animate-pulse bg-gray-200 h-6 w-8 mx-auto rounded"></div>
                                </div>
                                <div class="text-xs text-gray-600">{{ __('settings.trash.experiences') }}</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <div class="text-lg font-semibold text-gray-900">
                                    <div class="animate-pulse bg-gray-200 h-6 w-8 mx-auto rounded"></div>
                                </div>
                                <div class="text-xs text-gray-600">{{ __('settings.trash.education') }}</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <div class="text-lg font-semibold text-gray-900">
                                    <div class="animate-pulse bg-gray-200 h-6 w-8 mx-auto rounded"></div>
                                </div>
                                <div class="text-xs text-gray-600">{{ __('settings.trash.certificates') }}</div>
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
                <div id="trash-modal-backdrop"
                    class="fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300 ease-out opacity-0"></div>
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div id="trash-modal-content"
                        class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all duration-300 ease-out sm:my-8 sm:w-full sm:max-w-4xl w-full max-h-[90vh] flex flex-col translate-y-4 opacity-0">
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between p-6">
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">{{ __('settings.trash.title') }}</h2>
                                <p class="text-gray-600 text-sm mt-1">{{ __('settings.trash.manage_deleted') }}</p>
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
                                    <p class="text-gray-500 text-sm">{{ __('settings.trash.loading') }}</p>
                                </div>

                                <!-- Tab contents will be populated by JavaScript -->
                                <div id="modal-experiences-trash" class="h-full overflow-y-auto hidden"></div>
                                <div id="modal-educations-trash" class="h-full overflow-hidden hidden"></div>
                                <div id="modal-certificates-trash" class="h-full overflow-hidden hidden"></div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div
                            class="p-6 border-t border-gray-200 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                            <div class="text-sm text-gray-600" id="modal-footer-count">
                                {{ __('settings.trash.loading') }}
                            </div>
                            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto select-none">
                                <button onclick="closeTrashModal()"
                                    class="inline-flex w-full sm:w-auto items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 text-sm font-medium text-center leading-tight">
                                    {{ __('settings.trash.close') }}
                                </button>
                                <button id="empty-all-trash-btn" onclick="openEmptyTrashModal()"
                                    class="inline-flex w-full sm:w-auto items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300 text-sm font-medium text-center leading-tight hidden">
                                    {{ __('settings.trash.empty_all') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty Trash Confirmation Modal -->
            <div id="emptyTrashModal" class="fixed inset-0 z-[70] hidden transition-opacity duration-300">
                <div id="empty-trash-backdrop"
                    class="fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300 ease-out opacity-0">
                </div>
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div id="empty-trash-content"
                        class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all duration-300 ease-out sm:my-8 sm:w-full sm:max-w-md w-full translate-y-4 opacity-0">
                        <div class="flex items-start justify-between px-6 pt-6 pb-4 border-b border-gray-200">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ __('settings.trash.empty_title') }}</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ __('settings.trash.cannot_undo') }}</p>
                            </div>
                            <button type="button" onclick="closeEmptyTrashModal()"
                                class="text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100 transition duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="px-6 py-4">
                            <p class="text-sm text-gray-700">
                                {{ __('settings.trash.empty_confirm') }}
                            </p>
                        </div>
                        <div
                            class="px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row sm:justify-end gap-3 select-none">
                            <button type="button" onclick="closeEmptyTrashModal()"
                                class="inline-flex w-full sm:w-auto items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 text-sm font-medium">
                                {{ __('settings.trash.cancel') }}
                            </button>
                            <button type="button" onclick="confirmEmptyTrash()"
                                class="inline-flex w-full sm:w-auto items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300 text-sm font-medium">
                                {{ __('settings.trash.yes_empty_all') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-white rounded-xl shadow-sm border border-red-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">{{ __('settings.danger.title') }}</h2>

                <div class="space-y-4">
                    <div>
                        <h3 class="font-medium text-gray-900 mb-2">{{ __('settings.danger.deactivate_title') }}</h3>
                        <p class="text-gray-500 text-sm mb-3">{{ __('settings.danger.deactivate_help') }}</p>
                        <button onclick="deactivateAccount()"
                            class="w-full px-4 py-2 border border-yellow-300 text-yellow-700 rounded-lg hover:bg-yellow-50 transition duration-300 text-sm font-medium select-none">
                            {{ __('settings.danger.deactivate_button') }}
                        </button>
                    </div>

                    <div class="pt-4 border-t border-red-100">
                        <h3 class="font-medium text-gray-900 mb-2">{{ __('settings.danger.delete_title') }}</h3>
                        <p class="text-gray-500 text-sm mb-3">{{ __('settings.danger.delete_help') }}
                        </p>
                        @if (auth()->user()->role === 'client')
                            <button onclick="deleteAccount()"
                                class="w-full px-4 py-2 bg-red-50 border border-red-200 text-red-600 rounded-lg hover:bg-red-100 transition duration-300 text-sm font-medium select-none">
                                {{ __('settings.danger.delete_button') }}
                            </button>
                        @elseif (auth()->user()->role === 'freelancer')
                            <button type="button" onclick="openFreelancerDeleteModal()"
                                class="w-full px-4 py-2 bg-red-50 border border-red-200 text-red-600 rounded-lg hover:bg-red-100 transition duration-300 text-sm font-medium select-none">
                                {{ __('settings.danger.delete_button') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            @if (auth()->user()->role === 'freelancer')
                <!-- Freelancer Delete Account Confirmation Modal -->
                <div id="freelancerDeleteModal" class="fixed inset-0 z-[70] hidden transition-opacity duration-300">
                    <div id="freelancer-delete-backdrop"
                        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300 ease-out opacity-0">
                    </div>
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div id="freelancer-delete-content"
                            class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all duration-300 ease-out sm:my-8 sm:w-full sm:max-w-md w-full translate-y-4 opacity-0">
                            <div class="flex items-start justify-between px-6 pt-6 pb-4 border-b border-gray-200">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">
                                        {{ __('settings.danger.confirm_delete_title') }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ __('settings.danger.confirm_delete_help') }}
                                    </p>
                                </div>
                                <button type="button" onclick="closeFreelancerDeleteModal()"
                                    class="text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100 transition duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="px-6 py-4">
                                <p class="text-sm text-gray-700">
                                    {{ __('settings.danger.confirm_delete_body') }}
                                </p>
                            </div>
                            <div
                                class="px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row sm:justify-end gap-3 select-none">
                                <button type="button" onclick="closeFreelancerDeleteModal()"
                                    class="inline-flex w-full sm:w-auto items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 text-sm font-medium">
                                    {{ __('settings.trash.cancel') }}
                                </button>
                                <form class="w-full sm:w-auto mb-0"
                                    action="{{ route('freelancer-profile.destroy', auth()->user()->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex w-full sm:w-auto items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300 text-sm font-medium">
                                        {{ __('settings.danger.yes_delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Freelancer Reset Defaults Confirmation Modal -->
                <div id="freelancerResetModal" class="fixed inset-0 z-[70] hidden transition-opacity duration-300">
                    <div id="freelancer-reset-backdrop"
                        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300 ease-out opacity-0">
                    </div>
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div id="freelancer-reset-content"
                            class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all duration-300 ease-out sm:my-8 sm:w-full sm:max-w-md w-full translate-y-4 opacity-0">
                            <div class="flex items-start justify-between px-6 pt-6 pb-4 border-b border-gray-200">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ __('settings.danger.reset_title') }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ __('settings.danger.reset_help') }}</p>
                                </div>
                                <button type="button" onclick="closeFreelancerResetModal()"
                                    class="text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100 transition duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="px-6 py-4">
                                <p class="text-sm text-gray-700">
                                    {{ __('settings.danger.reset_body') }}
                                </p>
                            </div>
                            <div
                                class="px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row sm:justify-end gap-3 select-none">
                                <button type="button" onclick="closeFreelancerResetModal()"
                                    class="inline-flex w-full sm:w-auto items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 text-sm font-medium">
                                    {{ __('settings.trash.cancel') }}
                                </button>
                                <button type="button" onclick="confirmFreelancerResetDefaults()"
                                    class="inline-flex w-full sm:w-auto items-center justify-center px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black transition duration-300 text-sm font-medium">
                                    {{ __('settings.danger.yes_reset') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Save All Changes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">{{ __('settings.save.panel_title') }}</h2>

                <div class="space-y-4">
                    <div class="flex flex-col gap-3">
                        <div class="min-w-0">
                            <h3 class="font-medium text-gray-900">{{ __('settings.save.apply_title') }}</h3>
                            <p class="text-gray-500 text-sm mt-1">{{ __('settings.save.apply_help') }}</p>
                        </div>
                        <button id="saveAllSettings" type="button"
                            class="inline-flex w-full items-center justify-center px-6 py-2 bg-gray-800 text-white rounded-lg hover:bg-black transition duration-300 font-medium select-none text-center leading-tight whitespace-normal">
                            <div id="submitSpinner"
                                class="hidden w-5 h-5 border-t-2 border-white rounded-full animate-spin mr-2">
                            </div>
                            <span id="submitText">{{ __('settings.save.button') }}</span>
                        </button>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <button
                            onclick="{{ auth()->user()->role === 'freelancer' ? 'openFreelancerResetModal()' : 'resetToDefaults()' }}"
                            type="button"
                            class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 text-sm font-medium select-none">
                            {{ __('settings.save.reset_button') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const currentInterfaceLanguage = String(@json(auth()->user()->settings->language ?? 'en')).toLowerCase();
        const trashI18n = {
            workExperience: @json(__('settings.trash.work_experience')),
            experiences: @json(__('settings.trash.experiences')),
            education: @json(__('settings.trash.education')),
            certificates: @json(__('settings.trash.certificates')),
            loadFailed: @json(__('settings.trash.load_failed')),
            loadError: @json(__('settings.trash.load_error')),
            retry: @json(__('settings.trash.retry')),
            summaryOne: @json(__('settings.trash.summary_one', ['count' => ':count'])),
            summaryMany: @json(__('settings.trash.summary_many', ['count' => ':count'])),
            manageItems: @json(__('settings.trash.manage_items')),
            emptyAllShort: @json(__('settings.trash.empty_all_short')),
            emptyStateTitle: @json(__('settings.trash.empty_state_title')),
            emptyStateHelp: @json(__('settings.trash.empty_state_help')),
            restore: @json(__('settings.trash.restore')),
            deleteForever: @json(__('settings.trash.delete_forever')),
            noDeletedExperiences: @json(__('settings.trash.no_deleted_experiences')),
            noDeletedEducation: @json(__('settings.trash.no_deleted_education')),
            noDeletedCertificates: @json(__('settings.trash.no_deleted_certificates')),
            deletedExperiencesHelp: @json(__('settings.trash.deleted_experiences_help')),
            deletedEducationHelp: @json(__('settings.trash.deleted_education_help')),
            deletedCertificatesHelp: @json(__('settings.trash.deleted_certificates_help')),
            footerCountOne: @json(__('settings.trash.footer_count_one', ['count' => ':count'])),
            footerCountMany: @json(__('settings.trash.footer_count_many', ['count' => ':count'])),
            restoreConfirm: @json(__('settings.trash.restore_confirm')),
            deleteConfirm: @json(__('settings.trash.delete_confirm')),
            restoredSuccess: @json(__('settings.trash.restored_success')),
            restoreFailed: @json(__('settings.trash.restore_failed')),
            deletedSuccess: @json(__('settings.trash.deleted_success')),
            deleteFailed: @json(__('settings.trash.delete_failed')),
            emptySuccess: @json(__('settings.trash.empty_success')),
            emptyFailed: @json(__('settings.trash.empty_failed')),
            errorPrefix: @json(__('settings.trash.error_prefix')),
            noTitle: @json(__('settings.trash.no_title')),
            noCompany: @json(__('settings.trash.no_company')),
            noDegree: @json(__('settings.trash.no_degree')),
            noUniversity: @json(__('settings.trash.no_university')),
            noName: @json(__('settings.trash.no_name')),
            noIssuer: @json(__('settings.trash.no_issuer')),
            notAvailable: @json(__('settings.trash.not_available')),
            present: @json(__('settings.trash.present')),
            noExpiry: @json(__('settings.trash.no_expiry')),
            unknown: @json(__('settings.trash.unknown')),
            deletedLabel: @json(__('settings.trash.deleted_label')),
            issuedLabel: @json(__('settings.trash.issued_label')),
            expiresLabel: @json(__('settings.trash.expires_label')),
        };

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

        function renderTabButtonLabel(label, count) {
            if (count > 0) {
                return `${label} <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded-full">${count}</span>`;
            }

            return label;
        }

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
                    showToast(`${trashI18n.loadFailed}: ${data.message}`, 'error');
                }
            } catch (error) {
                console.error('Load trash data error:', error);
                showToast(trashI18n.loadError, 'error');
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
                <p class="text-gray-500 text-sm">${trashI18n.loadFailed}</p>
                <button onclick="loadTrashData()" class="mt-2 text-blue-600 text-sm hover:text-blue-800">
                    ${trashI18n.retry}
                </button>
            </div>
        `;
                return;
            }

            if (summary.total > 0) {
                const summaryTotal = summary.total || 0;
                const summaryTemplate = summaryTotal === 1 ? trashI18n.summaryOne : trashI18n.summaryMany;
                const summaryText = summaryTemplate.replace(':count', String(summaryTotal));

                container.innerHTML = `
            <div class="grid grid-cols-3 gap-3 mb-4">
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <div class="text-lg font-semibold text-gray-900">${summary.experiences || 0}</div>
                    <div class="text-xs text-gray-600">${trashI18n.experiences}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <div class="text-lg font-semibold text-gray-900">${summary.educations || 0}</div>
                    <div class="text-xs text-gray-600">${trashI18n.education}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <div class="text-lg font-semibold text-gray-900">${summary.certificates || 0}</div>
                    <div class="text-xs text-gray-600">${trashI18n.certificates}</div>
                </div>
            </div>
            <div class="text-sm text-gray-600 mb-3">
                ${summaryText}
            </div>
            <div class="flex space-x-2 select-none">
                <button onclick="openTrashModal()"
                    class="flex-1 px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg text-sm font-medium transition duration-300">
                    ${trashI18n.manageItems}
                </button>
                <button onclick="openEmptyTrashModal()"
                    class="px-4 py-2 bg-red-50 text-red-700 hover:bg-red-100 rounded-lg text-sm font-medium transition duration-300">
                    ${trashI18n.emptyAllShort}
                </button>
            </div>
        `;
            } else {
                container.innerHTML = `
            <div class="text-center py-6">
                <p class="text-gray-500 text-sm">${trashI18n.emptyStateTitle}</p>
                <p class="text-gray-400 text-xs mt-1">${trashI18n.emptyStateHelp}</p>
            </div>
        `;
            }
        }

        // Modal functions
        const trashModalElement = document.getElementById('trashModal');
        const trashModalBackdrop = document.getElementById('trash-modal-backdrop');
        const trashModalContent = document.getElementById('trash-modal-content');
        const freelancerDeleteModalElement = document.getElementById('freelancerDeleteModal');
        const freelancerDeleteModalBackdrop = document.getElementById('freelancer-delete-backdrop');
        const freelancerDeleteModalContent = document.getElementById('freelancer-delete-content');
        const freelancerResetModalElement = document.getElementById('freelancerResetModal');
        const freelancerResetModalBackdrop = document.getElementById('freelancer-reset-backdrop');
        const freelancerResetModalContent = document.getElementById('freelancer-reset-content');
        const emptyTrashModalElement = document.getElementById('emptyTrashModal');
        const emptyTrashModalBackdrop = document.getElementById('empty-trash-backdrop');
        const emptyTrashModalContent = document.getElementById('empty-trash-content');

        function openTrashModal() {
            if (!trashModalElement || !trashModalBackdrop || !trashModalContent) {
                return;
            }

            trashModalElement.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            void trashModalElement.offsetWidth;

            setTimeout(() => {
                trashModalBackdrop.classList.remove('opacity-0');
                trashModalBackdrop.classList.add('opacity-100');
            }, 10);

            setTimeout(() => {
                trashModalContent.classList.remove('translate-y-4', 'opacity-0');
                trashModalContent.classList.add('translate-y-0', 'opacity-100');
            }, 10);

            // Render modal content
            renderModalContent();
        }

        function closeTrashModal() {
            if (!trashModalElement || !trashModalBackdrop || !trashModalContent) {
                return;
            }

            trashModalContent.classList.remove('translate-y-0', 'opacity-100');
            trashModalContent.classList.add('translate-y-4', 'opacity-0');

            trashModalBackdrop.classList.remove('opacity-100');
            trashModalBackdrop.classList.add('opacity-0');

            setTimeout(() => {
                trashModalElement.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        function openFreelancerDeleteModal() {
            if (!freelancerDeleteModalElement || !freelancerDeleteModalBackdrop || !freelancerDeleteModalContent) {
                return;
            }

            freelancerDeleteModalElement.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            void freelancerDeleteModalElement.offsetWidth;

            setTimeout(() => {
                freelancerDeleteModalBackdrop.classList.remove('opacity-0');
                freelancerDeleteModalBackdrop.classList.add('opacity-100');
            }, 10);

            setTimeout(() => {
                freelancerDeleteModalContent.classList.remove('translate-y-4', 'opacity-0');
                freelancerDeleteModalContent.classList.add('translate-y-0', 'opacity-100');
            }, 10);
        }

        function closeFreelancerDeleteModal() {
            if (!freelancerDeleteModalElement || !freelancerDeleteModalBackdrop || !freelancerDeleteModalContent) {
                return;
            }

            freelancerDeleteModalContent.classList.remove('translate-y-0', 'opacity-100');
            freelancerDeleteModalContent.classList.add('translate-y-4', 'opacity-0');

            freelancerDeleteModalBackdrop.classList.remove('opacity-100');
            freelancerDeleteModalBackdrop.classList.add('opacity-0');

            setTimeout(() => {
                freelancerDeleteModalElement.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        function openFreelancerResetModal() {
            if (!freelancerResetModalElement || !freelancerResetModalBackdrop || !freelancerResetModalContent) {
                return;
            }

            freelancerResetModalElement.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            void freelancerResetModalElement.offsetWidth;

            setTimeout(() => {
                freelancerResetModalBackdrop.classList.remove('opacity-0');
                freelancerResetModalBackdrop.classList.add('opacity-100');
            }, 10);

            setTimeout(() => {
                freelancerResetModalContent.classList.remove('translate-y-4', 'opacity-0');
                freelancerResetModalContent.classList.add('translate-y-0', 'opacity-100');
            }, 10);
        }

        function closeFreelancerResetModal() {
            if (!freelancerResetModalElement || !freelancerResetModalBackdrop || !freelancerResetModalContent) {
                return;
            }

            freelancerResetModalContent.classList.remove('translate-y-0', 'opacity-100');
            freelancerResetModalContent.classList.add('translate-y-4', 'opacity-0');

            freelancerResetModalBackdrop.classList.remove('opacity-100');
            freelancerResetModalBackdrop.classList.add('opacity-0');

            setTimeout(() => {
                freelancerResetModalElement.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        function confirmFreelancerResetDefaults() {
            closeFreelancerResetModal();
            performResetToDefaults();
        }

        function openEmptyTrashModal() {
            if (!emptyTrashModalElement || !emptyTrashModalBackdrop || !emptyTrashModalContent) {
                return;
            }

            emptyTrashModalElement.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            void emptyTrashModalElement.offsetWidth;

            setTimeout(() => {
                emptyTrashModalBackdrop.classList.remove('opacity-0');
                emptyTrashModalBackdrop.classList.add('opacity-100');
            }, 10);

            setTimeout(() => {
                emptyTrashModalContent.classList.remove('translate-y-4', 'opacity-0');
                emptyTrashModalContent.classList.add('translate-y-0', 'opacity-100');
            }, 10);
        }

        function closeEmptyTrashModal() {
            if (!emptyTrashModalElement || !emptyTrashModalBackdrop || !emptyTrashModalContent) {
                return;
            }

            emptyTrashModalContent.classList.remove('translate-y-0', 'opacity-100');
            emptyTrashModalContent.classList.add('translate-y-4', 'opacity-0');

            emptyTrashModalBackdrop.classList.remove('opacity-100');
            emptyTrashModalBackdrop.classList.add('opacity-0');

            setTimeout(() => {
                emptyTrashModalElement.classList.add('hidden');
                const isTrashOpen = trashModalElement && !trashModalElement.classList.contains('hidden');
                const isDeleteOpen = freelancerDeleteModalElement && !freelancerDeleteModalElement.classList
                    .contains('hidden');
                const isResetOpen = freelancerResetModalElement && !freelancerResetModalElement.classList
                    .contains('hidden');
                if (!isTrashOpen && !isDeleteOpen && !isResetOpen) {
                    document.body.style.overflow = 'auto';
                }
            }, 300);
        }

        function confirmEmptyTrash() {
            closeEmptyTrashModal();
            emptyTrash();
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
            ${renderTabButtonLabel(trashI18n.workExperience, summary.experiences)}
        </button>
        <button type="button" onclick="showTrashTab('educations')" id="tab-educations"
            class="tab-button pb-3 px-1 text-sm font-medium border-b-2 ${currentActiveTab === 'educations' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'} hover:text-gray-700 whitespace-nowrap">
            ${renderTabButtonLabel(trashI18n.education, summary.educations)}
        </button>
        <button type="button" onclick="showTrashTab('certificates')" id="tab-certificates"
            class="tab-button pb-3 px-1 text-sm font-medium border-b-2 ${currentActiveTab === 'certificates' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'} hover:text-gray-700 whitespace-nowrap">
            ${renderTabButtonLabel(trashI18n.certificates, summary.certificates)}
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
                                <h4 class="font-semibold text-gray-900 text-sm truncate">${item.job_title || trashI18n.noTitle}</h4>
                                <p class="text-gray-600 text-xs truncate">${item.company || trashI18n.noCompany}</p>
                                <p class="text-gray-500 text-xs mt-1">
                                    ${item.formatted_dates?.start || trashI18n.notAvailable} - ${item.formatted_dates?.end || trashI18n.present}
                                </p>
                                <p class="text-red-500 text-xs mt-1">
                                    ${trashI18n.deletedLabel}: ${item.deleted_at || trashI18n.unknown}
                                </p>
                            </div>
                            <div class="flex items-center space-x-2 min-w-[120px] select-none">
                                <button onclick="restoreItem('experience', ${item.id})"
                                    class="text-green-600 hover:text-green-800 text-xs p-2 hover:bg-green-50 rounded transition-colors flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                    </svg>
                                    ${trashI18n.restore}
                                </button>
                                <button onclick="permanentlyDelete('experience', ${item.id})"
                                    class="text-red-600 hover:text-red-800 text-xs p-2 hover:bg-red-50 rounded transition-colors flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    ${trashI18n.deleteForever}
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
                                <h4 class="font-semibold text-gray-900 text-sm truncate">${item.degree || trashI18n.noDegree}</h4>
                                <p class="text-gray-600 text-xs truncate">${item.university || trashI18n.noUniversity}</p>
                                ${item.major ? `<p class="text-gray-500 text-xs">${item.major}</p>` : ''}
                                <p class="text-gray-500 text-xs mt-1">
                                    ${item.formatted_years?.start || trashI18n.notAvailable} - ${item.formatted_years?.end || trashI18n.present}
                                </p>
                                <p class="text-red-500 text-xs mt-1">
                                    ${trashI18n.deletedLabel}: ${item.deleted_at || trashI18n.unknown}
                                </p>
                            </div>
                            <div class="flex flex-col space-y-2 min-w-[120px] select-none">
                                <button onclick="restoreItem('education', ${item.id})"
                                    class="text-green-600 hover:text-green-800 text-xs p-2 hover:bg-green-50 rounded transition-colors flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                    </svg>
                                    ${trashI18n.restore}
                                </button>
                                <button onclick="permanentlyDelete('education', ${item.id})"
                                    class="text-red-600 hover:text-red-800 text-xs p-2 hover:bg-red-50 rounded transition-colors flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    ${trashI18n.deleteForever}
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
                                <h4 class="font-semibold text-gray-900 text-sm truncate">${item.name || trashI18n.noName}</h4>
                                <p class="text-gray-600 text-xs truncate">${item.issuer || trashI18n.noIssuer}</p>
                                <p class="text-gray-500 text-xs mt-1">
                                    ${trashI18n.issuedLabel}: ${item.formatted_dates?.issued || trashI18n.notAvailable} | ${trashI18n.expiresLabel}: ${item.formatted_dates?.expires || trashI18n.noExpiry}
                                </p>
                                <p class="text-red-500 text-xs mt-1">
                                    ${trashI18n.deletedLabel}: ${item.deleted_at || trashI18n.unknown}
                                </p>
                            </div>
                            <div class="flex flex-col space-y-2 min-w-[120px] select-none">
                                <button onclick="restoreItem('certificate', ${item.id})"
                                    class="text-green-600 hover:text-green-800 text-xs p-2 hover:bg-green-50 rounded transition-colors flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                    </svg>
                                    ${trashI18n.restore}
                                </button>
                                <button onclick="permanentlyDelete('certificate', ${item.id})"
                                    class="text-red-600 hover:text-red-800 text-xs p-2 hover:bg-red-50 rounded transition-colors flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    ${trashI18n.deleteForever}
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                    }
                });
                tabElement.innerHTML = html;
            } else {
                const emptyMessageMap = {
                    experiences: trashI18n.noDeletedExperiences,
                    educations: trashI18n.noDeletedEducation,
                    certificates: trashI18n.noDeletedCertificates
                };
                const emptyHelpMap = {
                    experiences: trashI18n.deletedExperiencesHelp,
                    educations: trashI18n.deletedEducationHelp,
                    certificates: trashI18n.deletedCertificatesHelp
                };
                const emptyMessage = emptyMessageMap[tabType] || trashI18n.emptyStateTitle;
                const emptyHelp = emptyHelpMap[tabType] || trashI18n.emptyStateHelp;

                tabElement.innerHTML = `
            <div class="text-center py-20">
                <p class="text-gray-500 text-sm">${emptyMessage}</p>
                <p class="text-gray-400 text-xs mt-1">${emptyHelp}</p>
            </div>
        `;
            }
        }

        // Update modal footer
        function updateModalFooter() {
            const summary = trashData.summary || {
                total: 0
            };
            const count = summary.total || 0;
            const countTemplate = count === 1 ? trashI18n.footerCountOne : trashI18n.footerCountMany;
            document.getElementById('modal-footer-count').textContent = countTemplate.replace(':count', String(count));
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
            if (!confirm(trashI18n.restoreConfirm)) {
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

                    showToast(data.message || trashI18n.restoredSuccess, 'success');
                } else {
                    throw new Error(data.message || trashI18n.restoreFailed);
                }
            } catch (error) {
                console.error('Restore error:', error);
                showToast(`${trashI18n.errorPrefix}: ${error.message}`, 'error');
            }
        }

        async function permanentlyDelete(type, id) {
            if (!confirm(trashI18n.deleteConfirm)) {
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

                    showToast(data.message || trashI18n.deletedSuccess, 'success');
                } else {
                    throw new Error(data.message || trashI18n.deleteFailed);
                }
            } catch (error) {
                console.error('Delete error:', error);
                showToast(`${trashI18n.errorPrefix}: ${error.message}`, 'error');
            }
        }

        async function emptyTrash() {
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

                    showToast(data.message || trashI18n.emptySuccess, 'success');
                } else {
                    throw new Error(data.message || trashI18n.emptyFailed);
                }
            } catch (error) {
                console.error('Empty trash error:', error);
                showToast(`${trashI18n.errorPrefix}: ${error.message}`, 'error');
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

            const tabs = [{
                    elementId: 'tab-experiences',
                    label: trashI18n.workExperience,
                    count: summary.experiences || 0
                },
                {
                    elementId: 'tab-educations',
                    label: trashI18n.education,
                    count: summary.educations || 0
                },
                {
                    elementId: 'tab-certificates',
                    label: trashI18n.certificates,
                    count: summary.certificates || 0
                }
            ];

            tabs.forEach(({
                elementId,
                label,
                count
            }) => {
                const tab = document.getElementById(elementId);
                if (tab) {
                    tab.innerHTML = renderTabButtonLabel(label, count);
                }
            });
        }

        // Close modal on outside click
        if (trashModalBackdrop) {
            trashModalBackdrop.addEventListener('click', closeTrashModal);
        }
        if (freelancerDeleteModalBackdrop) {
            freelancerDeleteModalBackdrop.addEventListener('click', closeFreelancerDeleteModal);
        }
        if (freelancerResetModalBackdrop) {
            freelancerResetModalBackdrop.addEventListener('click', closeFreelancerResetModal);
        }
        if (emptyTrashModalBackdrop) {
            emptyTrashModalBackdrop.addEventListener('click', closeEmptyTrashModal);
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            const emptyModal = document.getElementById('emptyTrashModal');
            if (e.key === 'Escape' && emptyModal && !emptyModal.classList.contains('hidden')) {
                closeEmptyTrashModal();
                return;
            }
            const modal = document.getElementById('trashModal');
            if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                closeTrashModal();
            }
            const deleteModal = document.getElementById('freelancerDeleteModal');
            if (e.key === 'Escape' && deleteModal && !deleteModal.classList.contains('hidden')) {
                closeFreelancerDeleteModal();
            }
            const resetModal = document.getElementById('freelancerResetModal');
            if (e.key === 'Escape' && resetModal && !resetModal.classList.contains('hidden')) {
                closeFreelancerResetModal();
            }
        });

        // Initialize toggle switches on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeToggleSwitches();
        });

        // Toggle switch functionality
        function initializeToggleSwitches() {
            const updateToggleState = (checkbox, label, span) => {
                checkbox.setAttribute('value', checkbox.checked ? '1' : '0');

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
            };

            document.querySelectorAll('.toggle-label').forEach(label => {
                // Set initial state from checkbox
                const checkbox = label.previousElementSibling;
                const span = label.querySelector('.toggle-span');

                if (!checkbox || !span) {
                    return;
                }

                // Set initial UI state
                updateToggleState(checkbox, label, span);

                // Keep UI synchronized with the checkbox state (label click, keyboard, etc.)
                checkbox.addEventListener('change', function() {
                    updateToggleState(checkbox, label, span);
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
            submitText.textContent = @json(__('settings.save.saving'));
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
                    showToast(result.message || @json(__('settings.messages.all_saved')), 'success');

                    const selectedLanguage = String(formData.get('language') || currentInterfaceLanguage)
                        .toLowerCase();
                    if (selectedLanguage && selectedLanguage !== currentInterfaceLanguage) {
                        window.location.reload();
                    }
                } else {
                    throw new Error(result.message || @json(__('settings.messages.save_failed')));
                }
            } catch (error) {
                console.error('Save error:', error);
                showToast(error.message || @json(__('settings.messages.save_error')), 'error');
            } finally {
                submitText.textContent = originalText;
                submitSpinner.classList.add('hidden');
                submitSpinner.classList.remove('block');
                saveAllBtn.disabled = false;
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

        function performResetToDefaults() {
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
                        showToast(@json(__('settings.messages.reset_success')), 'success');
                        window.location.reload();
                    } else {
                        showToast(data.message || @json(__('settings.messages.reset_failed')), 'error');
                    }
                })
                .catch(error => {
                    showToast(@json(__('settings.messages.generic_error')), 'error');
                });
        }

        function resetToDefaults() {
            if (confirm(@json(__('settings.messages.confirm_reset')))) {
                performResetToDefaults();
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
