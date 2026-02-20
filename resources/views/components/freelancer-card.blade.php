@props(['freelancer', 'viewType'])
<div @class([
    'freelancer-card' => true,
    'list-view' => $viewType === 'list',
    'grid-view' => $viewType === 'grid',
    'bg-white rounded-2xl shadow-sm border border-gray-200 p-6 transition-all duration-300 ease-in-out hover:shadow-md overflow-hidden',
])>
    <div class="flex items-start space-x-4">
        <!-- Avatar -->
        @if ($freelancer->profile_photo_path)
            <div class="w-14 h-14 rounded-full select-none">
                <img src="{{ $freelancer->profile_photo_url }}" alt="Profile Image"
                    class="w-full h-full rounded-full object-cover">
            </div>
        @else
            <div
                class="w-14 h-14 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center select-none">
                <span class="text-white font-bold text-lg">{{ strtoupper(substr($freelancer->name, 0, 1)) }}</span>
            </div>
        @endif
        <!-- Info -->
        <div class="flex-1">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="font-bold text-gray-900">{{ $freelancer->name }}</h3>
                    <p class="text-gray-600 text-sm mt-1">
                        {{ $freelancer->freelancer->job_title ?? 'Freelancer' }}
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-lg font-bold text-gray-900">
                        ${{ $freelancer->freelancer->hourly_rate ?? 0 }}/hr
                    </div>
                    <div class="flex items-center text-yellow-500 mt-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        {{-- Dynamic Average Rating --}}
                        <span class="text-gray-700 font-medium ml-1">
                            {{ number_format($freelancer->freelancer->rating ?? 0, 1) }}
                        </span>

                        {{-- Dynamic Review Count --}}
                        <span class="text-gray-500 text-sm ml-1">
                            ({{ $freelancer->reviewsReceived->count() ?? 0 }}
                            review{{ ($freelancer->reviewsReceived->count() ?? 0) !== 1 ? 's' : '' }})
                        </span>
                    </div>
                </div>
            </div>
            <!-- Location & Availability Status -->
            <div class="flex items-center space-x-4 mt-3">
                <div class="flex items-center text-gray-600 text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    @if ($freelancer->location && $freelancer->country)
                        {{ $freelancer->location }}, {{ $freelancer->country }}
                    @else
                        <p>No Location</p>
                    @endif
                </div>
                <!-- Availability Badge -->
                <div class="flex items-center text-sm font-medium">
                    @php
                        $availability = $freelancer->freelancer->availability ?? 'unknown';
                    @endphp
                    @switch($availability)
                        @case('available')
                            <div class="flex items-center text-green-600">
                                <div class="w-2 h-2 rounded-full bg-green-500 mr-1.5"></div>
                                Available Now
                            </div>
                        @break

                        @case('busy')
                            <div class="flex items-center text-amber-600">
                                <div class="w-2 h-2 rounded-full bg-amber-500 mr-1.5"></div>
                                Busy
                            </div>
                        @break

                        @case('unavailable')
                            <div class="flex items-center text-red-600">
                                <div class="w-2 h-2 rounded-full bg-red-500 mr-1.5"></div>
                                Unavailable
                            </div>
                        @break

                        @default
                            <div class="flex items-center text-gray-500">
                                <div class="w-2 h-2 rounded-full bg-gray-400 mr-1.5"></div>
                                Status Unknown
                            </div>
                    @endswitch
                </div>
            </div>
            <!-- Skills -->
            <div class="flex flex-wrap gap-2 mt-4 select-none">
                @forelse($freelancer->skills ?? [] as $skill)
                    <span
                        class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full hover:bg-blue-200 transition cursor-pointer">
                        {{ $skill->name }}
                    </span>
                @empty
                    <span class="bg-gray-100 text-gray-600 text-xs font-medium px-3 py-1.5 rounded-full italic">
                        No skills added yet
                    </span>
                @endforelse
            </div>
            <!-- Description -->
            <p class="text-gray-600 text-sm mt-4 line-clamp-2">
                {{ $freelancer->freelancer->bio ?? 'Talented freelancer ready to help bring your project to life with clean, efficient solutions.' }}
            </p>
            <!-- Stats -->
            <div class="grid grid-cols-3 gap-4 mt-4 pt-4 border-t border-gray-100">
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900">
                        {{ $freelancer->freelancer->completed_projects ?? 0 }}</div>
                    <div class="text-gray-500 text-xs">Projects</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900">
                        {{ $freelancer->freelancer->jobb_success_rate ?? 0 }}%
                    </div>
                    <div class="text-gray-500 text-xs">Job Success</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900">
                        {{ number_format($freelancer->freelancer->total_hours ?? 0) }}</div>
                    <div class="text-gray-500 text-xs">Hours</div>
                </div>
            </div>
            <!-- Actions -->
            <div class="flex items-center space-x-3 mt-6 select-none">
                @php
                    $freelancerAvailability = $freelancer->freelancer->availability ?? 'unknown';
                @endphp
                @if ($freelancerAvailability === 'unavailable')
                    <!-- Disabled Hire Now Button -->
                    <button
                        class="flex-1 bg-gray-300 text-gray-500 font-medium py-2.5 rounded-lg cursor-not-allowed text-sm"
                        disabled title="This freelancer is currently unavailable for hire">
                        Unavailable
                    </button>
                @elseif($freelancerAvailability === 'unknown')
                    <!-- Unknown Status Button -->
                    <button
                        class="flex-1 bg-gray-300 text-gray-500 font-medium py-2.5 rounded-lg cursor-not-allowed text-sm"
                        disabled title="Availability status unknown">
                        Unknown Status
                    </button>
                @else
                    <!-- Active Hire Now Button -->
                    <button
                        class="flex-1 bg-gray-800 hover:bg-black text-white font-medium py-2.5 rounded-lg transition duration-300 text-sm">
                        Hire Now
                    </button>
                @endif
                <!-- View Profile Button - Always Enabled -->
                <a href="{{ route('freelancer-profile', $freelancer->id) }}"
                    class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2.5 rounded-lg transition duration-300 text-sm">
                    View Profile
                </a>
                <!-- Favorite Button - Always Enabled -->
                <button class="p-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
