@extends('layouts.app')

@section('title', __('find-jobs.meta.title'))

@section('content')
    <!-- Page Header -->
    <div class="mb-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('find-jobs.header.title') }}</h1>
            <p class="text-gray-600 mt-1">
                {{ __('find-jobs.header.subtitle') }}
            </p>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-3">
        <div class="flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0">
            <!-- Tabs -->
            <div class="flex space-x-6 overflow-x-auto select-none">
                <button onclick="filterJobs('all')" id="tab-all"
                    class="pb-2 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap border-b-2 border-blue-600">
                    {{ __('find-jobs.tabs.all_jobs') }}
                </button>
                <button onclick="filterJobs('saved')" id="tab-saved"
                    class="pb-2 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap">
                    {{ __('find-jobs.tabs.saved_jobs') }}
                </button>
                <button onclick="filterJobs('in_progress')" id="tab-in_progress"
                    class="pb-2 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap">
                    {{ __('find-jobs.tabs.in_progress') }}
                </button>
                <button onclick="filterJobs('applied')" id="tab-applied"
                    class="pb-2 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap">
                    {{ __('find-jobs.tabs.applied_jobs') }}
                </button>
            </div>

            <!-- Search and Filter -->
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="{{ __('find-jobs.filters.search_placeholder') }}" id="job-search"
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm w-64">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <button id="filter-toggle"
                    class="flex items-center space-x-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm select-none">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span>{{ __('find-jobs.filters.filter') }}</span>
                </button>
            </div>
        </div>

        <!-- Advanced Filters (Hidden by default) -->
        <div id="advanced-filters" class="hidden mt-4 pt-4 border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('find-jobs.filters.job_type') }}</label>
                    <select id="filter-type"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">{{ __('find-jobs.filters.all_types') }}</option>
                        <option value="fixed">{{ __('find-jobs.filters.fixed_price') }}</option>
                        <option value="hourly">{{ __('find-jobs.filters.hourly') }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('find-jobs.filters.experience_level') }}</label>
                    <select id="filter-experience"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">{{ __('find-jobs.filters.all_levels') }}</option>
                        <option value="entry">{{ __('find-jobs.filters.entry_level') }}</option>
                        <option value="intermediate">{{ __('find-jobs.filters.intermediate') }}</option>
                        <option value="expert">{{ __('find-jobs.filters.expert') }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('find-jobs.filters.duration') }}</label>
                    <select id="filter-duration"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">{{ __('find-jobs.filters.any_duration') }}</option>
                        <option value="less_than_1_month">{{ __('find-jobs.filters.less_than_1_month') }}</option>
                        <option value="1_to_3_months">{{ __('find-jobs.filters.one_to_three_months') }}</option>
                        <option value="3_to_6_months">{{ __('find-jobs.filters.three_to_six_months') }}</option>
                        <option value="more_than_6_months">{{ __('find-jobs.filters.more_than_6_months') }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('find-jobs.filters.sort_by') }}</label>
                    <select id="filter-sort"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="newest">{{ __('find-jobs.filters.newest_first') }}</option>
                        <option value="oldest">{{ __('find-jobs.filters.oldest_first') }}</option>
                        <option value="budget_high">{{ __('find-jobs.filters.budget_high_to_low') }}</option>
                        <option value="budget_low">{{ __('find-jobs.filters.budget_low_to_high') }}</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-4 select-none">
                <button id="clear-filters" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm">
                    {{ __('find-jobs.filters.clear_all') }}
                </button>
                <button id="apply-filters" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                    {{ __('find-jobs.filters.apply_filters') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Job Details Modal -->
    <div id="job-details-modal" class="fixed inset-0 z-50 hidden transition-opacity duration-300">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300 ease-out" id="modal-backdrop">
        </div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all duration-300 ease-out sm:my-8 sm:w-full sm:max-w-4xl w-full translate-y-4 opacity-0 scale-95"
                id="modal-content">
                <!-- Modal Header -->
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-gray-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900" id="modal-title">{{ __('find-jobs.modals.job_details.title') }}</h3>
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

                <!-- Modal Content -->
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 overflow-y-auto max-h-[68vh]">
                    <div class="space-y-6">
                        <!-- Job Title -->
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

                        <!-- Job Description -->
                        <div class="bg-gray-50 rounded-lg p-3">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ __('find-jobs.modals.job_details.job_description') }}</h3>
                            <div class="text-sm max-w-none text-gray-700" id="modal-description"></div>
                        </div>

                        <!-- Skills Required -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ __('find-jobs.modals.job_details.skills_required') }}</h3>
                            <div class="flex flex-wrap gap-2" id="modal-skills"></div>
                        </div>

                        <!-- Job Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">{{ __('find-jobs.modals.job_details.job_type') }}</h4>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span id="modal-detail-type" class="text-sm text-gray-700"></span>
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">{{ __('find-jobs.modals.job_details.experience_level') }}</h4>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span id="modal-detail-experience" class="text-sm text-gray-700"></span>
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">{{ __('find-jobs.modals.job_details.timeline') }}</h4>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span id="modal-detail-duration" class="text-sm text-gray-700"></span>
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">{{ __('find-jobs.modals.job_details.proposals') }}</h4>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span id="modal-proposals-count" class="text-sm text-gray-700"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div
                    class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-3 border-t border-gray-200 select-none">
                    <button type="button" id="update-job-btn"
                        class="hidden w-full justify-center rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-black sm:w-auto transition duration-200">
                        {{ __('find-jobs.modals.job_details.update_proposal') }}
                    </button>
                    <button type="button" id="apply-job-btn"
                        class="inline-flex w-full justify-center rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-black sm:w-auto transition duration-200">
                        {{ __('find-jobs.modals.job_details.apply_job') }}
                    </button>
                    <button type="button" id="save-job-btn"
                        class="px-4 py-2 flex items-center border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 text-sm font-medium">
                        {{ __('find-jobs.modals.job_details.save_job') }}
                    </button>
                    <button type="button" id="cancel-modal"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 text-sm font-medium">
                        {{ __('find-jobs.common.cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Proposal Submission Modal -->
    <div id="proposal-modal" class="fixed inset-0 z-[60] hidden transition-opacity duration-300">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300 ease-out" id="proposal-backdrop">
        </div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all duration-300 ease-out sm:my-8 sm:w-full sm:max-w-2xl w-full translate-y-4 opacity-0 scale-95"
                id="proposal-content">
                <!-- Modal Header -->
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-gray-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900" id="proposal-modal-title">{{ __('find-jobs.modals.proposal.submit_title') }}</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">{{ __('find-jobs.modals.proposal.job_label') }}: <span id="proposal-job-title"
                                        class="font-medium"></span></p>
                                <p class="text-xs text-gray-500 mt-1">{{ __('find-jobs.modals.proposal.help_text') }}</p>
                            </div>
                        </div>
                        <button type="button" id="close-proposal-modal"
                            class="text-gray-400 hover:text-gray-500 rounded-lg p-2 transition-colors duration-200">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Content - Form -->
                <form id="proposal-form">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-0 sm:pb-4 overflow-y-auto max-h-[60vh]">
                        <div class="space-y-4">
                            <!-- Hidden job ID -->
                            <input type="hidden" id="proposal-job-id" name="job_id">

                            <!-- Proposal Text -->
                            <div>
                                <label for="proposal-text" class="block text-sm font-medium text-gray-900 mb-2">
                                    {{ __('find-jobs.modals.proposal.details_label') }} <span class="text-red-500">*</span>
                                </label>
                                <textarea id="proposal-text" name="proposal_text" rows="6"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 text-sm"
                                    placeholder="{{ __('find-jobs.modals.proposal.details_placeholder') }}"></textarea>
                            </div>

                            <!-- Bid Amount -->
                            <div>
                                <label for="bid-amount" class="block text-sm font-medium text-gray-900 mb-2">
                                    {{ __('find-jobs.modals.proposal.bid_amount_label') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" id="bid-amount" name="bid_amount" step="0.01"
                                        min="1"
                                        class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 text-sm"
                                        placeholder="{{ __('find-jobs.common.amount_placeholder') }}">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ __('find-jobs.modals.proposal.bid_amount_help') }}
                                    <span id="min_max_budget"></span></p>
                            </div>

                            <!-- Estimated Timeline (Optional) -->
                            <div>
                                <label for="estimated-timeline" class="block text-sm font-medium text-gray-900 mb-2">
                                    {{ __('find-jobs.modals.proposal.estimated_timeline_label') }}
                                </label>
                                <select name="estimated_timeline" id="estimated-timeline"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 text-sm">
                                    <option value="2 weeks">{{ __('find-jobs.timeline.two_weeks') }}</option>
                                    <option value="3-4 weeks">{{ __('find-jobs.timeline.three_four_weeks') }}</option>
                                    <option value="1-2 months">{{ __('find-jobs.timeline.one_two_months') }}</option>
                                    <option value="3-6 months">{{ __('find-jobs.timeline.three_six_months') }}</option>
                                    <option value="more than 6 months">{{ __('find-jobs.timeline.more_than_six_months') }}</option>
                                    <option value="not sure">{{ __('find-jobs.timeline.not_sure') }}</option>
                                    <option value="ongoing support">{{ __('find-jobs.timeline.ongoing_support') }}</option>
                                    <option value="to be discussed" selected>{{ __('find-jobs.timeline.to_be_discussed_default') }}</option>
                                </select>
                            </div>

                            <!-- Error Message Container -->
                            <div id="proposal-error" class="hidden p-3 bg-red-50 border border-red-200 rounded-lg">
                                <p class="text-sm text-red-600" id="proposal-error-text"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div
                        class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-3 border-t border-gray-200 select-none">
                        <button type="submit" id="submit-proposal-btn"
                            class="inline-flex w-full items-center justify-center rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-black sm:w-auto transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <div id="submitSpinner"
                                class="hidden w-5 h-5 border-t-2 border-white rounded-full animate-spin mr-2">
                            </div>
                            <span id="submit-proposal-text">{{ __('find-jobs.modals.proposal.submit_button') }}</span>
                        </button>
                        <button type="button" id="cancel-proposal-modal"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 text-sm font-medium">
                            {{ __('find-jobs.common.cancel') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Proposal Update Modal -->
    <div id="proposal-update-modal" class="fixed inset-0 z-[60] hidden transition-opacity duration-300">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300 ease-out"
            id="update-proposal-backdrop">
        </div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all duration-300 ease-out sm:my-8 sm:w-full sm:max-w-2xl w-full translate-y-4 opacity-0 scale-95"
                id="update-proposal-content">
                <!-- Modal Header -->
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-gray-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900">{{ __('find-jobs.modals.update_proposal.title') }}</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">{{ __('find-jobs.modals.proposal.job_label') }}: <span id="update-proposal-job-title"
                                        class="font-medium"></span></p>
                                <p class="text-xs text-gray-500 mt-1">{{ __('find-jobs.modals.update_proposal.help_text') }}</p>
                            </div>
                        </div>
                        <button type="button" id="close-update-proposal-modal"
                            class="text-gray-400 hover:text-gray-500 rounded-lg p-2 transition-colors duration-200">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Content - Form -->
                <form id="update-proposal-form">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-0 sm:pb-4 overflow-y-auto max-h-[60vh]">
                        <div class="space-y-4">
                            <!-- Hidden job ID and proposal ID -->
                            <input type="hidden" id="update-proposal-job-id" name="job_id">
                            <input type="hidden" id="update-proposal-id" name="proposal_id">

                            <!-- Proposal Text -->
                            <div>
                                <label for="update-proposal-text" class="block text-sm font-medium text-gray-900 mb-2">
                                    {{ __('find-jobs.modals.proposal.details_label') }} <span class="text-red-500">*</span>
                                </label>
                                <textarea id="update-proposal-text" name="proposal_text" rows="6"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 text-sm"
                                    placeholder="{{ __('find-jobs.modals.proposal.details_placeholder') }}"></textarea>
                            </div>

                            <!-- Bid Amount -->
                            <div>
                                <label for="update-bid-amount" class="block text-sm font-medium text-gray-900 mb-2">
                                    {{ __('find-jobs.modals.proposal.bid_amount_label') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" id="update-bid-amount" name="bid_amount" step="0.01"
                                        min="1"
                                        class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 text-sm"
                                        placeholder="{{ __('find-jobs.common.amount_placeholder') }}">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ __('find-jobs.modals.proposal.bid_amount_help') }}
                                    <span id="update-min_max_budget"></span></p>
                            </div>

                            <!-- Estimated Timeline (Optional) -->
                            <div>
                                <label for="update-estimated-timeline"
                                    class="block text-sm font-medium text-gray-900 mb-2">
                                    {{ __('find-jobs.modals.proposal.estimated_timeline_label') }}
                                </label>
                                <select name="estimated_timeline" id="update-estimated-timeline"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 text-sm">
                                    <option value="2 weeks">{{ __('find-jobs.timeline.two_weeks') }}</option>
                                    <option value="3-4 weeks">{{ __('find-jobs.timeline.three_four_weeks') }}</option>
                                    <option value="1-2 months">{{ __('find-jobs.timeline.one_two_months') }}</option>
                                    <option value="3-6 months">{{ __('find-jobs.timeline.three_six_months') }}</option>
                                    <option value="more than 6 months">{{ __('find-jobs.timeline.more_than_six_months') }}</option>
                                    <option value="not sure">{{ __('find-jobs.timeline.not_sure') }}</option>
                                    <option value="ongoing support">{{ __('find-jobs.timeline.ongoing_support') }}</option>
                                    <option value="to be discussed">{{ __('find-jobs.timeline.to_be_discussed_default') }}</option>
                                </select>
                            </div>

                            <!-- Error Message Container -->
                            <div id="update-proposal-error" class="hidden p-3 bg-red-50 border border-red-200 rounded-lg">
                                <p class="text-sm text-red-600" id="update-proposal-error-text"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div
                        class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-3 border-t border-gray-200 select-none">
                        <button type="submit" id="submit-update-proposal-btn"
                            class="inline-flex w-full items-center justify-center rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-black sm:w-auto transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <div id="update-submitSpinner"
                                class="hidden w-5 h-5 border-t-2 border-white rounded-full animate-spin mr-2">
                            </div>
                            <span id="submit-update-proposal-text">{{ __('find-jobs.modals.update_proposal.submit_button') }}</span>
                        </button>
                        <button type="submit" id="submit-withdraw-proposal-btn"
                            class="inline-flex w-full items-center justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 sm:w-auto transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <div id="withdraw-submitSpinner"
                                class="hidden w-5 h-5 border-t-2 border-white rounded-full animate-spin mr-2">
                            </div>
                            <span id="submit-withdraw-proposal-text">{{ __('find-jobs.modals.update_proposal.withdraw_button') }}</span>
                        </button>
                        <button type="button" id="cancel-proposal-update-modal"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 text-sm font-medium">
                            {{ __('find-jobs.common.cancel') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Jobs Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3" id="jobs-container">
        <!-- Job Card Template (Hidden) -->
        <template id="job-card-template">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200 cursor-pointer h-full flex flex-col"
                data-status="open" data-type="fixed" data-experience="expert" data-duration="3_to_6_months">
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <a href="#" class="client-profile-link inline-flex items-center gap-3 group"
                                    onclick="event.stopPropagation();">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center overflow-hidden select-none">
                                        <img src="" alt="{{ __('find-jobs.job_card.client_photo_alt') }}"
                                            class="client-avatar-image w-full h-full object-cover hidden">
                                        <span class="client-avatar-initial text-white text-sm font-bold">{{ __('find-jobs.job_card.client_initial') }}</span>
                                    </div>
                                    <div>
                                        <p
                                            class="text-sm font-semibold text-gray-900 group-hover:text-blue-700 client-name">
                                            {{ __('find-jobs.job_card.client_name') }}</p>
                                        <p class="text-xs text-gray-500 client-company">{{ __('find-jobs.job_card.client_company') }}</p>
                                    </div>
                                </a>
                                <div class="flex items-center gap-2">
                                    <div class="relative">
                                        <button type="button"
                                            class="job-more-btn w-8 h-8 rounded-full border border-gray-200 hover:bg-gray-50 text-gray-700 flex items-center justify-center"
                                            onclick="event.stopPropagation();">
                                            <i class="ri-more-line font-bold"></i>
                                        </button>
                                        <div
                                            class="job-more-menu hidden absolute right-0 top-9 z-30 w-36 rounded-lg border border-gray-200 bg-white shadow-lg py-1">
                                            <button type="button"
                                                class="menu-save-btn w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                                                onclick="event.stopPropagation();">
                                                <span class="inline-flex items-center gap-2">
                                                    <i class="ri-bookmark-line"></i>
                                                    <span>{{ __('find-jobs.job_card.menu.save') }}</span>
                                                </span>
                                            </button>
                                            <button type="button"
                                                class="menu-not-for-me-btn w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200"
                                                onclick="event.stopPropagation();">
                                                <span class="inline-flex items-center gap-2">
                                                    <i class="ri-forbid-2-line"></i>
                                                    <span>{{ __('find-jobs.job_card.menu.not_for_me') }}</span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 select-none status-badge">
                                    {{ __('find-jobs.job_card.status.open') }}
                                </span>
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs text-gray-500 posted-time">{{ __('find-jobs.job_card.posted_prefix') }} {{ __('find-jobs.time.just_now') }}</span>
                                </div>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2 text-lg job-title">{{ __('find-jobs.job_card.untitled_job') }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2 job-description">
                                {{ __('find-jobs.job_card.no_description') }}
                            </p>
                            <div class="flex flex-wrap gap-2 mb-4 select-none skills-container">
                                <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">{{ __('find-jobs.job_card.no_skills_required') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <div class="flex flex-col lg:flex-row lg:items-start xl:items-center justify-between gap-4">
                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:space-x-6 space-y-3 sm:space-y-0 min-w-0 flex-1">
                                <div class="flex items-center min-w-0 flex-wrap">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                    <span class="font-semibold text-gray-900 budget-amount break-words">{{ __('find-jobs.job_card.budget_not_specified') }}</span>
                                    <span class="text-gray-500 text-sm ml-2 job-type whitespace-nowrap">{{ __('find-jobs.job_card.not_specified') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-gray-600 text-sm duration-text">{{ __('find-jobs.job_card.duration_not_specified') }}</span>
                                </div>
                            </div>
                            <button
                                class="w-full sm:w-auto px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm font-medium transition duration-200 flex items-center justify-center select-none view-job-btn shrink-0 min-w-[130px]">
                                <span class="whitespace-nowrap">{{ __('find-jobs.job_card.view_job') }}</span>
                                <span
                                    class="ml-2 bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full views-count shrink-0">0</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Skeleton Loading Template -->
        <template id="skeleton-template">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 h-full flex flex-col">
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <!-- Status Badge Skeleton -->
                                <div class="w-16 h-6 bg-gray-200 rounded-full animate-pulse"></div>
                                <div class="flex items-center space-x-2">
                                    <!-- Posted Time Skeleton -->
                                    <div class="w-24 h-4 bg-gray-200 rounded animate-pulse"></div>
                                    <!-- Menu Button Skeleton -->
                                    <div class="w-5 h-5 bg-gray-200 rounded animate-pulse"></div>
                                </div>
                            </div>
                            <!-- Title Skeleton -->
                            <div class="w-3/4 h-6 bg-gray-200 rounded mb-2 animate-pulse"></div>
                            <!-- Description Skeleton -->
                            <div class="space-y-2 mb-6">
                                <div class="w-full h-4 bg-gray-200 rounded animate-pulse"></div>
                                <div class="w-2/3 h-4 bg-gray-200 rounded animate-pulse"></div>
                            </div>
                            <!-- Skills Skeleton -->
                            <div class="flex flex-wrap gap-2 mb-3">
                                <div class="w-20 h-6 bg-gray-200 rounded animate-pulse"></div>
                                <div class="w-16 h-6 bg-gray-200 rounded animate-pulse"></div>
                                <div class="w-24 h-6 bg-gray-200 rounded animate-pulse"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-6 space-y-3 sm:space-y-0">
                                <!-- Budget Section Skeleton -->
                                <div class="flex items-center">
                                    <div class="w-5 h-5 bg-gray-200 rounded mr-2 animate-pulse"></div>
                                    <div class="w-32 h-5 bg-gray-200 rounded animate-pulse"></div>
                                </div>
                                <!-- Duration Section Skeleton -->
                                <div class="flex items-center">
                                    <div class="w-5 h-5 bg-gray-200 rounded mr-2 animate-pulse"></div>
                                    <div class="w-24 h-4 bg-gray-200 rounded animate-pulse"></div>
                                </div>
                            </div>
                            <!-- View Job Button Skeleton -->
                            <div class="w-full sm:w-40 shrink-0">
                                <div class="w-full h-10 bg-gray-200 rounded-lg animate-pulse"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        {{-- Container for displaying jobs --}}
        <div id="jobs-container" class="space-y-6">
            <!-- Jobs will be dynamically inserted here -->
        </div>
    </div>

    <!-- Empty State (Hidden by default) -->
    <div id="empty-state" class="hidden text-center py-12">
        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ __('find-jobs.empty_state.title') }}</h3>
        <p class="text-gray-600 mb-6 max-w-md mx-auto">
            {{ __('find-jobs.empty_state.description') }}
        </p>
        <button id="clear-all-filters"
            class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm font-medium">
            {{ __('find-jobs.empty_state.clear_all_filters') }}
        </button>
    </div>

    <!-- Pagination -->
    <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-200">
        <div class="text-sm text-gray-700">
            {{ __('find-jobs.pagination.showing') }} <span id="showing-from">1</span> {{ __('find-jobs.pagination.to') }}
            <span id="showing-to">6</span> {{ __('find-jobs.pagination.of') }} <span id="total-jobs">12</span>
            {{ __('find-jobs.pagination.jobs') }}
        </div>
        <div class="flex items-center space-x-2">
            <button
                class="px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                id="prev-page" disabled>
                {{ __('find-jobs.pagination.previous') }}
            </button>
            <div class="flex items-center space-x-1">
                <button class="w-8 h-8 rounded-lg bg-blue-600 text-white text-sm font-medium">1</button>
                <button class="w-8 h-8 rounded-lg text-gray-700 hover:bg-gray-100 text-sm font-medium">2</button>
            </div>
            <button class="px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50"
                id="next-page">
                {{ __('find-jobs.pagination.next') }}
            </button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar')?.classList.toggle('active');
        });

        // Filter toggle functionality
        document.getElementById('filter-toggle')?.addEventListener('click', function() {
            const filters = document.getElementById('advanced-filters');
            filters.classList.toggle('hidden');
        });

        // Global variables to store jobs data
        let allJobsData = [];
        let savedJobsData = [];
        let inProgressJobsData = [];
        let appliedJobsData = [];
        let currentTab = 'all';
        let isInitialLoad = true;
        let jobViewsRealtimeInterval = null;
        let dismissedJobIds = new Set();
        const queryParams = new URLSearchParams(window.location.search);
        const deepLinkJobId = queryParams.get('job');
        let hasHandledDeepLinkJob = false;

        try {
            const dismissed = JSON.parse(localStorage.getItem('dismissed_job_ids') || '[]');
            if (Array.isArray(dismissed)) {
                dismissedJobIds = new Set(dismissed);
            }
        } catch (e) {
            dismissedJobIds = new Set();
        }

        const i18n = {
            networkResponseNotOk: @json(__('find-jobs.js.network_response_not_ok')),
            failedFetchJobDetails: @json(__('find-jobs.js.failed_fetch_job_details')),
            failedLoadJobDetails: @json(__('find-jobs.js.failed_load_job_details')),
            failedFetchProposal: @json(__('find-jobs.js.failed_fetch_proposal')),
            proposalNotFound: @json(__('find-jobs.js.proposal_not_found')),
            failedLoadProposalDetails: @json(__('find-jobs.js.failed_load_proposal_details')),
            failedSaveJob: @json(__('find-jobs.js.failed_save_job')),
            noJobsFoundSimple: @json(__('find-jobs.js.no_jobs_found')),
            unknownClient: @json(__('find-jobs.js.unknown_client')),
            independentClient: @json(__('find-jobs.js.independent_client')),
            noSkillsSpecified: @json(__('find-jobs.js.no_skills_specified')),
            moreSkills: @json(__('find-jobs.js.more_skills', ['count' => ':count'])),
            unableToSaveJob: @json(__('find-jobs.js.unable_save_job')),
            errorLoadingJobs: @json(__('find-jobs.js.error_loading_jobs')),
            errorLoadingSavedJobs: @json(__('find-jobs.js.error_loading_saved_jobs')),
            errorLoadingInProgressJobs: @json(__('find-jobs.js.error_loading_in_progress_jobs')),
            errorLoadingAppliedJobs: @json(__('find-jobs.js.error_loading_applied_jobs')),
            failedFetchJobs: @json(__('find-jobs.js.failed_fetch_jobs', ['type' => ':type'])),
            retry: @json(__('find-jobs.common.retry')),
            saveMenu: @json(__('find-jobs.job_card.menu.save')),
            unsaveMenu: @json(__('find-jobs.job_card.menu.unsave')),
            postedPrefix: @json(__('find-jobs.job_card.posted_prefix')),
            untitledJob: @json(__('find-jobs.job_card.untitled_job')),
            noDescription: @json(__('find-jobs.job_card.no_description')),
            noSkillsRequired: @json(__('find-jobs.job_card.no_skills_required')),
            budgetNotSpecified: @json(__('find-jobs.job_card.budget_not_specified')),
            durationNotSpecified: @json(__('find-jobs.job_card.duration_not_specified')),
            notSpecified: @json(__('find-jobs.job_card.not_specified')),
            experienceNotSpecified: @json(__('find-jobs.js.experience_not_specified')),
            jobDetailsTitle: @json(__('find-jobs.modals.job_details.title')),
            saveJob: @json(__('find-jobs.modals.job_details.save_job')),
            unsaveJob: @json(__('find-jobs.modals.job_details.unsave_job')),
            applyJob: @json(__('find-jobs.modals.job_details.apply_job')),
            updateProposal: @json(__('find-jobs.modals.job_details.update_proposal')),
            proposalsCount: @json(__('find-jobs.js.proposals_count', ['count' => ':count'])),
            zeroProposal: @json(__('find-jobs.js.zero_proposal')),
            proposalMinValidation: @json(__('find-jobs.js.proposal_min_validation', ['min' => ':min'])),
            charactersCount: @json(__('find-jobs.js.characters_count', ['count' => ':count'])),
            charactersCountMinimum: @json(__('find-jobs.js.characters_count_minimum', ['count' => ':count', 'min' => ':min'])),
            validBidAmount: @json(__('find-jobs.js.valid_bid_amount')),
            submitting: @json(__('find-jobs.js.submitting')),
            submitProposal: @json(__('find-jobs.modals.proposal.submit_button')),
            proposalSubmitted: @json(__('find-jobs.js.proposal_submitted')),
            failedSubmitProposal: @json(__('find-jobs.js.failed_submit_proposal')),
            failedSubmitProposalRetry: @json(__('find-jobs.js.failed_submit_proposal_retry')),
            updating: @json(__('find-jobs.js.updating')),
            updateProposalButton: @json(__('find-jobs.modals.update_proposal.submit_button')),
            proposalUpdated: @json(__('find-jobs.js.proposal_updated')),
            failedUpdateProposal: @json(__('find-jobs.js.failed_update_proposal')),
            failedUpdateProposalRetry: @json(__('find-jobs.js.failed_update_proposal_retry')),
            withdrawConfirm: @json(__('find-jobs.js.withdraw_confirm')),
            withdrawing: @json(__('find-jobs.js.withdrawing')),
            withdrawProposalButton: @json(__('find-jobs.modals.update_proposal.withdraw_button')),
            proposalWithdrawn: @json(__('find-jobs.js.proposal_withdrawn')),
            failedWithdrawProposal: @json(__('find-jobs.js.failed_withdraw_proposal')),
            failedWithdrawProposalRetry: @json(__('find-jobs.js.failed_withdraw_proposal_retry')),
            time: {
                justNow: @json(__('find-jobs.time.just_now')),
                minuteAgo: @json(__('find-jobs.time.minute_ago', ['count' => ':count'])),
                minutesAgo: @json(__('find-jobs.time.minutes_ago', ['count' => ':count'])),
                hourAgo: @json(__('find-jobs.time.hour_ago', ['count' => ':count'])),
                hoursAgo: @json(__('find-jobs.time.hours_ago', ['count' => ':count'])),
                dayAgo: @json(__('find-jobs.time.day_ago', ['count' => ':count'])),
                daysAgo: @json(__('find-jobs.time.days_ago', ['count' => ':count'])),
                weekAgo: @json(__('find-jobs.time.week_ago', ['count' => ':count'])),
                weeksAgo: @json(__('find-jobs.time.weeks_ago', ['count' => ':count'])),
                monthAgo: @json(__('find-jobs.time.month_ago', ['count' => ':count'])),
                monthsAgo: @json(__('find-jobs.time.months_ago', ['count' => ':count'])),
            },
            durationMap: {
                less_than_1_month: @json(__('find-jobs.duration.less_than_1_month')),
                one_to_three_months: @json(__('find-jobs.duration.one_to_three_months')),
                three_to_six_months: @json(__('find-jobs.duration.three_to_six_months')),
                six_months_to_one_year: @json(__('find-jobs.duration.six_months_to_one_year')),
                more_than_one_year: @json(__('find-jobs.duration.more_than_one_year')),
            },
            experienceMap: {
                entry: @json(__('find-jobs.experience.entry')),
                intermediate: @json(__('find-jobs.experience.intermediate')),
                expert: @json(__('find-jobs.experience.expert')),
            },
            jobTypeMap: {
                fixed: @json(__('find-jobs.filters.fixed_price')),
                hourly: @json(__('find-jobs.filters.hourly')),
            },
            status: {
                open: @json(__('find-jobs.job_card.status.open')),
                closed: @json(__('find-jobs.job_card.status.closed')),
                in_progress: @json(__('find-jobs.job_card.status.in_progress')),
            },
            appliedStatus: {
                viewed: @json(__('find-jobs.js.applied_status.viewed')),
                shortlisted: @json(__('find-jobs.js.applied_status.shortlisted')),
                interviewing: @json(__('find-jobs.js.applied_status.interviewing')),
                revising: @json(__('find-jobs.js.applied_status.revising')),
                reapply: @json(__('find-jobs.js.applied_status.reapply')),
                offerAccepted: @json(__('find-jobs.js.applied_status.offer_accepted')),
            },
            updateStatusText: {
                updateProposal: @json(__('find-jobs.modals.job_details.update_proposal')),
                withdrawApplication: @json(__('find-jobs.js.update_status.withdraw_application')),
                updateApplication: @json(__('find-jobs.js.update_status.update_application')),
                updateRevision: @json(__('find-jobs.js.update_status.update_revision')),
            },
        };

        function getJobsRouteByType(type = 'all') {
            const routes = {
                'all': '{{ route('find-jobs.jobs') }}',
                'saved': '{{ route('find-jobs.saved') }}',
                'in_progress': '{{ route('find-jobs.in-progress') }}',
                'applied': '{{ route('find-jobs.applied') }}'
            };

            return routes[type] || routes.all;
        }

        function removeJobQueryParam() {
            const params = new URLSearchParams(window.location.search);
            if (!params.has('job')) {
                return;
            }

            params.delete('job');
            const query = params.toString();
            const nextUrl = query ? `${window.location.pathname}?${query}` : window.location.pathname;
            window.history.replaceState({}, '', nextUrl);
        }

        function maybeAutoOpenDeepLinkedJob(type) {
            if (type !== 'all' || hasHandledDeepLinkJob || !deepLinkJobId) {
                return;
            }

            hasHandledDeepLinkJob = true;
            fetchJobDetails(deepLinkJobId);
            removeJobQueryParam();
        }

        async function refreshJobViewsRealtime() {
            try {
                const response = await fetch(getJobsRouteByType(currentTab), {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    return;
                }

                const data = await response.json();
                if (!data.success || !Array.isArray(data.jobs)) {
                    return;
                }

                const viewsByJobId = {};
                data.jobs.forEach(job => {
                    viewsByJobId[job.id] = job.views_count || 0;
                });

                document.querySelectorAll('#jobs-container [data-id]').forEach(card => {
                    const jobId = Number(card.getAttribute('data-id'));
                    const viewsBadge = card.querySelector('.views-count');
                    if (!viewsBadge) {
                        return;
                    }

                    if (Object.prototype.hasOwnProperty.call(viewsByJobId, jobId)) {
                        viewsBadge.textContent = viewsByJobId[jobId];
                    }
                });
            } catch (error) {
                // Silent fail for polling to avoid interrupting UX.
            }
        }

        function startJobViewsRealtimePolling() {
            if (jobViewsRealtimeInterval) {
                clearInterval(jobViewsRealtimeInterval);
            }

            jobViewsRealtimeInterval = setInterval(refreshJobViewsRealtime, 2000);
        }

        function closeAllJobMoreMenus() {
            document.querySelectorAll('.job-more-menu').forEach(menu => menu.classList.add('hidden'));
        }

        function persistDismissedJobs() {
            localStorage.setItem('dismissed_job_ids', JSON.stringify(Array.from(dismissedJobIds)));
        }

        function setSaveMenuButtonContent(button, isSaved) {
            const label = isSaved ? i18n.unsaveMenu : i18n.saveMenu;
            button.innerHTML = `
                <span class="inline-flex items-center gap-2">
                    <i class="ri-bookmark-line"></i>
                    <span>${label}</span>
                </span>
            `;
        }

        function updateJobViewsBadge(jobId, viewsCount) {
            const card = document.querySelector(`#jobs-container [data-id="${jobId}"]`);
            if (!card) {
                return;
            }

            const viewsBadge = card.querySelector('.views-count');
            if (!viewsBadge) {
                return;
            }

            viewsBadge.textContent = viewsCount || 0;
        }

        // Tab filtering
        function filterJobs(status) {
            currentTab = status;

            // Update active tab
            document.querySelectorAll('[id^="tab-"]').forEach(tab => {
                tab.classList.remove('border-blue-600', 'text-blue-600');
                tab.classList.add('border-transparent');
            });
            const activeTab = document.getElementById(`tab-${status}`);
            activeTab.classList.add('border-b-2', 'border-blue-600', 'text-blue-600');
            activeTab.classList.remove('border-transparent');

            // Call appropriate function based on tab
            if (status === 'saved') {
                // If we already have saved jobs data, just display it
                if (savedJobsData.length > 0 && !isInitialLoad) {
                    displayJobs(savedJobsData);
                    applyCurrentFilters();
                } else {
                    fetchJobs('saved');
                }
            } else if (status === 'all') {
                // If we already have all jobs data, just display it
                if (allJobsData.length > 0 && !isInitialLoad) {
                    displayJobs(allJobsData);
                    applyCurrentFilters();
                } else {
                    fetchJobs('all');
                }
            } else if (status === 'in_progress') {
                // If we already have in progress jobs data, just display it
                if (inProgressJobsData.length > 0 && !isInitialLoad) {
                    displayJobs(inProgressJobsData);
                    applyCurrentFilters();
                } else {
                    fetchJobs('in_progress');
                }
            } else if (status === 'applied') {
                // If we already have applied jobs data, just display it
                if (appliedJobsData.length > 0 && !isInitialLoad) {
                    displayJobs(appliedJobsData);
                    applyCurrentFilters();
                } else {
                    fetchJobs('applied');
                }
            }

            isInitialLoad = false;
        }

        // Separate function for status filtering
        function filterJobsByStatus(status) {
            // Filter job cards
            const jobCards = document.querySelectorAll('[data-status]');
            const emptyState = document.getElementById('empty-state');
            const jobsContainer = document.getElementById('jobs-container');
            let visibleCount = 0;

            jobCards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            // Show/hide empty state
            if (visibleCount === 0) {
                jobsContainer.classList.add('hidden');
                emptyState.classList.remove('hidden');
            } else {
                jobsContainer.classList.remove('hidden');
                emptyState.classList.add('hidden');
            }

            // Update showing counts
            updateShowingCounts(visibleCount);
        }

        // Search functionality
        document.getElementById('job-search')?.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();

            // Apply filters based on current tab
            if (currentTab === 'saved') {
                // Filter saved jobs
                const filteredSavedJobs = savedJobsData.filter(job => {
                    const title = job.title ? job.title.toLowerCase() : '';
                    const description = job.description ? job.description.toLowerCase() : '';
                    const skills = job.skills_required ?
                        (Array.isArray(job.skills_required) ?
                            job.skills_required.join(' ').toLowerCase() :
                            job.skills_required.toLowerCase()) : '';

                    return title.includes(searchTerm) ||
                        description.includes(searchTerm) ||
                        skills.includes(searchTerm);
                });

                displayJobs(filteredSavedJobs);
            } else if (currentTab === 'in_progress') {
                // Filter in progress jobs
                const filteredInProgressJobs = inProgressJobsData.filter(job => {
                    const title = job.title ? job.title.toLowerCase() : '';
                    const description = job.description ? job.description.toLowerCase() : '';
                    const skills = job.skills_required ?
                        (Array.isArray(job.skills_required) ?
                            job.skills_required.join(' ').toLowerCase() :
                            job.skills_required.toLowerCase()) : '';

                    return title.includes(searchTerm) ||
                        description.includes(searchTerm) ||
                        skills.includes(searchTerm);
                });

                displayJobs(filteredInProgressJobs);
            } else if (currentTab === 'applied') {
                // Filter applied jobs
                const filteredAppliedJobs = appliedJobsData.filter(job => {
                    const title = job.title ? job.title.toLowerCase() : '';
                    const description = job.description ? job.description.toLowerCase() : '';
                    const skills = job.skills_required ?
                        (Array.isArray(job.skills_required) ?
                            job.skills_required.join(' ').toLowerCase() :
                            job.skills_required.toLowerCase()) : '';

                    return title.includes(searchTerm) ||
                        description.includes(searchTerm) ||
                        skills.includes(searchTerm);
                });

                displayJobs(filteredAppliedJobs);
            } else {
                // Filter all jobs
                const filteredJobs = allJobsData.filter(job => {
                    const title = job.title ? job.title.toLowerCase() : '';
                    const description = job.description ? job.description.toLowerCase() : '';
                    const skills = job.skills_required ?
                        (Array.isArray(job.skills_required) ?
                            job.skills_required.join(' ').toLowerCase() :
                            job.skills_required.toLowerCase()) : '';

                    return title.includes(searchTerm) ||
                        description.includes(searchTerm) ||
                        skills.includes(searchTerm);
                });

                displayJobs(filteredJobs);
            }
        });

        // Advanced filtering
        document.getElementById('apply-filters')?.addEventListener('click', function() {
            applyCurrentFilters();
        });

        // Function to apply current filters
        function applyCurrentFilters() {
            const type = document.getElementById('filter-type').value;
            const experience = document.getElementById('filter-experience').value;
            const duration = document.getElementById('filter-duration').value;
            const sort = document.getElementById('filter-sort').value;
            const searchTerm = document.getElementById('job-search').value.toLowerCase();

            // Get data based on current tab
            let dataToFilter = [];
            if (currentTab === 'saved') {
                dataToFilter = [...savedJobsData];
            } else if (currentTab === 'in_progress') {
                dataToFilter = [...inProgressJobsData];
            } else if (currentTab === 'applied') {
                dataToFilter = [...appliedJobsData];
            } else {
                dataToFilter = [...allJobsData];
            }

            // Apply filters
            let filteredJobs = dataToFilter.filter(job => {
                const matchesType = !type || job.type === type;
                const matchesExperience = !experience || job.experience_level === experience;
                const matchesDuration = !duration || job.duration === duration;

                // Search filter
                const title = job.title ? job.title.toLowerCase() : '';
                const description = job.description ? job.description.toLowerCase() : '';
                const skills = job.skills_required ?
                    (Array.isArray(job.skills_required) ?
                        job.skills_required.join(' ').toLowerCase() :
                        job.skills_required.toLowerCase()) : '';

                const matchesSearch = !searchTerm ||
                    title.includes(searchTerm) ||
                    description.includes(searchTerm) ||
                    skills.includes(searchTerm);

                return matchesType && matchesExperience && matchesDuration && matchesSearch;
            });

            // Apply sorting
            if (sort) {
                filteredJobs.sort((a, b) => {
                    switch (sort) {
                        case 'newest':
                            return new Date(b.created_at) - new Date(a.created_at);
                        case 'oldest':
                            return new Date(a.created_at) - new Date(b.created_at);
                        case 'budget_high':
                            const aBudget = a.budget_max || a.budget_min || 0;
                            const bBudget = b.budget_max || b.budget_min || 0;
                            return bBudget - aBudget;
                        case 'budget_low':
                            const aBudget2 = a.budget_min || a.budget_max || 0;
                            const bBudget2 = b.budget_min || b.budget_max || 0;
                            return aBudget2 - bBudget2;
                        default:
                            return 0;
                    }
                });
            }

            // Display filtered jobs
            displayJobs(filteredJobs);
        }

        // Clear filters
        document.getElementById('clear-filters')?.addEventListener('click', function() {
            document.getElementById('filter-type').value = '';
            document.getElementById('filter-experience').value = '';
            document.getElementById('filter-duration').value = '';
            document.getElementById('filter-sort').value = 'newest';
            document.getElementById('job-search').value = '';
            document.getElementById('advanced-filters').classList.add('hidden');

            // Reset to show all jobs based on current tab
            if (currentTab === 'saved') {
                displayJobs(savedJobsData);
            } else if (currentTab === 'in_progress') {
                displayJobs(inProgressJobsData);
            } else {
                displayJobs(allJobsData);
            }
        });

        document.getElementById('clear-all-filters')?.addEventListener('click', function() {
            document.getElementById('filter-type').value = '';
            document.getElementById('filter-experience').value = '';
            document.getElementById('filter-duration').value = '';
            document.getElementById('filter-sort').value = 'newest';
            document.getElementById('job-search').value = '';

            // Reset to show all jobs based on current tab
            if (currentTab === 'saved') {
                displayJobs(savedJobsData);
            } else if (currentTab === 'in_progress') {
                displayJobs(inProgressJobsData);
            } else {
                displayJobs(allJobsData);
            }
        });

        // Update showing counts
        function updateShowingCounts(visibleCount) {
            let totalJobs = 0;
            if (currentTab === 'saved') {
                totalJobs = savedJobsData.length;
            } else if (currentTab === 'in_progress') {
                totalJobs = inProgressJobsData.length;
            } else {
                totalJobs = allJobsData.length;
            }

            document.getElementById('showing-from').textContent = visibleCount > 0 ? '1' : '0';
            document.getElementById('showing-to').textContent = visibleCount;
            document.getElementById('total-jobs').textContent = totalJobs;
        }

        // Update empty state
        function updateEmptyState(visibleCount) {
            const emptyState = document.getElementById('empty-state');
            const jobsContainer = document.getElementById('jobs-container');

            if (visibleCount === 0) {
                jobsContainer.classList.add('hidden');
                emptyState.classList.remove('hidden');
            } else {
                jobsContainer.classList.remove('hidden');
                emptyState.classList.add('hidden');
            }
        }

        // Initialize counts
        document.addEventListener('DOMContentLoaded', function() {
            // Initial fetch will update counts
            fetchJobs('all');
            startJobViewsRealtimePolling();
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');

            closeAllJobMoreMenus();

            if (window.innerWidth <= 1024 &&
                sidebar &&
                !sidebar.contains(event.target) &&
                toggleBtn &&
                !toggleBtn.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        const jobsContainer = document.getElementById('jobs-container');
        const jobCardTemplate = document.getElementById('job-card-template');
        const skeletonTemplate = document.getElementById('skeleton-template');

        // Modal elements
        const jobDetailsModal = document.getElementById('job-details-modal');
        const modalBackdrop = document.getElementById('modal-backdrop');
        const modalContent = document.getElementById('modal-content');
        const closeModalBtn = document.getElementById('close-modal');
        const cancelModalBtn = document.getElementById('cancel-modal');
        const applyJobBtn = document.getElementById('apply-job-btn');
        const updateJobBtn = document.getElementById('update-job-btn');
        const saveJobBtn = document.getElementById('save-job-btn');

        // Function to show skeleton loading animation
        function showSkeletonLoading(count = 4) {
            jobsContainer.innerHTML = '';

            for (let i = 0; i < count; i++) {
                const skeleton = skeletonTemplate.content.cloneNode(true);
                jobsContainer.appendChild(skeleton);
            }
        }

        // Modal functions
        function openModal() {
            // First remove hidden class
            jobDetailsModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Trigger reflow to ensure transition works
            void jobDetailsModal.offsetWidth;

            setTimeout(() => {
                modalBackdrop.classList.remove('opacity-0');
                modalBackdrop.classList.add('opacity-100');
            }, 10);

            setTimeout(() => {
                modalContent.classList.remove('translate-y-4', 'opacity-0');
                modalContent.classList.add('translate-y-0', 'opacity-100');
            }, 10);
        }

        function closeModal() {
            // Remove transform classes for content
            modalContent.classList.remove('translate-y-0', 'opacity-100');
            modalContent.classList.add('translate-y-4', 'opacity-0');

            // Remove opacity class for backdrop
            modalBackdrop.classList.remove('opacity-100');
            modalBackdrop.classList.add('opacity-0');

            setTimeout(() => {
                jobDetailsModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        // Event listeners for modal
        closeModalBtn.addEventListener('click', closeModal);
        cancelModalBtn.addEventListener('click', closeModal);

        // Close modal when clicking the dark backdrop
        modalBackdrop.addEventListener('click', closeModal);

        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !jobDetailsModal.classList.contains('hidden')) {
                closeModal();
            }
        });

        async function fetchJobDetails(jobId) {
            try {
                const response = await fetch(`/find-jobs/jobs/${jobId}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(i18n.networkResponseNotOk);
                }

                const data = await response.json();

                if (data.success) {
                    updateJobViewsBadge(jobId, data.job.views_count);
                    displayJobDetails(data.job);
                    openModal();
                } else {
                    throw new Error(data.message || i18n.failedFetchJobDetails);
                }
            } catch (error) {
                console.error('Error fetching job details:', error);
                alert(i18n.failedLoadJobDetails);
            }
        }

        function displayJobDetails(job) {
            // Set job ID for save button
            const modalJobTitle = document.getElementById('modal-job-title');
            modalJobTitle.setAttribute('data-job-id', job.id);

            // Set modal title
            document.getElementById('modal-title').textContent = i18n.jobDetailsTitle;
            modalJobTitle.textContent = job.title || i18n.untitledJob;

            // Set status badge
            const statusBadge = document.getElementById('modal-status');
            statusBadge.textContent = i18n.status[job.status] || i18n.status.open;

            // Update badge color based on status
            if (job.status === 'open') {
                statusBadge.className =
                    'px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 select-none';
            } else if (job.status === 'closed') {
                statusBadge.className = 'px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 select-none';
            } else if (job.status === 'in_progress') {
                statusBadge.className = 'px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 select-none';
            } else {
                statusBadge.className = 'px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 select-none';
            }

            // Set posted time
            document.getElementById('modal-posted-time').textContent =
                `${i18n.postedPrefix} ${formatTimeAgo(job.created_at)}`;

            // Set budget and type
            const budgetElement = document.getElementById('modal-budget');
            if (job.budget_min !== null && job.budget_max !== null) {
                budgetElement.textContent = formatBudgetRange(job.budget_min, job.budget_max);
            } else {
                budgetElement.textContent = i18n.budgetNotSpecified;
            }

            const typeElement = document.getElementById('modal-type');
            typeElement.textContent = job.type ? (i18n.jobTypeMap[job.type] || job.type.charAt(0).toUpperCase() + job.type
                .slice(1)) : i18n.notSpecified;

            // Set duration
            document.getElementById('modal-duration').textContent = job.duration ? formatDuration(job.duration) :
                i18n.durationNotSpecified;
            document.getElementById('modal-detail-duration').textContent = job.duration ? formatDuration(job.duration) :
                i18n.notSpecified;

            // Set experience level
            const experienceElement = document.getElementById('modal-experience');
            const detailExperienceElement = document.getElementById('modal-detail-experience');
            if (job.experience_level) {
                const experienceText = formatExperienceLevel(job.experience_level);
                experienceElement.textContent = experienceText;
                detailExperienceElement.textContent = experienceText;
            } else {
                experienceElement.textContent = i18n.experienceNotSpecified;
                detailExperienceElement.textContent = i18n.notSpecified;
            }

            // Set description
            const descriptionElement = document.getElementById('modal-description');
            descriptionElement.innerHTML = job.description ?
                job.description.replace(/\n/g, '<br>') :
                `<p class="text-gray-500 italic">${i18n.noDescription}</p>`;

            // Set skills
            const skillsContainer = document.getElementById('modal-skills');
            skillsContainer.innerHTML = '';

            if (job.skills_required && job.skills_required.length > 0) {
                // Parse skills if it's a JSON string
                let skills = job.skills_required;
                if (typeof skills === 'string') {
                    try {
                        skills = JSON.parse(skills);
                    } catch (e) {
                        skills = skills.split(',').map(skill => skill.trim());
                    }
                }

                skills.forEach(skill => {
                    const skillElement = document.createElement('span');
                    skillElement.className =
                        'px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-medium rounded-full border border-blue-100 select-none';
                    skillElement.textContent = skill;
                    skillsContainer.appendChild(skillElement);
                });
            } else {
                const noSkillElement = document.createElement('span');
                noSkillElement.className =
                    'px-3 py-1.5 bg-gray-50 text-gray-700 text-sm font-medium rounded-full border border-gray-200';
                noSkillElement.textContent = i18n.noSkillsSpecified;
                skillsContainer.appendChild(noSkillElement);
            }

            // Set detail type
            document.getElementById('modal-detail-type').textContent = job.type ?
                (i18n.jobTypeMap[job.type] || job.type.charAt(0).toUpperCase() + job.type.slice(1)) : i18n.notSpecified;

            // Set proposals count
            const proposalsElement = document.getElementById('modal-proposals-count');
            proposalsElement.textContent = job.proposals_count ?
                i18n.proposalsCount.replace(':count', job.proposals_count) :
                i18n.zeroProposal;

            // Update save button text
            if (job.is_saved) {
                saveJobBtn.textContent = i18n.unsaveJob;
            } else {
                saveJobBtn.textContent = i18n.saveJob;
            }

            // Function to update buttons based on job status
            function updateButtonsBasedOnStatus(job) {
                const applyJobBtn = document.getElementById('apply-job-btn');
                const updateJobBtn = document.getElementById('update-job-btn');
                const saveJobBtn = document.getElementById('save-job-btn');

                // Reset all buttons first
                applyJobBtn.classList.remove('hidden');
                applyJobBtn.classList.add('inline-flex');
                updateJobBtn.classList.remove('inline-flex');
                updateJobBtn.classList.add('hidden');
                applyJobBtn.disabled = false;
                applyJobBtn.classList.remove('opacity-30', 'cursor-not-allowed');

                // Define status behaviors
                const statusConfig = {
                    'submitted': {
                        showApply: false,
                        applyEnabled: false,
                        showUpdate: true,
                        updateText: i18n.updateStatusText.updateProposal
                    },
                    'viewed': {
                        showApply: true,
                        applyText: i18n.appliedStatus.viewed,
                        applyEnabled: false,
                        showUpdate: true,
                        updateText: i18n.updateStatusText.updateProposal
                    },
                    'shortlisted': {
                        showApply: true,
                        applyText: i18n.appliedStatus.shortlisted,
                        applyEnabled: false,
                        showUpdate: true,
                        updateText: i18n.updateStatusText.withdrawApplication
                    },
                    'interviewing': {
                        showApply: false,
                        applyText: i18n.appliedStatus.interviewing,
                        applyEnabled: false,
                        showUpdate: true,
                        updateText: i18n.updateStatusText.updateApplication
                    },
                    'revising': {
                        showApply: false,
                        applyText: i18n.appliedStatus.revising,
                        applyEnabled: false,
                        showUpdate: true,
                        updateText: i18n.updateStatusText.updateRevision
                    },
                    'rejected': {
                        showApply: true,
                        applyText: i18n.appliedStatus.reapply,
                        applyEnabled: true,
                        showUpdate: false
                    },
                    'accepted': {
                        showApply: true,
                        applyText: i18n.appliedStatus.offerAccepted,
                        applyEnabled: false,
                        showUpdate: false
                    },
                    'withdrawn': {
                        showApply: true,
                        applyText: i18n.applyJob,
                        applyEnabled: true,
                        showUpdate: false
                    }
                };

                // Get config for current status (default to 'viewed' if status not found)
                const config = statusConfig[job.applied_status] || statusConfig.submitted;

                // Apply button configuration
                if (config.showApply) {
                    applyJobBtn.classList.remove('hidden');
                    applyJobBtn.classList.add('inline-flex');
                    applyJobBtn.textContent = config.applyText;
                    applyJobBtn.disabled = !config.applyEnabled;

                    if (!config.applyEnabled) {
                        applyJobBtn.classList.add('opacity-30', 'cursor-not-allowed');
                    } else {
                        applyJobBtn.classList.remove('opacity-30', 'cursor-not-allowed');
                    }
                } else {
                    applyJobBtn.classList.remove('inline-flex');
                    applyJobBtn.classList.add('hidden');
                }

                // Update button configuration
                if (config.showUpdate) {
                    updateJobBtn.classList.remove('hidden');
                    updateJobBtn.classList.add('inline-flex');
                    updateJobBtn.textContent = config.updateText;
                } else {
                    updateJobBtn.classList.remove('inline-flex');
                    updateJobBtn.classList.add('hidden');
                }
            }

            updateButtonsBasedOnStatus(job);

            // Update button actions
            applyJobBtn.onclick = () => {
                openProposalModal(job);
            };

            // Update update button action
            updateJobBtn.onclick = async () => {
                try {
                    const jobId = job.id;
                    const response = await fetch(`/jobs/proposals/${jobId}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error(i18n.failedFetchProposal);
                    }

                    const data = await response.json();

                    if (data.success) {
                        // Open update modal with existing proposal data
                        openUpdateProposalModal(job, data.proposal);
                    } else {
                        throw new Error(data.message || i18n.proposalNotFound);
                    }
                } catch (error) {
                    console.error('Error fetching proposal:', error);
                    alert(i18n.failedLoadProposalDetails);
                }
            };

            // Update save button action
            saveJobBtn.onclick = async () => {
                const result = await toggleSaveJob(job.id);
                if (result.success) {
                    // Update button text based on action
                    saveJobBtn.textContent = result.action === 'saved' ? i18n.unsaveJob : i18n.saveJob;

                    // Update the job data in memory
                    updateJobSavedStatus(job.id, result.action === 'saved');
                }
            };
        }

        function displayJobs(jobs) {
            const visibleJobs = (jobs || []).filter(job => !dismissedJobIds.has(job.id));

            if (visibleJobs.length === 0) {
                jobsContainer.innerHTML =
                    '<div class="text-center p-8 bg-white rounded-xl shadow-sm border border-gray-200 h-full flex items-center justify-center">' +
                    '<div>' +
                    `<p class="text-gray-600">${i18n.noJobsFoundSimple}</p>` +
                    '</div>' +
                    '</div>';

                updateEmptyState(0);
                updateShowingCounts(0);
                return;
            }

            // Clear existing content
            jobsContainer.innerHTML = '';

            visibleJobs.forEach(job => {
                // Clone the template
                const jobCard = jobCardTemplate.content.cloneNode(true);
                const cardElement = jobCard.querySelector('div');

                // Set data attributes
                cardElement.setAttribute('data-id', job.id);
                cardElement.setAttribute('data-status', job.status || 'open');
                cardElement.setAttribute('data-type', job.type || 'fixed');
                cardElement.setAttribute('data-experience', job.experience_level || 'expert');
                cardElement.setAttribute('data-duration', job.duration || '3_to_6_months');

                // Set status badge
                const statusBadge = cardElement.querySelector('.status-badge');
                if (job.status) {
                    statusBadge.textContent = i18n.status[job.status] || i18n.status.open;
                    // Update badge color based on status
                    if (job.status === 'open') {
                        statusBadge.className =
                            'px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 select-none status-badge';
                    } else if (job.status === 'closed') {
                        statusBadge.className =
                            'px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 select-none status-badge';
                    } else if (job.status === 'in_progress') {
                        statusBadge.className =
                            'px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 select-none status-badge';
                    }
                }

                // Set posted time
                const postedTime = cardElement.querySelector('.posted-time');
                postedTime.textContent = `${i18n.postedPrefix} ${formatTimeAgo(job.created_at)}`;

                // Set client profile info
                const clientProfile = job.client_profile || {};
                const clientProfileLink = cardElement.querySelector('.client-profile-link');
                const clientName = cardElement.querySelector('.client-name');
                const clientCompany = cardElement.querySelector('.client-company');
                const clientAvatarImage = cardElement.querySelector('.client-avatar-image');
                const clientAvatarInitial = cardElement.querySelector('.client-avatar-initial');

                const resolvedClientName = clientProfile.name || i18n.unknownClient;
                const resolvedCompany = clientProfile.company || i18n.independentClient;
                const resolvedInitial = (clientProfile.initial || resolvedClientName.charAt(0) ||
                        @js(__('find-jobs.job_card.client_initial')))
                    .toUpperCase();

                clientName.textContent = resolvedClientName;
                clientCompany.textContent = resolvedCompany;
                clientAvatarInitial.textContent = resolvedInitial;

                if (clientProfile.profile_url) {
                    clientProfileLink.href = clientProfile.profile_url;
                } else {
                    clientProfileLink.href = '#';
                }

                if (clientProfile.profile_photo_url || clientProfile.profile_photo_path) {
                    clientAvatarImage.src = clientProfile.profile_photo_url ||
                        `/storage/${clientProfile.profile_photo_path}`;
                    clientAvatarImage.classList.remove('hidden');
                    clientAvatarInitial.classList.add('hidden');
                } else {
                    clientAvatarImage.classList.add('hidden');
                    clientAvatarInitial.classList.remove('hidden');
                }

                // Set job title
                const jobTitle = cardElement.querySelector('.job-title');
                jobTitle.textContent = job.title || i18n.untitledJob;

                // Set job description
                const jobDescription = cardElement.querySelector('.job-description');
                jobDescription.textContent = job.description ?
                    (job.description.length > 150 ? job.description.substring(0, 150) + '...' : job.description) :
                    i18n.noDescription;

                // Set skills
                const skillsContainer = cardElement.querySelector('.skills-container');
                skillsContainer.innerHTML = '';

                if (job.skills_required && job.skills_required.length > 0) {
                    // Parse skills if it's a JSON string
                    let skills = job.skills_required;
                    if (typeof skills === 'string') {
                        try {
                            skills = JSON.parse(skills);
                        } catch (e) {
                            skills = skills.split(',').map(skill => skill.trim());
                        }
                    }

                    // Show only first 3 skills
                    skills.slice(0, 3).forEach(skill => {
                        const skillElement = document.createElement('span');
                        skillElement.className =
                            'px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded';
                        skillElement.textContent = skill;
                        skillsContainer.appendChild(skillElement);
                    });

                    // Show +X more if there are more skills
                    if (skills.length > 3) {
                        const moreElement = document.createElement('span');
                        moreElement.className = 'px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded';
                        moreElement.textContent = i18n.moreSkills.replace(':count', skills.length - 3);
                        skillsContainer.appendChild(moreElement);
                    }
                } else {
                    const noSkillElement = document.createElement('span');
                    noSkillElement.className = 'px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded';
                    noSkillElement.textContent = i18n.noSkillsRequired;
                    skillsContainer.appendChild(noSkillElement);
                }

                // Set budget and job type
                const budgetAmount = cardElement.querySelector('.budget-amount');
                const jobType = cardElement.querySelector('.job-type');

                if (job.budget_min !== null && job.budget_max !== null) {
                    budgetAmount.textContent = formatBudgetRange(job.budget_min, job.budget_max);
                } else {
                    budgetAmount.textContent = i18n.budgetNotSpecified;
                }

                if (job.type) {
                    jobType.textContent = i18n.jobTypeMap[job.type] || (job.type.charAt(0).toUpperCase() + job.type.slice(1));
                } else {
                    jobType.textContent = i18n.notSpecified;
                }

                // Set duration
                const durationText = cardElement.querySelector('.duration-text');
                durationText.textContent = formatDuration(job.duration) || i18n.durationNotSpecified;

                // Set views count on View Job button
                const viewsCount = cardElement.querySelector('.views-count');
                viewsCount.textContent = job.views_count || 0;

                // Add click event to "View Job" button
                const viewJobBtn = cardElement.querySelector('.view-job-btn');
                viewJobBtn.addEventListener('click', () => {
                    fetchJobDetails(job.id);
                });

                // More menu actions
                const moreBtn = cardElement.querySelector('.job-more-btn');
                const moreMenu = cardElement.querySelector('.job-more-menu');
                const saveMenuBtn = cardElement.querySelector('.menu-save-btn');
                const notForMeBtn = cardElement.querySelector('.menu-not-for-me-btn');

                setSaveMenuButtonContent(saveMenuBtn, !!job.is_saved);

                moreBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isHidden = moreMenu.classList.contains('hidden');
                    closeAllJobMoreMenus();
                    if (isHidden) {
                        moreMenu.classList.remove('hidden');
                    }
                });

                saveMenuBtn.addEventListener('click', async (e) => {
                    e.stopPropagation();
                    const result = await toggleSaveJob(job.id);

                    if (result.success) {
                        const isSavedNow = result.action === 'saved';
                        job.is_saved = isSavedNow;
                        setSaveMenuButtonContent(saveMenuBtn, isSavedNow);
                        updateJobSavedStatus(job.id, isSavedNow);
                        closeAllJobMoreMenus();
                    } else {
                        showToast(result.message || i18n.unableToSaveJob, 'error');
                    }
                });

                notForMeBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    dismissedJobIds.add(job.id);
                    persistDismissedJobs();

                    allJobsData = allJobsData.filter(item => item.id !== job.id);
                    savedJobsData = savedJobsData.filter(item => item.id !== job.id);
                    inProgressJobsData = inProgressJobsData.filter(item => item.id !== job.id);
                    appliedJobsData = appliedJobsData.filter(item => item.id !== job.id);

                    cardElement.remove();
                    const remainingCards = document.querySelectorAll('#jobs-container [data-id]').length;
                    updateEmptyState(remainingCards);
                    updateShowingCounts(remainingCards);
                    closeAllJobMoreMenus();
                });

                // Append to container
                jobsContainer.appendChild(jobCard);
            });

            updateEmptyState(visibleJobs.length);
            updateShowingCounts(visibleJobs.length);
        }

        async function fetchJobs(type = 'all') {
            showSkeletonLoading();

            const errorMessages = {
                'all': i18n.errorLoadingJobs,
                'saved': i18n.errorLoadingSavedJobs,
                'in_progress': i18n.errorLoadingInProgressJobs,
                'applied': i18n.errorLoadingAppliedJobs
            };

            const retryFunctions = {
                'all': 'fetchJobs(\'all\')',
                'saved': 'fetchJobs(\'saved\')',
                'in_progress': 'fetchJobs(\'in_progress\')',
                'applied': 'fetchJobs(\'applied\')'
            };

            try {
                const response = await fetch(getJobsRouteByType(type), {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(i18n.networkResponseNotOk);
                }

                const data = await response.json();

                if (data.success) {
                    // Store data based on type
                    if (type === 'all') {
                        allJobsData = data.jobs;
                    } else if (type === 'saved') {
                        savedJobsData = data.jobs;
                    } else if (type === 'in_progress') {
                        inProgressJobsData = data.jobs;
                    } else if (type === 'applied') {
                        appliedJobsData = data.jobs;
                    }

                    displayJobs(data.jobs);
                    refreshJobViewsRealtime();
                    maybeAutoOpenDeepLinkedJob(type);
                } else {
                    throw new Error(data.message || i18n.failedFetchJobs.replace(':type', type));
                }
            } catch (error) {
                console.error(`Error fetching ${type} jobs:`, error);
                jobsContainer.innerHTML =
                    '<div class="text-center p-8 bg-white rounded-xl shadow-sm border border-gray-200 h-full flex items-center justify-center">' +
                    '<div>' +
                    `<p class="text-gray-600 mb-2">${errorMessages[type]}</p>` +
                    `<button onclick="${retryFunctions[type]}" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm font-medium transition duration-200">` +
                    i18n.retry +
                    '</button>' +
                    '</div>' +
                    '</div>';
            }
        }

        // Function to toggle save job
        async function toggleSaveJob(jobId) {
            try {
                const response = await fetch('{{ route('find-jobs.toggle-save') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        job_id: jobId
                    })
                });

                if (!response.ok) {
                    throw new Error(i18n.networkResponseNotOk);
                }

                const data = await response.json();

                if (data.success) {
                    // Update saved jobs data if we're on saved tab
                    if (currentTab === 'saved') {
                        if (data.action === 'removed') {
                            // Remove from saved jobs
                            closeModal();
                            savedJobsData = savedJobsData.filter(job => job.id !== jobId);
                            displayJobs(savedJobsData);
                        } else {
                            // Fetch updated saved jobs list
                            fetchJobs('saved');
                        }
                    }

                    return data;
                } else {
                    throw new Error(data.message || i18n.failedSaveJob);
                }
            } catch (error) {
                return {
                    success: false,
                    message: error.message
                };
            }
        }

        // Proposal Modal elements
        const proposalModal = document.getElementById('proposal-modal');
        const proposalBackdrop = document.getElementById('proposal-backdrop');
        const proposalContent = document.getElementById('proposal-content');
        const closeProposalModalBtn = document.getElementById('close-proposal-modal');
        const cancelProposalModalBtn = document.getElementById('cancel-proposal-modal');
        const proposalForm = document.getElementById('proposal-form');
        const min_max_budget = document.getElementById('min_max_budget');
        const submitProposalBtn = document.getElementById('submit-proposal-btn');
        const submitProposalText = document.getElementById('submit-proposal-text');
        const submitProposalLoading = document.getElementById('submitSpinner');
        const proposalError = document.getElementById('proposal-error');
        const proposalErrorText = document.getElementById('proposal-error-text');

        // Update Proposal Modal elements
        const proposalUpdateModal = document.getElementById('proposal-update-modal');
        const updateProposalBackdrop = document.getElementById('update-proposal-backdrop');
        const updateProposalContent = document.getElementById('update-proposal-content');
        const closeUpdateProposalModalBtn = document.getElementById('close-update-proposal-modal');
        const cancelUpdateProposalModalBtn = document.getElementById('cancel-proposal-update-modal');
        const updateProposalForm = document.getElementById('update-proposal-form');
        const updateMinMaxBudget = document.getElementById('update-min_max_budget');
        const submitUpdateProposalBtn = document.getElementById('submit-update-proposal-btn');
        const submitUpdateProposalText = document.getElementById('submit-update-proposal-text');
        const submitUpdateProposalLoading = document.getElementById('update-submitSpinner');
        const submitWithdrawProposalBtn = document.getElementById('submit-withdraw-proposal-btn');
        const submitWithdrawProposalText = document.getElementById('submit-withdraw-proposal-text');
        const submitWithdrawProposalLoading = document.getElementById('withdraw-submitSpinner');
        const updateProposalError = document.getElementById('update-proposal-error');
        const updateProposalErrorText = document.getElementById('update-proposal-error-text');

        // Current job details for proposal
        let currentJobForProposal = null;

        // Proposal Modal functions
        function openProposalModal(job) {
            currentJobForProposal = job;

            // Set job details
            document.getElementById('proposal-job-title').textContent = job.title || i18n.untitledJob;
            document.getElementById('proposal-job-id').value = job.id;

            // Clear form
            proposalForm.reset();
            hideProposalError();

            // Add character counter for proposal text
            const proposalText = document.getElementById('proposal-text');
            proposalText.addEventListener('input', updateCharCounter);

            const bid_amount = document.getElementById('bid-amount');
            bid_amount.min = job.budget_min;
            bid_amount.max = job.budget_max;
            bid_amount.value = job.budget_min;
            min_max_budget.textContent = formatBudgetRange(job.budget_min, job.budget_max);

            // Initialize character counter
            updateCharCounter.call(proposalText);

            // First remove hidden class
            proposalModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Trigger reflow to ensure transition works
            void proposalModal.offsetWidth;

            setTimeout(() => {
                proposalBackdrop.classList.remove('opacity-0');
                proposalBackdrop.classList.add('opacity-100');
            }, 10);

            setTimeout(() => {
                proposalContent.classList.remove('translate-y-4', 'opacity-0', 'scale-95');
                proposalContent.classList.add('translate-y-0', 'opacity-100', 'scale-100');
            }, 10);

            // Close job details modal
            closeModal();
        }

        function closeProposalModal() {
            // Remove transform classes for content
            proposalContent.classList.remove('translate-y-0', 'opacity-100', 'scale-100');
            proposalContent.classList.add('translate-y-4', 'opacity-0', 'scale-95');

            // Remove opacity class for backdrop
            proposalBackdrop.classList.remove('opacity-100');
            proposalBackdrop.classList.add('opacity-0');

            setTimeout(() => {
                proposalModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                currentJobForProposal = null;

                // Remove character counter event listener
                const proposalText = document.getElementById('proposal-text');
                proposalText.removeEventListener('input', updateCharCounter);

                // Remove character counter if exists
                const existingCounter = proposalText.nextElementSibling;
                if (existingCounter && existingCounter.classList.contains('char-counter')) {
                    existingCounter.remove();
                }
            }, 300);

            // Open job details modal
            openModal();
        }

        // Update Proposal Modal functions
        async function openUpdateProposalModal(job, proposal) {
            // Set job details
            document.getElementById('update-proposal-job-title').textContent = job.title || i18n.untitledJob;
            document.getElementById('update-proposal-job-id').value = job.id;

            // Set proposal details
            if (proposal) {
                document.getElementById('update-proposal-id').value = proposal.id;
                document.getElementById('update-proposal-text').value = proposal.proposal_text || '';
                document.getElementById('update-bid-amount').value = proposal.bid_amount || job.budget_min;
                document.getElementById('update-estimated-timeline').value = proposal.estimated_timeline ||
                    'to be discussed';
            }

            // Set budget limits
            const updateBidAmount = document.getElementById('update-bid-amount');
            updateBidAmount.min = job.budget_min;
            updateBidAmount.max = job.budget_max;
            updateMinMaxBudget.textContent = formatBudgetRange(job.budget_min, job.budget_max);

            // Clear any errors
            hideUpdateProposalError();

            // Add character counter for proposal text
            const updateProposalText = document.getElementById('update-proposal-text');
            updateProposalText.addEventListener('input', updateUpdateCharCounter);
            updateUpdateCharCounter.call(updateProposalText);

            // First remove hidden class
            proposalUpdateModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Trigger reflow to ensure transition works
            void proposalUpdateModal.offsetWidth;

            setTimeout(() => {
                updateProposalBackdrop.classList.remove('opacity-0');
                updateProposalBackdrop.classList.add('opacity-100');
            }, 10);

            setTimeout(() => {
                updateProposalContent.classList.remove('translate-y-4', 'opacity-0', 'scale-95');
                updateProposalContent.classList.add('translate-y-0', 'opacity-100', 'scale-100');
            }, 10);

            // Close job details modal
            closeModal();
        }

        function closeUpdateProposalModal() {
            // Remove transform classes for content
            updateProposalContent.classList.remove('translate-y-0', 'opacity-100', 'scale-100');
            updateProposalContent.classList.add('translate-y-4', 'opacity-0', 'scale-95');

            // Remove opacity class for backdrop
            updateProposalBackdrop.classList.remove('opacity-100');
            updateProposalBackdrop.classList.add('opacity-0');

            setTimeout(() => {
                proposalUpdateModal.classList.add('hidden');
                document.body.style.overflow = 'auto';

                // Remove character counter event listener
                const updateProposalText = document.getElementById('update-proposal-text');
                updateProposalText.removeEventListener('input', updateUpdateCharCounter);

                // Remove character counter if exists
                const existingCounter = updateProposalText.nextElementSibling;
                if (existingCounter && existingCounter.classList.contains('char-counter')) {
                    existingCounter.remove();
                }

                // Clear form
                updateProposalForm.reset();
            }, 300);

            // Open job details modal
            openModal();
        }

        // Character counter functions
        function updateCharCounter() {
            const text = this.value;
            const length = text.length;
            const minLength = 100;

            // Create or update counter
            let counter = this.nextElementSibling;
            if (!counter || !counter.classList.contains('char-counter')) {
                counter = document.createElement('div');
                counter.className = 'char-counter text-xs text-right mt-1';
                this.parentNode.insertBefore(counter, this.nextElementSibling);
            }

            // Reset classes
            counter.className = 'char-counter text-xs text-right mt-1';

            // Add conditional classes based on length
            if (length < minLength) {
                counter.classList.add('text-red-500');
                counter.textContent = i18n.charactersCountMinimum.replace(':count', length).replace(':min', minLength);
            } else if (length < 150) {
                counter.classList.add('text-amber-500');
                counter.textContent = i18n.charactersCount.replace(':count', length);
            } else {
                counter.classList.add('text-emerald-500');
                counter.textContent = i18n.charactersCount.replace(':count', length);
            }
        }

        function updateUpdateCharCounter() {
            const text = this.value;
            const length = text.length;
            const minLength = 100;

            // Create or update counter
            let counter = this.nextElementSibling;
            if (!counter || !counter.classList.contains('char-counter')) {
                counter = document.createElement('div');
                counter.className = 'char-counter text-xs text-right mt-1';
                this.parentNode.insertBefore(counter, this.nextElementSibling);
            }

            // Reset classes
            counter.className = 'char-counter text-xs text-right mt-1';

            // Add conditional classes based on length
            if (length < minLength) {
                counter.classList.add('text-red-500');
                counter.textContent = i18n.charactersCountMinimum.replace(':count', length).replace(':min', minLength);
            } else if (length < 150) {
                counter.classList.add('text-amber-500');
                counter.textContent = i18n.charactersCount.replace(':count', length);
            } else {
                counter.classList.add('text-emerald-500');
                counter.textContent = i18n.charactersCount.replace(':count', length);
            }
        }

        // Show/hide proposal error functions
        function showProposalError(message) {
            proposalErrorText.textContent = message;
            proposalError.classList.remove('hidden');
        }

        function hideProposalError() {
            proposalError.classList.add('hidden');
        }

        function showUpdateProposalError(message) {
            updateProposalErrorText.textContent = message;
            updateProposalError.classList.remove('hidden');
        }

        function hideUpdateProposalError() {
            updateProposalError.classList.add('hidden');
        }

        // Form validation
        function validateProposalForm(formData) {
            const errors = [];

            // Check proposal text
            const proposalText = formData.get('proposal_text')?.trim() || '';
            if (proposalText.length < 100) {
                errors.push(i18n.proposalMinValidation.replace(':min', 100));
            }

            // Check bid amount
            const bidAmount = parseFloat(formData.get('bid_amount'));
            if (!bidAmount || bidAmount <= 0) {
                errors.push(i18n.validBidAmount);
            }

            return errors;
        }

        function validateUpdateProposalForm(formData) {
            const errors = [];

            // Check proposal text
            const proposalText = formData.get('proposal_text')?.trim() || '';
            if (proposalText.length < 100) {
                errors.push(i18n.proposalMinValidation.replace(':min', 100));
            }

            // Check bid amount
            const bidAmount = parseFloat(formData.get('bid_amount'));
            if (!bidAmount || bidAmount <= 0) {
                errors.push(i18n.validBidAmount);
            }

            return errors;
        }

        // Submit proposal functions
        async function submitProposal(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);

            // Validate form
            const errors = validateProposalForm(formData);
            if (errors.length > 0) {
                showProposalError(errors.join(', '));
                return;
            }

            // Show loading state
            submitProposalText.textContent = i18n.submitting;
            submitProposalLoading.classList.remove('hidden');
            submitProposalBtn.disabled = true;
            hideProposalError();

            try {
                const response = await fetch('{{ route('find-jobs.proposals-save') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || i18n.failedSubmitProposal);
                }

                if (data.success) {
                    // Show success message
                    showToast(i18n.proposalSubmitted);

                    // Close modal
                    closeProposalModal();

                    // If on applied tab, refresh the list
                    if (currentTab === 'applied') {
                        fetchJobs('applied');
                    }
                } else {
                    throw new Error(data.message || i18n.failedSubmitProposal);
                }
            } catch (error) {
                console.error('Error submitting proposal:', error);
                showProposalError(error.message || i18n.failedSubmitProposalRetry);
            } finally {
                // Reset button state
                submitProposalText.textContent = i18n.submitProposal;
                submitProposalLoading.classList.add('hidden');
                submitProposalBtn.disabled = false;
            }
        }

        async function submitUpdateProposal(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);
            const proposalId = document.getElementById('update-proposal-id').value;

            // Validate form
            const errors = validateUpdateProposalForm(formData);
            if (errors.length > 0) {
                showUpdateProposalError(errors.join(', '));
                return;
            }

            // Show loading state
            submitUpdateProposalText.textContent = i18n.updating;
            submitUpdateProposalLoading.classList.remove('hidden');
            submitUpdateProposalBtn.disabled = true;
            hideUpdateProposalError();

            try {
                const response = await fetch(`/jobs/proposals/${proposalId}/update`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        proposal_text: formData.get('proposal_text'),
                        bid_amount: formData.get('bid_amount'),
                        estimated_timeline: formData.get('estimated_timeline')
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || i18n.failedUpdateProposal);
                }

                if (data.success) {
                    // Show success message
                    showToast(i18n.proposalUpdated);

                    // Close modal
                    closeUpdateProposalModal();

                    // If on applied tab, refresh the list
                    if (currentTab === 'applied') {
                        fetchJobs('applied');
                    }
                } else {
                    throw new Error(data.message || i18n.failedUpdateProposal);
                }
            } catch (error) {
                console.error('Error updating proposal:', error);
                showUpdateProposalError(error.message || i18n.failedUpdateProposalRetry);
            } finally {
                // Reset button state
                submitUpdateProposalText.textContent = i18n.updateProposalButton;
                submitUpdateProposalLoading.classList.add('hidden');
                submitUpdateProposalBtn.disabled = false;
            }
        }

        // Withdraw proposal function
        async function withdrawProposal(event) {
            event.preventDefault();

            const jobId = document.getElementById('update-proposal-job-id').value;

            // Confirm withdrawal
            if (!confirm(i18n.withdrawConfirm)) {
                return;
            }

            // Show loading state
            submitWithdrawProposalText.textContent = i18n.withdrawing;
            submitWithdrawProposalLoading.classList.remove('hidden');
            submitWithdrawProposalBtn.disabled = true;
            hideUpdateProposalError();

            try {
                const response = await fetch(`/jobs/proposals/${jobId}/withdraw`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || i18n.failedWithdrawProposal);
                }

                if (data.success) {
                    // Show success message
                    showToast(i18n.proposalWithdrawn);

                    // Close modal
                    closeUpdateProposalModal();

                    // If on applied tab, refresh the list
                    if (currentTab === 'applied') {
                        fetchJobs('applied');
                    }

                    // Update the job details modal if it's open
                    const modalJobTitle = document.getElementById('modal-job-title');
                    if (modalJobTitle && modalJobTitle.getAttribute('data-job-id') == jobId) {
                        // Update the button to show "Apply Job" instead of "Update Proposal"
                        const updateBtn = document.getElementById('update-job-btn');
                        const applyBtn = document.getElementById('apply-job-btn');

                        updateBtn.classList.remove('inline-flex');
                        updateBtn.classList.add('hidden');
                        applyBtn.classList.remove('hidden');
                        applyBtn.classList.add('inline-flex');
                        applyBtn.textContent = i18n.applyJob;
                        applyBtn.disabled = false;
                        applyBtn.classList.remove('opacity-30', 'cursor-not-allowed');
                    }
                } else {
                    throw new Error(data.message || i18n.failedWithdrawProposal);
                }
            } catch (error) {
                console.error('Error withdrawing proposal:', error);
                showUpdateProposalError(error.message || i18n.failedWithdrawProposalRetry);
            } finally {
                // Reset button state
                submitWithdrawProposalText.textContent = i18n.withdrawProposalButton;
                submitWithdrawProposalLoading.classList.add('hidden');
                submitWithdrawProposalBtn.disabled = false;
            }
        }

        // Event listeners for proposal modal
        closeProposalModalBtn.addEventListener('click', closeProposalModal);
        cancelProposalModalBtn.addEventListener('click', closeProposalModal);
        proposalForm.addEventListener('submit', submitProposal);

        // Event listeners for update proposal modal
        closeUpdateProposalModalBtn.addEventListener('click', closeUpdateProposalModal);
        cancelUpdateProposalModalBtn.addEventListener('click', closeUpdateProposalModal);
        updateProposalForm.addEventListener('submit', submitUpdateProposal);

        // Add event listener for withdraw proposal button
        submitWithdrawProposalBtn.addEventListener('click', withdrawProposal);

        // Close proposal modal when clicking the dark backdrop
        proposalBackdrop.addEventListener('click', closeProposalModal);

        // Close update proposal modal when clicking the dark backdrop
        updateProposalBackdrop.addEventListener('click', closeUpdateProposalModal);

        // Close proposal modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !proposalModal.classList.contains('hidden')) {
                closeProposalModal();
            }
            if (e.key === 'Escape' && !proposalUpdateModal.classList.contains('hidden')) {
                closeUpdateProposalModal();
            }
        });

        // Helper function to update job saved status in memory
        function updateJobSavedStatus(jobId, isSaved) {
            // Update in allJobsData
            const jobIndex = allJobsData.findIndex(job => job.id === jobId);
            if (jobIndex !== -1) {
                allJobsData[jobIndex].is_saved = isSaved;
            }

            // Update in savedJobsData if needed
            if (isSaved) {
                // Check if job exists in allJobsData to add to savedJobsData
                const jobToAdd = allJobsData.find(job => job.id === jobId);
                if (jobToAdd && !savedJobsData.some(job => job.id === jobId)) {
                    savedJobsData.push({
                        ...jobToAdd,
                        is_saved: true
                    });
                }
            } else {
                // Remove from savedJobsData
                savedJobsData = savedJobsData.filter(job => job.id !== jobId);
            }

            // Also update in inProgressJobsData if the job is there
            const inProgressIndex = inProgressJobsData.findIndex(job => job.id === jobId);
            if (inProgressIndex !== -1) {
                inProgressJobsData[inProgressIndex].is_saved = isSaved;
            }

            // Also update in appliedJobsData if the job is there
            const appliedIndex = appliedJobsData.findIndex(job => job.id === jobId);
            if (appliedIndex !== -1) {
                appliedJobsData[appliedIndex].is_saved = isSaved;
            }
        }

        // Utility functions
        function formatTimeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffInSeconds = Math.floor((now - date) / 1000);

            if (diffInSeconds < 60) return i18n.time.justNow;
            if (diffInSeconds < 3600) {
                const minutes = Math.floor(diffInSeconds / 60);
                const template = minutes === 1 ? i18n.time.minuteAgo : i18n.time.minutesAgo;
                return template.replace(':count', minutes);
            }
            if (diffInSeconds < 86400) {
                const hours = Math.floor(diffInSeconds / 3600);
                const template = hours === 1 ? i18n.time.hourAgo : i18n.time.hoursAgo;
                return template.replace(':count', hours);
            }
            if (diffInSeconds < 604800) {
                const days = Math.floor(diffInSeconds / 86400);
                const template = days === 1 ? i18n.time.dayAgo : i18n.time.daysAgo;
                return template.replace(':count', days);
            }
            if (diffInSeconds < 2592000) {
                const weeks = Math.floor(diffInSeconds / 604800);
                const template = weeks === 1 ? i18n.time.weekAgo : i18n.time.weeksAgo;
                return template.replace(':count', weeks);
            }
            const months = Math.floor(diffInSeconds / 2592000);
            const template = months === 1 ? i18n.time.monthAgo : i18n.time.monthsAgo;
            return template.replace(':count', months);
        }

        function formatDuration(duration) {
            if (!duration) return i18n.notSpecified;

            const durationMap = {
                'less_than_1_month': i18n.durationMap.less_than_1_month,
                '1_to_3_months': i18n.durationMap.one_to_three_months,
                '3_to_6_months': i18n.durationMap.three_to_six_months,
                '6_months_to_1_year': i18n.durationMap.six_months_to_one_year,
                'more_than_1_year': i18n.durationMap.more_than_one_year
            };

            return durationMap[duration] || duration.replace(/_/g, ' ');
        }

        function formatExperienceLevel(experience) {
            if (!experience) return i18n.notSpecified;

            const experienceMap = {
                'entry': i18n.experienceMap.entry,
                'intermediate': i18n.experienceMap.intermediate,
                'expert': i18n.experienceMap.expert
            };

            return experienceMap[experience] || experience.charAt(0).toUpperCase() + experience.slice(1);
        }

        function formatBudgetRange(minUsd, maxUsd) {
            const minAmount = parseFloat(minUsd);
            const maxAmount = parseFloat(maxUsd);

            if (!Number.isFinite(minAmount) || !Number.isFinite(maxAmount)) {
                return i18n.budgetNotSpecified;
            }

            return `$${minAmount.toLocaleString()} - $${maxAmount.toLocaleString()}`;
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
