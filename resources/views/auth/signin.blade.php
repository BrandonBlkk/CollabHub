<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signin | CollabHub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional styles for custom design -->
    <style>
        :root {
            --primary: #2563eb;
            --primary-light: #3b82f6;
            --secondary: #059669;
            --accent: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
        }

        .dot-pattern {
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

        /* Loading spinner - HIDDEN BY DEFAULT */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="font-['Figtree'] text-gray-800 bg-gradient-to-br from-slate-50 to-blue-50 h-screen overflow-hidden">
    <!-- Main Container -->
    <div class="h-screen flex flex-col md:flex-row overflow-hidden">
        <!-- Left Section - Login Form -->
        <div class="w-full md:w-1/2 p-4 md:p-6 flex flex-col justify-center items-center overflow-y-auto">
            <div class="w-full max-w-md py-10 sm:py-0">
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

                <!-- Welcome Back -->
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Welcome back</h2>
                    <p class="text-gray-600 text-sm mt-1">Sign in to continue to your freelance dashboard</p>
                </div>

                <!-- Login Form -->
                <form id="loginForm" method="POST" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email Address')" />
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
                            <p id="email-error"
                                class="absolute -bottom-2 left-5 mt-1 text-xs text-red-600 bg-white hidden">
                            </p>
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <x-input-label for="password" :value="__('Password')" />
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-xs text-blue-600 hover:text-blue-800 font-medium outline-none">
                                    Forgot password?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <x-text-input type="password" name="password" id="password" :value="old('password')"
                                placeholder="Create a strong password" />
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <button type="button" id="togglePassword"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                            <p id="password-error"
                                class="absolute -bottom-2 left-5 mt-1 text-xs text-red-600 bg-white hidden">
                            </p>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-3.5 w-3.5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="ml-2 block text-xs text-gray-700">
                            Remember me on this device
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn"
                        class="w-full bg-gray-800 hover:bg-black text-white font-semibold py-2.5 px-4 rounded-lg transition duration-300 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 select-none flex items-center justify-center">
                        <div id="submitSpinner"
                            class="hidden w-5 h-5 border-t-2 border-white rounded-full animate-spin mr-2">
                        </div>
                        <span id="submitText">Sign in to your account</span>
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

                <!-- Sign Up Link -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600 text-sm">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-800 ml-1">
                            Join CollabHub for free
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Section - Visual/Info (Keep as is) -->
        <div class="hidden md:flex md:w-1/2 relative overflow-hidden">
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
                <!-- Top Section - Quote -->
                <div class="max-w-lg">
                    <div class="inline-flex items-center px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                            </path>
                        </svg>
                        <span class="text-xs font-medium select-none">Top Rated Platform</span>
                    </div>

                    <h2 class="text-3xl font-bold mb-4">
                        Where Talent Meets <span class="text-amber-300">Opportunity</span>
                    </h2>

                    <p class="text-white/90 mb-6">
                        Join thousands of freelancers and clients collaborating on projects worldwide.
                        From web development to graphic design, find the perfect match for your next project.
                    </p>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 mb-8">
                        <div>
                            <div class="text-2xl font-bold">10K+</div>
                            <div class="text-white/80 text-xs">Projects Completed</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">5K+</div>
                            <div class="text-white/80 text-xs">Active Freelancers</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">98%</div>
                            <div class="text-white/80 text-xs">Satisfaction Rate</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonials -->
                <div class="max-w-lg">
                    <div
                        class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20 shadow-[0_20px_25px_-5px_rgba(0,0,0,0.1),0_10px_10px_-5px_rgba(0,0,0,0.04)]">
                        <div class="flex items-center mb-3">
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center font-bold text-white text-lg select-none">
                                SJ
                            </div>
                            <div class="ml-3">
                                <h4 class="font-bold text-base">Sarah Johnson</h4>
                                <p class="text-white/80 text-xs">UI/UX Designer</p>
                            </div>
                            <div class="ml-auto flex text-amber-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-white/90 italic text-sm">
                            "CollabHub transformed how I find clients. The platform is intuitive, and I've doubled my
                            income since joining. Highly recommended for any freelancer!"
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for AJAX login and enhanced UX -->
    <script>
        // Toggle password visibility
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
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
        }

        // AJAX Login Form Submission
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitSpinner = document.getElementById('submitSpinner');

            // Function to show field errors
            function showFieldErrors(errors) {
                // Clear previous field errors
                document.querySelectorAll('[id$="-error"]').forEach(el => {
                    el.classList.add('hidden');
                    el.textContent = '';
                });

                // Display new field errors
                for (const field in errors) {
                    const errorElement = document.getElementById(`${field}-error`);
                    if (errorElement) {
                        errorElement.textContent = errors[field][0];
                        errorElement.classList.remove('hidden');
                    }
                }
            }

            // Function to clear all errors
            function clearErrors() {
                document.querySelectorAll('[id$="-error"]').forEach(el => {
                    el.classList.add('hidden');
                    el.textContent = '';
                });
            }

            // Function to set loading state
            function setLoading(isLoading) {
                if (isLoading) {
                    submitBtn.disabled = true;
                    submitText.textContent = 'Signing in...';
                    submitSpinner.classList.remove('hidden');
                    submitSpinner.classList.add('block'); // Show spinner
                } else {
                    submitBtn.disabled = false;
                    submitText.textContent = 'Sign in to your account';
                    submitSpinner.classList.remove('block');
                    submitSpinner.classList.add('hidden'); // Hide spinner
                }
            }

            if (loginForm) {
                loginForm.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    // Clear previous errors
                    clearErrors();

                    // Set loading state
                    setLoading(true);

                    // Get form data
                    const formData = new FormData(this);

                    // Add CSRF token
                    const csrfToken = document.querySelector('input[name="_token"]').value;

                    try {
                        const response = await fetch('{{ route('signin') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (data.success) {
                            window.location.href = data.redirect;
                        } else {
                            // Show validation errors
                            if (data.errors) {
                                showFieldErrors(data.errors);
                            }
                            // Show general error message
                            if (data.message) {
                                //
                            }
                            // Reset loading state on error
                            setLoading(false);
                        }

                    } catch (error) {
                        console.error('Login error:', error);
                        //
                        setLoading(false);
                    }
                });
            }

            // Clear errors when user starts typing
            const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    const fieldName = this.name;
                    const errorElement = document.getElementById(`${fieldName}-error`);
                    if (errorElement) {
                        errorElement.classList.add('hidden');
                    }
                });
            });
        });
    </script>
</body>

</html>
