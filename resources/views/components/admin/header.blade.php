@props([
    'title' => 'Default Title',
    'description' => '',
])

<header class="bg-white border-b border-gray-200 px-3 py-4">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900">{{ $title }}</h2>
            <p class="text-sm text-gray-600">{{ $description }}</p>
        </div>

        <div class="flex items-center gap-4">
            <button class="p-2 hover:bg-gray-100 rounded-lg transition relative">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                    </path>
                </svg>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>

            <div class="flex items-center gap-3">
                @if (Auth::user()->profile_photo_path)
                    <div class="w-8 h-8 rounded-full select-none">
                        <img src="{{ Auth::user()->profile_photo_path }}" alt="Profile Image"
                            class="w-full h-full object-cover rounded-full">
                    </div>
                @else
                    <div
                        class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-400 to-teal-400 flex items-center justify-center select-none">
                        <span class="text-white font-bold text-sm">{{ Str::substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                @endif
                <div class="hidden md:block">
                    <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
    </div>
</header>
