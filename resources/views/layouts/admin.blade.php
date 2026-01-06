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

    @stack('scripts')
</body>

</html>
