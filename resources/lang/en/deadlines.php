<?php

return [
    'meta' => [
        'title' => 'Upcoming Deadlines',
    ],
    'header' => [
        'title' => 'Upcoming Deadlines',
        'subtitle' => 'Track your next milestones and due dates.',
    ],
    'filters' => [
        'all' => 'All',
        'today' => 'Today',
        'this_week' => 'This Week',
        'overdue' => 'Overdue',
    ],
    'sort' => [
        'label' => 'Sort by',
        'soonest' => 'Soonest',
        'latest' => 'Latest',
        'client' => 'Client',
        'project' => 'Project',
    ],
    'view' => [
        'list' => 'List',
        'timeline' => 'Timeline',
    ],
    'status' => [
        'overdue' => 'Overdue',
        'due_soon' => 'Due soon',
        'on_track' => 'On track',
    ],
    'links' => [
        'job' => 'Job',
        'contract' => 'Contract',
        'messages' => 'Messages',
    ],
    'labels' => [
        'due_in_days' => '{1}Due in :count day|[2,*]Due in :count days',
    ],
    'buttons' => [
        'reminders_on' => 'Reminders On',
        'mark_done' => 'Mark done',
        'request_extension' => 'Request extension',
        'send_update' => 'Send update',
    ],
    'empty_state' => [
        'no_upcoming' => 'No upcoming deadlines found.',
    ],
    'sample_deadlines' => [
        [
            'title' => 'Landing Page Final Review',
            'days' => 1,
            'desc' => 'Approve hero section and CTA updates',
            'date' => 'Feb 13, 2026',
        ],
        [
            'title' => 'API Integration Milestone',
            'days' => 2,
            'desc' => 'Connect payment and invoice endpoints',
            'date' => 'Feb 14, 2026',
        ],
        [
            'title' => 'Mobile UI QA Pass',
            'days' => 3,
            'desc' => 'Resolve responsive issues on iOS and Android',
            'date' => 'Feb 15, 2026',
        ],
        [
            'title' => 'Backend Performance Tuning',
            'days' => 4,
            'desc' => 'Optimize heavy dashboard queries',
            'date' => 'Feb 16, 2026',
        ],
        [
            'title' => 'Client Demo Preparation',
            'days' => 5,
            'desc' => 'Prepare walkthrough and staging data',
            'date' => 'Feb 17, 2026',
        ],
        [
            'title' => 'Auth Flow Regression Test',
            'days' => 6,
            'desc' => 'Validate signup/signin and password reset',
            'date' => 'Feb 18, 2026',
        ],
        [
            'title' => 'Messaging Module Update',
            'days' => 7,
            'desc' => 'Finalize unread badge and thread sorting',
            'date' => 'Feb 19, 2026',
        ],
        [
            'title' => 'Contract Page Cleanup',
            'days' => 8,
            'desc' => 'Update labels and status visibility',
            'date' => 'Feb 20, 2026',
        ],
    ],
];
