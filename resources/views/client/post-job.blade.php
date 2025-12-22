<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Post a Job | CollabHub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                <!-- Page Header -->
                <div class="mb-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Post a New Job</h1>
                            <p class="text-gray-600 mt-1">
                                Fill out the form below to post a new job and find the perfect freelancer
                            </p>
                        </div>
                        <button onclick="window.location.href='{{ route('my-jobs.index') }}'"
                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium transition duration-200 flex items-center space-x-2 select-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>Back to Jobs</span>
                        </button>
                    </div>
                </div>

                <!-- Job Post Form -->
                <form id="jobPostForm" method="POST" action="{{ route('my-jobs.store') }}" class="space-y-6">
                    @csrf
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-3">Basic Information</h2>

                        <input type="hidden" name="client_id" value="{{ Auth::user()->client->id }}">
                        <!-- Job Title -->
                        <div class="mb-3">
                            <label for="job_title" class="block text-sm font-medium text-gray-700 mb-2">
                                Job Title <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="job_title" name="title"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    placeholder="e.g., Senior React Developer with TypeScript Experience"
                                    maxlength="255">
                                @error('title')
                                    <p class="absolute -bottom-2 left-4 mt-1 text-xs text-red-600 bg-white">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <p class="text-gray-500 text-xs mt-2">Be specific about the role you're hiring for</p>
                        </div>

                        <!-- Job Description -->
                        <div class="mb-3">
                            <label for="job_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Job Description <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="border border-gray-300 rounded-lg overflow-hidden">
                                    <div
                                        class="bg-gray-50 border-b border-gray-300 px-4 py-2 flex items-center space-x-2">
                                        <button type="button" onclick="formatText('bold')"
                                            class="p-1 hover:bg-gray-200 rounded">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                        </button>
                                        <button type="button" onclick="formatText('italic')"
                                            class="p-1 hover:bg-gray-200 rounded">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                            </svg>
                                        </button>
                                        <button type="button" onclick="formatText('ul')"
                                            class="p-1 hover:bg-gray-200 rounded">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 12h16M4 18h16" />
                                            </svg>
                                        </button>
                                    </div>
                                    <textarea id="job_description" name="description" rows="8" class="w-full px-4 py-3 focus:outline-none resize-none"
                                        placeholder="Describe the job in detail. Include responsibilities, expectations, and project goals..."></textarea>
                                </div>
                                @error('description')
                                    <p class="absolute -bottom-2 left-4 mt-1 text-xs text-red-600 bg-white">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="flex justify-between mt-2">
                                <p class="text-gray-500 text-xs">Describe what you need done in detail</p>
                                <p id="charCount" class="text-gray-500 text-xs">0/5000 characters</p>
                            </div>
                        </div>

                        <!-- Job Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Job Type <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="relative">
                                    <input type="radio" name="type" value="fixed" checked class="peer sr-only">
                                    <div
                                        class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-400 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-200">
                                        <div class="flex items-center">
                                            <div
                                                class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center peer-checked:border-blue-500">
                                                <div
                                                    class="w-2.5 h-2.5 rounded-full bg-blue-500 hidden peer-checked:block">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">Fixed Price</div>
                                                <div class="text-gray-600 text-sm mt-1">Pay a fixed amount for the
                                                    entire project</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative">
                                    <input type="radio" name="type" value="hourly" class="peer sr-only">
                                    <div
                                        class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-400 peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                        <div class="flex items-center">
                                            <div
                                                class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center peer-checked:border-blue-500">
                                                <div
                                                    class="w-2.5 h-2.5 rounded-full bg-blue-500 hidden peer-checked:block">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">Hourly Rate</div>
                                                <div class="text-gray-600 text-sm mt-1">Pay by the hour for ongoing
                                                    work</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Skills Required -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-3">Skills Required</h2>

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Add Required Skills <span class="text-red-500">*</span>
                            </label>
                            <div class="border border-gray-300 rounded-lg p-4">
                                <div id="skillsContainer" class="flex flex-wrap gap-2 mb-3">
                                    <!-- Skills will be added here dynamically -->
                                </div>
                                <div class="relative">
                                    <div class="flex">
                                        <input type="text" id="skillInput"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                            placeholder="Type a skill and press Enter (e.g., React, Python, UI/UX Design)">
                                        <button type="button" onclick="addSkill()"
                                            class="px-4 py-2 bg-gray-800 text-white rounded-r-lg hover:bg-black transition duration-200 select-none">
                                            Add
                                        </button>
                                    </div>
                                    @error('skills_required')
                                        <p class="absolute -bottom-2 left-4 mt-1 text-xs text-red-600 bg-white">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <p class="text-gray-500 text-xs mt-2">Add at least 3 skills that are required for this
                                    job</p>
                            </div>
                            <input type="hidden" id="skills_required" name="skills_required">
                        </div>

                        <!-- Experience Level -->
                        <div class="mb-3">
                            <label for="experience_level" class="block text-sm font-medium text-gray-700 mb-2">
                                Experience Level <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select id="experience_level" name="experience_level"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <option value="">Select experience level</option>
                                    <option value="entry">Entry Level (0-2 years)</option>
                                    <option value="intermediate" selected>Intermediate (2-5 years)</option>
                                    <option value="expert">Expert (5+ years)</option>
                                </select>
                                @error('experience_level')
                                    <p class="absolute -bottom-2 left-4 mt-1 text-xs text-red-600 bg-white">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Duration -->
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                                Expected Duration
                            </label>
                            <select id="duration" name="duration"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                <option value="">Select expected duration</option>
                                <option value="less_than_1_month">Less than 1 month</option>
                                <option value="1_to_3_months">1 to 3 months</option>
                                <option value="3_to_6_months">3 to 6 months</option>
                                <option value="more_than_6_months">More than 6 months</option>
                            </select>
                        </div>
                    </div>

                    <!-- Budget & Timeline -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-3">Budget & Timeline</h2>

                        <!-- Budget Type Toggle -->
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Budget Range <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="budgetFields">
                                <!-- Fixed Price Fields -->
                                <div class="md:col-span-2">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="budget_min"
                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                Minimum Budget ($)
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500">$</span>
                                                </div>
                                                <div class="relative">
                                                    <input type="number" id="budget_min" name="budget_min"
                                                        min="0" step="0.01"
                                                        class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                                        placeholder="e.g., 1000">
                                                    @error('budget_min')
                                                        <p
                                                            class="absolute -bottom-2 left-4 mt-1 text-xs text-red-600 bg-white">
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="budget_max"
                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                Maximum Budget ($)
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500">$</span>
                                                </div>
                                                <div class="relative">
                                                    <input type="number" id="budget_max" name="budget_max"
                                                        min="0" step="0.01"
                                                        class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                                        placeholder="e.g., 5000">
                                                    @error('budget_max')
                                                        <p
                                                            class="absolute -bottom-2 left-4 mt-1 text-xs text-red-600 bg-white">
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-500 text-xs mt-2">Set a realistic budget range for your project
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Project Deadline -->
                        <div class="mb-3">
                            <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-2">
                                Application Deadline (Optional)
                            </label>
                            <input type="date" id="expires_at" name="expires_at"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                min="{{ date('Y-m-d') }}">
                            <p class="text-gray-500 text-xs mt-2">Set a deadline for freelancer applications</p>
                        </div>

                        <!-- Privacy Settings -->
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Privacy Settings
                            </label>
                            <div class="space-y-3 inline-block">
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" id="is_featured" name="is_featured"
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="text-sm text-gray-900">Feature this job (extra $50)</span>
                                    <span
                                        class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">Recommended</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" id="is_private" name="is_private"
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="text-sm text-gray-900">Make job private (only invited freelancers can
                                        apply)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Category (Optional)
                            </label>
                            <select id="category_id" name="category_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                <option value="">Select a category</option>

                                {{-- Get all categories --}}
                                @forelse ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    <option value="9">Other</option>
                                @empty
                                    <option value="" disabled>No categories found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between select-none">
                            <button type="button" onclick="saveAsDraft()"
                                class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium transition duration-200">
                                Save as Draft
                            </button>
                            <div class="flex items-center space-x-4">
                                <button type="button" onclick="previewJob()"
                                    class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium transition duration-200">
                                    Preview
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium transition duration-200">
                                    Publish Job
                                </button>
                            </div>
                        </div>
                        <p class="text-gray-500 text-sm text-center mt-4">
                            By clicking "Publish Job", you agree to our <a href="#"
                                class="text-blue-600 hover:text-blue-800">Terms of Service</a>
                        </p>
                    </div>
                </form>

                <!-- Preview Modal (Hidden by default) -->
                <div id="previewModal"
                    class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                    <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-xl bg-white">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Job Preview</h3>
                            <button onclick="closePreview()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div id="previewContent" class="space-y-6 max-h-[70vh] overflow-y-auto">
                            <!-- Preview content will be inserted here -->
                        </div>
                        <div class="mt-6 flex justify-end space-x-4">
                            <button onclick="closePreview()"
                                class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium">
                                Close
                            </button>
                            <button onclick="submitForm()"
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
                                Publish Job
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Skills Management
        let skills = [];

        function addSkill() {
            const skillInput = document.getElementById('skillInput');
            const skill = skillInput.value.trim();

            if (skill && !skills.includes(skill)) {
                skills.push(skill);
                updateSkillsDisplay();
                updateSkillsHiddenField();
                skillInput.value = '';
            }
        }

        function removeSkill(index) {
            skills.splice(index, 1);
            updateSkillsDisplay();
            updateSkillsHiddenField();
        }

        function updateSkillsDisplay() {
            const container = document.getElementById('skillsContainer');
            container.innerHTML = '';

            skills.forEach((skill, index) => {
                const skillElement = document.createElement('div');
                skillElement.className = 'flex items-center bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg';
                skillElement.innerHTML = `
                    ${skill}
                    <button type="button" onclick="removeSkill(${index})" class="ml-2 text-blue-700 hover:text-blue-900">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                `;
                container.appendChild(skillElement);
            });
        }

        function updateSkillsHiddenField() {
            document.getElementById('skills_required').value = JSON.stringify(skills);
        }

        // Character count for description
        const descriptionTextarea = document.getElementById('job_description');
        const charCount = document.getElementById('charCount');

        descriptionTextarea.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = `${length}/5000 characters`;

            if (length > 5000) {
                charCount.classList.add('text-red-600');
                charCount.classList.remove('text-gray-500');
            } else {
                charCount.classList.remove('text-red-600');
                charCount.classList.add('text-gray-500');
            }
        });

        // Text formatting
        function formatText(type) {
            const textarea = document.getElementById('job_description');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);

            let formattedText = '';
            switch (type) {
                case 'bold':
                    formattedText = `**${selectedText}**`;
                    break;
                case 'italic':
                    formattedText = `*${selectedText}*`;
                    break;
                case 'ul':
                    formattedText = `\n• ${selectedText}`;
                    break;
            }

            textarea.value = textarea.value.substring(0, start) + formattedText + textarea.value.substring(end);
            textarea.focus();
            textarea.setSelectionRange(start + formattedText.length, start + formattedText.length);
        }

        // Toggle budget fields based on job type
        const jobTypeRadios = document.querySelectorAll('input[name="type"]');
        const budgetFields = document.getElementById('budgetFields');

        function updateBudgetFields() {
            const selectedType = document.querySelector('input[name="type"]:checked').value;

            if (selectedType === 'fixed') {
                budgetFields.innerHTML = `
                    <div class="md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="budget_min" class="block text-sm font-medium text-gray-700 mb-2">
                                    Minimum Budget ($)
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">$</span>
                                    </div>
                                    <input type="number" id="budget_min" name="budget_min" min="0" step="0.01"
                                        class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="e.g., 1000">
                                </div>
                            </div>
                            <div>
                                <label for="budget_max" class="block text-sm font-medium text-gray-700 mb-2">
                                    Maximum Budget ($)
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">$</span>
                                    </div>
                                    <input type="number" id="budget_max" name="budget_max" min="0" step="0.01"
                                        class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="e.g., 5000">
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-500 text-xs mt-2">Set a realistic budget range for your project</p>
                    </div>
                `;
            } else {
                budgetFields.innerHTML = `
                    <div class="md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="hourly_min" class="block text-sm font-medium text-gray-700 mb-2">
                                    Minimum Hourly Rate ($/hr)
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">$</span>
                                    </div>
                                    <input type="number" id="budget_min" name="budget_min" min="0" step="0.01"
                                        class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="e.g., 20">
                                </div>
                            </div>
                            <div>
                                <label for="hourly_max" class="block text-sm font-medium text-gray-700 mb-2">
                                    Maximum Hourly Rate ($/hr)
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">$</span>
                                    </div>
                                    <input type="number" id="budget_max" name="budget_max" min="0" step="0.01"
                                        class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="e.g., 50">
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-500 text-xs mt-2">Set a realistic hourly rate range</p>
                    </div>
                `;
            }
        }

        jobTypeRadios.forEach(radio => {
            radio.addEventListener('change', updateBudgetFields);
        });

        // Initialize budget fields
        updateBudgetFields();

        // Preview functionality
        function previewJob() {
            const form = document.getElementById('jobPostForm');
            const formData = new FormData(form);
            const previewContent = document.getElementById('previewContent');

            let previewHTML = `
                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Open
                        </span>
                        <span class="text-sm text-gray-500">Posted just now</span>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">${formData.get('title') || 'Job Title'}</h2>

                    <div class="prose max-w-none">
                        <p class="text-gray-600 mb-4">${formData.get('description') || 'Job description will appear here...'}</p>
                    </div>

                    <div class="flex flex-wrap gap-2 mb-6">
            `;

            // Add skills preview
            skills.forEach(skill => {
                previewHTML += `
                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                        ${skill}
                    </span>
                `;
            });

            const jobType = formData.get('type');
            const budgetMin = formData.get('budget_min');
            const budgetMax = formData.get('budget_max');
            const experience = formData.get('experience_level');
            const duration = formData.get('duration');

            previewHTML += `
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-medium text-gray-700 mb-1">Budget</h4>
                                <p class="text-gray-900 font-semibold">
            `;

            if (budgetMin && budgetMax) {
                if (jobType === 'fixed') {
                    previewHTML += `$${budgetMin} - $${budgetMax} (Fixed Price)`;
                } else {
                    previewHTML += `$${budgetMin} - $${budgetMax}/hr (Hourly)`;
                }
            } else {
                previewHTML += 'Budget not specified';
            }

            previewHTML += `
                                </p>
                            </div>

                            <div>
                                <h4 class="font-medium text-gray-700 mb-1">Experience Level</h4>
                                <p class="text-gray-900">
            `;

            switch (experience) {
                case 'entry':
                    previewHTML += 'Entry Level (0-2 years)';
                    break;
                case 'intermediate':
                    previewHTML += 'Intermediate (2-5 years)';
                    break;
                case 'expert':
                    previewHTML += 'Expert (5+ years)';
                    break;
                default:
                    previewHTML += 'Not specified';
            }

            previewHTML += `
                                </p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <h4 class="font-medium text-gray-700 mb-1">Expected Duration</h4>
                                <p class="text-gray-900">
            `;

            switch (duration) {
                case 'less_than_1_month':
                    previewHTML += 'Less than 1 month';
                    break;
                case '1_to_3_months':
                    previewHTML += '1 to 3 months';
                    break;
                case '3_to_6_months':
                    previewHTML += '3 to 6 months';
                    break;
                case 'more_than_6_months':
                    previewHTML += 'More than 6 months';
                    break;
                default:
                    previewHTML += 'Not specified';
            }

            previewHTML += `
                                </p>
                            </div>

                            <div>
                                <h4 class="font-medium text-gray-700 mb-1">Application Deadline</h4>
                                <p class="text-gray-900">
            `;

            const deadline = formData.get('expires_at');
            if (deadline) {
                const date = new Date(deadline);
                previewHTML += date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            } else {
                previewHTML += 'No deadline set';
            }

            previewHTML += `
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h4 class="font-medium text-gray-700 mb-2">Additional Settings</h4>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 ${formData.get('is_featured') ? 'text-blue-600' : 'text-gray-400'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                <span class="text-sm ${formData.get('is_featured') ? 'text-blue-600 font-medium' : 'text-gray-600'}">Featured Job</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 ${formData.get('is_private') ? 'text-blue-600' : 'text-gray-400'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <span class="text-sm ${formData.get('is_private') ? 'text-blue-600 font-medium' : 'text-gray-600'}">Private Job</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            previewContent.innerHTML = previewHTML;
            document.getElementById('previewModal').classList.remove('hidden');
        }

        function closePreview() {
            document.getElementById('previewModal').classList.add('hidden');
        }

        // Save as draft
        function saveAsDraft() {
            if (validateForm(true)) {
                alert('Job saved as draft successfully!');
                // In a real application, you would submit the form with draft status
                // document.getElementById('jobPostForm').submit();
            }
        }

        // Submit form
        function submitForm() {
            document.getElementById('jobPostForm').submit();
        }

        // Handle form submission
        document.getElementById('jobPostForm').addEventListener('submit', function(e) {
            e.preventDefault();
            submitForm();
        });

        // Allow adding skills with Enter key
        document.getElementById('skillInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addSkill();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePreview();
            }
        });

        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar')?.classList.toggle('active');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');

            if (window.innerWidth <= 1024 &&
                sidebar &&
                !sidebar.contains(event.target) &&
                toggleBtn &&
                !toggleBtn.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
    </script>
</body>

</html>
