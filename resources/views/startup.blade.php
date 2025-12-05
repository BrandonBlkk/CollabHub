<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CollabHub | Freelance Platform</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Additional styles for custom design -->
    <style>
        :root {
            --primary: #2563eb;
            --primary-light: #3b82f6;
            --secondary: #059669;
            --accent: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
            --sidebar-width: 260px;
            --sidebar-collapsed: 70px;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1e40af 0%, #0d9488 100%);
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.3);
        }

        .btn-secondary {
            background-color: white;
            color: var(--primary);
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            border: 2px solid var(--primary);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #f8fafc;
            transform: translateY(-2px);
        }

        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .testimonial-card {
            background: linear-gradient(135deg, #fdfcfb 0%, #f5f7fa 100%);
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-pattern {
            background-image: radial-gradient(var(--primary) 1px, transparent 1px);
            background-size: 40px 40px;
            opacity: 0.1;
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% {
                transform: translate(0, 0px);
            }

            50% {
                transform: translate(0, -15px);
            }

            100% {
                transform: translate(0, 0px);
            }
        }

        /* Dashboard Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            color: white;
            transition: all 0.3s ease;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            padding-left: 2rem;
        }

        .menu-item.active {
            background: rgba(37, 99, 235, 0.2);
            color: white;
            border-left: 4px solid var(--primary);
        }

        .menu-item i {
            width: 24px;
            margin-right: 0.75rem;
            font-size: 1.2rem;
            text-align: center;
        }

        .sidebar.collapsed .menu-text {
            display: none;
        }

        .sidebar.collapsed .menu-item {
            justify-content: center;
            padding: 0.75rem 0;
        }

        .sidebar.collapsed .menu-item i {
            margin-right: 0;
            font-size: 1.4rem;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
            min-height: 100vh;
            background: #f8fafc;
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed);
        }

        .topbar {
            background: white;
            padding: 1rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .toggle-sidebar {
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            font-size: 1.2rem;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .toggle-sidebar:hover {
            background: #f1f5f9;
            color: #334155;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .notification-badge {
            position: relative;
        }

        .notification-badge .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ef4444;
            color: white;
            font-size: 0.7rem;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dashboard-content {
            padding: 2rem;
        }

        .dashboard-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card-dash {
            background: white;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .stat-card-dash i {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        .stat-card-dash .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: #1e293b;
        }

        .stat-card-dash .stat-label {
            color: #64748b;
            font-size: 0.9rem;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .table tr:hover {
            background: #f8fafc;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-active {
            background: #d1fae5;
            color: #065f46;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-completed {
            background: #dbeafe;
            color: #1e40af;
        }

        /* Authentication Pages */
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 1rem;
        }

        .auth-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 28rem;
            overflow: hidden;
        }

        .auth-header {
            padding: 2rem 2rem 1rem;
            text-align: center;
        }

        .auth-body {
            padding: 1.5rem 2rem 2rem;
        }

        .auth-footer {
            padding: 1.5rem 2rem;
            background: #f8fafc;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-auth {
            width: 100%;
            padding: 0.75rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-auth:hover {
            background: var(--primary-light);
        }

        .auth-divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: #6b7280;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .auth-divider span {
            padding: 0 1rem;
        }

        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            background: white;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .btn-social:hover {
            background: #f9fafb;
        }

        .btn-social i {
            margin-right: 0.75rem;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .topbar {
                padding: 1rem;
            }

            .dashboard-content {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="font-['Figtree'] text-gray-800">
    <!-- Check if user is authenticated -->
    <?php
    // Simulating authentication check - in real Laravel app, this would be @auth blade directive
    $isAuthenticated = false; // Change to true to see dashboard view
    ?>

    @if ($isAuthenticated)
        <!-- Dashboard Layout with Sidebar -->
        <div class="flex">
            <!-- Sidebar -->
            <aside class="sidebar" id="sidebar">
                <div class="sidebar-header">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 rounded-lg gradient-bg flex items-center justify-center">
                            <span class="text-white font-bold text-xl">C</span>
                        </div>
                        <span class="text-xl font-bold text-white" id="logo-text">CollabHub</span>
                    </div>
                    <button class="toggle-sidebar lg:hidden" id="mobile-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- User Profile -->
                <div class="px-4 py-6 border-b border-gray-700">
                    <div class="flex items-center">
                        <div class="user-avatar mr-3">
                            JD
                        </div>
                        <div>
                            <h4 class="font-medium text-white">John Doe</h4>
                            <p class="text-sm text-gray-400">Premium Client</p>
                        </div>
                    </div>
                </div>

                <!-- Main Menu -->
                <nav class="sidebar-menu">
                    <a href="/dashboard" class="menu-item active">
                        <i class="fas fa-home"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                    <a href="/projects" class="menu-item">
                        <i class="fas fa-briefcase"></i>
                        <span class="menu-text">Projects</span>
                        <span class="ml-auto bg-blue-500 text-white text-xs rounded-full px-2 py-1">3</span>
                    </a>
                    <a href="/messages" class="menu-item">
                        <i class="fas fa-envelope"></i>
                        <span class="menu-text">Messages</span>
                        <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1">5</span>
                    </a>
                    <a href="/freelancers" class="menu-item">
                        <i class="fas fa-users"></i>
                        <span class="menu-text">Freelancers</span>
                    </a>
                    <a href="/contracts" class="menu-item">
                        <i class="fas fa-file-contract"></i>
                        <span class="menu-text">Contracts</span>
                    </a>
                    <a href="/payments" class="menu-item">
                        <i class="fas fa-credit-card"></i>
                        <span class="menu-text">Payments</span>
                    </a>

                    <!-- Divider -->
                    <div class="px-6 py-3">
                        <span class="text-xs text-gray-500 uppercase tracking-wider">Settings</span>
                    </div>

                    <a href="/profile" class="menu-item">
                        <i class="fas fa-user"></i>
                        <span class="menu-text">Profile</span>
                    </a>
                    <a href="/settings" class="menu-item">
                        <i class="fas fa-cog"></i>
                        <span class="menu-text">Settings</span>
                    </a>
                    <a href="/help" class="menu-item">
                        <i class="fas fa-question-circle"></i>
                        <span class="menu-text">Help & Support</span>
                    </a>

                    <!-- Logout -->
                    <div class="px-6 py-6">
                        <a href="/logout" class="menu-item text-red-400 hover:text-red-300 hover:bg-red-900/20">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="menu-text">Logout</span>
                        </a>
                    </div>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="main-content" id="mainContent">
                <!-- Topbar -->
                <header class="topbar">
                    <div class="flex items-center">
                        <button class="toggle-sidebar" id="toggleSidebar">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="ml-4 hidden md:block">
                            <h1 class="text-xl font-bold text-gray-800">Dashboard</h1>
                            <p class="text-gray-600 text-sm">Welcome back, John! Here's what's happening today.</p>
                        </div>
                    </div>

                    <div class="user-menu">
                        <button class="notification-badge relative p-2 text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="badge">3</span>
                        </button>

                        <div class="relative">
                            <button class="flex items-center space-x-3" id="userMenuButton">
                                <div class="user-avatar">
                                    JD
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="font-medium">John Doe</p>
                                    <p class="text-sm text-gray-600">Client</p>
                                </div>
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden"
                                id="userDropdown">
                                <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i> My Profile
                                </a>
                                <a href="/settings" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i> Settings
                                </a>
                                <div class="border-t my-1"></div>
                                <a href="/logout" class="block px-4 py-2 text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Dashboard Content -->
                <div class="dashboard-content">
                    <!-- Stats Overview -->
                    <div class="stats-grid">
                        <div class="stat-card-dash">
                            <i class="fas fa-briefcase"></i>
                            <div class="stat-value">8</div>
                            <div class="stat-label">Active Projects</div>
                            <div class="text-sm text-green-600 mt-1">
                                <i class="fas fa-arrow-up mr-1"></i> 12% from last month
                            </div>
                        </div>

                        <div class="stat-card-dash">
                            <i class="fas fa-dollar-sign"></i>
                            <div class="stat-value">$12,540</div>
                            <div class="stat-label">Total Spent</div>
                            <div class="text-sm text-blue-600 mt-1">
                                <i class="fas fa-chart-line mr-1"></i> 8% increase
                            </div>
                        </div>

                        <div class="stat-card-dash">
                            <i class="fas fa-users"></i>
                            <div class="stat-value">24</div>
                            <div class="stat-label">Freelancers Hired</div>
                            <div class="text-sm text-purple-600 mt-1">
                                <i class="fas fa-user-plus mr-1"></i> 3 new this month
                            </div>
                        </div>

                        <div class="stat-card-dash">
                            <i class="fas fa-star"></i>
                            <div class="stat-value">4.8</div>
                            <div class="stat-label">Average Rating</div>
                            <div class="text-sm text-amber-600 mt-1">
                                <i class="fas fa-star mr-1"></i> 156 reviews
                            </div>
                        </div>
                    </div>

                    <!-- Recent Projects -->
                    <div class="dashboard-card mb-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-800">Recent Projects</h2>
                            <a href="/projects" class="text-blue-600 hover:text-blue-800 font-medium">
                                View All <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Freelancer</th>
                                        <th>Budget</th>
                                        <th>Status</th>
                                        <th>Deadline</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Website Redesign</td>
                                        <td>Sarah Johnson</td>
                                        <td>$2,500</td>
                                        <td>
                                            <span class="status-badge status-active">Active</span>
                                        </td>
                                        <td>Jun 15, 2024</td>
                                        <td>
                                            <button class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mobile App Development</td>
                                        <td>Mike Chen</td>
                                        <td>$5,000</td>
                                        <td>
                                            <span class="status-badge status-pending">Pending</span>
                                        </td>
                                        <td>Jul 10, 2024</td>
                                        <td>
                                            <button class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Logo Design</td>
                                        <td>Emma Wilson</td>
                                        <td>$800</td>
                                        <td>
                                            <span class="status-badge status-completed">Completed</span>
                                        </td>
                                        <td>May 20, 2024</td>
                                        <td>
                                            <button class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="dashboard-card">
                            <h3 class="text-lg font-bold mb-4">Quick Actions</h3>
                            <div class="space-y-3">
                                <a href="/projects/create"
                                    class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-plus text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Post New Project</p>
                                        <p class="text-sm text-gray-600">Find talented freelancers</p>
                                    </div>
                                </a>

                                <a href="/freelancers"
                                    class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-search text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Browse Freelancers</p>
                                        <p class="text-sm text-gray-600">Find experts for your needs</p>
                                    </div>
                                </a>

                                <a href="/messages"
                                    class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-envelope text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">View Messages</p>
                                        <p class="text-sm text-gray-600">5 unread messages</p>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="dashboard-card">
                            <h3 class="text-lg font-bold mb-4">Recent Activity</h3>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3 mt-1">
                                        <i class="fas fa-check text-blue-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Project completed</p>
                                        <p class="text-sm text-gray-600">"Logo Design" by Emma Wilson</p>
                                        <p class="text-xs text-gray-500">2 hours ago</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div
                                        class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3 mt-1">
                                        <i class="fas fa-dollar-sign text-green-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Payment received</p>
                                        <p class="text-sm text-gray-600">Invoice #INV-2024-056 paid</p>
                                        <p class="text-xs text-gray-500">Yesterday</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div
                                        class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center mr-3 mt-1">
                                        <i class="fas fa-user-plus text-amber-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">New proposal</p>
                                        <p class="text-sm text-gray-600">Mike Chen sent a proposal</p>
                                        <p class="text-xs text-gray-500">2 days ago</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Mobile Menu Button -->
        <button class="lg:hidden fixed bottom-6 right-6 w-14 h-14 rounded-full gradient-bg text-white shadow-lg z-50"
            id="mobileMenuButton">
            <i class="fas fa-bars text-xl"></i>
        </button>
    @else
        <!-- Original Landing Page (Non-authenticated users) -->
        <!-- Navigation -->
        <nav class="fixed w-full bg-white/90 backdrop-blur-md z-50 shadow-sm">
            <div class="container mx-auto px-4 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 rounded-lg gradient-bg flex items-center justify-center">
                            <span class="text-white font-bold text-xl">C</span>
                        </div>
                        <span class="text-2xl font-bold text-gray-900">CollabHub</span>
                    </div>

                    <div class="hidden md:flex space-x-8">
                        <a href="#features"
                            class="font-medium text-gray-700 hover:text-blue-600 transition">Features</a>
                        <a href="#how-it-works" class="font-medium text-gray-700 hover:text-blue-600 transition">How
                            It
                            Works</a>
                        <a href="#testimonials"
                            class="font-medium text-gray-700 hover:text-blue-600 transition">Testimonials</a>
                        <a href="#pricing"
                            class="font-medium text-gray-700 hover:text-blue-600 transition">Pricing</a>
                    </div>

                    <div class="flex items-center space-x-4">
                        <a href="/signin" class="text-gray-700 font-medium hover:text-blue-600 transition">Log In</a>
                        <a href="/register" class="btn-primary">Get Started</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="pt-24 pb-20 md:pt-32 md:pb-28 gradient-bg text-white overflow-hidden">
            <div class="container mx-auto px-4 relative">
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-80 h-80 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2">
                </div>

                <div class="relative z-10 max-w-4xl mx-auto text-center">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                        Connect with Top Freelancers &
                        <span class="text-amber-300">Amazing Projects</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-white/90 mb-10 max-w-3xl mx-auto">
                        A modern platform where businesses find talented freelancers and freelancers discover exciting
                        projects. Built with Laravel for performance and scalability.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="/register"
                            class="btn-primary bg-white text-blue-700 hover:bg-gray-100 inline-flex items-center justify-center">
                            <span>Post a Project</span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </a>
                        <a href="/register"
                            class="btn-secondary bg-transparent border-2 border-white text-white hover:bg-white/10 inline-flex items-center justify-center">
                            <span>Find Work</span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </a>
                    </div>

                    <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                        <div class="stat-card p-4 rounded-2xl">
                            <div class="text-3xl font-bold">10K+</div>
                            <div class="text-white/80">Projects Posted</div>
                        </div>
                        <div class="stat-card p-4 rounded-2xl">
                            <div class="text-3xl font-bold">5K+</div>
                            <div class="text-white/80">Freelancers</div>
                        </div>
                        <div class="stat-card p-4 rounded-2xl">
                            <div class="text-3xl font-bold">98%</div>
                            <div class="text-white/80">Satisfaction Rate</div>
                        </div>
                        <div class="stat-card p-4 rounded-2xl">
                            <div class="text-3xl font-bold">24/7</div>
                            <div class="text-white/80">Support</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Powerful Features for Everyone</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                        Whether you're a business looking for talent or a freelancer seeking projects, we have the tools
                        you
                        need.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="feature-card bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                        <div class="w-14 h-14 rounded-xl gradient-bg flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Project Posting</h3>
                        <p class="text-gray-600 mb-4">
                            Easily create detailed project posts with requirements, budget, and timeline. Attach files
                            and
                            specify skills needed.
                        </p>
                        <a href="#" class="text-blue-600 font-medium inline-flex items-center">
                            Learn more
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Feature 2 -->
                    <div class="feature-card bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                        <div class="w-14 h-14 rounded-xl gradient-bg flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Smart Matching</h3>
                        <p class="text-gray-600 mb-4">
                            Our algorithm connects clients with the most suitable freelancers based on skills, ratings,
                            and
                            project requirements.
                        </p>
                        <a href="#" class="text-blue-600 font-medium inline-flex items-center">
                            Learn more
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Feature 3 -->
                    <div class="feature-card bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                        <div class="w-14 h-14 rounded-xl gradient-bg flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Secure Payments</h3>
                        <p class="text-gray-600 mb-4">
                            Built-in escrow system ensures freelancers get paid and clients receive quality work.
                            Multiple
                            payment options available.
                        </p>
                        <a href="#" class="text-blue-600 font-medium inline-flex items-center">
                            Learn more
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works -->
        <section id="how-it-works" class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">How CollabHub Works</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                        Simple steps to get started on our platform, whether you're a client or a freelancer.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="mb-8">
                            <div class="flex items-start mb-6">
                                <div
                                    class="flex-shrink-0 w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xl mr-4">
                                    1</div>
                                <div>
                                    <h3 class="text-xl font-bold mb-2">Create Your Profile</h3>
                                    <p class="text-gray-600">
                                        Sign up as a client or freelancer. Complete your profile with skills, portfolio,
                                        and
                                        experience.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start mb-6">
                                <div
                                    class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xl mr-4">
                                    2</div>
                                <div>
                                    <h3 class="text-xl font-bold mb-2">Post or Browse Projects</h3>
                                    <p class="text-gray-600">
                                        Clients can post detailed projects. Freelancers can browse and apply to projects
                                        matching their skills.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="flex-shrink-0 w-12 h-12 rounded-full bg-violet-100 text-violet-600 flex items-center justify-center font-bold text-xl mr-4">
                                    3</div>
                                <div>
                                    <h3 class="text-xl font-bold mb-2">Connect & Collaborate</h3>
                                    <p class="text-gray-600">
                                        Communicate directly, agree on terms, and start working. Use our tools for
                                        seamless
                                        collaboration.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="bg-gray-50 p-8 rounded-2xl shadow-lg border border-gray-200">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-bold">Project Dashboard Preview</h3>
                                <span
                                    class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">Live</span>
                            </div>

                            <div class="space-y-4">
                                <div
                                    class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                                    <div>
                                        <h4 class="font-medium">Website Redesign</h4>
                                        <p class="text-sm text-gray-500">Posted 2 days ago</p>
                                    </div>
                                    <span
                                        class="px-3 py-1 bg-emerald-100 text-emerald-800 text-sm font-medium rounded-full">$2,500</span>
                                </div>

                                <div
                                    class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                                    <div>
                                        <h4 class="font-medium">Mobile App Development</h4>
                                        <p class="text-sm text-gray-500">Posted 5 days ago</p>
                                    </div>
                                    <span
                                        class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">$5,000</span>
                                </div>

                                <div
                                    class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                                    <div>
                                        <h4 class="font-medium">Logo Design</h4>
                                        <p class="text-sm text-gray-500">Posted 1 week ago</p>
                                    </div>
                                    <span
                                        class="px-3 py-1 bg-amber-100 text-amber-800 text-sm font-medium rounded-full">$800</span>
                                </div>
                            </div>

                            <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 rounded-full gradient-bg flex items-center justify-center mr-3">
                                        <span class="text-white font-bold">JD</span>
                                    </div>
                                    <div>
                                        <h4 class="font-medium">John Doe</h4>
                                        <p class="text-sm text-gray-600">Senior UI/UX Designer</p>
                                    </div>
                                    <button class="ml-auto btn-primary py-2 px-4 text-sm">Connect</button>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative element -->
                        <div
                            class="absolute -bottom-6 -left-6 w-24 h-24 bg-amber-300 rounded-full opacity-20 floating">
                        </div>
                        <div class="absolute -top-6 -right-3 w-32 h-32 bg-blue-300 rounded-full opacity-20 floating"
                            style="animation-delay: 0.5s;"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 gradient-bg text-white">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Get Started?</h2>
                <p class="text-xl text-white/90 max-w-2xl mx-auto mb-10">
                    Join thousands of clients and freelancers who are already collaborating on CollabHub.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/register"
                        class="btn-primary bg-white text-blue-700 hover:bg-gray-100 py-3 px-8 text-lg">
                        Create Free Account
                    </a>
                    <a href="#"
                        class="btn-secondary bg-transparent border-2 border-white text-white hover:bg-white/10 py-3 px-8 text-lg">
                        Schedule a Demo
                    </a>
                </div>

                <p class="mt-8 text-white/70">
                    No credit card required • 14-day free trial • Cancel anytime
                </p>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-8 md:mb-0">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-10 h-10 rounded-lg gradient-bg flex items-center justify-center">
                                <span class="text-white font-bold text-xl">C</span>
                            </div>
                            <span class="text-2xl font-bold">CollabHub</span>
                        </div>
                        <p class="text-gray-400 max-w-md">
                            A modern freelance platform built with Laravel, connecting talented freelancers with
                            businesses
                            worldwide.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                        <div>
                            <h4 class="font-bold text-lg mb-4">Platform</h4>
                            <ul class="space-y-2 text-gray-400">
                                <li><a href="#" class="hover:text-white transition">For Clients</a></li>
                                <li><a href="#" class="hover:text-white transition">For Freelancers</a></li>
                                <li><a href="#" class="hover:text-white transition">How It Works</a></li>
                                <li><a href="#" class="hover:text-white transition">Pricing</a></li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="font-bold text-lg mb-4">Company</h4>
                            <ul class="space-y-2 text-gray-400">
                                <li><a href="#" class="hover:text-white transition">About Us</a></li>
                                <li><a href="#" class="hover:text-white transition">Careers</a></li>
                                <li><a href="#" class="hover:text-white transition">Blog</a></li>
                                <li><a href="#" class="hover:text-white transition">Contact</a></li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="font-bold text-lg mb-4">Legal</h4>
                            <ul class="space-y-2 text-gray-400">
                                <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                                <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                                <li><a href="#" class="hover:text-white transition">Cookie Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-800 mt-10 pt-8 text-center text-gray-400">
                    <p>&copy; 2025 CollabHub. All rights reserved. Built by Kyaw Zayar Tun.</p>
                </div>
            </div>
        </footer>
    @endif

    <!-- JavaScript for interactive elements -->
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Simple counter animation for stats
        const counters = document.querySelectorAll('.stat-card .text-3xl');
        const speed = 200;

        const animateCounters = () => {
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target') || 0;
                const count = +counter.innerText.replace('+', '');

                if (count < target) {
                    const increment = target / speed;
                    counter.innerText = Math.ceil(count + increment) + '+';
                    setTimeout(animateCounters, 1);
                } else {
                    counter.innerText = target + '+';
                }
            });
        };

        // Initialize counters when stats are in viewport
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Set data-target attributes for counter animation
                    document.querySelectorAll('.stat-card .text-3xl').forEach((stat, index) => {
                        const values = [10000, 5000, 98, 24];
                        stat.setAttribute('data-target', values[index]);
                        stat.innerText = '0' + (index === 3 ? '' : '+');
                    });

                    setTimeout(animateCounters, 300);
                    observer.disconnect();
                }
            });
        }, {
            threshold: 0.5
        });

        observer.observe(document.querySelector('.gradient-bg .grid'));

        // Dashboard Sidebar Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleSidebar = document.getElementById('toggleSidebar');
            const mobileMenuButton = document.getElementById('mobileMenuButton');
            const mobileClose = document.getElementById('mobileClose');
            const userMenuButton = document.getElementById('userMenuButton');
            const userDropdown = document.getElementById('userDropdown');

            // Toggle sidebar (desktop)
            if (toggleSidebar) {
                toggleSidebar.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');

                    // Update logo text visibility
                    const logoText = document.getElementById('logo-text');
                    if (sidebar.classList.contains('collapsed')) {
                        logoText.style.display = 'none';
                    } else {
                        logoText.style.display = 'block';
                    }
                });
            }

            // Toggle mobile menu
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', function() {
                    sidebar.classList.add('mobile-open');
                });
            }

            // Close mobile menu
            if (mobileClose) {
                mobileClose.addEventListener('click', function() {
                    sidebar.classList.remove('mobile-open');
                });
            }

            // User dropdown menu
            if (userMenuButton && userDropdown) {
                userMenuButton.addEventListener('click', function() {
                    userDropdown.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(event) {
                    if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
                        userDropdown.classList.add('hidden');
                    }
                });
            }

            // Active menu item highlighting
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    menuItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');

                    // Close mobile menu after clicking
                    if (window.innerWidth < 1024) {
                        sidebar.classList.remove('mobile-open');
                    }
                });
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 1024 &&
                    sidebar.classList.contains('mobile-open') &&
                    !sidebar.contains(event.target) &&
                    event.target !== mobileMenuButton) {
                    sidebar.classList.remove('mobile-open');
                }
            });
        });
    </script>
</body>

</html>
