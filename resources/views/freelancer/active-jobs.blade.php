@extends('layouts.app')

@section('title', __('active-jobs.meta.title'))

@section('content')
    <div class="mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('active-jobs.header.title') }}</h1>
                <p class="text-gray-600 mt-1">{{ __('active-jobs.header.subtitle') }}</p>
            </div>
        </div>
    </div>

    @php
        $activeJobs = trans('active-jobs.sample_jobs');
    @endphp

    <div class="grid gap-4">
        @foreach ($activeJobs as $job)
            @php
                $statusLabel = __('active-jobs.status.' . $job['status_key']);
                $jobTypeLabel = __('active-jobs.job_type.' . $job['job_type_key']);
                $isInProgress = $job['status_key'] === 'in_progress';
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
                                {{ $statusLabel }}
                            </span>
                            <span class="text-gray-300">|</span>
                            <span>{{ __('active-jobs.labels.client') }}: {{ $job['client'] }}</span>
                            <span class="text-gray-300">|</span>
                            <span>{{ __('active-jobs.labels.deadline') }}: {{ $job['deadline'] }}</span>
                        </div>
                        <div class="mt-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>{{ __('active-jobs.labels.progress') }}</span>
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
                            data-title="{{ $job['title'] }}" data-status="{{ $statusLabel }}"
                            data-client="{{ $job['client'] }}" data-amount="{{ $job['amount'] }}"
                            data-progress="{{ $job['progress'] }}" data-deadline="{{ $job['deadline'] }}"
                            data-type="{{ $jobTypeLabel }}" data-started="{{ $job['started'] }}"
                            data-milestone="{{ $job['milestone'] }}" data-next-due="{{ $job['next_due'] }}"
                            data-notes="{{ $job['notes'] }}">
                            {{ __('active-jobs.buttons.view_details') }}
                        </button>
                        <button type="button"
                            class="px-3 py-2 text-sm font-medium bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            {{ __('active-jobs.buttons.message') }}
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
                        <h3 class="text-lg font-bold text-gray-900" id="active-job-title">{{ __('active-jobs.modal.title') }}</h3>
                        <p class="text-sm text-gray-500 mt-1" id="active-job-client">{{ __('active-jobs.modal.client_fallback') }}</p>
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
                            {{ __('active-jobs.modal.status_fallback') }}
                        </span>
                        <span class="text-xs text-gray-500">{{ __('active-jobs.labels.type') }}:</span>
                        <span class="text-xs font-medium text-gray-900" id="active-job-type"></span>
                        <span class="text-sm text-gray-500">{{ __('active-jobs.labels.deadline') }}:</span>
                        <span class="text-sm font-medium text-gray-900" id="active-job-deadline"></span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('active-jobs.labels.budget') }}</p>
                            <p class="text-base font-semibold text-gray-900" id="active-job-amount"></p>
                        </div>
                        <div class="sm:text-right">
                            <p class="text-sm text-gray-500">{{ __('active-jobs.labels.progress') }}</p>
                            <p class="text-base font-semibold text-gray-900" id="active-job-progress-text"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('active-jobs.labels.started') }}</p>
                            <p class="text-base font-semibold text-gray-900" id="active-job-started"></p>
                        </div>
                        <div class="sm:text-right">
                            <p class="text-sm text-gray-500">{{ __('active-jobs.labels.next_milestone') }}</p>
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
                        <p class="text-sm font-semibold text-gray-900 mb-1">{{ __('active-jobs.labels.notes') }}</p>
                        <p class="text-sm text-gray-600" id="active-job-notes"></p>
                    </div>
                    <div class="flex flex-wrap gap-2 pt-2">
                        <button type="button"
                            class="px-3 py-2 text-sm font-medium bg-gray-900 text-white rounded-lg hover:bg-black">
                            {{ __('active-jobs.buttons.open_contract') }}
                        </button>
                        <button type="button"
                            class="px-3 py-2 text-sm font-medium bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            {{ __('active-jobs.buttons.message_client') }}
                        </button>
                        <button type="button"
                            class="px-3 py-2 text-sm font-medium bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100">
                            {{ __('active-jobs.buttons.add_milestone') }}
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
            const i18n = {
                clientLabel: @json(__('active-jobs.labels.client')),
                nextDueLabel: @json(__('active-jobs.labels.next_due'))
            };

            const modal = document.getElementById('active-job-modal');
            const backdrop = document.getElementById('active-job-backdrop');
            const content = document.getElementById('active-job-content');
            const closeBtn = document.getElementById('active-job-close');
            const buttons = document.querySelectorAll('.view-details-btn');

            function openModal(data) {
                document.getElementById('active-job-title').textContent = data.title;
                document.getElementById('active-job-client').textContent = `${i18n.clientLabel}: ${data.client}`;
                document.getElementById('active-job-deadline').textContent = data.deadline;
                document.getElementById('active-job-amount').textContent = data.amount;
                document.getElementById('active-job-progress-text').textContent = `${data.progress}%`;
                document.getElementById('active-job-progress-bar').style.width = `${data.progress}%`;
                document.getElementById('active-job-status').textContent = data.status;
                document.getElementById('active-job-type').textContent = data.type;
                document.getElementById('active-job-started').textContent = data.started;
                document.getElementById('active-job-milestone').textContent = data.milestone;
                document.getElementById('active-job-next-due').textContent = `${i18n.nextDueLabel}: ${data.nextDue}`;
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
