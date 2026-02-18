@extends('layouts.app')

@section('title', $clientUser->name . ' Profile')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-3">
            <div class="lg:col-span-8 xl:col-span-9 space-y-3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center gap-4">
                            @if ($clientUser->profile_photo_path)
                                <img src="{{ asset('storage/' . $clientUser->profile_photo_path) }}"
                                    alt="{{ $clientUser->name }}" class="w-32 h-32 rounded-full object-cover">
                            @else
                                <div
                                    class="w-32 h-32 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center select-none">
                                    <span
                                        class="text-white text-4xl font-bold">{{ strtoupper(substr($clientUser->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $clientUser->name }}</h1>
                                <p class="text-sm text-gray-600">{{ $clientUser->client->company ?? 'Independent client' }}
                                </p>
                                @if ($clientUser->location)
                                    <p class="text-xs text-gray-500 mt-1">{{ $clientUser->location }}</p>
                                @endif
                            </div>
                        </div>
                        @if ($clientUser->client?->website)
                            <a href="{{ $clientUser->client->website }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm select-none">
                                Visit Website
                            </a>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <p class="text-xs text-gray-500">Total Jobs</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $clientStats['total_jobs'] }}</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <p class="text-xs text-gray-500">Open Jobs</p>
                        <p class="text-2xl font-bold text-green-700">{{ $clientStats['open_jobs'] }}</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <p class="text-xs text-gray-500">In Progress</p>
                        <p class="text-2xl font-bold text-blue-700">{{ $clientStats['in_progress_jobs'] }}</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <p class="text-xs text-gray-500">Completed</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $clientStats['completed_jobs'] }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <div class="flex space-x-6 overflow-x-auto select-none border-b border-gray-200 pb-2">
                        <button type="button"
                            class="profile-tab pb-2 text-sm font-medium border-b-2 border-blue-600 text-blue-600"
                            data-tab="home">Home</button>
                        <button type="button"
                            class="profile-tab pb-2 text-sm font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-900"
                            data-tab="jobs">Jobs ({{ $clientJobs->count() }})</button>
                        <button type="button"
                            class="profile-tab pb-2 text-sm font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-900"
                            data-tab="about">About</button>
                    </div>

                    <div id="tab-home" class="profile-tab-content pt-4">
                        <p class="text-sm text-gray-700">Browse this client profile and switch to the Jobs tab to see all
                            posted
                            jobs.</p>
                    </div>

                    <div id="tab-jobs" class="profile-tab-content hidden pt-4">
                        @if ($clientJobs->isEmpty())
                            <div
                                class="rounded-lg border border-dashed border-gray-300 p-6 text-center text-sm text-gray-500">
                                No jobs posted yet.
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach ($clientJobs as $job)
                                    <div class="public-job-card bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200 h-full flex flex-col"
                                        data-job-id="{{ $job->id }}" data-status="{{ $job->status ?? 'open' }}"
                                        data-type="{{ $job->type ?? 'fixed' }}" data-duration="{{ $job->duration ?? '' }}"
                                        data-saved="{{ $job->is_saved ? '1' : '0' }}">
                                        <div class="p-6 flex-1 flex flex-col">
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between gap-3 mb-4">
                                                        <a href="{{ route('clients.profile.show', $clientUser->id) }}"
                                                            class="inline-flex items-center gap-3 group">
                                                            <div
                                                                class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center overflow-hidden select-none">
                                                                @if ($clientUser->profile_photo_path)
                                                                    <img src="{{ asset('storage/' . $clientUser->profile_photo_path) }}"
                                                                        alt="{{ $clientUser->name }}"
                                                                        class="w-full h-full object-cover">
                                                                @else
                                                                    <span
                                                                        class="text-white text-sm font-bold">{{ strtoupper(substr($clientUser->name, 0, 1)) }}</span>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <p
                                                                    class="text-sm font-semibold text-gray-900 group-hover:text-blue-700">
                                                                    {{ $clientUser->name }}</p>
                                                                <p class="text-xs text-gray-500">
                                                                    {{ $clientUser->client->company ?? 'Independent client' }}
                                                                </p>
                                                            </div>
                                                        </a>

                                                        <div class="relative">
                                                            <button type="button"
                                                                class="job-more-btn w-8 h-8 rounded-full border border-gray-200 hover:bg-gray-50 text-gray-700 flex items-center justify-center"
                                                                aria-label="More options">
                                                                <i class="ri-more-line font-bold"></i>
                                                            </button>
                                                            <div
                                                                class="job-more-menu hidden absolute right-0 top-9 z-30 w-36 rounded-lg border border-gray-200 bg-white shadow-lg py-1">
                                                                <button type="button"
                                                                    class="menu-save-btn w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                                                    <span class="inline-flex items-center gap-2">
                                                                        <i class="ri-bookmark-line"></i>
                                                                        <span>{{ $job->is_saved ? 'Saved' : 'Save' }}</span>
                                                                    </span>
                                                                </button>
                                                                <button type="button"
                                                                    class="menu-not-for-me-btn w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                                                    <span class="inline-flex items-center gap-2">
                                                                        <i class="ri-forbid-2-line"></i>
                                                                        <span>Not for me</span>
                                                                    </span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center justify-between mb-2">
                                                        <span
                                                            class="px-3 py-1 rounded-full text-xs font-medium select-none
                                                    @if ($job->status === 'open') bg-green-100 text-green-800
                                                    @elseif ($job->status === 'closed') bg-red-100 text-red-800
                                                    @elseif ($job->status === 'in_progress') bg-blue-100 text-blue-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                            {{ ucfirst(str_replace('_', ' ', $job->status ?? 'open')) }}
                                                        </span>
                                                        <div class="flex items-center space-x-2">
                                                            <span class="text-xs text-gray-500">Posted:
                                                                {{ optional($job->created_at)->diffForHumans() ?? 'Just now' }}</span>
                                                        </div>
                                                    </div>

                                                    <h3 class="font-bold text-gray-900 mb-2 text-lg">
                                                        {{ $job->title ?? 'Untitled Job' }}
                                                    </h3>
                                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                                        {{ \Illuminate\Support\Str::limit(strip_tags($job->description ?? 'No description provided.'), 150) }}
                                                    </p>

                                                    @php
                                                        $skills = is_array($job->skills_required)
                                                            ? $job->skills_required
                                                            : [];
                                                        $durationMap = [
                                                            'less_than_1_month' => 'Less than 1 month',
                                                            '1_to_3_months' => '1-3 months',
                                                            '3_to_6_months' => '3-6 months',
                                                            'more_than_6_months' => 'More than 6 months',
                                                        ];
                                                        $durationLabel =
                                                            $durationMap[$job->duration] ?? 'Not specified';
                                                    @endphp
                                                    <div class="flex flex-wrap gap-2 mb-4 select-none">
                                                        @if (count($skills))
                                                            @foreach (array_slice($skills, 0, 3) as $skill)
                                                                <span
                                                                    class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">{{ $skill }}</span>
                                                            @endforeach
                                                            @if (count($skills) > 3)
                                                                <span
                                                                    class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">+{{ count($skills) - 3 }}
                                                                    more</span>
                                                            @endif
                                                        @else
                                                            <span
                                                                class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">No
                                                                Skills Required</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-auto pt-4 border-t border-gray-100">
                                                <div
                                                    class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                                                    <div
                                                        class="flex flex-col sm:flex-row sm:items-center sm:space-x-6 space-y-3 sm:space-y-0">
                                                        <div class="flex items-center">
                                                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                                            </svg>
                                                            <span
                                                                class="font-semibold text-gray-900">{{ $job->budget_display }}</span>
                                                            <span
                                                                class="text-gray-500 text-sm ml-2">{{ ucfirst($job->type ?? 'n/a') }}</span>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <span
                                                                class="text-gray-600 text-sm">{{ $durationLabel }}</span>
                                                        </div>
                                                    </div>
                                                    <button type="button"
                                                        class="view-detail-btn flex-1 xs:flex-none px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm font-medium transition duration-200 flex items-center justify-center select-none"
                                                        data-job-id="{{ $job->id }}">
                                                        <span>View Detail</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div id="tab-about" class="profile-tab-content hidden pt-4">
                        <div class="text-sm text-gray-700 space-y-2">
                            <p><span class="font-medium text-gray-900">Company:</span>
                                {{ $clientUser->client->company ?? 'Independent client' }}</p>
                            <p><span class="font-medium text-gray-900">Location:</span>
                                {{ $clientUser->location ?? 'Not specified' }}
                            </p>
                            <p><span class="font-medium text-gray-900">Website:</span>
                                @if ($clientUser->client?->website)
                                    <a href="{{ $clientUser->client->website }}" class="text-blue-600 hover:underline"
                                        target="_blank" rel="noopener noreferrer">{{ $clientUser->client->website }}</a>
                                @else
                                    Not specified
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <aside class="lg:col-span-4 xl:col-span-3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 lg:sticky lg:top-0">
                    <h2 class="text-base font-semibold text-gray-900">People Also Viewed</h2>
                    <p class="text-xs text-gray-500 mt-1">Other client profiles you may want to check.</p>

                    <div class="mt-4 space-y-3">
                        @forelse ($peopleAlsoViewed as $person)
                            <a href="{{ route('clients.profile.show', $person->id) }}"
                                class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center overflow-hidden select-none">
                                    @if ($person->profile_photo_path)
                                        <img src="{{ asset('storage/' . $person->profile_photo_path) }}"
                                            alt="{{ $person->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span
                                            class="text-white text-sm font-bold">{{ strtoupper(substr($person->name, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $person->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">
                                        {{ $person->client->company ?? 'Independent client' }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $person->jobs_count ?? 0 }} jobs posted</p>
                                </div>
                            </a>
                        @empty
                            <div class="text-sm text-gray-500">No profiles to suggest yet.</div>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <div id="job-details-modal" class="fixed inset-0 z-50 hidden transition-opacity duration-300">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300 ease-out opacity-0"
            id="modal-backdrop">
        </div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all duration-300 ease-out sm:my-8 sm:w-full sm:max-w-4xl w-full translate-y-4 opacity-0 scale-95"
                id="modal-content">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-gray-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900">Job Details</h3>
                            <div class="mt-2">
                                <div class="flex items-center space-x-2">
                                    <span id="modal-status" class="px-2 py-1 rounded-full text-xs font-medium"></span>
                                    <span class="text-sm text-gray-500" id="modal-posted-time"></span>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="close-modal"
                            class="text-gray-400 hover:text-gray-500 rounded-lg p-2 transition-colors duration-200">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 overflow-y-auto max-h-[68vh]">
                    <div class="space-y-6">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900" id="modal-job-title"></h2>
                            <div class="mt-1 flex items-center space-x-4 text-sm">
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                    <span class="font-medium" id="modal-budget"></span>
                                    <span class="text-gray-500 ml-2" id="modal-type"></span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span id="modal-duration"></span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span id="modal-experience"></span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-3">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Job Description</h3>
                            <div class="text-sm max-w-none text-gray-700 whitespace-pre-line" id="modal-description">
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Skills Required</h3>
                            <div class="flex flex-wrap gap-2" id="modal-skills"></div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-3 border-t border-gray-200">
                    @if (auth()->user()?->role === 'freelancer')
                        <a id="open-in-find-jobs" href="{{ route('find-jobs') }}"
                            class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black transition duration-300 text-sm font-medium">
                            Open in Find Jobs
                        </a>
                    @endif
                    <button type="button" id="cancel-modal"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 text-sm font-medium">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (() => {
            const tabs = document.querySelectorAll('.profile-tab');
            const contents = document.querySelectorAll('.profile-tab-content');
            const canSaveJobs = @json(auth()->user()?->role === 'freelancer');
            const saveJobUrl = @json(route('find-jobs.toggle-save'));
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const modalData = @json($modalJobsData);
            const jobsById = new Map(modalData.map((job) => [String(job.id), job]));
            const jobDetailsModal = document.getElementById('job-details-modal');
            const modalContent = document.getElementById('modal-content');
            const closeModalBtn = document.getElementById('close-modal');
            const cancelModalBtn = document.getElementById('cancel-modal');
            const modalBackdrop = document.getElementById('modal-backdrop');
            const openInFindJobsBtn = document.getElementById('open-in-find-jobs');
            const findJobsBaseUrl = @json(route('find-jobs'));

            function activateTab(tabName) {
                tabs.forEach((tab) => {
                    const isActive = tab.dataset.tab === tabName;
                    tab.classList.toggle('border-blue-600', isActive);
                    tab.classList.toggle('text-blue-600', isActive);
                    tab.classList.toggle('border-transparent', !isActive);
                    tab.classList.toggle('text-gray-600', !isActive);
                });

                contents.forEach((content) => {
                    content.classList.toggle('hidden', content.id !== `tab-${tabName}`);
                });
            }

            tabs.forEach((tab) => {
                tab.addEventListener('click', () => activateTab(tab.dataset.tab));
            });

            function closeAllMenus() {
                document.querySelectorAll('.job-more-menu').forEach((menu) => {
                    menu.classList.add('hidden');
                });
            }

            function setSaveLabel(button, isSaved) {
                const label = button.querySelector('span span');
                if (label) {
                    label.textContent = isSaved ? 'Saved' : 'Save';
                }
            }

            function showToast(message, type = 'success') {
                const oldToast = document.querySelector('.public-profile-toast');
                if (oldToast) {
                    oldToast.remove();
                }

                const toast = document.createElement('div');
                toast.className =
                    `public-profile-toast fixed bottom-4 right-3 px-4 py-3 rounded-md shadow-md text-white font-medium z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
                toast.textContent = message;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.remove();
                }, 2500);
            }

            function formatDuration(duration) {
                const durationMap = {
                    less_than_1_month: 'Less than 1 month',
                    '1_to_3_months': '1-3 months',
                    '3_to_6_months': '3-6 months',
                    more_than_6_months: 'More than 6 months',
                };
                return durationMap[duration] || 'Not specified';
            }

            function formatExperienceLevel(experience) {
                const experienceMap = {
                    entry: 'Entry Level',
                    intermediate: 'Intermediate',
                    expert: 'Expert',
                };
                return experienceMap[experience] || 'Not specified';
            }

            function formatTimeAgo(dateString) {
                if (!dateString) return 'Posted: Just now';
                const date = new Date(dateString);
                const now = new Date();
                const diffInSeconds = Math.floor((now - date) / 1000);

                if (diffInSeconds < 60) return 'Posted: Just now';
                if (diffInSeconds < 3600) return `Posted: ${Math.floor(diffInSeconds / 60)} minutes ago`;
                if (diffInSeconds < 86400) return `Posted: ${Math.floor(diffInSeconds / 3600)} hours ago`;
                if (diffInSeconds < 604800) return `Posted: ${Math.floor(diffInSeconds / 86400)} days ago`;
                if (diffInSeconds < 2592000) return `Posted: ${Math.floor(diffInSeconds / 604800)} weeks ago`;
                return `Posted: ${Math.floor(diffInSeconds / 2592000)} months ago`;
            }

            function closeDetailModal() {
                modalContent.classList.remove('translate-y-0', 'opacity-100');
                modalContent.classList.add('translate-y-4', 'opacity-0');
                modalBackdrop.classList.remove('opacity-100');
                modalBackdrop.classList.add('opacity-0');

                setTimeout(() => {
                    jobDetailsModal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }, 300);
            }

            function openDetailModal(jobId) {
                const job = jobsById.get(String(jobId));
                if (!job) return;

                const statusBadge = document.getElementById('modal-status');
                const status = job.status || 'open';
                statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' ');
                if (status === 'open') {
                    statusBadge.className = 'px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800';
                } else if (status === 'closed') {
                    statusBadge.className = 'px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800';
                } else if (status === 'in_progress') {
                    statusBadge.className = 'px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
                } else {
                    statusBadge.className = 'px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
                }

                document.getElementById('modal-posted-time').textContent = formatTimeAgo(job.created_at);
                document.getElementById('modal-job-title').textContent = job.title || 'Untitled Job';
                document.getElementById('modal-budget').textContent = job.budget_display || 'Budget not specified';
                document.getElementById('modal-type').textContent = job.type ?
                    job.type.charAt(0).toUpperCase() + job.type.slice(1) : 'Not specified';
                document.getElementById('modal-duration').textContent = formatDuration(job.duration);
                document.getElementById('modal-experience').textContent = formatExperienceLevel(job.experience_level);
                document.getElementById('modal-description').textContent = job.description ||
                    'No description provided.';

                const skillsContainer = document.getElementById('modal-skills');
                skillsContainer.innerHTML = '';
                const skills = Array.isArray(job.skills_required) ? job.skills_required : [];
                if (!skills.length) {
                    const skill = document.createElement('span');
                    skill.className = 'px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded';
                    skill.textContent = 'No Skills Required';
                    skillsContainer.appendChild(skill);
                } else {
                    skills.forEach((name) => {
                        const skill = document.createElement('span');
                        skill.className = 'px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded';
                        skill.textContent = name;
                        skillsContainer.appendChild(skill);
                    });
                }

                jobDetailsModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                void jobDetailsModal.offsetWidth;
                setTimeout(() => {
                    modalBackdrop.classList.remove('opacity-0');
                    modalBackdrop.classList.add('opacity-100');
                }, 10);
                setTimeout(() => {
                    modalContent.classList.remove('translate-y-4', 'opacity-0');
                    modalContent.classList.add('translate-y-0', 'opacity-100');
                }, 10);

                if (openInFindJobsBtn) {
                    openInFindJobsBtn.href = `${findJobsBaseUrl}?job=${job.id}`;
                }
            }

            async function toggleSave(card, saveBtn) {
                if (!canSaveJobs) {
                    showToast('Only freelancers can save jobs.', 'error');
                    return;
                }

                const jobId = card.dataset.jobId;
                if (!jobId || !csrfToken) {
                    showToast('Unable to save this job right now.', 'error');
                    return;
                }

                try {
                    const response = await fetch(saveJobUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            job_id: Number(jobId),
                        }),
                    });

                    const data = await response.json();
                    if (!response.ok || !data.success) {
                        throw new Error(data.message || 'Failed to save job');
                    }

                    const isSaved = data.action === 'saved';
                    card.dataset.saved = isSaved ? '1' : '0';
                    setSaveLabel(saveBtn, isSaved);
                    showToast(isSaved ? 'Job saved successfully.' : 'Job removed from saved jobs.');
                } catch (error) {
                    showToast(error.message || 'Failed to save job.', 'error');
                }
            }

            const cards = document.querySelectorAll('.public-job-card');
            cards.forEach((card) => {
                const moreBtn = card.querySelector('.job-more-btn');
                const menu = card.querySelector('.job-more-menu');
                const saveBtn = card.querySelector('.menu-save-btn');
                const notForMeBtn = card.querySelector('.menu-not-for-me-btn');
                const viewDetailBtn = card.querySelector('.view-detail-btn');

                if (!moreBtn || !menu || !saveBtn || !notForMeBtn) {
                    return;
                }

                setSaveLabel(saveBtn, card.dataset.saved === '1');

                moreBtn.addEventListener('click', (event) => {
                    event.stopPropagation();
                    const isHidden = menu.classList.contains('hidden');
                    closeAllMenus();
                    if (isHidden) {
                        menu.classList.remove('hidden');
                    }
                });

                saveBtn.addEventListener('click', async (event) => {
                    event.stopPropagation();
                    await toggleSave(card, saveBtn);
                    menu.classList.add('hidden');
                });

                notForMeBtn.addEventListener('click', (event) => {
                    event.stopPropagation();
                    card.classList.add('hidden');
                    menu.classList.add('hidden');
                    showToast('Job hidden from this view.');
                });

                if (viewDetailBtn) {
                    viewDetailBtn.addEventListener('click', () => {
                        openDetailModal(card.dataset.jobId);
                    });
                }
            });

            document.addEventListener('click', closeAllMenus);
            closeModalBtn?.addEventListener('click', closeDetailModal);
            cancelModalBtn?.addEventListener('click', closeDetailModal);
            modalBackdrop?.addEventListener('click', closeDetailModal);
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && !jobDetailsModal.classList.contains('hidden')) {
                    closeDetailModal();
                }
            });
        })();
    </script>
@endsection
