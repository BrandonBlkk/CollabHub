function createProposalModalController(proposalModal) {
    if (!proposalModal) {
        return null;
    }

    const proposalsEndpointTemplate = proposalModal.dataset.proposalsEndpoint;
    const proposalStatusEndpointTemplate = proposalModal.dataset.proposalStatusEndpoint;
    const messagesUrl = proposalModal.dataset.messagesUrl;
    const csrfToken = proposalModal.dataset.csrfToken;

    if (!proposalsEndpointTemplate || !proposalStatusEndpointTemplate) {
        return null;
    }

    const proposalBackdrop = proposalModal.querySelector('[data-proposal-backdrop]');
    const proposalModalContent = proposalModal.querySelector('[data-proposal-modal-content]');
    const proposalModalBody = proposalModal.querySelector('[data-proposal-body]');
    const proposalModalTitle = proposalModal.querySelector('[data-proposal-title]');
    const proposalModalSubtitle = proposalModal.querySelector('[data-proposal-subtitle]');
    const proposalModalFeedback = proposalModal.querySelector('[data-proposal-feedback]');
    const closeProposalButtons = proposalModal.querySelectorAll('[data-proposal-close]');

    let activeProposalTrigger = null;
    let activeProposalJobId = null;
    let activeProposalJobTitle = null;
    let activeProposalJobBudget = null;

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    function formatTimeAgo(dateString) {
        if (!dateString) {
            return 'Just now';
        }

        const date = new Date(dateString);
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);

        if (diffInSeconds < 60) return 'Just now';

        if (diffInSeconds < 3600) {
            const minutes = Math.floor(diffInSeconds / 60);
            return `${minutes} minute${minutes === 1 ? '' : 's'} ago`;
        }

        if (diffInSeconds < 86400) {
            const hours = Math.floor(diffInSeconds / 3600);
            return `${hours} hour${hours === 1 ? '' : 's'} ago`;
        }

        if (diffInSeconds < 604800) {
            const days = Math.floor(diffInSeconds / 86400);
            return `${days} day${days === 1 ? '' : 's'} ago`;
        }

        if (diffInSeconds < 2592000) {
            const weeks = Math.floor(diffInSeconds / 604800);
            return `${weeks} week${weeks === 1 ? '' : 's'} ago`;
        }

        const months = Math.floor(diffInSeconds / 2592000);
        return `${months} month${months === 1 ? '' : 's'} ago`;
    }

    function formatCurrency(amount, suffix = '') {
        const value = Number(amount);
        if (!Number.isFinite(value)) {
            return 'Negotiable';
        }

        return `$${value.toLocaleString()}${suffix}`;
    }

    function getInitials(name) {
        const parts = String(name || '').trim().split(/\s+/).filter(Boolean);
        if (parts.length === 0) {
            return 'F';
        }

        const first = parts[0].charAt(0).toUpperCase();
        const second = parts[1] ? parts[1].charAt(0).toUpperCase() : '';
        return `${first}${second}`.trim();
    }

    function formatProposalText(text) {
        if (!text) {
            return '<span class="text-gray-500 italic">No proposal message provided.</span>';
        }

        return escapeHtml(String(text)).replace(/\n/g, '<br>');
    }

    function getProposalStatusMeta(status) {
        const normalized = status || 'pending';
        const map = {
            accepted: {
                label: 'Accepted',
                className: 'bg-green-100 text-green-800 select-none'
            },
            declined: {
                label: 'Declined',
                className: 'bg-red-100 text-red-800 select-none'
            },
            pending: {
                label: 'Pending',
                className: 'bg-amber-100 text-amber-800 select-none'
            },
        };

        return map[normalized] || map.pending;
    }

    function getBudgetFitMeta(bidAmount) {
        if (!activeProposalJobBudget) {
            return null;
        }

        const min = Number(activeProposalJobBudget.budget_min);
        const max = Number(activeProposalJobBudget.budget_max);
        const bid = Number(bidAmount);

        if (!Number.isFinite(bid)) {
            return null;
        }

        if (Number.isFinite(min) && bid < min) {
            return {
                label: 'Below budget',
                className: 'bg-blue-50 text-blue-700 select-none',
            };
        }

        if (Number.isFinite(max) && bid > max) {
            return {
                label: 'Above budget',
                className: 'bg-red-50 text-red-700 select-none',
            };
        }

        if (Number.isFinite(min) || Number.isFinite(max)) {
            return {
                label: 'Within budget',
                className: 'bg-green-50 text-green-700 select-none',
            };
        }

        return null;
    }

    function buildMessageTemplate(name, jobTitle) {
        const safeName = name || 'there';
        const safeJobTitle = jobTitle || 'your proposal';
        return `Hi ${safeName},\n\nThanks for submitting your proposal for "${safeJobTitle}". I reviewed your bid and would like to discuss next steps.\n\n- ${document.title}`;
    }

    function setProposalModalTitle(title, count) {
        if (proposalModalTitle) {
            proposalModalTitle.textContent = title || 'Proposals';
        }

        if (!proposalModalSubtitle) {
            return;
        }

        if (count === null || typeof count === 'undefined') {
            proposalModalSubtitle.textContent = 'Loading proposals...';
            return;
        }

        proposalModalSubtitle.textContent = `${count} proposal${count === 1 ? '' : 's'} received`;
    }

    function showProposalFeedback(type, message) {
        if (!proposalModalFeedback) {
            return;
        }

        proposalModalFeedback.classList.remove(
            'hidden',
            'border-red-200',
            'bg-red-50',
            'text-red-700',
            'border-green-200',
            'bg-green-50',
            'text-green-700'
        );

        if (type === 'success') {
            proposalModalFeedback.classList.add('border-green-200', 'bg-green-50', 'text-green-700');
        } else {
            proposalModalFeedback.classList.add('border-red-200', 'bg-red-50', 'text-red-700');
        }

        proposalModalFeedback.textContent = message;
    }

    function clearProposalFeedback() {
        if (!proposalModalFeedback) {
            return;
        }

        proposalModalFeedback.textContent = '';
        proposalModalFeedback.classList.add('hidden');
    }

    function openProposalModal() {
        if (!proposalModal || !proposalBackdrop || !proposalModalContent) {
            return;
        }

        proposalModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        void proposalModal.offsetWidth;

        setTimeout(() => {
            proposalBackdrop.classList.remove('opacity-0');
            proposalBackdrop.classList.add('opacity-100');
        }, 10);

        setTimeout(() => {
            proposalModalContent.classList.remove('translate-y-4', 'opacity-0', 'scale-95');
            proposalModalContent.classList.add('translate-y-0', 'opacity-100', 'scale-100');
        }, 10);
    }

    function closeProposalModal() {
        if (!proposalModal || !proposalBackdrop || !proposalModalContent) {
            return;
        }

        proposalModalContent.classList.remove('translate-y-0', 'opacity-100', 'scale-100');
        proposalModalContent.classList.add('translate-y-4', 'opacity-0', 'scale-95');

        proposalBackdrop.classList.remove('opacity-100');
        proposalBackdrop.classList.add('opacity-0');

        setTimeout(() => {
            proposalModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }

    function renderProposalLoading() {
        if (!proposalModalBody) {
            return;
        }

        proposalModalBody.innerHTML = `
            <div class="border border-gray-200 rounded-lg p-4 animate-pulse">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-4 bg-gray-200 rounded w-1/3"></div>
                    <div class="h-4 bg-gray-200 rounded w-20"></div>
                </div>
                <div class="h-3 bg-gray-200 rounded w-2/3 mb-2"></div>
                <div class="h-3 bg-gray-200 rounded w-full mb-2"></div>
                <div class="h-3 bg-gray-200 rounded w-5/6"></div>
            </div>
            <div class="border border-gray-200 rounded-lg p-4 animate-pulse">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-4 bg-gray-200 rounded w-1/3"></div>
                    <div class="h-4 bg-gray-200 rounded w-20"></div>
                </div>
                <div class="h-3 bg-gray-200 rounded w-2/3 mb-2"></div>
                <div class="h-3 bg-gray-200 rounded w-full mb-2"></div>
                <div class="h-3 bg-gray-200 rounded w-5/6"></div>
            </div>
        `;
    }

    function renderProposalEmpty() {
        if (!proposalModalBody) {
            return;
        }

        proposalModalBody.innerHTML = `
            <div class="text-center py-10">
                <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-900">No proposals yet</h4>
                <p class="text-sm text-gray-600 mt-1">Freelancers have not submitted proposals for this job.</p>
            </div>
        `;
    }

    function renderProposalError(message) {
        if (!proposalModalBody) {
            return;
        }

        proposalModalBody.innerHTML = `
            <div class="border border-red-200 bg-red-50 text-red-700 rounded-lg p-4 text-center">
                <p class="font-medium">${escapeHtml(message)}</p>
                <button type="button" data-action="retry-proposals"
                    class="mt-3 px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm font-medium">
                    Retry
                </button>
            </div>
        `;

        proposalModalBody.querySelector('[data-action="retry-proposals"]')?.addEventListener('click', () => {
            if (activeProposalJobId) {
                fetchProposals(activeProposalJobId, activeProposalJobTitle, activeProposalTrigger);
            }
        });
    }

    function updateProposalButtonCount(button, count) {
        if (!button) {
            return;
        }

        const countElement = button.querySelector('[data-proposals-count]');
        if (countElement) {
            countElement.textContent = String(count);
        }
    }

    function renderProposalsList(proposals) {
        if (!proposalModalBody) {
            return;
        }

        const cards = proposals.map((proposal) => {
            const freelancer = proposal.freelancer || {};
            const name = freelancer.name || 'Unknown Freelancer';
            const initials = getInitials(name);
            const photoUrl = freelancer.profile_photo_url;
            const profileUrl = freelancer.profile_url;
            const jobTitle = freelancer.job_title || 'Freelancer';
            const status = proposal.status || 'pending';
            const statusMeta = getProposalStatusMeta(status);
            const isAccepted = status === 'accepted';
            const isDeclined = status === 'declined';
            const ratingValue = Number(freelancer.rating);
            const ratingCount = Number(freelancer.rating_count);
            const ratingText = Number.isFinite(ratingValue) && ratingValue > 0 ?
                `${ratingValue.toFixed(1)} (${Number.isFinite(ratingCount) ? ratingCount : 0})` :
                'No ratings';
            const yearsExp = freelancer.years_experience ?
                `${freelancer.years_experience} yrs exp` :
                null;
            const availability = freelancer.availability || null;
            const hourlyRate = freelancer.hourly_rate ?
                `${formatCurrency(freelancer.hourly_rate, '/hr')}` :
                null;
            const jobSuccess = freelancer.job_success_rate ?
                `${Number(freelancer.job_success_rate).toFixed(0)}% job success` :
                null;
            const totalEarned = freelancer.total_earned ?
                `${formatCurrency(freelancer.total_earned)} earned` :
                null;
            const completedProjects = freelancer.completed_projects ?
                `${freelancer.completed_projects} completed` :
                null;
            const responseTime = freelancer.response_time ?
                `Responds in ${freelancer.response_time} hr` :
                null;
            const languages = Array.isArray(freelancer.languages) && freelancer.languages.length ?
                `Languages: ${freelancer.languages.join(', ')}` :
                null;
            const submitted = formatTimeAgo(proposal.created_at);
            const bid = formatCurrency(proposal.bid_amount);
            const timeline = proposal.estimated_timeline ?
                escapeHtml(String(proposal.estimated_timeline)) :
                'Timeline not specified';
            const proposalText = formatProposalText(proposal.proposal_text);
            const budgetFit = getBudgetFitMeta(proposal.bid_amount);
            const metaItems = [ratingText, yearsExp, availability].filter(Boolean);
            const metaHtml = metaItems.length ?
                metaItems.map((item, index) =>
                    `${index > 0 ? '<span class="text-gray-300">&bull;</span>' : ''}<span class="text-xs text-gray-500">${escapeHtml(String(item))}</span>`
                ).join(' ') :
                '<span class="text-xs text-gray-500">No additional details</span>';
            const statChips = [hourlyRate, jobSuccess, totalEarned, completedProjects, responseTime]
                .filter(Boolean)
                .map((item) =>
                    `<span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">${escapeHtml(String(item))}</span>`
                ).join('');

            const avatarHtml = photoUrl ?
                `<img src="${escapeHtml(photoUrl)}" alt="${escapeHtml(name)}" class="w-12 h-12 rounded-full object-cover">` :
                `<span class="text-white font-bold text-sm">${escapeHtml(initials)}</span>`;

            const nameHtml = profileUrl ?
                `<a href="${escapeHtml(profileUrl)}" class="text-gray-900 hover:text-blue-600">${escapeHtml(name)}</a>` :
                escapeHtml(name);

            return `
                <div class="border border-gray-200 rounded-lg p-4" data-proposal-id="${escapeHtml(proposal.id)}">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-3">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center select-none">
                                ${avatarHtml}
                            </div>
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <h4 class="font-semibold text-gray-900">${nameHtml}</h4>
                                    <span class="px-2 py-1 rounded-full text-xs font-medium ${statusMeta.className}"
                                        data-proposal-status>${statusMeta.label}</span>
                                    ${budgetFit ? `<span class="px-2 py-1 rounded-full text-xs font-medium ${budgetFit.className}">${budgetFit.label}</span>` : ''}
                                </div>
                                <p class="text-sm text-gray-600 mt-1">${escapeHtml(jobTitle)}</p>
                                <div class="flex items-center space-x-2 mt-2">
                                    ${metaHtml}
                                </div>
                                ${languages ? `<div class="text-xs text-gray-500 mt-2">${escapeHtml(languages)}</div>` : ''}
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">Bid</p>
                            <p class="text-sm font-semibold text-gray-900">${bid}</p>
                            <p class="text-xs text-gray-500 mt-1">${timeline}</p>
                            <p class="text-xs text-gray-400 mt-2">${submitted}</p>
                        </div>
                    </div>
                    ${statChips ? `<div class="mt-3 flex flex-wrap gap-2 select-none">${statChips}</div>` : ''}
                    <div class="mt-4 text-sm text-gray-700 leading-relaxed">
                        ${proposalText}
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2 select-none">
                        <button type="button" data-proposal-action="accept" data-proposal-id="${escapeHtml(proposal.id)}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg border border-emerald-200 text-emerald-700 hover:bg-emerald-50 transition ${isAccepted || isDeclined ? 'opacity-50 cursor-not-allowed' : ''}"
                            ${isAccepted || isDeclined ? 'disabled' : ''}>
                            Accept
                        </button>
                        <button type="button" data-proposal-action="decline" data-proposal-id="${escapeHtml(proposal.id)}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg border border-red-200 text-red-700 hover:bg-red-50 transition ${isAccepted || isDeclined ? 'opacity-50 cursor-not-allowed' : ''}"
                            ${isAccepted || isDeclined ? 'disabled' : ''}>
                            Decline
                        </button>
                        <button type="button" data-proposal-action="message" data-proposal-id="${escapeHtml(proposal.id)}"
                            data-freelancer-name="${escapeHtml(name)}"
                            data-freelancer-user-id="${escapeHtml(freelancer.user_id || '')}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg border border-blue-200 text-blue-700 hover:bg-blue-50 transition">
                            Message
                        </button>
                        ${profileUrl ? `<a href="${escapeHtml(profileUrl)}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50 transition">View Profile</a>` : ''}
                    </div>
                </div>
            `;
        }).join('');

        proposalModalBody.innerHTML = cards;
    }

    async function fetchProposals(jobId, jobTitle, triggerButton) {
        if (!jobId) {
            return;
        }

        activeProposalTrigger = triggerButton || null;
        activeProposalJobId = jobId;
        activeProposalJobTitle = jobTitle || 'Proposals';
        activeProposalJobBudget = null;

        clearProposalFeedback();
        setProposalModalTitle(activeProposalJobTitle, null);
        renderProposalLoading();
        openProposalModal();

        const endpoint = proposalsEndpointTemplate.replace('__JOB__', encodeURIComponent(String(jobId)));

        try {
            const response = await fetch(endpoint, {
                method: 'GET',
                headers: {
                    Accept: 'application/json',
                },
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Failed to load proposals.');
            }

            const proposals = Array.isArray(data.proposals) ? data.proposals : [];
            const count = proposals.length;
            activeProposalJobBudget = data.job || null;

            setProposalModalTitle(data.job?.title || activeProposalJobTitle, count);
            updateProposalButtonCount(activeProposalTrigger, count);

            if (count === 0) {
                renderProposalEmpty();
                return;
            }

            renderProposalsList(proposals);
        } catch (error) {
            console.error('Proposal load failed:', error);
            renderProposalError(error.message || 'Failed to load proposals.');
        }
    }

    function updateProposalCardStatus(proposalId, status) {
        if (!proposalModalBody) {
            return;
        }

        const card = proposalModalBody.querySelector(`[data-proposal-id="${proposalId}"]`);
        if (!card) {
            return;
        }

        const statusMeta = getProposalStatusMeta(status);
        const statusBadge = card.querySelector('[data-proposal-status]');
        if (statusBadge) {
            statusBadge.textContent = statusMeta.label;
            statusBadge.className = `px-2 py-1 rounded-full text-xs font-medium ${statusMeta.className}`;
        }

        card.querySelectorAll('[data-proposal-action="accept"], [data-proposal-action="decline"]').forEach(
            (button) => {
                button.disabled = true;
                button.classList.add('opacity-50', 'cursor-not-allowed');
            }
        );
    }

    async function updateProposalStatus(proposalId, status) {
        if (!proposalId || !activeProposalJobId) {
            return;
        }

        clearProposalFeedback();

        const endpoint = proposalStatusEndpointTemplate
            .replace('__JOB__', encodeURIComponent(String(activeProposalJobId)))
            .replace('__PROPOSAL__', encodeURIComponent(String(proposalId)));

        try {
            const response = await fetch(endpoint, {
                method: 'PATCH',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    status,
                }),
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Unable to update proposal.');
            }

            updateProposalCardStatus(proposalId, data.proposal?.status || status);
            showProposalFeedback('success', data.message || 'Proposal updated successfully.');
        } catch (error) {
            console.error('Proposal status update failed:', error);
            showProposalFeedback('error', error.message || 'Failed to update proposal status.');
        }
    }

    async function handleProposalMessage(button) {
        if (!button || !messagesUrl) {
            return;
        }

        const freelancerName = button.dataset.freelancerName || 'there';
        const template = buildMessageTemplate(freelancerName, activeProposalJobTitle);

        try {
            await navigator.clipboard.writeText(template);
            showProposalFeedback('success', 'Message template copied. Opening messages...');
            window.open(messagesUrl, '_blank');
        } catch (error) {
            showProposalFeedback('error', 'Unable to copy message. You can still message from the inbox.');
            window.open(messagesUrl, '_blank');
        }
    }

    proposalModalBody?.addEventListener('click', (event) => {
        const button = event.target.closest('[data-proposal-action]');
        if (!button || button.disabled) {
            return;
        }

        const proposalId = button.dataset.proposalId;
        if (!proposalId) {
            return;
        }

        const action = button.dataset.proposalAction;
        if (action === 'accept') {
            updateProposalStatus(proposalId, 'accepted');
        } else if (action === 'decline') {
            updateProposalStatus(proposalId, 'declined');
        } else if (action === 'message') {
            handleProposalMessage(button);
        }
    });

    closeProposalButtons.forEach((button) => {
        button.addEventListener('click', closeProposalModal);
    });

    proposalBackdrop?.addEventListener('click', closeProposalModal);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && proposalModal && !proposalModal.classList.contains('hidden')) {
            closeProposalModal();
        }
    });

    return {
        modalId: proposalModal.id || '',
        triggerSelector: proposalModal.dataset.triggerSelector || '[data-action="view-proposals"]',
        fetchProposals,
    };
}

document.addEventListener('DOMContentLoaded', () => {
    const modalElements = Array.from(document.querySelectorAll('[data-proposals-modal]'));
    if (modalElements.length === 0) {
        return;
    }

    const controllers = [];
    modalElements.forEach((modal) => {
        const controller = createProposalModalController(modal);
        if (controller) {
            controllers.push(controller);
        }
    });

    if (controllers.length === 0) {
        return;
    }

    document.addEventListener('click', (event) => {
        for (const controller of controllers) {
            const trigger = event.target.closest(controller.triggerSelector);
            if (!trigger) {
                continue;
            }

            const jobId = trigger.dataset.jobId;
            if (!jobId) {
                return;
            }

            const targetId = trigger.dataset.proposalsTarget || trigger.dataset.modalTarget;
            if (targetId && controller.modalId && targetId !== controller.modalId) {
                continue;
            }

            event.preventDefault();
            const jobTitle = trigger.dataset.jobTitle || 'Proposals';
            controller.fetchProposals(jobId, jobTitle, trigger);
            return;
        }

    });
});
