<?php

return [
    'meta' => [
        'title' => 'Earnings',
    ],
    'header' => [
        'title' => 'Earnings Overview',
        'subtitle' => 'Track your income, payments, and financial performance',
    ],
    'actions' => [
        'export_report' => 'Export Report',
        'filter_period' => 'Filter Period',
    ],
    'periods' => [
        'this_month' => 'This Month',
        'last_month' => 'Last Month',
        'last_3_months' => 'Last 3 Months',
        'this_year' => 'This Year',
        'custom_range' => 'Custom Range',
    ],
    'stats' => [
        'total_earnings' => 'Total Earnings',
        'pending_payments' => 'Pending Payments',
        'avg_hourly_rate' => 'Avg. Hourly Rate',
        'total_hours' => 'Total Hours',
        'from_last_month' => 'from last month',
        'from_last_quarter' => 'from last quarter',
        'projects_count' => ':count projects',
        'awaiting_payment' => 'awaiting payment',
    ],
    'chart' => [
        'title' => 'Earnings Overview',
        'monthly' => 'Monthly',
        'quarterly' => 'Quarterly',
        'yearly' => 'Yearly',
        'months' => [
            'jan' => 'Jan',
            'feb' => 'Feb',
            'mar' => 'Mar',
            'apr' => 'Apr',
            'may' => 'May',
            'jun' => 'Jun',
        ],
        'legend' => [
            'current_month' => 'Current Month',
            'previous_months' => 'Previous Months',
        ],
    ],
    'payment_methods' => [
        'title' => 'Payment Methods',
        'primary' => 'Primary',
        'secondary' => 'Secondary',
        'add_payment_method' => 'Add Payment Method',
        'names' => [
            'paypal' => 'PayPal',
            'stripe' => 'Stripe',
            'bank_transfer' => 'Bank Transfer',
        ],
        'accounts' => [
            'paypal_email' => 'john.doe@example.com',
            'stripe_mask' => '**** **** **** 4242',
            'bank_account' => 'Chase **** 5678',
        ],
    ],
    'transactions' => [
        'title' => 'Recent Transactions',
        'filters' => [
            'all' => 'All',
            'completed' => 'Completed',
            'pending' => 'Pending',
            'withdrawn' => 'Withdrawn',
        ],
        'table' => [
            'project' => 'Project',
            'client' => 'Client',
            'date' => 'Date',
            'type' => 'Type',
            'amount' => 'Amount',
            'status' => 'Status',
        ],
        'types' => [
            'fixed_price' => 'Fixed Price',
            'hourly' => 'Hourly',
        ],
        'statuses' => [
            'completed' => 'Completed',
            'pending' => 'Pending',
        ],
        'rows' => [
            [
                'project' => 'E-commerce Website',
                'project_id' => 'Project #PRJ-2456',
                'client' => 'TechCorp Inc.',
                'client_initials' => 'TC',
                'date' => 'May 15, 2023',
                'type' => 'fixed_price',
                'amount' => '$2,400',
                'status' => 'completed',
            ],
            [
                'project' => 'Mobile App UI/UX',
                'project_id' => 'Project #PRJ-2457',
                'client' => 'Startup Dreams',
                'client_initials' => 'SD',
                'date' => 'May 10, 2023',
                'type' => 'hourly',
                'amount' => '$1,650',
                'status' => 'pending',
            ],
            [
                'project' => 'API Integration',
                'project_id' => 'Project #PRJ-2453',
                'client' => 'Global Analytics',
                'client_initials' => 'GA',
                'date' => 'May 5, 2023',
                'type' => 'fixed_price',
                'amount' => '$3,200',
                'status' => 'completed',
            ],
            [
                'project' => 'Brand Identity Design',
                'project_id' => 'Project #PRJ-2450',
                'client' => 'Creative Co.',
                'client_initials' => 'CC',
                'date' => 'Apr 28, 2023',
                'type' => 'hourly',
                'amount' => '$1,850',
                'status' => 'completed',
            ],
            [
                'project' => 'SEO Optimization',
                'project_id' => 'Project #PRJ-2448',
                'client' => 'Digital Marketing Pro',
                'client_initials' => 'DM',
                'date' => 'Apr 20, 2023',
                'type' => 'fixed_price',
                'amount' => '$1,200',
                'status' => 'pending',
            ],
        ],
        'footer' => 'Showing :shown of :total transactions',
        'pagination' => [
            'previous' => 'Previous',
            'next' => 'Next',
        ],
    ],
    'withdrawal' => [
        'title' => 'Withdraw Funds',
        'available' => 'Available: :amount',
        'methods' => [
            'paypal' => [
                'name' => 'PayPal',
                'detail' => 'Instant transfer - 1% fee',
                'button' => 'Withdraw to PayPal',
            ],
            'bank' => [
                'name' => 'Bank Transfer',
                'detail' => '2-3 business days - No fee',
                'button' => 'Withdraw to Bank',
            ],
        ],
        'history' => [
            'title' => 'Withdrawal History',
        ],
        'history_entries' => [
            [
                'label' => 'Apr 15, 2023 - PayPal',
                'amount' => '+$2,500',
            ],
            [
                'label' => 'Mar 28, 2023 - Bank Transfer',
                'amount' => '+$3,000',
            ],
            [
                'label' => 'Mar 10, 2023 - PayPal',
                'amount' => '+$1,800',
            ],
        ],
    ],
    'tax_summary' => [
        'title' => 'Tax & Financial Summary',
        'year_to_date' => 'Year-to-Date Summary',
        'total_earnings' => 'Total Earnings',
        'platform_fees' => 'Platform Fees (10%)',
        'estimated_tax' => 'Estimated Tax (25%)',
        'net_income' => 'Net Income',
        'quarterly_breakdown' => 'Quarterly Breakdown',
        'quarters' => [
            'q1' => 'Q1 (Jan-Mar)',
            'q2' => 'Q2 (Apr-Jun)',
            'q3' => 'Q3 (Jul-Sep)',
            'q4' => 'Q4 (Oct-Dec)',
        ],
        'download_reports' => 'Download Reports',
        'reports' => [
            'q1_2023' => 'Q1 2023 Report',
            'q2_2023' => 'Q2 2023 Report',
        ],
    ],
    'messages' => [
        'withdraw_unavailable' => 'Withdrawal feature would be implemented in a live application.',
    ],
];
