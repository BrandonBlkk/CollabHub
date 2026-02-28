@extends('layouts.app')

@section('title', __('earnings.meta.title'))

@section('content')
    @php
        $chartMonths = [
            ['month' => 'jan', 'height' => 40, 'amount' => '$2,400', 'is_current' => false],
            ['month' => 'feb', 'height' => 80, 'amount' => '$4,800', 'is_current' => false],
            ['month' => 'mar', 'height' => 120, 'amount' => '$7,200', 'is_current' => false],
            ['month' => 'apr', 'height' => 60, 'amount' => '$3,600', 'is_current' => false],
            ['month' => 'may', 'height' => 160, 'amount' => '$9,600', 'is_current' => true],
            ['month' => 'jun', 'height' => 100, 'amount' => '$6,000', 'is_current' => false],
        ];

        $transactions = trans('earnings.transactions.rows');
        $avatarGradients = [
            'from-blue-500 to-teal-400',
            'from-purple-500 to-pink-400',
            'from-green-500 to-blue-400',
            'from-red-500 to-orange-400',
            'from-indigo-500 to-purple-400',
        ];

        $withdrawalHistory = trans('earnings.withdrawal.history_entries');
        $quarterlyBreakdown = [
            ['key' => 'q1', 'amount' => '$4,200'],
            ['key' => 'q2', 'amount' => '$8,380'],
            ['key' => 'q3', 'amount' => '-'],
            ['key' => 'q4', 'amount' => '-'],
        ];
    @endphp

    <!-- Main Content -->
    <div data-withdraw-message="{{ __('earnings.messages.withdraw_unavailable') }}">
        <div class="mb-3">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ __('earnings.header.title') }}</h1>
                    <p class="text-gray-600 mt-2">{{ __('earnings.header.subtitle') }}</p>
                </div>
                <div class="flex space-x-3 select-none">
                    <button
                        class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition duration-200 text-sm font-medium">
                        <i class="fas fa-download mr-2"></i>{{ __('earnings.actions.export_report') }}
                    </button>
                    <button
                        class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black transition duration-200 text-sm font-medium">
                        <i class="far fa-calendar-alt mr-2"></i>{{ __('earnings.actions.filter_period') }}
                    </button>
                </div>
            </div>
            <!-- Period Selector -->
            <div class="mt-6 flex space-x-2 select-none">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">
                    {{ __('earnings.periods.this_month') }}
                </button>
                <button class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg text-sm font-medium hover:bg-gray-200">
                    {{ __('earnings.periods.last_month') }}
                </button>
                <button class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg text-sm font-medium hover:bg-gray-200">
                    {{ __('earnings.periods.last_3_months') }}
                </button>
                <button class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg text-sm font-medium hover:bg-gray-200">
                    {{ __('earnings.periods.this_year') }}
                </button>
                <button class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg text-sm font-medium hover:bg-gray-200">
                    {{ __('earnings.periods.custom_range') }}
                </button>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
            <!-- Total Earnings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ __('earnings.stats.total_earnings') }}</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">$12,580</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="text-green-600 font-medium">&uarr; 18%</span>
                        <span class="text-gray-500 ml-2">{{ __('earnings.stats.from_last_month') }}</span>
                    </div>
                </div>
            </div>

            <!-- Pending Payments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ __('earnings.stats.pending_payments') }}</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">$3,450</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                        <i class="fas fa-clock text-amber-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="text-gray-600 font-medium">{{ __('earnings.stats.projects_count', ['count' => 3]) }}</span>
                        <span class="text-gray-500 ml-2">{{ __('earnings.stats.awaiting_payment') }}</span>
                    </div>
                </div>
            </div>

            <!-- Avg. Hourly Rate -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ __('earnings.stats.avg_hourly_rate') }}</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">$85</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-hourglass-half text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="text-green-600 font-medium">&uarr; $5</span>
                        <span class="text-gray-500 ml-2">{{ __('earnings.stats.from_last_quarter') }}</span>
                    </div>
                </div>
            </div>

            <!-- Total Hours -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ __('earnings.stats.total_hours') }}</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">148</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="text-green-600 font-medium">&uarr; 12%</span>
                        <span class="text-gray-500 ml-2">{{ __('earnings.stats.from_last_month') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Detailed Earnings -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 mb-3">
            <!-- Earnings Chart -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">{{ __('earnings.chart.title') }}</h2>
                    <div class="flex items-center space-x-2 select-none">
                        <button class="px-3 py-1 bg-gray-100 text-gray-800 rounded text-sm">
                            {{ __('earnings.chart.monthly') }}
                        </button>
                        <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded text-sm">
                            {{ __('earnings.chart.quarterly') }}
                        </button>
                        <button class="px-3 py-1 bg-gray-100 text-gray-800 rounded text-sm">
                            {{ __('earnings.chart.yearly') }}
                        </button>
                    </div>
                </div>

                <!-- Chart Container (Static Visualization) -->
                <div class="h-72 flex items-end space-x-4 pt-8">
                    @foreach ($chartMonths as $month)
                        <div class="flex flex-col items-center flex-1">
                            <div class="text-xs text-gray-500 mb-1">{{ __('earnings.chart.months.' . $month['month']) }}</div>
                            <div class="w-full {{ $month['is_current'] ? 'bg-blue-600' : 'bg-blue-100' }} rounded-t-lg"
                                style="height: {{ $month['height'] }}px;"></div>
                            <div class="text-sm font-medium mt-1">{{ $month['amount'] }}</div>
                        </div>
                    @endforeach
                </div>

                <!-- Legend -->
                <div class="flex justify-center mt-8">
                    <div class="flex items-center mr-6">
                        <div class="w-3 h-3 bg-blue-600 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">{{ __('earnings.chart.legend.current_month') }}</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-100 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">{{ __('earnings.chart.legend.previous_months') }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('earnings.payment_methods.title') }}</h2>
                <div class="space-y-4">
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-6 bg-blue-500 rounded flex items-center justify-center mr-3">
                                    <i class="fab fa-cc-paypal text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ __('earnings.payment_methods.names.paypal') }}</h3>
                                    <p class="text-gray-500 text-sm">{{ __('earnings.payment_methods.accounts.paypal_email') }}</p>
                                </div>
                            </div>
                            <span class="text-green-600 text-sm font-medium">{{ __('earnings.payment_methods.primary') }}</span>
                        </div>
                    </div>

                    <div class="p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-6 bg-gray-800 rounded flex items-center justify-center mr-3">
                                    <i class="fab fa-cc-stripe text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ __('earnings.payment_methods.names.stripe') }}</h3>
                                    <p class="text-gray-500 text-sm">{{ __('earnings.payment_methods.accounts.stripe_mask') }}</p>
                                </div>
                            </div>
                            <span class="text-gray-500 text-sm">{{ __('earnings.payment_methods.secondary') }}</span>
                        </div>
                    </div>

                    <div class="p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-6 bg-gradient-to-r from-green-400 to-blue-500 rounded flex items-center justify-center mr-3">
                                    <i class="fas fa-university text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ __('earnings.payment_methods.names.bank_transfer') }}</h3>
                                    <p class="text-gray-500 text-sm">{{ __('earnings.payment_methods.accounts.bank_account') }}</p>
                                </div>
                            </div>
                            <span class="text-gray-500 text-sm">{{ __('earnings.payment_methods.secondary') }}</span>
                        </div>
                    </div>

                    <button
                        class="w-full py-2 border border-dashed border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition duration-200 select-none">
                        <i class="fas fa-plus mr-2"></i>{{ __('earnings.payment_methods.add_payment_method') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-3">
            <div class="px-6 py-5 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">{{ __('earnings.transactions.title') }}</h2>
                    <div class="flex space-x-2 select-none">
                        <button
                            class="px-3 py-1.5 bg-gray-100 text-gray-800 rounded-lg text-sm font-medium hover:bg-gray-200">
                            {{ __('earnings.transactions.filters.all') }}
                        </button>
                        <button
                            class="px-3 py-1.5 bg-gray-100 text-gray-800 rounded-lg text-sm font-medium hover:bg-gray-200">
                            {{ __('earnings.transactions.filters.completed') }}
                        </button>
                        <button class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium">
                            {{ __('earnings.transactions.filters.pending') }}
                        </button>
                        <button
                            class="px-3 py-1.5 bg-gray-100 text-gray-800 rounded-lg text-sm font-medium hover:bg-gray-200">
                            {{ __('earnings.transactions.filters.withdrawn') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('earnings.transactions.table.project') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('earnings.transactions.table.client') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('earnings.transactions.table.date') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('earnings.transactions.table.type') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('earnings.transactions.table.amount') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('earnings.transactions.table.status') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($transactions as $index => $transaction)
                            @php
                                $isPending = ($transaction['status'] ?? 'completed') === 'pending';
                                $isHourly = ($transaction['type'] ?? 'fixed_price') === 'hourly';
                                $typeClasses = $isHourly ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800';
                                $statusClasses = $isPending ? 'bg-amber-100 text-amber-800' : 'bg-green-100 text-green-800';
                                $amountClasses = $isPending ? 'text-amber-600' : 'text-green-600';
                                $avatarGradient = $avatarGradients[$index % count($avatarGradients)];
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $transaction['project'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $transaction['project_id'] }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="h-8 w-8 rounded-full bg-gradient-to-r {{ $avatarGradient }} flex items-center justify-center mr-2">
                                            <span class="text-white text-xs font-bold">{{ $transaction['client_initials'] }}</span>
                                        </div>
                                        <span class="text-gray-900">{{ $transaction['client'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ $transaction['date'] }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-medium {{ $typeClasses }} rounded-full">
                                        {{ __('earnings.transactions.types.' . $transaction['type']) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold {{ $amountClasses }}">{{ $transaction['amount'] }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-medium {{ $statusClasses }} rounded-full">
                                        {{ __('earnings.transactions.statuses.' . $transaction['status']) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        {{ __('earnings.transactions.footer', ['shown' => 5, 'total' => 24]) }}
                    </div>
                    <div class="flex space-x-2">
                        <button
                            class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium hover:bg-gray-50">
                            {{ __('earnings.transactions.pagination.previous') }}
                        </button>
                        <button class="px-3 py-1.5 bg-blue-600 text-white rounded text-sm font-medium">1</button>
                        <button
                            class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium hover:bg-gray-50">2</button>
                        <button
                            class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium hover:bg-gray-50">3</button>
                        <button
                            class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium hover:bg-gray-50">
                            {{ __('earnings.transactions.pagination.next') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Withdrawal & Tax Information -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
            <!-- Withdrawal Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">{{ __('earnings.withdrawal.title') }}</h2>
                    <div class="text-green-600 font-medium">{{ __('earnings.withdrawal.available', ['amount' => '$9,130']) }}
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">{{ __('earnings.withdrawal.methods.paypal.name') }}</h3>
                                <p class="text-gray-500 text-sm">{{ __('earnings.withdrawal.methods.paypal.detail') }}</p>
                            </div>
                            <div class="font-bold">$9,130</div>
                        </div>
                        <button data-withdraw-action="true"
                            class="mt-3 w-full py-2.5 bg-blue-600 text-sm text-white rounded-lg font-medium hover:bg-blue-700 transition duration-200 select-none">
                            {{ __('earnings.withdrawal.methods.paypal.button') }}
                        </button>
                    </div>

                    <div class="p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">{{ __('earnings.withdrawal.methods.bank.name') }}</h3>
                                <p class="text-gray-500 text-sm">{{ __('earnings.withdrawal.methods.bank.detail') }}</p>
                            </div>
                            <div class="font-bold">$9,130</div>
                        </div>
                        <button data-withdraw-action="true"
                            class="mt-3 w-full py-2.5 bg-gray-800 text-sm text-white rounded-lg font-medium hover:bg-black transition duration-200 select-none">
                            {{ __('earnings.withdrawal.methods.bank.button') }}
                        </button>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="font-medium text-gray-900 mb-3">{{ __('earnings.withdrawal.history.title') }}</h3>
                    <div class="space-y-3">
                        @foreach ($withdrawalHistory as $entry)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-700">{{ $entry['label'] }}</span>
                                <span class="font-medium text-green-600">{{ $entry['amount'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Tax & Financial Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('earnings.tax_summary.title') }}</h2>

                <div class="space-y-6">
                    <div>
                        <h3 class="font-medium text-gray-900 mb-3">{{ __('earnings.tax_summary.year_to_date') }}</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">{{ __('earnings.tax_summary.total_earnings') }}</span>
                                <span class="font-bold">$12,580</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">{{ __('earnings.tax_summary.platform_fees') }}</span>
                                <span class="font-bold text-red-600">-$1,258</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">{{ __('earnings.tax_summary.estimated_tax') }}</span>
                                <span class="font-bold text-red-600">-$3,145</span>
                            </div>
                            <div class="pt-3 border-t border-gray-200 flex items-center justify-between">
                                <span class="text-gray-900 font-medium">{{ __('earnings.tax_summary.net_income') }}</span>
                                <span class="font-bold text-green-600">$8,177</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-medium text-gray-900 mb-3">{{ __('earnings.tax_summary.quarterly_breakdown') }}</h3>
                        <div class="space-y-2">
                            @foreach ($quarterlyBreakdown as $quarter)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">{{ __('earnings.tax_summary.quarters.' . $quarter['key']) }}</span>
                                    <span class="font-medium">{{ $quarter['amount'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h3 class="font-medium text-gray-900 mb-3">{{ __('earnings.tax_summary.download_reports') }}</h3>
                        <div class="grid grid-cols-2 gap-3 select-none">
                            <button
                                class="py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-file-pdf text-red-500 text-xl mb-2"></i>
                                    <span class="text-sm font-medium">{{ __('earnings.tax_summary.reports.q1_2023') }}</span>
                                </div>
                            </button>
                            <button
                                class="py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-file-excel text-green-500 text-xl mb-2"></i>
                                    <span class="text-sm font-medium">{{ __('earnings.tax_summary.reports.q2_2023') }}</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/earnings.js')
@endpush
