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
                        <h3 class="text-lg font-bold text-gray-900" id="modal-title">
                            {{ __('find-jobs.modals.job_details.title') }}</h3>
                        <div class="mt-2">
                            <div class="flex items-center space-x-2">
                                <span id="modal-status" class="px-2 py-1 rounded-full text-xs font-medium"></span>
                                <span id="modal-category"
                                    class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded select-none"></span>
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
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">
                            {{ __('find-jobs.modals.job_details.job_description') }}</h3>
                        <div class="text-sm max-w-none text-gray-700" id="modal-description"></div>
                    </div>

                    <!-- Skills Required -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">
                            {{ __('find-jobs.modals.job_details.skills_required') }}</h3>
                        <div class="flex flex-wrap gap-2" id="modal-skills"></div>
                    </div>

                    <!-- Job Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-2">
                                {{ __('find-jobs.modals.job_details.job_type') }}</h4>
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
                            <h4 class="font-semibold text-gray-900 mb-2">
                                {{ __('find-jobs.modals.job_details.experience_level') }}</h4>
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
                            <h4 class="font-semibold text-gray-900 mb-2">
                                {{ __('find-jobs.modals.job_details.timeline') }}</h4>
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
                            <h4 class="font-semibold text-gray-900 mb-2">
                                {{ __('find-jobs.modals.job_details.proposals') }}</h4>
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
