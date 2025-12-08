<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Find Freelancers | CollabHub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-['Figtree'] text-gray-800 bg-gray-50">
    <!-- Main Container -->
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
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
                            <h1 class="text-2xl font-bold text-gray-900">Find Freelancers</h1>
                            <p class="text-gray-600 mt-1">Browse talented freelancers ready to work on your projects
                            </p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-gray-500 text-sm">Sort by:</span>
                            <select
                                class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option>Recommended</option>
                                <option>Highest Rated</option>
                                <option>Most Projects</option>
                                <option>Newest</option>
                                <option>Lowest Hourly Rate</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Content Grid - Changed to horizontal layout -->
                <div x-data="filterState()" class="space-y-3">
                    <!-- Filters Toggle Button (Visible on all screens) -->
                    <div
                        class="flex items-center justify-between bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <h2 class="text-lg font-bold text-gray-900">Filter Results</h2>
                        <button @click="showFilters = !showFilters"
                            class="flex items-center space-x-2 text-blue-600 hover:text-blue-800 font-medium text-sm">
                            <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'"></span>
                            <svg class="w-4 h-4 transition-transform duration-300"
                                :class="{ 'rotate-180': showFilters }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Horizontal Filters and Content -->
                    <div class="flex flex-col xl:flex-row gap-3">
                        <!-- Filters Panel (Left) -->
                        <div x-show="showFilters" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-x-4"
                            x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in"
                            x-transition:leave-start="opacity-100 translate-x-0"
                            x-transition:leave-end="opacity-0 -translate-x-4" class="xl:w-auto min-w-0">
                            <!-- Filters Card - Made sticky -->
                            <div
                                class="sticky top-0 bg-white rounded-xl shadow-sm border border-gray-200 p-4 w-full min-w-[250px] xl:max-w-[200px] overflow-y-auto">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-lg font-bold text-gray-900">Filters</h2>
                                    <button @click="clearAllFilters()"
                                        class="text-sm text-blue-600 hover:text-blue-800 font-medium whitespace-nowrap">
                                        Clear All
                                    </button>
                                </div>

                                <!-- Compact Filter Sections -->
                                <div class="space-y-4">
                                    <!-- Categories Filter -->
                                    <div class="filter-group">
                                        <div @click="toggleFilter('categories')"
                                            class="filter-toggle flex items-center justify-between text-gray-700 font-medium text-sm py-2 cursor-pointer">
                                            <span>Categories</span>
                                            <svg class="w-4 h-4 transition-transform duration-300 flex-shrink-0 ml-2"
                                                :class="{ 'rotate-180': openFilters.includes('categories') }"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                        <div x-show="openFilters.includes('categories')" x-transition
                                            class="mt-2 space-y-2">
                                            <label class="flex items-center text-xs">
                                                <input type="checkbox" x-model="filters.categories.webDev"
                                                    class="h-3 w-3 text-blue-600 border-gray-300 rounded mr-2 flex-shrink-0">
                                                <span class="text-gray-600 truncate">Web Dev (245)</span>
                                            </label>
                                            <label class="flex items-center text-xs">
                                                <input type="checkbox" x-model="filters.categories.mobileDev"
                                                    class="h-3 w-3 text-blue-600 border-gray-300 rounded mr-2 flex-shrink-0">
                                                <span class="text-gray-600 truncate">Mobile Dev (189)</span>
                                            </label>
                                            <label class="flex items-center text-xs">
                                                <input type="checkbox" x-model="filters.categories.uiux"
                                                    class="h-3 w-3 text-blue-600 border-gray-300 rounded mr-2 flex-shrink-0">
                                                <span class="text-gray-600 truncate">UI/UX (156)</span>
                                            </label>
                                            <label class="flex items-center text-xs">
                                                <input type="checkbox" x-model="filters.categories.graphicDesign"
                                                    class="h-3 w-3 text-blue-600 border-gray-300 rounded mr-2 flex-shrink-0">
                                                <span class="text-gray-600 truncate">Graphic Design (98)</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Hourly Rate Filter -->
                                    <div class="filter-group">
                                        <div @click="toggleFilter('hourlyRate')"
                                            class="filter-toggle flex items-center justify-between text-gray-700 font-medium text-sm py-2 cursor-pointer">
                                            <span>Hourly Rate</span>
                                            <svg class="w-4 h-4 transition-transform duration-300 flex-shrink-0 ml-2"
                                                :class="{ 'rotate-180': openFilters.includes('hourlyRate') }"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                        <div x-show="openFilters.includes('hourlyRate')" x-transition
                                            class="mt-2 space-y-2">
                                            <label class="flex items-center text-xs">
                                                <input type="radio" x-model="filters.hourlyRate" value="any"
                                                    class="h-3 w-3 text-blue-600 border-gray-300 mr-2 flex-shrink-0">
                                                <span class="text-gray-600 truncate">Any rate</span>
                                            </label>
                                            <label class="flex items-center text-xs">
                                                <input type="radio" x-model="filters.hourlyRate" value="under25"
                                                    class="h-3 w-3 text-blue-600 border-gray-300 mr-2 flex-shrink-0">
                                                <span class="text-gray-600 truncate">Under $25/hr</span>
                                            </label>
                                            <label class="flex items-center text-xs">
                                                <input type="radio" x-model="filters.hourlyRate" value="25to50"
                                                    class="h-3 w-3 text-blue-600 border-gray-300 mr-2 flex-shrink-0">
                                                <span class="text-gray-600 truncate">$25 - $50/hr</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Experience Filter -->
                                    <div class="filter-group">
                                        <div @click="toggleFilter('experience')"
                                            class="filter-toggle flex items-center justify-between text-gray-700 font-medium text-sm py-2 cursor-pointer">
                                            <span>Experience</span>
                                            <svg class="w-4 h-4 transition-transform duration-300 flex-shrink-0 ml-2"
                                                :class="{ 'rotate-180': openFilters.includes('experience') }"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                        <div x-show="openFilters.includes('experience')" x-transition
                                            class="mt-2 space-y-2">
                                            <label class="flex items-center text-xs">
                                                <input type="checkbox" x-model="filters.experience.entry"
                                                    class="h-3 w-3 text-blue-600 border-gray-300 rounded mr-2 flex-shrink-0">
                                                <span class="text-gray-600 truncate">Entry Level</span>
                                            </label>
                                            <label class="flex items-center text-xs">
                                                <input type="checkbox" x-model="filters.experience.intermediate"
                                                    class="h-3 w-3 text-blue-600 border-gray-300 rounded mr-2 flex-shrink-0">
                                                <span class="text-gray-600 truncate">Intermediate</span>
                                            </label>
                                            <label class="flex items-center text-xs">
                                                <input type="checkbox" x-model="filters.experience.expert"
                                                    class="h-3 w-3 text-blue-600 border-gray-300 rounded mr-2 flex-shrink-0">
                                                <span class="text-gray-600 truncate">Expert</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Location Filter -->
                                    <div class="filter-group">
                                        <div @click="toggleFilter('location')"
                                            class="filter-toggle flex items-center justify-between text-gray-700 font-medium text-sm py-2 cursor-pointer">
                                            <span>Location</span>
                                            <svg class="w-4 h-4 transition-transform duration-300 flex-shrink-0 ml-2"
                                                :class="{ 'rotate-180': openFilters.includes('location') }"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                        <div x-show="openFilters.includes('location')" x-transition
                                            class="mt-2 space-y-2">
                                            <label class="flex items-center text-xs">
                                                <input type="checkbox" x-model="filters.location.anywhere"
                                                    class="h-3 w-3 text-blue-600 border-gray-300 rounded mr-2 flex-shrink-0">
                                                <span class="text-gray-600 truncate">Anywhere</span>
                                            </label>
                                            <label class="flex items-center text-xs">
                                                <input type="checkbox" x-model="filters.location.usa"
                                                    class="h-3 w-3 text-blue-600 border-gray-300 rounded mr-2 flex-shrink-0">
                                                <span class="text-gray-600 truncate">United States</span>
                                            </label>
                                            <label class="flex items-center text-xs">
                                                <input type="checkbox" x-model="filters.location.europe"
                                                    class="h-3 w-3 text-blue-600 border-gray-300 rounded mr-2 flex-shrink-0">
                                                <span class="text-gray-600 truncate">Europe</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Skills Filter -->
                                    <div class="filter-group">
                                        <div @click="toggleFilter('skills')"
                                            class="filter-toggle flex items-center justify-between text-gray-700 font-medium text-sm py-2 cursor-pointer">
                                            <span>Popular Skills</span>
                                            <svg class="w-4 h-4 transition-transform duration-300 flex-shrink-0 ml-2"
                                                :class="{ 'rotate-180': openFilters.includes('skills') }"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                        <div x-show="openFilters.includes('skills')" x-transition class="mt-2">
                                            <div class="flex flex-wrap gap-1">
                                                <template x-for="skill in skills" :key="skill.id">
                                                    <span @click="toggleSkill(skill.id)"
                                                        class="skill-tag text-xs px-2.5 py-1 rounded-full cursor-pointer transition-all duration-200 hover:scale-105 flex-shrink-0 min-w-0 break-words max-w-full select-none"
                                                        :class="{
                                                            'bg-blue-600 text-white': selectedSkills.includes(skill.id),
                                                            'bg-blue-100 text-blue-800': skill.id === 'react' && !
                                                                selectedSkills.includes(skill.id),
                                                            'bg-green-100 text-green-800': skill.id === 'node' && !
                                                                selectedSkills.includes(skill.id),
                                                            'bg-purple-100 text-purple-800': skill.id === 'uiux' &&
                                                                !selectedSkills.includes(skill.id),
                                                            'bg-amber-100 text-amber-800': skill.id === 'python' && !
                                                                selectedSkills.includes(skill.id),
                                                            'bg-red-100 text-red-800': skill.id === 'mobile' && !
                                                                selectedSkills.includes(skill.id)
                                                        }"
                                                        x-text="skill.name">
                                                    </span>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Main Content (Right) -->
                        <div class="flex-1 min-w-0">
                            <!-- Stats Bar -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-3">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-600">
                                        Showing <span class="font-semibold text-gray-900">1-12</span> of <span
                                            class="font-semibold text-gray-900">{{ count($freelancers) }}</span>
                                        freelancers
                                        <span x-show="hasActiveFilters"
                                            class="ml-2 text-blue-600 text-xs font-medium">
                                            (Filtered)
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-gray-600 text-sm">View:</span>

                                        <!-- Grid View Button -->
                                        <button @click="$store.viewSettings.setViewType('grid')"
                                            :class="{
                                                'bg-blue-50 text-blue-700 border border-blue-200': $store.viewSettings
                                                    .viewType === 'grid',
                                                'text-gray-400 hover:text-gray-600 hover:bg-gray-50': $store
                                                    .viewSettings.viewType !== 'grid'
                                            }"
                                            class="p-1.5 rounded-lg transition-all duration-200 border border-transparent"
                                            title="Grid View">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                                </path>
                                            </svg>
                                        </button>

                                        <!-- List View Button -->
                                        <button @click="$store.viewSettings.setViewType('list')"
                                            :class="{
                                                'bg-blue-50 text-blue-700 border border-blue-200': $store.viewSettings
                                                    .viewType === 'list',
                                                'text-gray-400 hover:text-gray-600 hover:bg-gray-50': $store
                                                    .viewSettings.viewType !== 'list'
                                            }"
                                            class="p-1.5 rounded-lg transition-all duration-200 border border-transparent"
                                            title="List View">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Freelancers Grid/List -->
                            <div
                                :class="{
                                    'grid grid-cols-1 md:grid-cols-2 gap-3': viewType === 'grid',
                                    'space-y-3': viewType === 'list'
                                }">
                                <!-- Using Freelancer Card Component -->
                                @foreach ($freelancers as $freelancer)
                                    <x-freelancer-card :freelancer="$freelancer" :view-type="$viewType" />
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-3">
                                <div class="flex items-center justify-between">
                                    <button
                                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300 text-sm font-medium">
                                        Previous
                                    </button>

                                    <div class="flex items-center space-x-2">
                                        <a href="#"
                                            class="w-10 h-10 flex items-center justify-center rounded-lg font-medium text-sm bg-blue-600 text-white">1</a>
                                        <a href="#"
                                            class="w-10 h-10 flex items-center justify-center rounded-lg font-medium text-sm hover:bg-gray-100 transition duration-200">2</a>
                                        <a href="#"
                                            class="w-10 h-10 flex items-center justify-center rounded-lg font-medium text-sm hover:bg-gray-100 transition duration-200">3</a>
                                        <span class="text-gray-500">...</span>
                                        <a href="#"
                                            class="w-10 h-10 flex items-center justify-center rounded-lg font-medium text-sm hover:bg-gray-100 transition duration-200">8</a>
                                    </div>

                                    <button
                                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300 text-sm font-medium">
                                        Next
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('viewSettings', {
                viewType: localStorage.getItem('freelancerViewType') || 'grid',

                setViewType(type) {
                    if (!['grid', 'list'].includes(type)) return;

                    this.viewType = type;
                    localStorage.setItem('freelancerViewType', type);
                },

                toggle() {
                    this.setViewType(this.viewType === 'grid' ? 'list' : 'grid');
                }
            });
        });

        // Filter state
        function filterState() {
            return {
                showFilters: true,
                openFilters: ['categories', 'hourlyRate', 'experience', 'location', 'skills'],
                selectedSkills: [],
                skills: [{
                        id: 'react',
                        name: 'React.js'
                    },
                    {
                        id: 'node',
                        name: 'Node.js'
                    },
                    {
                        id: 'uiux',
                        name: 'UI/UX'
                    },
                    {
                        id: 'python',
                        name: 'Python'
                    },
                    {
                        id: 'mobile',
                        name: 'Mobile'
                    }
                ],

                // Reactive filters object
                filters: {
                    categories: {
                        webDev: false,
                        mobileDev: false,
                        uiux: false,
                        graphicDesign: false
                    },
                    hourlyRate: 'any',
                    experience: {
                        entry: false,
                        intermediate: false,
                        expert: false
                    },
                    location: {
                        anywhere: true,
                        usa: false,
                        europe: false
                    } // default: anywhere
                },

                // Access viewType from the store
                get viewType() {
                    return this.$store.viewSettings.viewType;
                },

                toggleFilter(filterName) {
                    const index = this.openFilters.indexOf(filterName);
                    if (index > -1) {
                        this.openFilters.splice(index, 1);
                    } else {
                        this.openFilters.push(filterName);
                    }
                },

                toggleSkill(skillId) {
                    const index = this.selectedSkills.indexOf(skillId);
                    if (index > -1) {
                        this.selectedSkills.splice(index, 1);
                    } else {
                        this.selectedSkills.push(skillId);
                    }
                },

                clearAllFilters() {
                    this.filters.categories = {
                        webDev: false,
                        mobileDev: false,
                        uiux: false,
                        graphicDesign: false
                    };
                    this.filters.hourlyRate = 'any';
                    this.filters.experience = {
                        entry: false,
                        intermediate: false,
                        expert: false
                    };
                    this.filters.location = {
                        anywhere: true,
                        usa: false,
                        europe: false
                    };
                    this.selectedSkills = [];
                },

                get hasActiveFilters() {
                    const c = this.filters.categories;
                    const e = this.filters.experience;
                    const l = this.filters.location;
                    const activeCategories = Object.values(c).some(Boolean);
                    const activeExperience = Object.values(e).some(Boolean);
                    const activeLocation = Object.keys(l).some(k => k !== 'anywhere' && l[k]);
                    const activeSkills = this.selectedSkills.length > 0;
                    const activeRate = this.filters.hourlyRate !== 'any';

                    return activeCategories || activeExperience || activeLocation || activeSkills || activeRate;
                }
            }
        }
    </script>
</body>

</html>
