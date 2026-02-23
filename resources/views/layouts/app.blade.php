<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @hasSection('title')
        <title>@yield('title') | CollabHub</title>
    @else
        <title>CollabHub</title>
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css"
        integrity="sha512-kJlvECunwXftkPwyvHbclArO8wszgBGisiLeuDFwNM8ws+wKIw0sv1os3ClWZOcrEB2eRXULYUsm8OVRGJKwGA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional styles -->
    <style>
        .sidebar {
            transition: all 0.3s ease;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }
        }

        .notification-dot {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .5;
            }
        }

        .progress-bar {
            transition: width 1s ease-in-out;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .chart-container {
            position: relative;
            height: 300px;
        }
    </style>

    @stack('styles')
</head>

<body class="font-['Figtree'] text-gray-800 bg-gray-50">
    <!-- Main Container -->
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar Component -->
        <x-sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <x-header />

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-3">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');

            if (window.innerWidth <= 1024 &&
                !sidebar.contains(event.target) &&
                !toggleBtn.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // Initialize progress bars animation
        document.addEventListener('DOMContentLoaded', function() {
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            });
        });

        // Notification bell animation
        const notificationBell = document.getElementById('notificationBell');
        if (notificationBell) {
            notificationBell.addEventListener('click', function() {
                const notificationDot = this.querySelector('span.bg-red-500');
                if (notificationDot) {
                    notificationDot.remove();
                }
            });
        }

        // Header currency switcher
        const currencySwitcher = document.getElementById('headerCurrencySwitcher');
        const currencyMenuButton = document.getElementById('currencyMenuButton');
        const currencyMenu = document.getElementById('currencyMenu');
        const currencyMenuArrow = document.getElementById('currencyMenuArrow');
        const currencyMenuCode = document.getElementById('currencyMenuCode');
        const currencyMenuFlag = document.getElementById('currencyMenuFlag');
        const currencyMenuItems = document.querySelectorAll('.currency-menu-item');
        const settingsUpdateUrl = @json(route('settings.update'));
        const exchangeRatesUrl = @json(route('currency.exchange-rates'));
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        let headerExchangeRates = {
            USD: 1,
            MMK: 3959.10,
            EUR: 0.93,
            GBP: 0.79,
            CAD: 1.35,
            AUD: 1.53
        };
        let currencyMenuCloseTimer = null;
        let isCurrencyMenuOpen = false;

        function openCurrencyMenu() {
            if (!currencyMenu) {
                return;
            }

            if (currencyMenuCloseTimer) {
                clearTimeout(currencyMenuCloseTimer);
                currencyMenuCloseTimer = null;
            }

            currencyMenu.classList.remove('hidden', 'pointer-events-none', 'duration-75', 'ease-in', 'opacity-100',
                'scale-100');
            currencyMenu.classList.add('ease-out', 'duration-100', 'opacity-0', 'scale-95');

            requestAnimationFrame(() => {
                currencyMenu.classList.remove('opacity-0', 'scale-95');
                currencyMenu.classList.add('opacity-100', 'scale-100');
            });

            if (currencyMenuArrow) {
                currencyMenuArrow.classList.add('rotate-180');
            }

            isCurrencyMenuOpen = true;
        }

        function closeCurrencyMenu() {
            if (currencyMenu) {
                if (currencyMenuCloseTimer) {
                    clearTimeout(currencyMenuCloseTimer);
                }

                currencyMenu.classList.remove('duration-100', 'ease-out', 'opacity-0', 'scale-95');
                currencyMenu.classList.add('duration-75', 'ease-in', 'opacity-100', 'scale-100');

                requestAnimationFrame(() => {
                    currencyMenu.classList.remove('opacity-100', 'scale-100');
                    currencyMenu.classList.add('opacity-0', 'scale-95');
                });

                currencyMenuCloseTimer = window.setTimeout(() => {
                    currencyMenu.classList.add('hidden', 'pointer-events-none');
                    currencyMenuCloseTimer = null;
                }, 75);
            }

            if (currencyMenuArrow) {
                currencyMenuArrow.classList.remove('rotate-180');
            }

            isCurrencyMenuOpen = false;
        }

        function formatHeaderExchangeRate(rateValue, currencyCode) {
            const parsedRate = parseFloat(rateValue);
            if (!Number.isFinite(parsedRate) || parsedRate <= 0) {
                return null;
            }

            return new Intl.NumberFormat(undefined, {
                minimumFractionDigits: currencyCode === 'USD' ? 0 : 2,
                maximumFractionDigits: currencyCode === 'MMK' ? 2 : 4
            }).format(parsedRate);
        }

        function syncHeaderCurrencyRates(rates = {}) {
            currencyMenuItems.forEach((menuItem) => {
                const code = (menuItem.dataset.currency || '').toUpperCase();
                const rateLabel = menuItem.querySelector('[data-currency-rate]');

                if (!code || !rateLabel) {
                    return;
                }

                const formattedRate = formatHeaderExchangeRate(rates[code], code);
                rateLabel.textContent = formattedRate ? `1 USD = ${formattedRate} ${code}` : `1 USD = -- ${code}`;
            });
        }

        async function loadHeaderCurrencyRates() {
            try {
                const response = await fetch(exchangeRatesUrl, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    return;
                }

                const data = await response.json();
                if (!data.success || typeof data.rates !== 'object' || !data.rates) {
                    return;
                }

                headerExchangeRates = {
                    ...headerExchangeRates,
                    ...data.rates
                };

                syncHeaderCurrencyRates(headerExchangeRates);
            } catch (error) {
                // Keep fallback rates when the exchange API request fails.
            }
        }

        function syncHeaderCurrencyUI(selectedCurrency) {
            if (!selectedCurrency) {
                return;
            }

            const normalizedCurrency = String(selectedCurrency).toUpperCase();
            if (currencyMenuCode) {
                currencyMenuCode.textContent = normalizedCurrency;
            }

            let activeMenuItem = null;
            currencyMenuItems.forEach((menuItem) => {
                const code = (menuItem.dataset.currency || '').toUpperCase();
                const isActive = code === normalizedCurrency;

                if (isActive) {
                    activeMenuItem = menuItem;
                }

                menuItem.classList.toggle('bg-gray-50', isActive);
                menuItem.classList.toggle('text-gray-900', isActive);
                menuItem.classList.toggle('text-gray-700', !isActive);
                menuItem.classList.toggle('hover:bg-gray-50', !isActive);
                menuItem.setAttribute('aria-pressed', isActive ? 'true' : 'false');

                const selectedIcon = menuItem.querySelector('[data-selected-icon]');
                if (selectedIcon) {
                    selectedIcon.classList.toggle('hidden', !isActive);
                }
            });

            if (activeMenuItem && currencyMenuFlag) {
                const activeFlag = activeMenuItem.querySelector('img');
                if (activeFlag) {
                    currencyMenuFlag.src = activeFlag.src;
                    currencyMenuFlag.alt = activeFlag.alt || normalizedCurrency;
                }
            }
        }

        if (currencySwitcher && currencyMenuButton && currencyMenu) {
            syncHeaderCurrencyRates(headerExchangeRates);
            loadHeaderCurrencyRates();

            currencyMenuButton.addEventListener('click', function(event) {
                event.stopPropagation();
                if (isCurrencyMenuOpen) {
                    closeCurrencyMenu();
                } else {
                    openCurrencyMenu();
                }
            });

            currencyMenuItems.forEach((item) => {
                item.addEventListener('click', async function() {
                    const selectedCurrency = (this.dataset.currency || '').toUpperCase();
                    const currentCurrency = (currencyMenuCode?.textContent || '').trim().toUpperCase();

                    if (!selectedCurrency || selectedCurrency === currentCurrency || !csrfToken) {
                        closeCurrencyMenu();
                        return;
                    }

                    currencyMenuButton.disabled = true;
                    currencyMenuButton.classList.add('opacity-60', 'cursor-not-allowed');
                    currencyMenuItems.forEach((menuItem) => menuItem.setAttribute('disabled', 'disabled'));

                    try {
                        const response = await fetch(settingsUpdateUrl, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                currency: selectedCurrency
                            })
                        });

                        const result = await response.json();
                        if (!response.ok || !result.success) {
                            throw new Error(result.message || 'Failed to update currency');
                        }

                        syncHeaderCurrencyUI(selectedCurrency);
                        if (window.AppCurrency?.setCurrency) {
                            await window.AppCurrency.setCurrency(selectedCurrency);
                        }
                    } catch (error) {
                        window.alert('Failed to update currency. Please try again.');
                    } finally {
                        currencyMenuButton.disabled = false;
                        currencyMenuButton.classList.remove('opacity-60', 'cursor-not-allowed');
                        currencyMenuItems.forEach((menuItem) => menuItem.removeAttribute('disabled'));
                        closeCurrencyMenu();
                    }
                });
            });

            document.addEventListener('click', function(event) {
                if (!currencySwitcher.contains(event.target)) {
                    closeCurrencyMenu();
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeCurrencyMenu();
                }
            });
        }

        // Search functionality
        const searchInput = document.querySelector('input[type="search"]');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const query = this.value.trim();
                    if (query) {
                        console.log('Searching for:', query);
                    }
                }
            });
        }
    </script>

    @auth
        <script>
            (() => {
                const exchangeRatesUrl = @json(route('currency.exchange-rates'));
                let preferredCurrency = @json(auth()->user()?->settings?->currency ?? 'USD');
                let exchangeRates = {
                    USD: 1,
                    MMK: 3959.10,
                    EUR: 0.93,
                    GBP: 0.79,
                    CAD: 1.35,
                    AUD: 1.53
                };
                let currencyObserver = null;
                const originalUsdTextMap = new WeakMap();

                function parseUsdAmount(rawValue) {
                    const numericValue = parseFloat(String(rawValue).replace(/,/g, ''));
                    return Number.isFinite(numericValue) ? numericValue : null;
                }

                function getActiveCurrencyCode() {
                    return (preferredCurrency || 'USD').toUpperCase();
                }

                function getUsdRateForCurrency(currencyCode) {
                    const parsedRate = parseFloat(exchangeRates[currencyCode]);
                    return Number.isFinite(parsedRate) && parsedRate > 0 ? parsedRate : 1;
                }

                function formatUsdAmount(usdAmount) {
                    if (!Number.isFinite(usdAmount)) {
                        return null;
                    }

                    const currencyCode = getActiveCurrencyCode();
                    const convertedAmount = usdAmount * getUsdRateForCurrency(currencyCode);

                    return new Intl.NumberFormat(undefined, {
                        style: 'currency',
                        currency: currencyCode,
                        minimumFractionDigits: 0,
                        maximumFractionDigits: currencyCode === 'MMK' ? 0 : 2
                    }).format(convertedAmount);
                }

                function applySign(formattedAmount, sign) {
                    if (!formattedAmount) {
                        return formattedAmount;
                    }

                    return sign === '-' || sign === '+' ? `${sign}${formattedAmount}` : formattedAmount;
                }

                function containsRawUsdAmount(text) {
                    return typeof text === 'string' && /(^|[^A-Za-z])[+-]?\$\d/.test(text);
                }

                function convertUsdText(text) {
                    if (!containsRawUsdAmount(text)) {
                        return text;
                    }

                    const rangeRegex =
                        /(^|[^A-Za-z])([+-]?)\$(\d[\d,]*(?:\.\d+)?)\s*-\s*([+-]?)\$(\d[\d,]*(?:\.\d+)?)(\s*\/hr)?/g;
                    const singleRegex = /(^|[^A-Za-z])([+-]?)\$(\d[\d,]*(?:\.\d+)?)(\s*\/hr)?/g;

                    let convertedText = text.replace(rangeRegex, (match, prefix, minSign, minValue, maxSign, maxValue, suffix = '') => {
                        const parsedMin = parseUsdAmount(minValue);
                        const parsedMax = parseUsdAmount(maxValue);

                        if (parsedMin === null || parsedMax === null) {
                            return match;
                        }

                        const formattedMin = applySign(formatUsdAmount(parsedMin), minSign);
                        const formattedMax = applySign(formatUsdAmount(parsedMax), maxSign);

                        if (!formattedMin || !formattedMax) {
                            return match;
                        }

                        return `${prefix}${formattedMin} - ${formattedMax}${suffix || ''}`;
                    });

                    convertedText = convertedText.replace(singleRegex, (match, prefix, sign, value, suffix = '') => {
                        const parsedValue = parseUsdAmount(value);
                        if (parsedValue === null) {
                            return match;
                        }

                        const formattedValue = applySign(formatUsdAmount(parsedValue), sign);
                        return formattedValue ? `${prefix}${formattedValue}${suffix || ''}` : match;
                    });

                    return convertedText;
                }

                function shouldSkipTextNode(textNode) {
                    const parent = textNode?.parentElement;
                    if (!parent) {
                        return true;
                    }

                    return !!parent.closest('script,style,noscript,textarea,code,pre,[data-no-currency-convert]');
                }

                function convertTextNode(textNode) {
                    if (!textNode || shouldSkipTextNode(textNode)) {
                        return;
                    }

                    const currentText = typeof textNode.nodeValue === 'string' ? textNode.nodeValue : '';
                    const storedText = originalUsdTextMap.get(textNode);

                    if (containsRawUsdAmount(currentText)) {
                        if (storedText !== currentText) {
                            originalUsdTextMap.set(textNode, currentText);
                        }
                    } else if (typeof storedText !== 'string') {
                        return;
                    }

                    const originalText = originalUsdTextMap.get(textNode);
                    if (typeof originalText !== 'string') {
                        return;
                    }

                    const convertedText = convertUsdText(originalText);

                    if (typeof convertedText === 'string' && convertedText !== currentText) {
                        textNode.nodeValue = convertedText;
                    }
                }

                function convertSubtree(rootNode) {
                    if (!rootNode || rootNode.nodeType !== Node.ELEMENT_NODE) {
                        return;
                    }

                    const walker = document.createTreeWalker(rootNode, NodeFilter.SHOW_TEXT);
                    const textNodes = [];
                    let currentNode = walker.nextNode();

                    while (currentNode) {
                        textNodes.push(currentNode);
                        currentNode = walker.nextNode();
                    }

                    textNodes.forEach(convertTextNode);
                }

                function startCurrencyObserver() {
                    if (currencyObserver || !document.body) {
                        return;
                    }

                    currencyObserver = new MutationObserver((mutations) => {
                        mutations.forEach((mutation) => {
                            if (mutation.type === 'characterData') {
                                convertTextNode(mutation.target);
                                return;
                            }

                            mutation.addedNodes.forEach((node) => {
                                if (node.nodeType === Node.TEXT_NODE) {
                                    convertTextNode(node);
                                } else if (node.nodeType === Node.ELEMENT_NODE) {
                                    convertSubtree(node);
                                }
                            });
                        });
                    });

                    currencyObserver.observe(document.body, {
                        childList: true,
                        subtree: true,
                        characterData: true
                    });
                }

                async function loadExchangeRates(preferredCurrencyOverride = null) {
                    if (typeof preferredCurrencyOverride === 'string' && preferredCurrencyOverride.trim() !== '') {
                        preferredCurrency = preferredCurrencyOverride.toUpperCase();
                    }

                    try {
                        const response = await fetch(exchangeRatesUrl, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) {
                            return;
                        }

                        const data = await response.json();
                        if (!data.success || typeof data.rates !== 'object' || !data.rates) {
                            return;
                        }

                        if (typeof data.preferred_currency === 'string' && data.preferred_currency.trim() !== '') {
                            preferredCurrency = data.preferred_currency.toUpperCase();
                        }

                        exchangeRates = {
                            ...exchangeRates,
                            ...data.rates
                        };
                    } catch (error) {
                        // Keep fallback rates when the exchange API request fails.
                    }
                }

                window.AppCurrency = {
                    getCurrency: () => getActiveCurrencyCode(),
                    setCurrency: async (currencyCode) => {
                        const normalizedCurrency = String(currencyCode || '').toUpperCase();
                        if (!normalizedCurrency) {
                            return getActiveCurrencyCode();
                        }

                        await loadExchangeRates(normalizedCurrency);
                        convertSubtree(document.body);

                        return getActiveCurrencyCode();
                    },
                    formatFromUsd: (amount, suffix = '') => {
                        const numericAmount = parseFloat(amount);
                        if (!Number.isFinite(numericAmount)) {
                            return null;
                        }

                        const formattedAmount = formatUsdAmount(numericAmount);
                        return formattedAmount ? `${formattedAmount}${suffix}` : null;
                    },
                    formatRangeFromUsd: (minAmount, maxAmount, suffix = '') => {
                        const minFormatted = window.AppCurrency.formatFromUsd(minAmount, '');
                        const maxFormatted = window.AppCurrency.formatFromUsd(maxAmount, '');

                        if (!minFormatted || !maxFormatted) {
                            return null;
                        }

                        return `${minFormatted} - ${maxFormatted}${suffix}`;
                    }
                };

                document.addEventListener('DOMContentLoaded', async () => {
                    await loadExchangeRates();
                    convertSubtree(document.body);
                    startCurrencyObserver();
                });
            })();
        </script>
    @endauth

    @stack('scripts')
</body>

</html>
