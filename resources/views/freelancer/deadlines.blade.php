@extends('layouts.app')

@section('title', __('deadlines.meta.title'))

@section('content')
    <div class="mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('deadlines.header.title') }}</h1>
                <p class="text-gray-600 mt-1">{{ __('deadlines.header.subtitle') }}</p>
            </div>
        </div>
    </div>

    @php
        $deadlines = trans('deadlines.sample_deadlines');
    @endphp

    <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
        <div class="flex flex-wrap gap-2" id="deadline-filters" role="tablist">
            <button type="button" data-filter="all"
                class="px-3 py-1.5 rounded-full text-sm font-medium bg-gray-900 text-white">
                {{ __('deadlines.filters.all') }}
            </button>
            <button type="button" data-filter="today"
                class="px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">
                {{ __('deadlines.filters.today') }}
            </button>
            <button type="button" data-filter="week"
                class="px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">
                {{ __('deadlines.filters.this_week') }}
            </button>
            <button type="button" data-filter="overdue"
                class="px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">
                {{ __('deadlines.filters.overdue') }}
            </button>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <label for="deadline-sort" class="font-medium text-gray-700">{{ __('deadlines.sort.label') }}</label>
                <select id="deadline-sort"
                    class="rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-sm text-gray-700 focus:ring-2 focus:ring-blue-200 focus:border-blue-300">
                    <option value="soonest">{{ __('deadlines.sort.soonest') }}</option>
                    <option value="latest">{{ __('deadlines.sort.latest') }}</option>
                    <option value="client">{{ __('deadlines.sort.client') }}</option>
                    <option value="project">{{ __('deadlines.sort.project') }}</option>
                </select>
            </div>
            <div class="flex items-center gap-1 text-sm">
                <button type="button" data-view="list" class="px-3 py-1.5 rounded-lg bg-gray-900 text-white font-medium">
                    {{ __('deadlines.view.list') }}
                </button>
                <button type="button" data-view="timeline"
                    class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200">
                    {{ __('deadlines.view.timeline') }}
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200" id="deadlines-card" data-view="list">
        <div class="divide-y divide-gray-200" id="deadlines-list">
            @foreach ($deadlines as $deadline)
                @php
                    $isOverdue = $deadline['days'] < 0;
                    $isDueSoon = !$isOverdue && $deadline['days'] <= 2;
                    $statusKey = $isOverdue ? 'overdue' : ($isDueSoon ? 'due_soon' : 'on_track');
                    $statusLabel = __('deadlines.status.' . $statusKey);
                    $badgeClasses = $isOverdue
                        ? 'bg-red-100 text-red-700'
                        : ($isDueSoon
                            ? 'bg-amber-100 text-amber-700'
                            : 'bg-blue-100 text-blue-700');

                    $filterBucket = $isOverdue ? 'overdue' : ($deadline['days'] === 0 ? 'today' : 'week');
                    $normalizedTitle = \Illuminate\Support\Str::lower($deadline['title']);
                @endphp
                <div class="p-5 flex flex-col lg:flex-row lg:items-start justify-between gap-6 deadline-item"
                    data-days="{{ $deadline['days'] }}" data-status="{{ $filterBucket }}"
                    data-title="{{ $normalizedTitle }}" data-client="client"
                    data-project="{{ $normalizedTitle }}">
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-3 mb-2">
                            <h3 class="text-base font-semibold text-gray-900">{{ $deadline['title'] }}</h3>
                            <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $badgeClasses }}">
                                {{ $statusLabel }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">{{ $deadline['desc'] }}</p>
                        <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ $deadline['date'] }}
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('find-jobs') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    {{ __('deadlines.links.job') }}
                                </a>
                                <span class="text-gray-300">|</span>
                                <a href="{{ route('dashboard') }}#freelancer-active-jobs"
                                    class="text-blue-600 hover:text-blue-800 font-medium">
                                    {{ __('deadlines.links.contract') }}
                                </a>
                                <span class="text-gray-300">|</span>
                                <a href="{{ route('messages.index') }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium">
                                    {{ __('deadlines.links.messages') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">
                            {{ trans_choice('deadlines.labels.due_in_days', $deadline['days'], ['count' => $deadline['days']]) }}
                        </p>
                        <div class="mt-3 flex flex-col items-end gap-2">
                            <button type="button"
                                class="text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
                                {{ __('deadlines.buttons.reminders_on') }}
                            </button>
                            <div class="flex items-center gap-2">
                                <button type="button"
                                    class="text-xs font-medium px-2.5 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100">
                                    {{ __('deadlines.buttons.mark_done') }}
                                </button>
                                <button type="button"
                                    class="text-xs font-medium px-2.5 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100">
                                    {{ __('deadlines.buttons.request_extension') }}
                                </button>
                                <button type="button"
                                    class="text-xs font-medium px-2.5 py-1.5 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">
                                    {{ __('deadlines.buttons.send_update') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="deadlines-empty" class="hidden p-8 text-center">
            <p class="text-gray-600 text-sm">{{ __('deadlines.empty_state.no_upcoming') }}</p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const list = document.getElementById('deadlines-list');
            const items = Array.from(document.querySelectorAll('.deadline-item'));
            const emptyState = document.getElementById('deadlines-empty');
            const filters = document.querySelectorAll('#deadline-filters button');
            const sortSelect = document.getElementById('deadline-sort');
            const viewButtons = document.querySelectorAll('[data-view]');
            const card = document.getElementById('deadlines-card');

            let activeFilter = 'all';
            let activeView = 'list';

            function updateEmptyState(visibleCount) {
                if (visibleCount === 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }

            function applyFilter() {
                let visible = 0;
                items.forEach(item => {
                    const days = parseInt(item.dataset.days, 10);
                    const status = item.dataset.status;

                    let show = true;
                    if (activeFilter === 'today') {
                        show = days === 0;
                    } else if (activeFilter === 'week') {
                        show = days >= 0 && days <= 7;
                    } else if (activeFilter === 'overdue') {
                        show = status === 'overdue';
                    }

                    item.classList.toggle('hidden', !show);
                    if (show) visible += 1;
                });
                updateEmptyState(visible);
            }

            function applySort() {
                const sorted = [...items].sort((a, b) => {
                    const aDays = parseInt(a.dataset.days, 10);
                    const bDays = parseInt(b.dataset.days, 10);
                    const aTitle = a.dataset.title;
                    const bTitle = b.dataset.title;

                    switch (sortSelect.value) {
                        case 'latest':
                            return bDays - aDays;
                        case 'client':
                            return aTitle.localeCompare(bTitle);
                        case 'project':
                            return aTitle.localeCompare(bTitle);
                        default:
                            return aDays - bDays;
                    }
                });

                sorted.forEach(item => list.appendChild(item));
            }

            function applyView() {
                if (activeView === 'timeline') {
                    list.classList.remove('divide-y', 'divide-gray-200');
                    list.classList.add('space-y-4', 'p-4');
                    items.forEach(item => {
                        item.classList.add('rounded-xl', 'border', 'border-gray-200');
                    });
                } else {
                    list.classList.add('divide-y', 'divide-gray-200');
                    list.classList.remove('space-y-4', 'p-4');
                    items.forEach(item => {
                        item.classList.remove('rounded-xl', 'border', 'border-gray-200');
                    });
                }
            }

            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    viewButtons.forEach(btn => {
                        btn.classList.remove('bg-gray-900', 'text-white');
                        btn.classList.add('bg-gray-100', 'text-gray-700');
                    });
                    this.classList.add('bg-gray-900', 'text-white');
                    this.classList.remove('bg-gray-100', 'text-gray-700');
                    activeView = this.dataset.view;
                    applyView();
                });
            });

            filters.forEach(button => {
                button.addEventListener('click', function() {
                    filters.forEach(btn => {
                        btn.classList.remove('bg-gray-900', 'text-white');
                        btn.classList.add('bg-gray-100', 'text-gray-700');
                    });
                    this.classList.add('bg-gray-900', 'text-white');
                    this.classList.remove('bg-gray-100', 'text-gray-700');

                    activeFilter = this.dataset.filter;
                    applyFilter();
                });
            });

            sortSelect.addEventListener('change', function() {
                applySort();
                applyFilter();
            });

            applySort();
            applyFilter();
            applyView();
        });
    </script>
@endpush
