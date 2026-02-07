@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <div>
        <div class="mb-3">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Earnings Overview</h1>
                    <p class="text-gray-600 mt-2">Track your income, payments, and financial performance</p>
                </div>
                <div class="flex space-x-3 select-none">
                    <button
                        class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition duration-200 text-sm font-medium">
                        <i class="fas fa-download mr-2"></i>Export Report
                    </button>
                    <button
                        class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black transition duration-200 text-sm font-medium">
                        <i class="far fa-calendar-alt mr-2"></i>Filter Period
                    </button>
                </div>
            </div>
            <!-- Period Selector -->
            <div class="mt-6 flex space-x-2 select-none">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">This Month</button>
                <button class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg text-sm font-medium hover:bg-gray-200">Last
                    Month</button>
                <button class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg text-sm font-medium hover:bg-gray-200">Last 3
                    Months</button>
                <button class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg text-sm font-medium hover:bg-gray-200">This
                    Year</button>
                <button class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg text-sm font-medium hover:bg-gray-200">Custom
                    Range</button>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
            <!-- Total Earnings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Earnings</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">$12,580</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="text-green-600 font-medium">↑ 18%</span>
                        <span class="text-gray-500 ml-2">from last month</span>
                    </div>
                </div>
            </div>

            <!-- Pending Payments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Pending Payments</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">$3,450</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                        <i class="fas fa-clock text-amber-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="text-gray-600 font-medium">3 projects</span>
                        <span class="text-gray-500 ml-2">awaiting payment</span>
                    </div>
                </div>
            </div>

            <!-- Avg. Hourly Rate -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Avg. Hourly Rate</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">$85</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-hourglass-half text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="text-green-600 font-medium">↑ $5</span>
                        <span class="text-gray-500 ml-2">from last quarter</span>
                    </div>
                </div>
            </div>

            <!-- Total Hours -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Hours</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">148</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="text-green-600 font-medium">↑ 12%</span>
                        <span class="text-gray-500 ml-2">from last month</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Detailed Earnings -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 mb-3">
            <!-- Earnings Chart -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Earnings Overview</h2>
                    <div class="flex items-center space-x-2 select-none">
                        <button class="px-3 py-1 bg-gray-100 text-gray-800 rounded text-sm">Monthly</button>
                        <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded text-sm">Quarterly</button>
                        <button class="px-3 py-1 bg-gray-100 text-gray-800 rounded text-sm">Yearly</button>
                    </div>
                </div>

                <!-- Chart Container (Static Visualization) -->
                <div class="h-72 flex items-end space-x-4 pt-8">
                    <div class="flex flex-col items-center flex-1">
                        <div class="text-xs text-gray-500 mb-1">Jan</div>
                        <div class="w-full bg-blue-100 rounded-t-lg" style="height: 40px;"></div>
                        <div class="text-sm font-medium mt-1">$2,400</div>
                    </div>
                    <div class="flex flex-col items-center flex-1">
                        <div class="text-xs text-gray-500 mb-1">Feb</div>
                        <div class="w-full bg-blue-100 rounded-t-lg" style="height: 80px;"></div>
                        <div class="text-sm font-medium mt-1">$4,800</div>
                    </div>
                    <div class="flex flex-col items-center flex-1">
                        <div class="text-xs text-gray-500 mb-1">Mar</div>
                        <div class="w-full bg-blue-100 rounded-t-lg" style="height: 120px;"></div>
                        <div class="text-sm font-medium mt-1">$7,200</div>
                    </div>
                    <div class="flex flex-col items-center flex-1">
                        <div class="text-xs text-gray-500 mb-1">Apr</div>
                        <div class="w-full bg-blue-100 rounded-t-lg" style="height: 60px;"></div>
                        <div class="text-sm font-medium mt-1">$3,600</div>
                    </div>
                    <div class="flex flex-col items-center flex-1">
                        <div class="text-xs text-gray-500 mb-1">May</div>
                        <div class="w-full bg-blue-600 rounded-t-lg" style="height: 160px;"></div>
                        <div class="text-sm font-medium mt-1">$9,600</div>
                    </div>
                    <div class="flex flex-col items-center flex-1">
                        <div class="text-xs text-gray-500 mb-1">Jun</div>
                        <div class="w-full bg-blue-100 rounded-t-lg" style="height: 100px;"></div>
                        <div class="text-sm font-medium mt-1">$6,000</div>
                    </div>
                </div>

                <!-- Legend -->
                <div class="flex justify-center mt-8">
                    <div class="flex items-center mr-6">
                        <div class="w-3 h-3 bg-blue-600 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Current Month</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-100 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Previous Months</span>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Payment Methods</h2>
                <div class="space-y-4">
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-6 bg-blue-500 rounded flex items-center justify-center mr-3">
                                    <i class="fab fa-cc-paypal text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">PayPal</h3>
                                    <p class="text-gray-500 text-sm">john.doe@example.com</p>
                                </div>
                            </div>
                            <span class="text-green-600 text-sm font-medium">Primary</span>
                        </div>
                    </div>

                    <div class="p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-6 bg-gray-800 rounded flex items-center justify-center mr-3">
                                    <i class="fab fa-cc-stripe text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">Stripe</h3>
                                    <p class="text-gray-500 text-sm">•••• •••• •••• 4242</p>
                                </div>
                            </div>
                            <span class="text-gray-500 text-sm">Secondary</span>
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
                                    <h3 class="font-medium text-gray-900">Bank Transfer</h3>
                                    <p class="text-gray-500 text-sm">Chase •••• 5678</p>
                                </div>
                            </div>
                            <span class="text-gray-500 text-sm">Secondary</span>
                        </div>
                    </div>

                    <button
                        class="w-full py-2 border border-dashed border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition duration-200 select-none">
                        <i class="fas fa-plus mr-2"></i>Add Payment Method
                    </button>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-3">
            <div class="px-6 py-5 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">Recent Transactions</h2>
                    <div class="flex space-x-2 select-none">
                        <button
                            class="px-3 py-1.5 bg-gray-100 text-gray-800 rounded-lg text-sm font-medium hover:bg-gray-200">All</button>
                        <button
                            class="px-3 py-1.5 bg-gray-100 text-gray-800 rounded-lg text-sm font-medium hover:bg-gray-200">Completed</button>
                        <button
                            class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium">Pending</button>
                        <button
                            class="px-3 py-1.5 bg-gray-100 text-gray-800 rounded-lg text-sm font-medium hover:bg-gray-200">Withdrawn</button>
                    </div>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Project</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- Transaction 1 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">E-commerce Website</div>
                                <div class="text-sm text-gray-500">Project #PRJ-2456</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center mr-2">
                                        <span class="text-white text-xs font-bold">TC</span>
                                    </div>
                                    <span class="text-gray-900">TechCorp Inc.</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-700">May 15, 2023</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Fixed
                                    Price</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-green-600">$2,400</div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Completed</span>
                            </td>
                        </tr>

                        <!-- Transaction 2 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">Mobile App UI/UX</div>
                                <div class="text-sm text-gray-500">Project #PRJ-2457</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gradient-to-r from-purple-500 to-pink-400 flex items-center justify-center mr-2">
                                        <span class="text-white text-xs font-bold">SD</span>
                                    </div>
                                    <span class="text-gray-900">Startup Dreams</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-700">May 10, 2023</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">Hourly</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-amber-600">$1,650</div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-amber-100 text-amber-800 rounded-full">Pending</span>
                            </td>
                        </tr>

                        <!-- Transaction 3 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">API Integration</div>
                                <div class="text-sm text-gray-500">Project #PRJ-2453</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gradient-to-r from-green-500 to-blue-400 flex items-center justify-center mr-2">
                                        <span class="text-white text-xs font-bold">GA</span>
                                    </div>
                                    <span class="text-gray-900">Global Analytics</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-700">May 5, 2023</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Fixed
                                    Price</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-green-600">$3,200</div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Completed</span>
                            </td>
                        </tr>

                        <!-- Transaction 4 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">Brand Identity Design</div>
                                <div class="text-sm text-gray-500">Project #PRJ-2450</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gradient-to-r from-red-500 to-orange-400 flex items-center justify-center mr-2">
                                        <span class="text-white text-xs font-bold">CC</span>
                                    </div>
                                    <span class="text-gray-900">Creative Co.</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-700">Apr 28, 2023</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">Hourly</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-green-600">$1,850</div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Completed</span>
                            </td>
                        </tr>

                        <!-- Transaction 5 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">SEO Optimization</div>
                                <div class="text-sm text-gray-500">Project #PRJ-2448</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gradient-to-r from-indigo-500 to-purple-400 flex items-center justify-center mr-2">
                                        <span class="text-white text-xs font-bold">DM</span>
                                    </div>
                                    <span class="text-gray-900">Digital Marketing Pro</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-700">Apr 20, 2023</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Fixed
                                    Price</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-amber-600">$1,200</div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-amber-100 text-amber-800 rounded-full">Pending</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Showing <span class="font-medium">5</span> of <span class="font-medium">24</span> transactions
                    </div>
                    <div class="flex space-x-2">
                        <button
                            class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium hover:bg-gray-50">Previous</button>
                        <button class="px-3 py-1.5 bg-blue-600 text-white rounded text-sm font-medium">1</button>
                        <button
                            class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium hover:bg-gray-50">2</button>
                        <button
                            class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium hover:bg-gray-50">3</button>
                        <button
                            class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium hover:bg-gray-50">Next</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Withdrawal & Tax Information -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
            <!-- Withdrawal Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Withdraw Funds</h2>
                    <div class="text-green-600 font-medium">Available: $9,130</div>
                </div>

                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">PayPal</h3>
                                <p class="text-gray-500 text-sm">Instant transfer • 1% fee</p>
                            </div>
                            <div class="font-bold">$9,130</div>
                        </div>
                        <button
                            class="mt-3 w-full py-2.5 bg-blue-600 text-sm text-white rounded-lg font-medium hover:bg-blue-700 transition duration-200 select-none">
                            Withdraw to PayPal
                        </button>
                    </div>

                    <div class="p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">Bank Transfer</h3>
                                <p class="text-gray-500 text-sm">2-3 business days • No fee</p>
                            </div>
                            <div class="font-bold">$9,130</div>
                        </div>
                        <button
                            class="mt-3 w-full py-2.5 bg-gray-800 text-sm text-white rounded-lg font-medium hover:bg-black transition duration-200 select-none">
                            Withdraw to Bank
                        </button>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="font-medium text-gray-900 mb-3">Withdrawal History</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700">Apr 15, 2023 • PayPal</span>
                            <span class="font-medium text-green-600">+$2,500</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700">Mar 28, 2023 • Bank Transfer</span>
                            <span class="font-medium text-green-600">+$3,000</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700">Mar 10, 2023 • PayPal</span>
                            <span class="font-medium text-green-600">+$1,800</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tax & Financial Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Tax & Financial Summary</h2>

                <div class="space-y-6">
                    <div>
                        <h3 class="font-medium text-gray-900 mb-3">Year-to-Date Summary</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Total Earnings</span>
                                <span class="font-bold">$12,580</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Platform Fees (10%)</span>
                                <span class="font-bold text-red-600">-$1,258</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Estimated Tax (25%)</span>
                                <span class="font-bold text-red-600">-$3,145</span>
                            </div>
                            <div class="pt-3 border-t border-gray-200 flex items-center justify-between">
                                <span class="text-gray-900 font-medium">Net Income</span>
                                <span class="font-bold text-green-600">$8,177</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-medium text-gray-900 mb-3">Quarterly Breakdown</h3>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Q1 (Jan-Mar)</span>
                                <span class="font-medium">$4,200</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Q2 (Apr-Jun)</span>
                                <span class="font-medium">$8,380</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Q3 (Jul-Sep)</span>
                                <span class="font-medium">-</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Q4 (Oct-Dec)</span>
                                <span class="font-medium">-</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-medium text-gray-900 mb-3">Download Reports</h3>
                        <div class="grid grid-cols-2 gap-3 select-none">
                            <button
                                class="py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-file-pdf text-red-500 text-xl mb-2"></i>
                                    <span class="text-sm font-medium">Q1 2023 Report</span>
                                </div>
                            </button>
                            <button
                                class="py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-file-excel text-green-500 text-xl mb-2"></i>
                                    <span class="text-sm font-medium">Q2 2023 Report</span>
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
