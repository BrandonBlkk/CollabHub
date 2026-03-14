@props([
    'modalId' => 'proposalModal',
    'triggerSelector' => '[data-action="view-proposals"]',
    'proposalsEndpoint' => null,
    'proposalStatusEndpoint' => null,
    'messagesUrl' => null,
    'csrfToken' => null,
])

@php
    $proposalsEndpoint = $proposalsEndpoint ?? route('my-jobs.proposals', ['my_job' => '__JOB__']);
    $proposalStatusEndpoint =
        $proposalStatusEndpoint ??
        route('my-jobs.proposals.status', ['my_job' => '__JOB__', 'proposal' => '__PROPOSAL__']);
    $messagesUrl = $messagesUrl ?? route('messages.index');
    $csrfToken = $csrfToken ?? csrf_token();
@endphp

<div id="{{ $modalId }}" data-proposals-modal data-proposals-endpoint="{{ $proposalsEndpoint }}"
    data-proposal-status-endpoint="{{ $proposalStatusEndpoint }}" data-messages-url="{{ $messagesUrl }}"
    data-csrf-token="{{ $csrfToken }}" data-trigger-selector="{{ $triggerSelector }}"
    class="fixed inset-0 z-50 hidden transition-opacity duration-300">
    <div data-proposal-backdrop
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300 ease-out opacity-0"></div>
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div data-proposal-modal-content
            class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-lg transition-all duration-300 ease-out sm:my-8 sm:w-full sm:max-w-4xl w-full translate-y-4 opacity-0 scale-95">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 data-proposal-title class="text-xl font-bold text-gray-900">Proposals</h3>
                        <p data-proposal-subtitle class="text-sm text-gray-600 mt-1"></p>
                    </div>
                    <button data-proposal-close type="button" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div data-proposal-feedback class="hidden mb-4 rounded-lg border px-4 py-2 text-sm"></div>
                <div data-proposal-body class="space-y-4 max-h-[70vh] overflow-y-auto">
                    <!-- Proposal content will render here -->
                </div>
                <div class="mt-6 flex justify-end select-none">
                    <button data-proposal-close type="button"
                        class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
