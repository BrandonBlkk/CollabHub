@extends('layouts.app')

@section('title', 'Active Jobs')

@section('content')
    <div class="mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Active Jobs</h1>
                <p class="text-gray-600 mt-1">Track progress and manage your active contracts.</p>
            </div>
        </div>
    </div>

    @php
        $activeJobs = [
            [
                'title' => 'Landing Page Revamp',
                'status' => 'In Progress',
                'amount' => '$2,400',
                'progress' => 65,
                'deadline' => 'Feb 19, 2026',
                'client' => 'Nova Studio',
                'job_type' => 'Fixed',
                'started' => 'Feb 02, 2026',
                'milestone' => 'UI polish & QA',
                'next_due' => 'Feb 16, 2026',
                'notes' => 'Waiting on final assets and client feedback for hero section.',
            ],
            [
                'title' => 'API Integration Support',
                'status' => 'Active',
                'amount' => '$1,200',
                'progress' => 35,
                'deadline' => 'Feb 24, 2026',
                'client' => 'BrightPay',
                'job_type' => 'Hourly',
                'started' => 'Feb 05, 2026',
                'milestone' => 'Payment webhooks',
                'next_due' => 'Feb 18, 2026',
                'notes' => 'Client shared staging keys. Pending webhook retry spec.',
            ],
            [
                'title' => 'Mobile QA Audit',
                'status' => 'In Progress',
                'amount' => '$900',
                'progress' => 80,
                'deadline' => 'Feb 15, 2026',
                'client' => 'ShipMate',
                'job_type' => 'Fixed',
                'started' => 'Feb 07, 2026',
                'milestone' => 'iOS regression pass',
                'next_due' => 'Feb 14, 2026',
                'notes' => 'Most issues verified. Final pass on iPhone 13 mini pending.',
            ],
        ];
    @endphp

    <div class="grid gap-4">
        @foreach ($activeJobs as $job)
            @php
                $isInProgress = $job['status'] === 'In Progress';
                $dotColor = $isInProgress ? 'bg-amber-500' : 'bg-green-500';
                $progressColor = $isInProgress ? 'bg-amber-600' : 'bg-green-600';
            @endphp
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $job['title'] }}</h3>
                            <span class="text-gray-700 font-medium">{{ $job['amount'] }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600 mt-2">
                            <span class="inline-flex items-center">
                                <span class="w-2 h-2 rounded-full {{ $dotColor }} mr-2"></span>
                                {{ $job['status'] }}
                            </span>
                            <span class="text-gray-300">|</span>
                            <span>Client: {{ $job['client'] }}</span>
                            <span class="text-gray-300">|</span>
                            <span>Deadline: {{ $job['deadline'] }}</span>
                        </div>
                        <div class="mt-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>Progress</span>
                                <span>{{ $job['progress'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="h-2 rounded-full {{ $progressColor }}" style="width: {{ $job['progress'] }}%;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button"
                            class="px-3 py-2 text-sm font-medium bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 view-details-btn"
                            data-title="{{ $job['title'] }}" data-status="{{ $job['status'] }}"
                            data-client="{{ $job['client'] }}" data-amount="{{ $job['amount'] }}"
                            data-progress="{{ $job['progress'] }}" data-deadline="{{ $job['deadline'] }}"
                            data-type="{{ $job['job_type'] }}" data-started="{{ $job['started'] }}"
                            data-milestone="{{ $job['milestone'] }}" data-next-due="{{ $job['next_due'] }}"
                            data-notes="{{ $job['notes'] }}">
                            View details
                        </button>
                        <button type="button"
                            class="px-3 py-2 text-sm font-medium bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            Message
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Active Job Details Modal -->
    <div id="active-job-modal" class="fixed inset-0 z-50 hidden transition-opacity duration-300">
        <div id="active-job-backdrop"
            class="fixed inset-0 bg-black bg-opacity-50 opacity-0 transition-opacity duration-300">
        </div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div id="active-job-content"
                class="relative w-full max-w-2xl transform rounded-xl bg-white shadow-xl border border-gray-200 transition-all duration-300 ease-out translate-y-4 opacity-0">
                <div class="flex items-start justify-between p-5 border-b border-gray-200">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900" id="active-job-title">Job details</h3>
                        <p class="text-sm text-gray-500 mt-1" id="active-job-client">Client</p>
                    </div>
                    <button type="button" id="active-job-close"
                        class="text-gray-400 hover:text-gray-600 rounded-lg p-2 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex flex-wrap items-center gap-2">
                        <span id="active-job-status"
                            class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                            Status
                        </span>
                        <span class="text-xs text-gray-500">Type:</span>
                        <span class="text-xs font-medium text-gray-900" id="active-job-type"></span>
                        <span class="text-sm text-gray-500">Deadline:</span>
                        <span class="text-sm font-medium text-gray-900" id="active-job-deadline"></span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Budget</p>
                            <p class="text-base font-semibold text-gray-900" id="active-job-amount"></p>
                        </div>
                        <div class="sm:text-right">
                            <p class="text-sm text-gray-500">Progress</p>
                            <p class="text-base font-semibold text-gray-900" id="active-job-progress-text"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Started</p>
                            <p class="text-base font-semibold text-gray-900" id="active-job-started"></p>
                        </div>
                        <div class="sm:text-right">
                            <p class="text-sm text-gray-500">Next milestone</p>
                            <p class="text-base font-semibold text-gray-900" id="active-job-milestone"></p>
                            <p class="text-xs text-gray-500" id="active-job-next-due"></p>
                        </div>
                    </div>
                    <div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="h-2 rounded-full bg-green-600" id="active-job-progress-bar" style="width: 0%;">
                            </div>
                        </div>
                    </div>
                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                        <p class="text-sm font-semibold text-gray-900 mb-1">Notes</p>
                        <p class="text-sm text-gray-600" id="active-job-notes"></p>
                    </div>
                    <div class="flex flex-wrap gap-2 pt-2">
                        <button type="button"
                            class="px-3 py-2 text-sm font-medium bg-gray-900 text-white rounded-lg hover:bg-black">
                            Open contract
                        </button>
                        <button type="button"
                            class="px-3 py-2 text-sm font-medium bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            Message client
                        </button>
                        <button type="button"
                            class="px-3 py-2 text-sm font-medium bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100">
                            Add milestone
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('active-job-modal');
            const backdrop = document.getElementById('active-job-backdrop');
            const content = document.getElementById('active-job-content');
            const closeBtn = document.getElementById('active-job-close');
            const buttons = document.querySelectorAll('.view-details-btn');

            function openModal(data) {
                document.getElementById('active-job-title').textContent = data.title;
                document.getElementById('active-job-client').textContent = `Client: ${data.client}`;
                document.getElementById('active-job-deadline').textContent = data.deadline;
                document.getElementById('active-job-amount').textContent = data.amount;
                document.getElementById('active-job-progress-text').textContent = `${data.progress}%`;
                document.getElementById('active-job-progress-bar').style.width = `${data.progress}%`;
                document.getElementById('active-job-status').textContent = data.status;
                document.getElementById('active-job-type').textContent = data.type;
                document.getElementById('active-job-started').textContent = data.started;
                document.getElementById('active-job-milestone').textContent = data.milestone;
                document.getElementById('active-job-next-due').textContent = `Next due: ${data.nextDue}`;
                document.getElementById('active-job-notes').textContent = data.notes;

                modal.classList.remove('hidden');
                void modal.offsetWidth;
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');
                content.classList.remove('translate-y-4', 'opacity-0');
                content.classList.add('translate-y-0', 'opacity-100');
            }

            function closeModal() {
                content.classList.remove('translate-y-0', 'opacity-100');
                content.classList.add('translate-y-4', 'opacity-0');
                backdrop.classList.remove('opacity-100');
                backdrop.classList.add('opacity-0');
                setTimeout(() => modal.classList.add('hidden'), 200);
            }

            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    openModal(this.dataset);
                });
            });

            closeBtn.addEventListener('click', closeModal);
            backdrop.addEventListener('click', closeModal);
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });
    </script>
@endpush
