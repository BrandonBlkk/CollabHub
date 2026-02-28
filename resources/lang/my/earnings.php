<?php

return [
    'meta' => [
        'title' => 'ဝင်ငွေ',
    ],
    'header' => [
        'title' => 'ဝင်ငွေအကျဉ်းချုပ်',
        'subtitle' => 'သင့်ဝင်ငွေ၊ ငွေပေးချေမှုများနှင့် ငွေကြေးဆိုင်ရာလုပ်ဆောင်မှုများကို စောင့်ကြည့်ပါ',
    ],
    'actions' => [
        'export_report' => 'အစီရင်ခံစာ ထုတ်ယူရန်',
        'filter_period' => 'ကာလ စစ်ထုတ်ရန်',
    ],
    'periods' => [
        'this_month' => 'ဒီလ',
        'last_month' => 'ပြီးခဲ့သောလ',
        'last_3_months' => 'နောက်ဆုံး ၃ လ',
        'this_year' => 'ဒီနှစ်',
        'custom_range' => 'ကိုယ်ပိုင် ကာလ',
    ],
    'stats' => [
        'total_earnings' => 'စုစုပေါင်း ဝင်ငွေ',
        'pending_payments' => 'စောင့်ဆိုင်းနေသော ငွေပေးချေမှုများ',
        'avg_hourly_rate' => 'ပျမ်းမျှ နာရီနှုန်း',
        'total_hours' => 'စုစုပေါင်း နာရီ',
        'from_last_month' => 'ပြီးခဲ့သောလနှင့် နှိုင်းယှဉ်လျှင်',
        'from_last_quarter' => 'ပြီးခဲ့သော သုံးလပတ်နှင့် နှိုင်းယှဉ်လျှင်',
        'projects_count' => 'ပရောဂျက် :count ခု',
        'awaiting_payment' => 'ငွေပေးချေမှု စောင့်ဆိုင်းနေ',
    ],
    'chart' => [
        'title' => 'ဝင်ငွေအကျဉ်းချုပ်',
        'monthly' => 'လစဉ်',
        'quarterly' => 'သုံးလပတ်',
        'yearly' => 'နှစ်စဉ်',
        'months' => [
            'jan' => 'ဇန်',
            'feb' => 'ဖေ',
            'mar' => 'မတ်',
            'apr' => 'ဧပြီ',
            'may' => 'မေ',
            'jun' => 'ဇွန်',
        ],
        'legend' => [
            'current_month' => 'ယခုလ',
            'previous_months' => 'ယခင်လများ',
        ],
    ],
    'payment_methods' => [
        'title' => 'ငွေပေးချေမှု နည်းလမ်းများ',
        'primary' => 'အဓိက',
        'secondary' => 'အရန်',
        'add_payment_method' => 'ငွေပေးချေမှု နည်းလမ်း ထည့်မည်',
        'names' => [
            'paypal' => 'PayPal',
            'stripe' => 'Stripe',
            'bank_transfer' => 'ဘဏ်လွှဲပြောင်း',
        ],
        'accounts' => [
            'paypal_email' => 'john.doe@example.com',
            'stripe_mask' => '**** **** **** 4242',
            'bank_account' => 'Chase **** 5678',
        ],
    ],
    'transactions' => [
        'title' => 'နောက်ဆုံး ငွေလွှဲမှုများ',
        'filters' => [
            'all' => 'အားလုံး',
            'completed' => 'ပြီးစီး',
            'pending' => 'စောင့်ဆိုင်း',
            'withdrawn' => 'ထုတ်ယူပြီး',
        ],
        'table' => [
            'project' => 'ပရောဂျက်',
            'client' => 'ကလိုင်းယင့်',
            'date' => 'ရက်စွဲ',
            'type' => 'အမျိုးအစား',
            'amount' => 'ပမာဏ',
            'status' => 'အခြေအနေ',
        ],
        'types' => [
            'fixed_price' => 'စျေးနှုန်းသတ်မှတ်',
            'hourly' => 'နာရီအလိုက်',
        ],
        'statuses' => [
            'completed' => 'ပြီးစီး',
            'pending' => 'စောင့်ဆိုင်း',
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
        'footer' => 'အရောင်းအဝယ် :total ခုအနက် :shown ခုကို ပြထားသည်',
        'pagination' => [
            'previous' => 'ယခင်',
            'next' => 'နောက်',
        ],
    ],
    'withdrawal' => [
        'title' => 'ငွေထုတ်ယူရန်',
        'available' => 'အသုံးပြုနိုင်သည်: :amount',
        'methods' => [
            'paypal' => [
                'name' => 'PayPal',
                'detail' => 'ချက်ချင်းလွှဲပြောင်း - ၁% ဝန်ဆောင်ခ',
                'button' => 'PayPal သို့ ထုတ်ယူမည်',
            ],
            'bank' => [
                'name' => 'ဘဏ်လွှဲပြောင်း',
                'detail' => '၂-၃ အလုပ်လုပ်ရက် - ဝန်ဆောင်ခမရှိ',
                'button' => 'ဘဏ်သို့ ထုတ်ယူမည်',
            ],
        ],
        'history' => [
            'title' => 'ငွေထုတ် မှတ်တမ်း',
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
        'title' => 'အခွန်နှင့် ဘဏ္ဍာရေး အကျဉ်းချုပ်',
        'year_to_date' => 'ယခုနှစ်အထိ အကျဉ်းချုပ်',
        'total_earnings' => 'စုစုပေါင်း ဝင်ငွေ',
        'platform_fees' => 'ပလက်ဖောင်းကြေး (၁၀%)',
        'estimated_tax' => 'ခန့်မှန်း အခွန် (၂၅%)',
        'net_income' => 'အသားတင် ဝင်ငွေ',
        'quarterly_breakdown' => 'သုံးလပတ် အလိုက်',
        'quarters' => [
            'q1' => 'Q1 (Jan-Mar)',
            'q2' => 'Q2 (Apr-Jun)',
            'q3' => 'Q3 (Jul-Sep)',
            'q4' => 'Q4 (Oct-Dec)',
        ],
        'download_reports' => 'အစီရင်ခံစာ ဒေါင်းလုဒ်',
        'reports' => [
            'q1_2023' => 'Q1 2023 အစီရင်ခံစာ',
            'q2_2023' => 'Q2 2023 အစီရင်ခံစာ',
        ],
    ],
    'messages' => [
        'withdraw_unavailable' => 'ငွေထုတ်ယူမှု လုပ်ဆောင်ချက်ကို လက်တွေ့အသုံးပြုမှုတွင် ထည့်သွင်းထားမည်ဖြစ်သည်။',
    ],
];
