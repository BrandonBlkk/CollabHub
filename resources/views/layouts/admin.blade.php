<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard | CollabHub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-['Figtree'] text-gray-800 bg-gray-50">
    <!-- Main Container -->
    <div class="flex h-screen overflow-hidden">
        <!-- Admin Sidebar  -->
        <x-admin.sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <x-admin.header :title="view()->yieldContent('title')" :description="view()->yieldContent('description')" />

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-3">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="border-t border-gray-200 px-6 py-4 bg-white">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="text-sm text-gray-600">
                        © 2025 CollabHub. All rights reserved.
                    </div>
                    <div class="flex items-center gap-6 mt-3 md:mt-0">
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900 transition">Privacy
                            Policy</a>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900 transition">Terms of
                            Service</a>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900 transition">Help
                            Center</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            // You can add Alpine.js data and methods here
        });

        // Simple confirmation for delete actions
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('button .fa-trash').forEach(icon => {
                icon.closest('button').addEventListener('click', function(e) {
                    if (!confirm(
                            'Are you sure you want to delete this item? This action cannot be undone.'
                        )) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                });
            });
        });
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

                function convertUsdText(text) {
                    if (typeof text !== 'string' || !text.includes('$')) {
                        return text;
                    }

                    const rangeRegex =
                        /([+-]?)\$(\d[\d,]*(?:\.\d+)?)\s*-\s*([+-]?)\$(\d[\d,]*(?:\.\d+)?)(\s*\/hr)?/g;
                    const singleRegex = /([+-]?)\$(\d[\d,]*(?:\.\d+)?)(\s*\/hr)?/g;

                    let convertedText = text.replace(rangeRegex, (match, minSign, minValue, maxSign, maxValue, suffix = '') => {
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

                        return `${formattedMin} - ${formattedMax}${suffix || ''}`;
                    });

                    convertedText = convertedText.replace(singleRegex, (match, sign, value, suffix = '') => {
                        const parsedValue = parseUsdAmount(value);
                        if (parsedValue === null) {
                            return match;
                        }

                        const formattedValue = applySign(formatUsdAmount(parsedValue), sign);
                        return formattedValue ? `${formattedValue}${suffix || ''}` : match;
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

                    const originalText = textNode.nodeValue;
                    const convertedText = convertUsdText(originalText);

                    if (convertedText !== originalText) {
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

                async function loadExchangeRates() {
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
