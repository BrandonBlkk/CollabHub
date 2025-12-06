<div class="sidebar bg-white w-64 border-r border-gray-200 flex-col flex-shrink-0 hidden lg:flex">
    <!-- Logo -->
    <div class="px-6 py-4 border-b border-gray-200">
        <a href="/" class="flex items-center space-x-3">
            <div
                class="w-8 h-8 rounded-xl bg-gradient-to-r from-blue-700 to-teal-600 flex items-center justify-center select-none">
                <span class="text-white font-bold text-base">C</span>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-900">CollabHub</h1>
                <p class="text-gray-600 text-xs">Admin Dashboard</p>
            </div>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
        <x-sidebar-item href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')"
            icon="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
            Dashboard
        </x-sidebar-item>

        <!-- User Management -->
        <x-sidebar-item href="#manage-clients"
            icon="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
            Manage Clients
        </x-sidebar-item>

        <x-sidebar-item href="#manage-freelancers"
            icon="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0a6 6 0 00-9 5.197">
            Manage Freelancers
        </x-sidebar-item>

        <!-- Jobs & Proposals -->
        <div class="pt-4">
            <p class="px-3 text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Jobs & Marketplace</p>

            <x-sidebar-item href="#jobs" icon="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7">
                All Jobs
            </x-sidebar-item>

            <x-sidebar-item href="#proposals"
                icon="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                Proposals & Bids
            </x-sidebar-item>

            <x-sidebar-item href="#contracts"
                icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                Active Contracts
            </x-sidebar-item>

            <x-sidebar-item href="#disputes" icon="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                Disputes & Reports
            </x-sidebar-item>
        </div>

        <!-- Finance & Payments -->
        <div class="pt-4">
            <p class="px-3 text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Finance</p>

            <x-sidebar-item href="#transactions" icon="M3 10h18M7 15h10M7 3v12a3 3 0 003 3h4a3 3 0 003-3V3">
                Transactions
            </x-sidebar-item>

            <x-sidebar-item href="#payouts"
                icon="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                Payout Requests
            </x-sidebar-item>

            <x-sidebar-item href="#earnings"
                icon="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                Platform Earnings
            </x-sidebar-item>
        </div>

        <!-- Data Management -->
        <div class="pt-4">
            <p class="px-3 text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Data Management</p>

            <x-sidebar-item href="#majors"
                icon="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                Majors
            </x-sidebar-item>

            <x-sidebar-item href="#universities"
                icon="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1">
                Universities
            </x-sidebar-item>

            <x-sidebar-item href="#skills" icon="M13 10V3L4 14h7v7l9-11h-7z">
                Skills
            </x-sidebar-item>

            <x-sidebar-item href="#programming-languages"
                icon="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                Programming Languages
            </x-sidebar-item>
        </div>

        <!-- System -->
        <div class="pt-4">
            <p class="px-3 text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">System</p>

            <x-sidebar-item href="#settings"
                icon="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                Settings
            </x-sidebar-item>

            <x-sidebar-item href="#admin-users"
                icon="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M9 7v4m0 0v4m0-4h6">
                Admin Users
            </x-sidebar-item>

            <x-sidebar-item href="#audit-log" icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                Audit Log
            </x-sidebar-item>
        </div>
    </nav>

    <!-- Admin Profile & Logout -->
    <div class="p-4 border-t border-gray-200">
        <div class="flex items-center space-x-3">
            <div
                class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center select-none">
                <span class="text-white font-bold text-sm">{{ auth()->user()->name[0] ?? 'A' }}</span>
            </div>
            <div class="flex-1">
                <h3 class="font-semibold text-sm">{{ auth()->user()->name }}</h3>
                <p class="text-gray-500 text-xs">Super Administrator</p>
            </div>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="text-gray-400 hover:text-red-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </div>
</div>
