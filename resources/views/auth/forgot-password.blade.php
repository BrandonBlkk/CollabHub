<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password | CollabHub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .dot-pattern {
            background-image: radial-gradient(#2563eb 1px, transparent 1px);
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
    </style>
</head>

<body class="font-['Figtree'] text-gray-800 bg-gradient-to-br from-slate-50 to-blue-50 h-screen overflow-hidden">
    <!-- Main Container -->
    <div class="h-screen flex flex-col lg:flex-row overflow-hidden">
        <!-- Left Section - Reset Form -->
        <div class="w-full lg:w-1/2 p-4 md:p-6 flex flex-col justify-center items-center overflow-y-auto">
            <div class="w-full max-w-md">
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

                <!-- Forgot Password Message -->
                <div class="mb-4 text-sm text-gray-600">
                    Forgot your password? No problem. Just let us know your email address and we will email you a
                    password reset link that will allow you to choose a new one.
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Reset Form -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email Address')" />
                        <div class="relative">
                            <x-text-input id="email" type="email" name="email" :value="old('email')" required
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

                    <!-- Submit Button -->
                    <div class="flex items-center mt-4">
                        <button type="submit"
                            class="bg-gray-800 hover:bg-black text-white font-semibold py-2.5 px-6 rounded-lg w-full transition duration-300 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 select-none">
                            Email Password Reset Link
                        </button>
                    </div>
                </form>

                <!-- Back to Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600 text-sm">
                        Remember your password?
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
                <div class="absolute bottom-1/4 right-1/4 w-36 h-36 bg-white/10 rounded-full floating"
                    style="animation-delay: 0.5s;"></div>
                <div class="absolute top-1/3 right-1/3 w-24 h-24 bg-white/5 rounded-full floating"
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
                        <span class="text-xs font-medium select-none">Secure & Reliable Platform</span>
                    </div>

                    <h2 class="text-3xl font-bold mb-4 leading-tight">
                        Security You Can <span class="text-amber-300">Trust</span>
                    </h2>

                    <p class="text-white/90 mb-6">
                        Your security is our top priority. We use industry-standard encryption and security measures to
                        protect your account and data.
                    </p>

                    <!-- Security Features -->
                    <div class="space-y-4 mb-6">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-white/90 text-sm">End-to-end encrypted password reset</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-white/90 text-sm">Time-limited reset links (24 hours)</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-amber-500/20 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-white/90 text-sm">One-click secure password reset</span>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 mb-8">
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-3 rounded-lg text-center">
                            <div class="text-lg font-bold mb-1">99.9%</div>
                            <div class="text-white/80 text-xs">Uptime</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-3 rounded-lg text-center">
                            <div class="text-lg font-bold mb-1">256-bit</div>
                            <div class="text-white/80 text-xs">Encryption</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-3 rounded-lg text-center">
                            <div class="text-lg font-bold mb-1">24/7</div>
                            <div class="text-white/80 text-xs">Support</div>
                        </div>
                    </div>

                    <!-- Testimonial -->
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                        <div class="flex items-start">
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center font-bold text-white text-sm mr-3 flex-shrink-0 select-none">
                                AS
                            </div>
                            <div>
                                <div class="flex items-center mb-1">
                                    <h4 class="font-bold text-sm">Alex Smith</h4>
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
                                    "I accidentally locked myself out of my account, but the password reset process was
                                    incredibly smooth and secure. Received the reset link instantly and was back to work
                                    in minutes."
                                </p>
                                <p class="text-white/70 text-xs mt-1">Frontend Developer • Member since 2022</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
