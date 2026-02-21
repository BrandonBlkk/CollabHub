@props(['role' => auth()->user()->role])

<div class="sidebar bg-white w-64 border-r border-gray-200 flex-col hidden lg:flex" x-data="{ profileMenuOpen: false }">
    <!-- Logo -->
    <div class="px-6 py-4 border-b border-gray-200">
        <a href="/" class="flex items-center space-x-3">
            <div
                class="w-8 h-8 rounded-xl bg-gradient-to-r from-blue-700 to-teal-600 flex items-center justify-center select-none">
                <span class="text-white font-bold text-base">C</span>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-900">CollabHub</h1>
                <p class="text-gray-600 text-xs">
                    {{ $role === 'freelancer' ? 'Freelancer Dashboard' : 'Client Dashboard' }}
                </p>
            </div>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-1">
        <x-sidebar-item :href="route('dashboard')" :active="request()->routeIs('dashboard')"
            icon="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
            Dashboard
        </x-sidebar-item>

        @if ($role === 'freelancer')
            <x-sidebar-item href="{{ route('find-jobs') }}" :active="request()->routeIs('find-jobs')"
                icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                Find Jobs
            </x-sidebar-item>

            <x-sidebar-item href="{{ route('freelancer.active-jobs') }}" :active="request()->routeIs('freelancer.active-jobs')"
                icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                Active Jobs
            </x-sidebar-item>

            <x-sidebar-item href="{{ route('freelancer.deadlines') }}" :active="request()->routeIs('freelancer.deadlines')"
                icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                Upcoming Deadlines
            </x-sidebar-item>
        @else
            <x-sidebar-item :href="route('my-jobs.index')" :active="request()->routeIs('my-jobs.index')"
                icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                badge="5" badgeColor="blue">
                My Jobs
            </x-sidebar-item>

            <x-sidebar-item :href="route('find-freelancers')" :active="request()->routeIs('find-freelancers')"
                icon="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0a6 6 0 00-9 5.197">
                Find Freelancers
            </x-sidebar-item>
        @endif

        <x-sidebar-item href="{{ route('messages.index') }}" :active="request()->routeIs('messages.index')"
            icon="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
            badge="2" badgeColor="red">
            Messages
        </x-sidebar-item>

        <x-sidebar-item href="{{ route('earnings') }}" :active="request()->routeIs('earnings')"
            icon="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
            Earnings
        </x-sidebar-item>
    </nav>

    <!-- User Profile Dropdown -->
    <div class="p-4 border-t border-gray-200 relative">
        <div class="flex items-center space-x-3">
            <!-- Profile Trigger Button -->
            <button @click="profileMenuOpen = !profileMenuOpen"
                class="flex items-center space-x-3 w-full focus:outline-none hover:bg-gray-50 p-2 rounded-lg transition duration-150">
                {{-- Profile Photo --}}
                @if (auth()->user()->profile_photo_path)
                    <div class="w-10 h-10 rounded-full overflow-hidden">
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="Profile Image"
                            class="w-full h-full object-cover select-none">
                    </div>
                @else
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center select-none">
                        <span
                            class="text-white font-bold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                @endif

                <div class="flex-1 text-left">
                    <h3 id="name" class="font-semibold text-sm text-gray-900">{{ auth()->user()->name }}</h3>
                    <p class="text-gray-500 text-xs">
                        {{ $role === 'freelancer' ? 'Freelancer' : 'Client' }}
                    </p>
                </div>

                <!-- Dropdown Arrow -->
                <svg :class="{ 'transform rotate-180': profileMenuOpen }"
                    class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>

        <!-- Profile Dropdown Menu -->
        <div x-show="profileMenuOpen" @click.outside="profileMenuOpen = false" x-cloak
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute bottom-full left-4 right-4 mb-2 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">

            @php
                $current_user_role = auth()->user()->role;

                $profileRoute = match ($current_user_role) {
                    'freelancer' => route('freelancer-profile.show', auth()->user()->id),
                    'client' => route('profile.show', auth()->user()->id),
                };
            @endphp

            @auth
                <!-- For Authenticated Users -->
                <a href="{{ $profileRoute }}" class="flex items-center px-4 py-3 hover:bg-gray-50 text-gray-700">
                    <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <div>
                        <span class="font-medium text-sm">My Profile</span>
                        <p class="text-xs text-gray-500">View and edit profile</p>
                    </div>
                </a>

                <a href="{{ route('settings.index') }}"
                    class="flex items-center px-4 py-3 hover:bg-gray-50 text-gray-700 border-t border-gray-100">
                    <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div>
                        <span class="font-medium text-sm">Settings</span>
                        <p class="text-xs text-gray-500">Account preferences</p>
                    </div>
                </a>

                <div class="border-t border-gray-100">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center px-4 py-3 hover:bg-gray-50 text-red-600 group">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="font-medium text-sm">Logout</span>
                        </button>
                    </form>
                </div>
            @else
                <!-- For Guest Users -->
                <a href="{{ route('login') }}" class="flex items-center px-4 py-3 hover:bg-gray-50 text-gray-700 group">
                    <svg class="w-5 h-5 text-gray-400 mr-3 group-hover:text-blue-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <div>
                        <span class="font-medium text-sm">Sign In</span>
                        <p class="text-xs text-gray-500">Access your account</p>
                    </div>
                </a>

                <a href="{{ route('register') }}"
                    class="flex items-center px-4 py-3 hover:bg-gray-50 text-gray-700 group border-t border-gray-100">
                    <svg class="w-5 h-5 text-gray-400 mr-3 group-hover:text-green-600" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <div>
                        <span class="font-medium text-sm">Sign Up</span>
                        <p class="text-xs text-gray-500">Create new account</p>
                    </div>
                </a>
            @endauth
        </div>
    </div>
</div>

<!-- Mobile sidebar overlay (optional) -->
<div x-show="profileMenuOpen" @click="profileMenuOpen = false" x-cloak
    class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden">
</div>

<!-- Add Alpine.js if not already included in your layout -->
@push('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush
