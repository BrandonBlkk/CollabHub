<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up | CollabHub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional styles for custom design -->
    <style>
        .dot-pattern {
            background-image: radial-gradient(var(--primary) 1px, transparent 1px);
            background-size: 40px 40px;
            opacity: 0.1;
        }

        /* Define CSS variables */
        :root {
            --primary: #2563eb;
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

        .user-type-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .user-type-card:hover {
            transform: translateY(-4px);
            border-color: var(--primary);
        }

        .user-type-card.selected {
            border-color: var(--primary);
            background-color: #eff6ff;
        }

        /* Password Strength Meter Styles */
        .password-strength-meter {
            margin-top: 8px;
        }

        .strength-bar {
            height: 6px;
            border-radius: 3px;
            background-color: #e5e7eb;
            overflow: hidden;
            margin-bottom: 4px;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .strength-text {
            font-size: 12px;
            font-weight: 500;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .strength-text span {
            transition: color 0.3s ease;
        }

        /* Password strength colors */
        .strength-weak .strength-fill {
            background-color: #ef4444;
            width: 25%;
        }

        .strength-fair .strength-fill {
            background-color: #f59e0b;
            width: 50%;
        }

        .strength-good .strength-fill {
            background-color: #3b82f6;
            width: 75%;
        }

        .strength-strong .strength-fill {
            background-color: #10b981;
            width: 100%;
        }

        .strength-weak .strength-text span {
            color: #ef4444;
        }

        .strength-fair .strength-text span {
            color: #f59e0b;
        }

        .strength-good .strength-text span {
            color: #3b82f6;
        }

        .strength-strong .strength-text span {
            color: #10b981;
        }

        /* Password requirements list */
        .password-requirements {
            margin-top: 8px;
            padding-left: 16px;
            font-size: 11px;
        }

        .password-requirements li {
            margin-bottom: 2px;
            color: #6b7280;
            list-style-type: disc;
        }

        .password-requirements li.requirement-met {
            color: #10b981;
        }

        .password-requirements li.requirement-met::marker {
            color: #10b981;
        }
    </style>
</head>

<body class="font-['Figtree'] text-gray-800 bg-gradient-to-br from-slate-50 to-blue-50 h-screen">
    <!-- Main Container -->
    <div class="h-screen flex flex-col lg:flex-row overflow-hidden">
        <!-- Left Section - Signup Form -->
        <div class="signup-form w-full lg:w-1/2 p-4 md:p-6 flex flex-col justify-center items-center overflow-y-auto">
            <div class="w-full max-w-md mt-44 md:mt-40">
                <!-- Logo -->
                <div class="inline-block">
                    <a href="/" class="flex items-center space-x-3 mb-6">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-r from-blue-700 to-teal-600 flex items-center justify-center">
                            <span class="text-white font-bold text-xl">C</span>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">CollabHub</h1>
                            <p class="text-gray-600 text-xs">Freelance Collaboration Platform</p>
                        </div>
                    </a>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Welcome -->
                <div class="mb-6">
                    <h2 id="formTitle" class="text-2xl font-bold text-gray-900">Create Your Account</h2>
                    <p class="text-gray-600 text-sm mt-1">Join thousands of professionals on CollabHub</p>
                </div>

                <!-- Signup Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4" id="signupForm">
                    @csrf

                    <!-- User Type Selection -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2 text-sm">I want to join as:</label>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="user-type-card bg-white rounded-lg shadow-sm p-4 text-center border-2"
                                data-type="client" onclick="selectUserType('client')">
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-sm">Client</h3>
                                <p class="text-gray-500 text-xs mt-1">Hire freelancers</p>
                                <input type="radio" name="user_type" value="client" class="hidden" id="clientType">
                            </div>
                            <div class="user-type-card bg-white rounded-lg shadow-sm p-4 text-center border-2"
                                data-type="freelancer" onclick="selectUserType('freelancer')">
                                <div
                                    class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-sm">Freelancer</h3>
                                <p class="text-gray-500 text-xs mt-1">Find projects</p>
                                <input type="radio" name="user_type" value="freelancer" class="hidden"
                                    id="freelancerType">
                            </div>
                        </div>
                        @error('user_type')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <!-- Name -->
                        <div class="flex-1">
                            <x-input-label for="name" :value="__('Full Name')" />
                            <div class="relative">
                                <x-text-input type="text" name="name" id="name" value="{{ old('name') }}"
                                    placeholder="Enter your full name" />
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @error('name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="flex-1">
                            <x-input-label for="email" :value="__('Email')" />
                            <div class="relative">
                                <x-text-input type="email" name="email" id="email" :value="old('email')"
                                    placeholder="you@example.com" />
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <div class="relative">
                            <x-text-input type="password" name="password" id="password"
                                placeholder="Create a strong password" class="password" />
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <button type="button"
                                class="togglePassword absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>

                        <!-- Password Strength Meter -->
                        <div class="password-strength-meter" id="passwordStrengthMeter">
                            <div class="strength-bar">
                                <div class="strength-fill"></div>
                            </div>
                            <div class="strength-text">
                                <span>Password Strength: <span id="strengthText">Very Weak</span></span>
                                <span id="strengthScore">0/5</span>
                            </div>
                        </div>

                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <div class="relative">
                            <x-text-input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Confirm your password" class="password" />
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <button type="button"
                                class="togglePassword absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="flex items-center">
                        <input id="terms" name="terms" type="checkbox"
                            class="h-3.5 w-3.5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                            {{ old('terms') ? 'checked' : '' }}>
                        <label for="terms" class="ml-2 block text-xs text-gray-700">
                            I agree to the <a href="#" class="text-blue-600 hover:text-blue-800">Terms of
                                Service</a> and <a href="#" class="text-blue-600 hover:text-blue-800">Privacy
                                Policy</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-gray-800 hover:bg-black text-white font-semibold py-2.5 px-4 rounded-lg transition duration-300 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 select-none">
                        Create Account
                    </button>

                    <!-- Divider -->
                    <div class="relative my-4">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="px-3 bg-white text-gray-500">Or continue with</span>
                        </div>
                    </div>

                    <!-- Social Login Options -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <button type="button"
                                class="w-full flex items-center justify-center p-2.5 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-300 text-sm">
                                <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24">
                                    <path fill="#4285F4"
                                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                    <path fill="#34A853"
                                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                    <path fill="#FBBC05"
                                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                    <path fill="#EA4335"
                                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                </svg>
                                <span class="font-medium text-gray-700 select-none">Google</span>
                            </button>
                            <p class="text-xs text-gray-500 text-center mt-1 block">Recommended for everyone</p>
                        </div>
                        <div>
                            <button type="button"
                                class="w-full flex items-center justify-center p-2.5 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-300 text-sm">
                                <svg class="w-4 h-4 mr-2" fill="#000000" viewBox="0 0 24 24">
                                    <path
                                        d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                </svg>
                                <span class="font-medium text-gray-700 select-none">GitHub</span>
                            </button>
                            <p class="text-xs text-gray-500 text-center mt-1 block">Great for freelancers</p>
                        </div>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600 text-sm">
                        Already have an account?
                        <a href="{{ route('signin') }}" class="font-medium text-blue-600 hover:text-blue-800 ml-1">
                            Sign in here
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Section - Visual/Info -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-gradient-to-r from-blue-800 to-teal-700">
                <div class="absolute inset-0 dot-pattern"></div>

                <!-- Animated floating elements -->
                <div class="absolute top-1/4 left-1/4 w-48 h-48 bg-white/10 rounded-full floating"></div>
                <div class="absolute bottom-1/4 right-1/4 w-36 h-36 bg-white/10 rounded-full floating animation-delay-500"
                    style="animation-delay: 0.5s;"></div>
                <div class="absolute top-1/3 right-1/3 w-24 h-24 bg-white/5 rounded-full floating animation-delay-1000"
                    style="animation-delay: 1s;"></div>
            </div>

            <!-- Content Overlay -->
            <div class="relative z-10 flex flex-col justify-center p-8 text-white w-full h-full">
                <!-- Compact Content -->
                <div class="max-w-lg">
                    <div class="inline-flex items-center px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                        <span class="text-xs font-medium select-none">Join 5,000+ professionals</span>
                    </div>

                    <h2 class="text-3xl font-bold mb-4 leading-tight">
                        Start Your <span class="text-amber-300">Journey</span> Today
                    </h2>

                    <p class="text-white/90 mb-6">
                        Whether you're looking to hire talent or find amazing projects, CollabHub is the perfect
                        platform to grow your business or career.
                    </p>

                    <!-- Benefits -->
                    <div class="space-y-4 mb-6">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-white/90 text-sm">For Clients: Find vetted freelancers</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-white/90 text-sm">For Freelancers: Access quality projects</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-amber-500/20 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-white/90 text-sm">Secure payments & escrow protection</span>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 mb-8">
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-3 rounded-lg text-center">
                            <div class="text-lg font-bold mb-1">10K+</div>
                            <div class="text-white/80 text-xs">Projects</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-3 rounded-lg text-center">
                            <div class="text-lg font-bold mb-1">$5M+</div>
                            <div class="text-white/80 text-xs">Paid</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-3 rounded-lg text-center">
                            <div class="text-lg font-bold mb-1">48h</div>
                            <div class="text-white/80 text-xs">Hiring Time</div>
                        </div>
                    </div>

                    <!-- Testimonial -->
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                        <div class="flex items-start">
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center font-bold text-white text-sm mr-3 flex-shrink-0 select-none">
                                MJ
                            </div>
                            <div>
                                <div class="flex items-center mb-1">
                                    <h4 class="font-bold text-sm">Michael Rodriguez</h4>
                                    <div class="ml-2 flex text-amber-400">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-white/90 text-xs italic">
                                    "As a freelancer, CollabHub helped me find consistent work and build my portfolio.
                                    The platform is intuitive and payment is always secure."
                                </p>
                                <p class="text-white/70 text-xs mt-1">Full-Stack Developer • Member since 2021</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for enhanced UX -->
    <script>
        // Toggle password visibility for all password fields
        const toggleButtons = document.querySelectorAll('.togglePassword');
        const passwordInputs = document.querySelectorAll('.password');

        toggleButtons.forEach((toggleButton, index) => {
            toggleButton.addEventListener('click', function() {
                const passwordInput = passwordInputs[index];
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Change icon
                const icon = this.querySelector('svg');
                if (type === 'text') {
                    icon.innerHTML =
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
                } else {
                    icon.innerHTML =
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
                }
            });
        });

        // User Type Selection
        function selectUserType(type) {
            // Remove selected class from all cards
            document.querySelectorAll('.user-type-card').forEach(card => {
                card.classList.remove('selected');
            });

            // Add selected class to clicked card
            const selectedCard = document.querySelector(`.user-type-card[data-type="${type}"]`);
            selectedCard.classList.add('selected');

            // Update radio button
            document.getElementById(`${type}Type`).checked = true;

            // Update form heading based on selection
            const heading = document.getElementById('formTitle');
            if (type === 'client') {
                heading.innerHTML = 'Find Amazing Talent <span class="text-amber-300">as a Client</span>';
            } else {
                heading.innerHTML = 'Start Your <span class="text-amber-300">Freelance Career</span>';
            }
        }

        // Password Strength Checker
        function checkPasswordStrength(password) {
            let score = 0;
            const requirements = {
                length: false,
                lowercase: false,
                uppercase: false,
                number: false,
                special: false
            };

            // Check length
            if (password.length >= 8) {
                score++;
                requirements.length = true;
            }

            // Check lowercase
            if (/[a-z]/.test(password)) {
                score++;
                requirements.lowercase = true;
            }

            // Check uppercase
            if (/[A-Z]/.test(password)) {
                score++;
                requirements.uppercase = true;
            }

            // Check number
            if (/[0-9]/.test(password)) {
                score++;
                requirements.number = true;
            }

            // Check special character
            if (/[^A-Za-z0-9]/.test(password)) {
                score++;
                requirements.special = true;
            }

            return {
                score,
                requirements
            };
        }

        function updatePasswordStrengthDisplay(password) {
            const strengthMeter = document.getElementById('passwordStrengthMeter');
            const strengthText = document.getElementById('strengthText');
            const strengthScore = document.getElementById('strengthScore');

            if (!password) {
                strengthMeter.className = 'password-strength-meter';
                strengthText.textContent = 'Very Weak';
                strengthScore.textContent = '0/5';
                return;
            }

            const {
                score,
                requirements
            } = checkPasswordStrength(password);

            // Update strength classes
            strengthMeter.className = 'password-strength-meter';
            if (score <= 1) {
                strengthMeter.classList.add('strength-weak');
                strengthText.textContent = 'Very Weak';
            } else if (score === 2) {
                strengthMeter.classList.add('strength-fair');
                strengthText.textContent = 'Fair';
            } else if (score === 3) {
                strengthMeter.classList.add('strength-good');
                strengthText.textContent = 'Good';
            } else {
                strengthMeter.classList.add('strength-strong');
                strengthText.textContent = 'Strong';
            }

            // Update score display
            strengthScore.textContent = `${score}/5`;
        }

        // Password input event listener
        document.getElementById('password').addEventListener('input', function(e) {
            updatePasswordStrengthDisplay(e.target.value);
        });

        // Confirm password matching check
        document.getElementById('password_confirmation').addEventListener('input', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = e.target.value;

            if (confirmPassword && password !== confirmPassword) {
                e.target.classList.add('border-red-500');
                e.target.classList.remove('border-gray-200');
            } else {
                e.target.classList.remove('border-red-500');
                e.target.classList.add('border-gray-200');
            }
        });

        // Form submission feedback
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML =
                        '<span class="flex items-center justify-center"><svg class="animate-spin h-3 w-3 mr-1 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Creating account...</span>';
                    submitBtn.disabled = true;

                    // Reset button after 5 seconds (in case of error)
                    setTimeout(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }, 5000);
                }
            });
        }

        // Add focus styling to inputs
        document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-blue-200', 'rounded-lg');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-blue-200', 'rounded-lg');
            });
        });

        // Set default user type to client
        document.addEventListener('DOMContentLoaded', function() {
            selectUserType('client');
        });
    </script>
</body>

</html>
