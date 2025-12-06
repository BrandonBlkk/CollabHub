@props(['userType' => auth()->user()->user_type])

<div class="sidebar bg-white w-64 border-r border-gray-200 flex-col hidden lg:flex">
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
                    {{ $userType === 'freelancer' ? 'Freelancer Dashboard' : 'Client Dashboard' }}
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

        @if ($userType === 'freelancer')
            <x-sidebar-item href="#"
                icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                Find Projects
            </x-sidebar-item>

            <x-sidebar-item href="#"
                icon="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                badge="3" badgeColor="blue">
                My Proposals
            </x-sidebar-item>

            <x-sidebar-item href="#"
                icon="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                Portfolio
            </x-sidebar-item>
        @else
            <x-sidebar-item href="#" icon="M12 6v6m0 0v6m0-6h6m-6 0H6">
                Post a Job
            </x-sidebar-item>

            <x-sidebar-item href="#"
                icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                badge="5" badgeColor="blue">
                My Jobs
            </x-sidebar-item>

            <x-sidebar-item :href="route('find-freelancers')" :active="request()->routeIs('find-freelancers')"
                icon="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0a6 6 0 00-9 5.197">
                Find Freelancers
            </x-sidebar-item>
        @endif

        <x-sidebar-item href="#"
            icon="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
            badge="2" badgeColor="red">
            Messages
        </x-sidebar-item>

        <x-sidebar-item href="#"
            icon="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
            Earnings
        </x-sidebar-item>

        <x-sidebar-item href="#"
            icon="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z">
            Settings
        </x-sidebar-item>
    </nav>

    <!-- User Profile -->
    <div class="p-4 border-t border-gray-200">
        <div class="flex items-center space-x-3">

            {{-- Profile Photo --}}
            @if (auth()->user()->profile_photo_path)
                <div class="w-10 rounded-full select-none">
                    <img src="{{ $freelancer->profile_photo_path }}" alt="Profile Image"
                        class="w-full h-full object-cover rounded-full">
                </div>
            @else
                <div
                    class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center select-none">
                    <span
                        class="text-white font-bold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                </div>
            @endif

            <div class="flex-1">
                <h3 class="font-semibold text-sm">{{ auth()->user()->name }}</h3>
                <p class="text-gray-500 text-xs">
                    {{ $userType === 'freelancer' ? 'Freelancer' : 'Client' }}
                </p>
            </div>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="text-gray-400 hover:text-red-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</div>
