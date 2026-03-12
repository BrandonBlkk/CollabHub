@extends('layouts.app')

@php
    $job = $job ?? null;
    $isEdit = $job !== null;
@endphp

@section('title', $isEdit ? 'Edit Job' : 'Post a New Job')

@push('styles')
    <style>
        #job_description_editor:empty::before {
            content: attr(data-placeholder);
            color: #9ca3af;
        }

        #job_description_editor ul {
            list-style: disc;
            margin-left: 1.5rem;
        }

        #job_description_editor li {
            margin: 0.25rem 0;
        }

        .format-button-active {
            background-color: #e5e7eb;
        }

        .format-button-active svg {
            color: #111827;
        }

        .description-error {
            border-color: #ef4444;
        }

        .description-error:hover {
            border-color: #ef4444;
        }

        .description-error:focus-within {
            --tw-ring-color: #ef4444;
            border-color: #ef4444;
        }
    </style>
@endpush

@section('content')
    <div class="mb-3">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $isEdit ? 'Edit Job' : 'Post a New Job' }}</h1>
                <p class="text-gray-600 mt-1">
                    {{ $isEdit
                        ? 'Update the details of your job posting.'
                        : 'Fill out the form below to post a new job and find the perfect freelancer' }}
                </p>
            </div>
            <button onclick="window.location.href='{{ route('my-jobs.index') }}'"
                class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium transition duration-200 flex items-center space-x-2 select-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Back to Jobs</span>
            </button>
        </div>
    </div>

    <!-- Job Post Form -->
    <form id="jobPostForm" method="POST"
        action="{{ $isEdit ? route('my-jobs.update', $job->id) : route('my-jobs.store') }}" class="space-y-3">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif
        <input type="hidden" id="job_status" name="status" value="{{ old('status', $job?->status ?? 'open') }}">
        <div id="jobPostFeedback" class="hidden rounded-lg border px-4 py-3 text-sm"></div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-3">Basic Information</h2>

            <!-- Job Title -->
            <div class="mb-3">
                <label for="job_title" class="block text-sm font-medium text-gray-700 mb-2">
                    Job Title <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" id="job_title" name="title"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="e.g., Senior React Developer with TypeScript Experience" maxlength="255"
                        value="{{ old('title', $job?->title ?? '') }}">
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
                <label for="job_description_editor" class="block text-sm font-medium text-gray-700 mb-2">
                    Job Description <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div id="job_description_wrapper"
                        class="border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 hover:border-gray-400 transition-all duration-200">
                        <div class="bg-gray-50 border-b border-gray-300 px-4 py-2 flex items-center space-x-2">
                            <button type="button" onclick="formatText('bold')" data-format="bold" aria-pressed="false"
                                class="p-1 hover:bg-gray-200 rounded">
                                <i class="ri-bold text-lg"></i>
                            </button>
                            <button type="button" onclick="formatText('italic')" data-format="italic" aria-pressed="false"
                                class="p-1 hover:bg-gray-200 rounded">
                                <i class="ri-italic text-lg"></i>
                            </button>
                            <button type="button" onclick="formatText('ul')" data-format="ul" aria-pressed="false"
                                class="p-1 hover:bg-gray-200 rounded">
                                <i class="ri-list-unordered text-lg"></i>
                            </button>
                        </div>
                        <div id="job_description_editor" contenteditable="true" role="textbox" aria-multiline="true"
                            class="w-full px-4 py-3 focus:outline-none resize-none min-h-[200px] whitespace-pre-wrap"
                            data-placeholder="Describe the job in detail. Include responsibilities, expectations, and project goals...">
                        </div>
                        <textarea id="job_description" name="description" rows="8"
                            class="hidden">{{ old('description', $job?->description ?? '') }}</textarea>
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
                <div id="typeOptions" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="relative">
                        <input type="radio" name="type" value="fixed"
                            {{ old('type', $job?->type ?? 'fixed') === 'fixed' ? 'checked' : '' }}
                            class="peer sr-only">
                        <div
                            class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-400 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-200">
                            <div class="flex items-center">
                                <div
                                    class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center peer-checked:border-blue-500">
                                    <div class="w-2.5 h-2.5 rounded-full bg-blue-500 hidden peer-checked:block">
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
                        <input type="radio" name="type" value="hourly"
                            {{ old('type', $job?->type ?? '') === 'hourly' ? 'checked' : '' }}
                            class="peer sr-only">
                        <div
                            class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-400 peer-checked:border-blue-500 peer-checked:bg-blue-50">
                            <div class="flex items-center">
                                <div
                                    class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center peer-checked:border-blue-500">
                                    <div class="w-2.5 h-2.5 rounded-full bg-blue-500 hidden peer-checked:block">
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
                    <div class="relative" id="skillsSearchWrapper">
                        <input type="text" id="skillInput"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                            placeholder="Search skills by name (e.g., React, Laravel, Figma)" autocomplete="off">
                        <div id="skillsSuggestions"
                            class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                            <!-- Suggestions will be populated here -->
                        </div>
                        @error('skills_required')
                            <p class="mt-2 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <p class="text-gray-500 text-xs mt-2">Search and select skills you required for this job, then remove
                        any skill you
                        don't
                        need.</p>
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
                        <option value="entry"
                            {{ old('experience_level', $job?->experience_level ?? 'intermediate') === 'entry' ? 'selected' : '' }}>
                            Entry Level
                            (0-2 years)</option>
                        <option value="intermediate"
                            {{ old('experience_level', $job?->experience_level ?? 'intermediate') === 'intermediate' ? 'selected' : '' }}>
                            Intermediate (2-5 years)</option>
                        <option value="expert"
                            {{ old('experience_level', $job?->experience_level ?? 'intermediate') === 'expert' ? 'selected' : '' }}>
                            Expert (5+ years)</option>
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
                    <option value="less_than_1_month"
                        {{ old('duration', $job?->duration ?? '') === 'less_than_1_month' ? 'selected' : '' }}>Less
                        than 1
                        month</option>
                    <option value="1_to_3_months"
                        {{ old('duration', $job?->duration ?? '') === '1_to_3_months' ? 'selected' : '' }}>1 to 3
                        months</option>
                    <option value="3_to_6_months"
                        {{ old('duration', $job?->duration ?? '') === '3_to_6_months' ? 'selected' : '' }}>3 to 6
                        months</option>
                    <option value="more_than_6_months"
                        {{ old('duration', $job?->duration ?? '') === 'more_than_6_months' ? 'selected' : '' }}>
                        More than 6
                        months</option>
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
                                <label for="budget_min" class="block text-sm font-medium text-gray-700 mb-2">
                                    Minimum Budget ($)
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">$</span>
                                    </div>
                                    <div class="relative">
                                        <input type="number" id="budget_min" name="budget_min" min="0"
                                            step="0.01"
                                            class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                            placeholder="e.g., 1000"
                                            value="{{ old('budget_min', $job?->budget_min ?? '') }}">
                                        @error('budget_min')
                                            <p class="absolute -bottom-2 left-4 mt-1 text-xs text-red-600 bg-white">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
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
                                    <div class="relative">
                                        <input type="number" id="budget_max" name="budget_max" min="0"
                                            step="0.01"
                                            class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                            placeholder="e.g., 5000"
                                            value="{{ old('budget_max', $job?->budget_max ?? '') }}">
                                        @error('budget_max')
                                            <p class="absolute -bottom-2 left-4 mt-1 text-xs text-red-600 bg-white">
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
                    min="{{ date('Y-m-d') }}"
                    value="{{ old('expires_at', $job?->expires_at?->format('Y-m-d')) }}">
                <p class="text-gray-500 text-xs mt-2">Set a deadline for freelancer applications</p>
            </div>

            <!-- Privacy Settings -->
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Privacy Settings
                </label>
                <div class="space-y-3 inline-block">
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" id="is_featured" name="is_featured" value="1"
                            {{ old('is_featured', $job?->is_featured ?? false) ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="text-sm text-gray-900">Feature this job (extra $50)</span>
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">Recommended</span>
                    </label>
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" id="is_private" name="is_private" value="1"
                            {{ old('is_private', $job?->is_private ?? false) ? 'checked' : '' }}
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
                        <option value="{{ $category->id }}"
                            {{ (string) old('category_id', $job?->category_id ?? '') === (string) $category->id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @empty
                        <option value="" disabled>No categories found</option>
                    @endforelse
                </select>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between select-none">
                <button id="saveDraftBtn" type="button" onclick="saveAsDraft()"
                    class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium transition duration-200">
                    Save as Draft
                </button>
                <div class="flex items-center space-x-4">
                    <button type="button" onclick="previewJob()"
                        class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium transition duration-200">
                        Preview
                    </button>
                    <button id="publishBtn" type="submit"
                        class="px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-black text-sm font-medium transition duration-200">
                        {{ $isEdit ? 'Update Job' : 'Publish Job' }}
                    </button>
                </div>
            </div>
            <p class="text-gray-500 text-sm text-center mt-4">
                By clicking "{{ $isEdit ? 'Update Job' : 'Publish Job' }}", you agree to our <a href="#"
                    class="text-blue-600 hover:text-blue-800">Terms of Service</a>
            </p>
        </div>
    </form>

    <!-- Preview Modal (Hidden by default) -->
    <div id="previewModal" class="fixed inset-0 z-50 hidden transition-opacity duration-300">
        <div id="previewBackdrop" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300 ease-out">
        </div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div id="previewModalContent"
                class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-lg transition-all duration-300 ease-out sm:my-8 sm:w-full sm:max-w-4xl w-full translate-y-4 opacity-0 scale-95">
                <div class="p-5">
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
                    <div class="mt-6 flex justify-end space-x-4 select-none">
                        <button onclick="closePreview()"
                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium">
                            Close
                        </button>
                        <button id="modalPublishBtn" type="button" onclick="submitForm()"
                            class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm font-medium">
                            {{ $isEdit ? 'Update Job' : 'Publish Job' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const isEditMode = @json($isEdit);

        // Skills Management
        let skills = @json(old('skills_required', $job?->skills_required ?? []));
        if (!Array.isArray(skills)) {
            try {
                skills = JSON.parse(skills || '[]');
            } catch (error) {
                skills = [];
            }
        }
        if (!Array.isArray(skills)) {
            skills = [];
        }
        let skillSearchTimeout = null;
        let skillSearchResults = [];
        let activeSkillSuggestionIndex = -1;

        function normalizeSkill(skillName) {
            return (skillName || '').toString().trim().toLowerCase();
        }

        function hasSelectedSkill(skillName) {
            const normalized = normalizeSkill(skillName);
            return skills.some(existing => normalizeSkill(existing) === normalized);
        }

        function addSkillByName(skillName) {
            const cleanSkillName = (skillName || '').toString().trim();

            if (!cleanSkillName || hasSelectedSkill(cleanSkillName)) {
                return false;
            }

            skills.push(cleanSkillName);
            updateSkillsDisplay();
            updateSkillsHiddenField();
            clearFieldValidationError('skills_required');
            return true;
        }

        function removeSkill(index) {
            skills.splice(index, 1);
            updateSkillsDisplay();
            updateSkillsHiddenField();
            if (skills.length > 0) {
                clearFieldValidationError('skills_required');
            }
        }

        function updateSkillsDisplay() {
            const container = document.getElementById('skillsContainer');
            container.innerHTML = '';

            if (skills.length === 0) {
                const emptyState = document.createElement('p');
                emptyState.className = 'text-gray-500 text-sm';
                emptyState.textContent = 'No skill selected yet.';
                container.appendChild(emptyState);
                return;
            }

            skills.forEach((skill, index) => {
                const skillElement = document.createElement('div');
                skillElement.className =
                    'flex items-center bg-blue-50 text-blue-700 text-sm px-3 py-1.5 rounded-lg select-none';
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

        function hideSkillSuggestions() {
            const suggestions = document.getElementById('skillsSuggestions');
            suggestions.classList.add('hidden');
            suggestions.innerHTML = '';
            activeSkillSuggestionIndex = -1;
        }

        function renderSkillSuggestions() {
            const suggestions = document.getElementById('skillsSuggestions');
            suggestions.innerHTML = '';

            if (skillSearchResults.length === 0) {
                const noResults = document.createElement('div');
                noResults.className = 'px-4 py-3 text-sm text-gray-500';
                noResults.textContent = 'No skills found.';
                suggestions.appendChild(noResults);
                suggestions.classList.remove('hidden');
                return;
            }

            skillSearchResults.forEach((skill, index) => {
                const item = document.createElement('button');
                item.type = 'button';
                item.className =
                    'w-full text-left px-4 py-3 text-sm text-gray-800 hover:bg-gray-50 border-b border-gray-100 last:border-b-0';
                item.setAttribute('data-index', String(index));
                item.textContent = skill.name;
                item.addEventListener('mouseenter', () => {
                    activeSkillSuggestionIndex = index;
                    updateActiveSuggestion();
                });
                item.addEventListener('click', () => {
                    selectSkillSuggestion(index);
                });
                suggestions.appendChild(item);
            });

            activeSkillSuggestionIndex = -1;
            suggestions.classList.remove('hidden');
        }

        function updateActiveSuggestion() {
            const suggestionItems = document.querySelectorAll('#skillsSuggestions button[data-index]');
            suggestionItems.forEach((item, index) => {
                if (index === activeSkillSuggestionIndex) {
                    item.classList.add('bg-blue-50', 'text-blue-700');
                } else {
                    item.classList.remove('bg-blue-50', 'text-blue-700');
                }
            });
        }

        function selectSkillSuggestion(index) {
            const selected = skillSearchResults[index];
            if (!selected || !selected.name) {
                return;
            }

            addSkillByName(selected.name);
            document.getElementById('skillInput').value = '';
            skillSearchResults = [];
            hideSkillSuggestions();
        }

        async function fetchSkillSuggestions(query) {
            const normalizedQuery = query.trim();

            if (normalizedQuery.length < 2) {
                skillSearchResults = [];
                hideSkillSuggestions();
                return;
            }

            try {
                const response = await fetch(`/skills/search?q=${encodeURIComponent(normalizedQuery)}`, {
                    headers: {
                        Accept: 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error('Unable to fetch skills.');
                }

                const payload = await response.json();
                const rawResults = Array.isArray(payload) ? payload : (payload.skills || payload.data || []);

                skillSearchResults = rawResults.filter(skill => {
                    return !!skill?.name && !hasSelectedSkill(skill.name);
                });

                renderSkillSuggestions();
            } catch (error) {
                skillSearchResults = [];
                hideSkillSuggestions();
                console.error('Skill search failed:', error);
            }
        }

        function debounceSkillSearch(query) {
            if (skillSearchTimeout) {
                clearTimeout(skillSearchTimeout);
            }

            skillSearchTimeout = setTimeout(() => {
                fetchSkillSuggestions(query);
            }, 250);
        }

        function escapeHtml(value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function applyInlineFormatting(value) {
            let formatted = value;
            formatted = formatted.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
            formatted = formatted.replace(/\*(.+?)\*/g, '<em>$1</em>');
            return formatted;
        }

        function markdownToHtml(text) {
            if (!text) {
                return '';
            }

            const lines = escapeHtml(String(text)).replace(/\r\n/g, '\n').split('\n');
            const output = [];
            let paragraphLines = [];
            let inList = false;

            const flushParagraph = () => {
                if (paragraphLines.length === 0) {
                    return;
                }

                output.push(`<p>${paragraphLines.join('<br>')}</p>`);
                paragraphLines = [];
            };

            lines.forEach((line) => {
                const listMatch = line.match(/^\s*-\s+(.*)$/);
                if (listMatch) {
                    flushParagraph();
                    if (!inList) {
                        output.push('<ul class="list-disc pl-6 space-y-1">');
                        inList = true;
                    }
                    output.push(`<li>${applyInlineFormatting(listMatch[1])}</li>`);
                    return;
                }

                if (inList) {
                    output.push('</ul>');
                    inList = false;
                }

                if (line.trim() === '') {
                    flushParagraph();
                    return;
                }

                paragraphLines.push(applyInlineFormatting(line));
            });

            flushParagraph();
            if (inList) {
                output.push('</ul>');
            }

            return output.join('');
        }

        function renderFormattedDescription(text) {
            const html = markdownToHtml(text);
            if (!html) {
                return '<p class="text-gray-500 italic">Job description will appear here...</p>';
            }

            return html;
        }

        function htmlToMarkdownFromNode(node) {
            if (!node) {
                return '';
            }

            if (node.nodeType === Node.TEXT_NODE) {
                return (node.nodeValue || '').replace(/\u00a0/g, ' ');
            }

            if (node.nodeType !== Node.ELEMENT_NODE) {
                return '';
            }

            const tag = node.tagName.toLowerCase();
            const childContent = Array.from(node.childNodes).map(htmlToMarkdownFromNode).join('');

            if (tag === 'br') {
                return '\n';
            }

            if (tag === 'strong' || tag === 'b') {
                return `**${childContent}**`;
            }

            if (tag === 'em' || tag === 'i') {
                return `*${childContent}*`;
            }

            if (tag === 'ul') {
                const items = Array.from(node.children)
                    .filter(child => child.tagName && child.tagName.toLowerCase() === 'li')
                    .map(li => `- ${htmlToMarkdownFromNode(li).trim()}`);
                return `${items.join('\n')}\n`;
            }

            if (tag === 'li') {
                return childContent;
            }

            if (tag === 'div' || tag === 'p') {
                return `${childContent}\n`;
            }

            return childContent;
        }

        function normalizeMarkdown(value) {
            return String(value || '')
                .replace(/\r\n/g, '\n')
                .replace(/\n{3,}/g, '\n\n')
                .trim();
        }

        function htmlToMarkdown(htmlElement) {
            if (!htmlElement) {
                return '';
            }

            const raw = Array.from(htmlElement.childNodes).map(htmlToMarkdownFromNode).join('');
            return normalizeMarkdown(raw);
        }

        updateSkillsDisplay();
        updateSkillsHiddenField();

        const descriptionTextarea = document.getElementById('job_description');
        const descriptionEditor = document.getElementById('job_description_editor');
        const descriptionWrapper = document.getElementById('job_description_wrapper');
        const charCount = document.getElementById('charCount');
        const formatButtons = Array.from(document.querySelectorAll('[data-format]'));

        function updateDescriptionCharCount(length) {
            charCount.textContent = `${length}/5000 characters`;

            if (length > 5000) {
                charCount.classList.add('text-red-600');
                charCount.classList.remove('text-gray-500');
            } else {
                charCount.classList.remove('text-red-600');
                charCount.classList.add('text-gray-500');
            }
        }

        function syncDescriptionFromEditor() {
            if (!descriptionEditor || !descriptionTextarea) {
                return;
            }

            const markdown = htmlToMarkdown(descriptionEditor);
            descriptionTextarea.value = markdown;
            updateDescriptionCharCount(markdown.length);
        }

        function setDescriptionEditorContent(markdown) {
            if (!descriptionEditor) {
                return;
            }

            const html = markdownToHtml(markdown);
            descriptionEditor.innerHTML = html || '';
        }

        setDescriptionEditorContent(descriptionTextarea?.value || '');
        syncDescriptionFromEditor();
        updateFormatToolbarState();

        descriptionEditor?.addEventListener('input', function() {
            syncDescriptionFromEditor();
            clearFieldValidationError('description');
            updateFormatToolbarState();
        });
        descriptionEditor?.addEventListener('blur', function() {
            if (!descriptionEditor.textContent?.trim()) {
                descriptionEditor.innerHTML = '';
                syncDescriptionFromEditor();
            }
            updateFormatToolbarState();
        });
        descriptionEditor?.addEventListener('keyup', updateFormatToolbarState);
        descriptionEditor?.addEventListener('mouseup', updateFormatToolbarState);
        descriptionEditor?.addEventListener('focus', updateFormatToolbarState);

        document.addEventListener('selectionchange', function() {
            if (!descriptionEditor || document.activeElement !== descriptionEditor) {
                return;
            }
            updateFormatToolbarState();
        });

        function isSelectionInsideEditor() {
            const selection = window.getSelection();
            if (!selection || selection.rangeCount === 0) {
                return false;
            }

            const range = selection.getRangeAt(0);
            return descriptionEditor && descriptionEditor.contains(range.commonAncestorContainer);
        }

        function setFormatButtonState(button, isActive) {
            if (!button) {
                return;
            }

            button.classList.toggle('format-button-active', isActive);
            button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        }

        function updateFormatToolbarState() {
            if (!descriptionEditor || formatButtons.length === 0) {
                return;
            }

            if (!isSelectionInsideEditor()) {
                formatButtons.forEach((button) => setFormatButtonState(button, false));
                return;
            }

            formatButtons.forEach((button) => {
                const format = button.dataset.format;
                let isActive = false;

                if (format === 'bold') {
                    isActive = document.queryCommandState('bold');
                } else if (format === 'italic') {
                    isActive = document.queryCommandState('italic');
                } else if (format === 'ul') {
                    isActive = document.queryCommandState('insertUnorderedList');
                }

                setFormatButtonState(button, isActive);
            });
        }

        // Text formatting
        function formatText(type) {
            if (!descriptionEditor) {
                return;
            }

            descriptionEditor.focus();

            switch (type) {
                case 'bold':
                    document.execCommand('bold');
                    break;
                case 'italic':
                    document.execCommand('italic');
                    break;
                case 'ul':
                    document.execCommand('insertUnorderedList');
                    break;
                default:
                    return;
            }

            syncDescriptionFromEditor();
            updateFormatToolbarState();
        }

        // Toggle budget fields based on job type
        const jobTypeRadios = document.querySelectorAll('input[name="type"]');
        const budgetFields = document.getElementById('budgetFields');

        function updateBudgetFields() {
            const selectedType = document.querySelector('input[name="type"]:checked').value;
            const currentMin = document.getElementById('budget_min')?.value ?? '';
            const currentMax = document.getElementById('budget_max')?.value ?? '';

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
                                        placeholder="e.g., 1000" value="${currentMin}">
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
                                        placeholder="e.g., 5000" value="${currentMax}">
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
                                        placeholder="e.g., 20" value="${currentMin}">
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
                                        placeholder="e.g., 50" value="${currentMax}">
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-500 text-xs mt-2">Set a realistic hourly rate range</p>
                    </div>
                `;
            }
        }

        jobTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                updateBudgetFields();
                clearFieldValidationError('type');
            });
        });

        // Initialize budget fields
        updateBudgetFields();

        // Preview functionality
        function previewJob() {
            const form = document.getElementById('jobPostForm');
            syncDescriptionFromEditor();
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

                    <div class="prose max-w-none text-gray-600 mb-4">
                        ${renderFormattedDescription(formData.get('description'))}
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
            openPreviewModal();
        }

        function openPreviewModal() {
            if (!previewModal || !previewBackdrop || !previewModalContent) {
                return;
            }

            previewModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            void previewModal.offsetWidth;

            setTimeout(() => {
                previewBackdrop.classList.remove('opacity-0');
                previewBackdrop.classList.add('opacity-100');
            }, 10);

            setTimeout(() => {
                previewModalContent.classList.remove('translate-y-4', 'opacity-0', 'scale-95');
                previewModalContent.classList.add('translate-y-0', 'opacity-100', 'scale-100');
            }, 10);
        }

        function closePreview() {
            if (!previewModal || !previewBackdrop || !previewModalContent) {
                return;
            }

            previewModalContent.classList.remove('translate-y-0', 'opacity-100', 'scale-100');
            previewModalContent.classList.add('translate-y-4', 'opacity-0', 'scale-95');

            previewBackdrop.classList.remove('opacity-100');
            previewBackdrop.classList.add('opacity-0');

            setTimeout(() => {
                previewModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        let isSubmittingJob = false;

        function setJobSubmittingState(isSubmitting) {
            isSubmittingJob = isSubmitting;

            const actionButtons = [
                document.getElementById('saveDraftBtn'),
                document.getElementById('publishBtn'),
                document.getElementById('modalPublishBtn'),
            ];

            actionButtons.forEach(button => {
                if (!button) {
                    return;
                }

                button.disabled = isSubmitting;
                button.classList.toggle('opacity-60', isSubmitting);
                button.classList.toggle('cursor-not-allowed', isSubmitting);
            });
        }

        function showJobPostFeedback(type, message, shouldScroll = true) {
            const feedback = document.getElementById('jobPostFeedback');
            if (!feedback) {
                return;
            }

            feedback.classList.remove(
                'hidden',
                'border-red-200',
                'bg-red-50',
                'text-red-700',
                'border-green-200',
                'bg-green-50',
                'text-green-700'
            );

            if (type === 'success') {
                feedback.classList.add('border-green-200', 'bg-green-50', 'text-green-700');
            } else {
                feedback.classList.add('border-red-200', 'bg-red-50', 'text-red-700');
            }

            feedback.textContent = message;
            if (shouldScroll) {
                feedback.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start',
                });
            }
        }

        function clearJobPostFeedback() {
            const feedback = document.getElementById('jobPostFeedback');
            if (!feedback) {
                return;
            }

            feedback.textContent = '';
            feedback.classList.add('hidden');
        }

        const validationFieldMap = {
            title: '#job_title',
            description: '#job_description_editor',
            type: '#typeOptions',
            skills_required: '#skillsSearchWrapper',
            experience_level: '#experience_level',
            duration: '#duration',
            budget_min: '#budget_min',
            budget_max: '#budget_max',
            expires_at: '#expires_at',
            category_id: '#category_id',
        };

        function normalizeValidationFieldName(fieldName) {
            if (!fieldName) {
                return '';
            }

            const normalized = fieldName.replace(/\.\d+/g, '');
            if (normalized.startsWith('skills_required')) {
                return 'skills_required';
            }

            return normalized;
        }

        function getValidationTarget(fieldName) {
            const normalized = normalizeValidationFieldName(fieldName);
            const selector = validationFieldMap[normalized];
            return selector ? document.querySelector(selector) : null;
        }

        function getValidationAnchor(fieldName, target) {
            if (!target) {
                return null;
            }

            const normalized = normalizeValidationFieldName(fieldName);
            if (normalized === 'type' || normalized === 'skills_required') {
                return target;
            }

            if (['title', 'description', 'experience_level', 'budget_min', 'budget_max'].includes(normalized)) {
                return target.closest('.relative') || target;
            }

            return target;
        }

        function clearFieldValidationError(fieldName) {
            const normalized = normalizeValidationFieldName(fieldName);
            if (!normalized) {
                return;
            }

            document.querySelectorAll(`.js-validation-error[data-field="${normalized}"]`).forEach(error => error.remove());

            if (normalized === 'type') {
                document.querySelectorAll('#typeOptions label > div').forEach(card => {
                    card.classList.remove('border-red-500');
                });
                return;
            }

            if (normalized === 'description') {
                descriptionWrapper?.classList.remove('description-error');
                return;
            }

            const target = getValidationTarget(normalized);
            const inputTarget = normalized === 'skills_required' ? document.getElementById('skillInput') : target;
            if (!inputTarget) {
                return;
            }

            inputTarget.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        }

        function clearFieldValidationErrors() {
            document.querySelectorAll('.js-validation-error').forEach(error => error.remove());
            Object.keys(validationFieldMap).forEach(fieldName => clearFieldValidationError(fieldName));
        }

        function showFieldValidationError(fieldName, message) {
            const normalized = normalizeValidationFieldName(fieldName);
            if (!normalized || !message) {
                return;
            }

            clearFieldValidationError(normalized);

            const target = getValidationTarget(normalized);
            const anchor = getValidationAnchor(normalized, target);
            if (!target || !anchor) {
                return;
            }

            const error = document.createElement('p');
            error.className = 'js-validation-error mt-2 text-xs text-red-600';
            error.dataset.field = normalized;
            error.textContent = message;
            anchor.insertAdjacentElement('afterend', error);

            if (normalized === 'type') {
                document.querySelectorAll('#typeOptions label > div').forEach(card => {
                    card.classList.add('border-red-500');
                });
                return;
            }

            if (normalized === 'description') {
                descriptionWrapper?.classList.add('description-error');
                return;
            }

            const inputTarget = normalized === 'skills_required' ? document.getElementById('skillInput') : target;
            inputTarget?.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        }

        function renderFieldValidationErrors(errors) {
            if (!errors || typeof errors !== 'object') {
                return;
            }

            clearFieldValidationErrors();

            let firstTarget = null;
            Object.entries(errors).forEach(([fieldName, messages]) => {
                const message = Array.isArray(messages) ? messages[0] : messages;
                const normalized = normalizeValidationFieldName(fieldName);

                showFieldValidationError(normalized, message);

                if (!firstTarget) {
                    if (normalized === 'skills_required') {
                        firstTarget = document.getElementById('skillInput');
                    } else if (normalized === 'type') {
                        firstTarget = document.querySelector('input[name="type"]');
                    } else {
                        firstTarget = getValidationTarget(normalized);
                    }
                }
            });

            if (firstTarget) {
                firstTarget.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                });

                if (['INPUT', 'SELECT', 'TEXTAREA'].includes(firstTarget.tagName)) {
                    firstTarget.focus();
                } else if (firstTarget.getAttribute && firstTarget.getAttribute('contenteditable') === 'true') {
                    firstTarget.focus();
                }
            }
        }

        function resetJobPostForm() {
            const form = document.getElementById('jobPostForm');
            form.reset();
            clearFieldValidationErrors();

            skills = [];
            updateSkillsDisplay();
            updateSkillsHiddenField();
            hideSkillSuggestions();

            document.getElementById('job_status').value = 'open';
            updateBudgetFields();
            setDescriptionEditorContent('');
            syncDescriptionFromEditor();
        }

        // Save as draft
        function saveAsDraft() {
            submitForm('draft');
        }

        // Submit form
        async function submitForm(status = 'open') {
            if (isSubmittingJob) {
                return;
            }

            clearJobPostFeedback();
            clearFieldValidationErrors();
            document.getElementById('job_status').value = status;
            updateSkillsHiddenField();
            syncDescriptionFromEditor();

            const form = document.getElementById('jobPostForm');
            const formData = new FormData(form);
            const csrfToken = form.querySelector('input[name="_token"]')?.value;

            setJobSubmittingState(true);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        ...(csrfToken ? {
                            'X-CSRF-TOKEN': csrfToken
                        } : {}),
                    },
                    body: formData,
                });

                const payload = await response.json().catch(() => ({}));

                if (!response.ok) {
                    if (response.status === 422 && payload?.errors) {
                        renderFieldValidationErrors(payload.errors);
                        showJobPostFeedback('error', payload?.message ||
                            'Please fix the highlighted fields and try again.',
                            false);
                        return;
                    }

                    showJobPostFeedback('error', payload?.message || 'Unable to save job right now.');
                    return;
                }

                showJobPostFeedback('success', payload?.message || 'Job saved successfully.');
                closePreview();
                if (!isEditMode) {
                    resetJobPostForm();
                }
            } catch (error) {
                console.error('Job submit failed:', error);
                showJobPostFeedback('error', 'Network error. Please try again.');
            } finally {
                setJobSubmittingState(false);
            }
        }

        const jobPostForm = document.getElementById('jobPostForm');

        // Handle form submission
        jobPostForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitForm('open');
        });

        jobPostForm.addEventListener('input', function(e) {
            const target = e.target;

            if (target.id === 'job_title') {
                clearFieldValidationError('title');
            } else if (target.id === 'job_description' || target.id === 'job_description_editor') {
                clearFieldValidationError('description');
            } else if (target.id === 'budget_min') {
                clearFieldValidationError('budget_min');
            } else if (target.id === 'budget_max') {
                clearFieldValidationError('budget_max');
            }
        });

        jobPostForm.addEventListener('change', function(e) {
            const target = e.target;

            if (target.name === 'type') {
                clearFieldValidationError('type');
            } else if (target.id === 'experience_level') {
                clearFieldValidationError('experience_level');
            } else if (target.id === 'duration') {
                clearFieldValidationError('duration');
            } else if (target.id === 'expires_at') {
                clearFieldValidationError('expires_at');
            } else if (target.id === 'category_id') {
                clearFieldValidationError('category_id');
            }
        });

        const skillInput = document.getElementById('skillInput');
        const skillsSearchWrapper = document.getElementById('skillsSearchWrapper');

        skillInput.addEventListener('input', function() {
            clearFieldValidationError('skills_required');
            debounceSkillSearch(this.value);
        });

        skillInput.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (skillSearchResults.length === 0) {
                    return;
                }

                activeSkillSuggestionIndex = Math.min(activeSkillSuggestionIndex + 1, skillSearchResults.length -
                    1);
                updateActiveSuggestion();
                return;
            }

            if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (skillSearchResults.length === 0) {
                    return;
                }

                activeSkillSuggestionIndex = Math.max(activeSkillSuggestionIndex - 1, 0);
                updateActiveSuggestion();
                return;
            }

            if (e.key === 'Enter') {
                e.preventDefault();

                if (activeSkillSuggestionIndex >= 0) {
                    selectSkillSuggestion(activeSkillSuggestionIndex);
                    return;
                }

                if (skillSearchResults.length > 0) {
                    selectSkillSuggestion(0);
                }
                return;
            }

            if (e.key === 'Escape') {
                hideSkillSuggestions();
            }
        });

        document.addEventListener('click', function(e) {
            if (skillsSearchWrapper && !skillsSearchWrapper.contains(e.target)) {
                hideSkillSuggestions();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const suggestions = document.getElementById('skillsSuggestions');
                if (suggestions && !suggestions.classList.contains('hidden')) {
                    hideSkillSuggestions();
                    return;
                }

                const previewModalElement = document.getElementById('previewModal');
                if (previewModalElement && !previewModalElement.classList.contains('hidden')) {
                    closePreview();
                }
            }
        });

        // Close preview modal when clicking the dark overlay
        const previewModal = document.getElementById('previewModal');
        const previewBackdrop = document.getElementById('previewBackdrop');
        const previewModalContent = document.getElementById('previewModalContent');

        previewBackdrop?.addEventListener('click', closePreview);

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
@endpush
