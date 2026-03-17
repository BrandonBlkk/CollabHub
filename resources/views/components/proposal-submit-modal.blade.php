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
                        <h3 class="text-lg font-bold text-gray-900" id="proposal-modal-title">
                            {{ __('find-jobs.modals.proposal.submit_title') }}</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">{{ __('find-jobs.modals.proposal.job_label') }}: <span
                                    id="proposal-job-title" class="font-medium"></span></p>
                            <p class="text-xs text-gray-500 mt-1">{{ __('find-jobs.modals.proposal.help_text') }}</p>
                        </div>
                    </div>
                    <button type="button" id="close-proposal-modal"
                        class="text-gray-400 hover:text-gray-500 rounded-lg p-2 transition-colors duration-200">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
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
                                <input type="number" id="bid-amount" name="bid_amount" step="0.01" min="1"
                                    class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 text-sm"
                                    placeholder="{{ __('find-jobs.common.amount_placeholder') }}">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ __('find-jobs.modals.proposal.bid_amount_help') }}
                                <span id="min_max_budget"></span>
                            </p>
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
                                <option value="more than 6 months">
                                    {{ __('find-jobs.timeline.more_than_six_months') }}</option>
                                <option value="not sure">{{ __('find-jobs.timeline.not_sure') }}</option>
                                <option value="ongoing support">{{ __('find-jobs.timeline.ongoing_support') }}</option>
                                <option value="to be discussed" selected>
                                    {{ __('find-jobs.timeline.to_be_discussed_default') }}</option>
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
                        <div id="submitSpinner" class="hidden w-5 h-5 border-t-2 border-white rounded-full animate-spin mr-2">
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
