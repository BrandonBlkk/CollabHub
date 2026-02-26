<header class="bg-white border-b border-gray-200 px-3 py-4">
    @php
        $preferredCurrency = strtoupper(Auth::user()?->settings?->currency ?? 'USD');
        $currencyOptions = [
            'USD' => ['flag_url' => 'https://flagcdn.com/w20/us.png', 'flag_alt' => 'US', 'label' => 'US Dollar'],
            'MMK' => ['flag_url' => 'https://flagcdn.com/w20/mm.png', 'flag_alt' => 'MM', 'label' => 'Myanmar Kyat'],
            'EUR' => ['flag_url' => 'https://flagcdn.com/w20/eu.png', 'flag_alt' => 'EU', 'label' => 'Euro'],
            'GBP' => ['flag_url' => 'https://flagcdn.com/w20/gb.png', 'flag_alt' => 'GB', 'label' => 'British Pound'],
            'CAD' => ['flag_url' => 'https://flagcdn.com/w20/ca.png', 'flag_alt' => 'CA', 'label' => 'Canadian Dollar'],
            'AUD' => [
                'flag_url' => 'https://flagcdn.com/w20/au.png',
                'flag_alt' => 'AU',
                'label' => 'Australian Dollar',
            ],
        ];
        $activeCurrencyMeta = $currencyOptions[$preferredCurrency] ?? $currencyOptions['USD'];
    @endphp

    <div class="flex items-center justify-between gap-3">
        <!-- Mobile menu button -->
        <button class="lg:hidden text-gray-500 hover:text-gray-700" id="sidebarToggle">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <div class="flex items-center w-full gap-3">
            <!-- Desktop sidebar collapse button -->
            <button type="button" x-data="{ isCollapsed: localStorage.getItem('collabhub.sidebar.collapsed') === '1' }"
                @click="isCollapsed = !isCollapsed; window.dispatchEvent(new CustomEvent('toggle-sidebar-collapse'))"
                class="hidden lg:inline-flex h-8 w-8 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-100 transition-colors duration-150 items-center justify-center"
                :title="isCollapsed ? @js(__('sidebar.actions.expand')) : @js(__('sidebar.actions.collapse'))">
                <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': isCollapsed }"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Search Bar -->
            <div class="flex-1 max-w-2xl">
                <div class="relative">
                    <input type="search" placeholder="{{ __('header.placeholder') }}"
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition-all duration-200 outline-none">
                    <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Notifications & Actions -->
        <div class="flex items-center space-x-4 select-none">
            <div class="relative" id="headerCurrencySwitcher">
                <button type="button" id="currencyMenuButton"
                    class="inline-flex items-center gap-2 px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200 text-sm font-medium">
                    <img id="currencyMenuFlag" src="{{ $activeCurrencyMeta['flag_url'] }}"
                        alt="{{ $activeCurrencyMeta['flag_alt'] }}" class="w-5 h-4 rounded-sm object-cover">
                    <span id="currencyMenuCode" class="hidden sm:inline">{{ $preferredCurrency }}</span>
                    <svg id="currencyMenuArrow" class="w-4 h-4 text-gray-500 transition-transform duration-200"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div id="currencyMenu"
                    class="hidden pointer-events-none absolute right-0 mt-2 w-60 origin-top-right transform scale-95 opacity-0 bg-white border border-gray-200 rounded-lg shadow-lg z-50 overflow-hidden transition ease-out duration-100">
                    @foreach ($currencyOptions as $code => $meta)
                        <button type="button" data-currency="{{ $code }}"
                            class="currency-menu-item w-full px-4 py-2.5 text-left text-sm flex items-center justify-between {{ $preferredCurrency === $code ? 'bg-gray-50 text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}">
                            <span class="flex items-center gap-2 min-w-0">
                                <img src="{{ $meta['flag_url'] }}" alt="{{ $meta['flag_alt'] }}"
                                    class="w-5 h-4 rounded-sm object-cover">
                                <span class="min-w-0">
                                    <span class="block font-medium leading-tight">{{ $code }}</span>
                                    <span data-currency-rate class="block text-xs text-gray-500 leading-tight"
                                        title="{{ $meta['label'] }}">
                                        1 USD = -- {{ $code }}
                                    </span>
                                </span>
                            </span>
                            <svg data-selected-icon
                                class="w-4 h-4 text-gray-900 {{ $preferredCurrency === $code ? '' : 'hidden' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    @endforeach
                </div>
            </div>

            <button id="notificationBell" class="relative text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                    </path>
                </svg>
                <span
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
            </button>

            @if (Auth::user()->role === 'client')
                <a href="{{ route('my-jobs.create') }}"
                    class="bg-gray-800 text-white px-4 py-2.5 rounded-lg hover:bg-black transition duration-300 font-medium text-sm">
                    Post a Job
                </a>
            @endif
        </div>
    </div>
</header>
