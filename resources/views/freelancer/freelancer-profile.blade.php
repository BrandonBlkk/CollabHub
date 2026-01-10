@extends('layouts.app')

@section('content')
    <!-- Add Experience Modal -->
    <div id="addExperienceModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50"
        style="display: none;">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Add New Experience</h3>
            </div>

            <form id="experienceForm" method="POST" action="{{ route('freelancer-profile.experience.store') }}"
                class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="freelancer_id" value="{{ $freelancer->freelancer->id }}">

                {{-- Job Role --}}
                <div>
                    <label for="job_role_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Job Role *
                    </label>
                    <select name="job_role_id" id="job_role_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                        <option value="">Select Job Role</option>
                        @foreach ($jobRoles as $jobRole)
                            <option value="{{ $jobRole->id }}">{{ $jobRole->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700 mb-1">
                        Company Name *
                    </label>
                    <input type="text" id="company" name="company" placeholder="e.g., TechCorp Inc." required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        Description
                    </label>
                    <textarea id="description" name="description" rows="3"
                        placeholder="Describe your responsibilities and achievements..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200"></textarea>
                </div>

                <div>
                    <label for="employment_type" class="block text-sm font-medium text-gray-700 mb-1">
                        Employment Type
                    </label>
                    <input type="text" id="employment_type" name="employment_type" placeholder="e.g., Full-time" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Start Date
                        </label>
                        <input type="month" id="start_date" name="start_date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                            End Date
                        </label>
                        <input type="month" id="end_date" name="end_date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                        <div class="flex items-center mt-2">
                            <input type="checkbox" id="is_current" name="is_current" class="mr-2" value="1">
                            <label for="is_current" class="text-sm text-gray-600">Currently working here</label>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">
                        Location
                    </label>
                    <input type="text" id="location" name="location" placeholder="e.g., San Francisco, CA"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="hideAddExperienceModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-gray-800 hover:bg-black rounded-lg transition flex items-center gap-2">
                        Save Experience
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Experience Modal -->
    <div id="editExperienceModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50"
        style="display: none;">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Edit Experience</h3>
            </div>

            <form id="editExperienceForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_experience_id" name="id">

                <!-- Job Role -->
                <div>
                    <label for="edit_job_role_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Job Role *
                    </label>
                    <select name="job_role_id" id="edit_job_role_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                        <option value="">Select Job Role</option>
                        @foreach ($jobRoles as $jobRole)
                            <option value="{{ $jobRole->id }}">{{ $jobRole->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="edit_company" class="block text-sm font-medium text-gray-700 mb-1">
                        Company Name *
                    </label>
                    <input type="text" id="edit_company" name="company" placeholder="e.g., TechCorp Inc." required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                </div>

                <div>
                    <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-1">
                        Description
                    </label>
                    <textarea id="edit_description" name="description" rows="3"
                        placeholder="Describe your responsibilities and achievements..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200"></textarea>
                </div>

                <div>
                    <label for="edit_employment_type" class="block text-sm font-medium text-gray-700 mb-1">
                        Employment Type
                    </label>
                    <input type="text" id="edit_employment_type" name="employment_type" placeholder="e.g., Full-time"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="edit_start_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Start Date
                        </label>
                        <input type="month" id="edit_start_date" name="start_date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                    </div>

                    <div>
                        <label for="edit_end_date" class="block text-sm font-medium text-gray-700 mb-1">
                            End Date
                        </label>
                        <input type="month" id="edit_end_date" name="end_date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                        <div class="flex items-center mt-2">
                            <input type="checkbox" id="edit_is_current" name="is_current" class="mr-2">
                            <label for="edit_is_current" class="text-sm text-gray-600">Currently working
                                here</label>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="edit_location" class="block text-sm font-medium text-gray-700 mb-1">
                        Location
                    </label>
                    <input type="text" id="edit_location" name="location" placeholder="e.g., San Francisco, CA"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="hideEditExperienceModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-gray-800 hover:bg-black rounded-lg transition flex items-center gap-2">
                        Update Experience
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Education Modal -->
    <div id="addEducationModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50"
        style="display: none;">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Add New Education</h3>
            </div>

            <form id="educationForm" method="POST" action="{{ route('freelancer-profile.education.store') }}"
                class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="freelancer_id" value="{{ $freelancer->freelancer->id }}">

                <!-- University -->
                <div>
                    <label for="university_id" class="block text-sm font-medium text-gray-700 mb-1">
                        University *
                    </label>
                    <select name="university_id" id="university_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                        <option value="">Select University</option>
                        @forelse ($universities as $university)
                            <option value="{{ $university->id }}">{{ $university->name }}</option>
                        @empty
                            <option value="">No universities found</option>
                        @endforelse
                    </select>
                </div>

                <!-- Major -->
                <div>
                    <label for="major_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Major/Field of Study *
                    </label>
                    <select name="major_id" id="major_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                        <option value="">Select Major</option>
                        @forelse ($majors as $major)
                            <option value="{{ $major->id }}">{{ $major->name }}</option>
                        @empty
                            <option value="">No majors found</option>
                        @endforelse
                    </select>
                </div>

                <!-- Degree -->
                <div>
                    <label for="degree" class="block text-sm font-medium text-gray-700 mb-1">
                        Degree *
                    </label>
                    <input type="text" id="degree" name="degree" placeholder="e.g., Bachelor of Science" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                </div>

                <!-- Field of Study -->
                <div>
                    <label for="field_of_study" class="block text-sm font-medium text-gray-700 mb-1">
                        Field of Study
                    </label>
                    <input type="text" id="field_of_study" name="field_of_study" placeholder="e.g., Computer Science"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_year" class="block text-sm font-medium text-gray-700 mb-1">
                            Start Year *
                        </label>
                        <select id="start_year" name="start_year" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                            <option value="">Select Year</option>
                            @for ($year = date('Y'); $year >= 1980; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label for="end_year" class="block text-sm font-medium text-gray-700 mb-1">
                            End Year
                        </label>
                        <select id="end_year" name="end_year"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                            <option value="">Select Year</option>
                            <option value="present">Present</option>
                            @for ($year = date('Y'); $year >= 1980; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                        <div class="flex items-center mt-2">
                            <input type="checkbox" id="is_current" name="is_current" class="mr-2" value="1">
                            <label for="is_current" class="text-sm text-gray-600">Currently studying</label>
                        </div>
                    </div>
                </div>

                <!-- Grade -->
                <div>
                    <label for="grade" class="block text-sm font-medium text-gray-700 mb-1">
                        Grade/GPA
                    </label>
                    <input type="text" id="grade" name="grade" placeholder="e.g., 3.8/4.0, First Class"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        Description
                    </label>
                    <textarea id="description" name="description" rows="3"
                        placeholder="Describe your achievements, courses, or projects..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="hideAddEducationModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-gray-800 hover:bg-black rounded-lg transition flex items-center gap-2">
                        Save Education
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Education Modal -->
    <div id="editEducationModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50"
        style="display: none;">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Edit Education</h3>
            </div>

            <form id="editEducationForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_education_id" name="id">

                <!-- University -->
                <div>
                    <label for="edit_university_id" class="block text-sm font-medium text-gray-700 mb-1">
                        University *
                    </label>
                    <select name="university_id" id="edit_university_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                        <option value="">Select University</option>
                        @foreach ($universities as $university)
                            <option value="{{ $university->id }}">{{ $university->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Major -->
                <div>
                    <label for="edit_major_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Major/Field of Study *
                    </label>
                    <select name="major_id" id="edit_major_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                        <option value="">Select Major</option>
                        @foreach ($majors as $major)
                            <option value="{{ $major->id }}">{{ $major->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Degree -->
                <div>
                    <label for="edit_degree" class="block text-sm font-medium text-gray-700 mb-1">
                        Degree *
                    </label>
                    <input type="text" id="edit_degree" name="degree" placeholder="e.g., Bachelor of Science"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                </div>

                <!-- Field of Study -->
                <div>
                    <label for="edit_field_of_study" class="block text-sm font-medium text-gray-700 mb-1">
                        Field of Study
                    </label>
                    <input type="text" id="edit_field_of_study" name="field_of_study"
                        placeholder="e.g., Computer Science"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="edit_start_year" class="block text-sm font-medium text-gray-700 mb-1">
                            Start Year *
                        </label>
                        <select id="edit_start_year" name="start_year" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                            <option value="">Select Year</option>
                            @for ($year = date('Y'); $year >= 1980; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label for="edit_end_year" class="block text-sm font-medium text-gray-700 mb-1">
                            End Year
                        </label>
                        <select id="edit_end_year" name="end_year"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                            <option value="">Select Year</option>
                            <option value="present">Present</option>
                            @for ($year = date('Y'); $year >= 1980; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                        <div class="flex items-center mt-2">
                            <input type="checkbox" id="edit_is_current" name="is_current" class="mr-2">
                            <label for="edit_is_current" class="text-sm text-gray-600">Currently studying</label>
                        </div>
                    </div>
                </div>

                <!-- Grade -->
                <div>
                    <label for="edit_grade" class="block text-sm font-medium text-gray-700 mb-1">
                        Grade/GPA
                    </label>
                    <input type="text" id="edit_grade" name="grade" placeholder="e.g., 3.8/4.0, First Class"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                </div>

                <!-- Description -->
                <div>
                    <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-1">
                        Description
                    </label>
                    <textarea id="edit_description" name="description" rows="3"
                        placeholder="Describe your achievements, courses, or projects..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="hideEditEducationModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-gray-800 hover:bg-black rounded-lg transition flex items-center gap-2">
                        Update Education
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Certification Modal -->
    <div id="addCertificationModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50" style="display: none;">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Add New Certification</h3>
            </div>

            <form id="certificationForm" method="POST" action="{{ route('freelancer-profile.certificate.store') }}"
                class="p-6 space-y-4">
                @csrf
                @method('POST')
                <input type="hidden" name="freelancer_id" value="{{ $freelancer->freelancer->id }}">

                <div>
                    <label for="certification_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Certification Name *
                    </label>
                    <input type="text" id="certification_name" name="name"
                        placeholder="Enter your certificate name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                </div>

                <div>
                    <label for="issuer" class="block text-sm font-medium text-gray-700 mb-1">
                        Issuing Organization *
                    </label>
                    <input type="text" id="issuer" name="issuer" placeholder="Enter your issuer" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="issued_year" class="block text-sm font-medium text-gray-700 mb-1">
                            Issued Year
                        </label>
                        <select id="issued_year" name="issued_year"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                            <option value="">Select Year</option>
                            @for ($year = date('Y'); $year >= 1990; $year--)
                                <option value="{{ $year }}">{{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label for="expiry_year" class="block text-sm font-medium text-gray-700 mb-1">
                            Expiry Year
                        </label>
                        <select id="expiry_year" name="expiry_year"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                            <option value="">No Expiry</option>
                            @for ($year = date('Y'); $year <= date('Y') + 10; $year++)
                                <option value="{{ $year }}">{{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div>
                    <label for="certificate_url" class="block text-sm font-medium text-gray-700 mb-1">
                        Certificate URL
                    </label>
                    <input type="url" id="certificate_url" name="certificate_url"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200"
                        placeholder="https://example.com/verify">
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="hideAddCertificationModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-gray-800 hover:bg-black rounded-lg transition flex items-center gap-2">
                        Save Certification
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Certification Modal -->
    <div id="editCertificationModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50" style="display: none;">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Edit Certification</h3>
            </div>

            <form id="editCertificationForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_certificate_id" name="id">

                <div>
                    <label for="edit_certification_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Certification Name *
                    </label>
                    <input type="text" id="edit_certification_name" name="name"
                        placeholder="Enter your certificate name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                </div>

                <div>
                    <label for="edit_issuer" class="block text-sm font-medium text-gray-700 mb-1">
                        Issuing Organization *
                    </label>
                    <input type="text" id="edit_issuer" name="issuer" placeholder="Enter your issuer" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="edit_issued_year" class="block text-sm font-medium text-gray-700 mb-1">
                            Issued Year
                        </label>
                        <select id="edit_issued_year" name="issued_year"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                            <option value="">Select Year</option>
                            @for ($year = date('Y'); $year >= 1990; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label for="edit_expiry_year" class="block text-sm font-medium text-gray-700 mb-1">
                            Expiry Year
                        </label>
                        <select id="edit_expiry_year" name="expiry_year"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                            <option value="">No Expiry</option>
                            @for ($year = date('Y'); $year <= date('Y') + 10; $year++)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div>
                    <label for="edit_certificate_url" class="block text-sm font-medium text-gray-700 mb-1">
                        Certificate URL
                    </label>
                    <input type="url" id="edit_certificate_url" name="certificate_url"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200"
                        placeholder="https://example.com/verify">
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="hideEditCertificationModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-gray-800 hover:bg-black rounded-lg transition flex items-center gap-2">
                        Update Certification
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Content Area -->
    <form action="{{ route('freelancer-profile.update', $freelancer->id) }}" method="POST"
        class="flex-1 overflow-y-auto p-3">
        @csrf
        @method('PUT')

        <!-- Profile Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-3">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-3">
                <!-- Profile Info -->
                <div class="flex items-start space-x-4 flex-1 min-w-0">
                    <!-- Avatar with Verification Badge -->
                    <div class="relative">
                        @if ($freelancer->profile_photo_path)
                            <div class="w-32 h-32 rounded-full flex-shrink-0 select-none">
                                <img src="{{ $freelancer->profile_photo_path }}" alt="Profile Image"
                                    class="w-full h-full rounded-full object-cover border-4 border-white shadow">
                            </div>
                        @else
                            <div
                                class="w-32 h-32 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center select-none border-4 border-white shadow">
                                <span
                                    class="text-white font-bold text-4xl">{{ strtoupper(substr($freelancer->name, 0, 1)) }}</span>
                            </div>
                        @endif

                        <!-- Edit Photo Button (Only for freelancer viewing their own profile) -->
                        @auth
                            @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                <button type="button" onclick="document.getElementById('profile-photo-upload').click()"
                                    class="absolute bottom-0 right-0 bg-gray-800 text-white p-2 rounded-full hover:bg-black transition shadow-lg"
                                    title="Change profile photo">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                                <input type="file" id="profile-photo-upload" class="hidden" accept="image/*">
                            @endif
                        @endauth
                    </div>

                    <!-- Basic Info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-2">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h1 class="text-2xl font-bold text-gray-900">{{ $freelancer->name }}</h1>
                                </div>
                                <div class="flex items-center flex-wrap gap-2 mt-1">
                                    <span
                                        class="text-gray-700 font-medium">{{ $freelancer->freelancer->job_title }}</span>
                                    <span class="text-gray-500">•</span>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span
                                            class="font-semibold text-gray-900">{{ number_format($freelancer->freelancer->rating, 1) }}</span>
                                        <span
                                            class="text-gray-600 ml-1 text-sm">({{ $freelancer->freelancer->rating_count }}
                                            reviews)</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Hourly Rate & Availability -->
                            <div class="flex flex-col items-start md:items-end gap-2">
                                <div class="text-2xl font-bold text-gray-900">
                                    ${{ number_format($freelancer->freelancer->hourly_rate, 2) }}/hr</div>

                                @switch($freelancer->freelancer->availability)
                                    @case('available')
                                        <div class="flex items-center text-green-600 bg-green-50 px-3 py-1 rounded-full">
                                            <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div>
                                            <span class="font-medium text-sm">Available Now</span>
                                        </div>
                                    @break

                                    @case('busy')
                                        <div class="flex items-center text-amber-600 bg-amber-50 px-3 py-1 rounded-full">
                                            <div class="w-2 h-2 rounded-full bg-amber-500 mr-2"></div>
                                            <span class="font-medium text-sm">Busy</span>
                                        </div>
                                    @break

                                    @case('unavailable')
                                        <div class="flex items-center text-red-600 bg-red-50 px-3 py-1 rounded-full">
                                            <div class="w-2 h-2 rounded-full bg-red-500 mr-2"></div>
                                            <span class="font-medium text-sm">Unavailable</span>
                                        </div>
                                    @break
                                @endswitch
                            </div>
                        </div>

                        <!-- Location & Experience -->
                        <div class="flex flex-wrap items-center gap-4 mt-3 text-sm">
                            @if ($freelancer->location)
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    @auth
                                        {{ $freelancer->location }}
                                    @endauth
                                </div>
                            @endif

                            @if ($freelancer->freelancer->years_experience)
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @auth
                                        @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                            <input type="number" value="{{ $freelancer->freelancer->years_experience }}"
                                                class="bg-transparent border-b border-transparent hover:border-gray-300 focus:border-blue-500 focus:outline-none px-1 py-0.5 w-20"
                                                id="years-experience">
                                            <span class="ml-1">+ years experience</span>
                                        @else
                                            {{ $freelancer->freelancer->years_experience }}+ years experience
                                        @endif
                                    @else
                                        {{ $freelancer->freelancer->years_experience }}+ years experience
                                    @endauth
                                </div>
                            @endif

                            <!-- Member Since -->
                            @if ($freelancer->created_at)
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Member since {{ date('Y', strtotime($freelancer->created_at)) }}
                                </div>
                            @endif
                        </div>

                        <!-- Social Links -->
                        <div class="flex items-center gap-3 mt-3">
                            @auth
                                @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                    <!-- LinkedIn -->
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                        </svg>
                                        <input type="url" value="{{ $freelancer->linkedin_url }}"
                                            placeholder="LinkedIn URL"
                                            class="ml-1 text-sm bg-transparent border-b border-transparent hover:border-gray-300 focus:border-blue-500 focus:outline-none px-1 py-0.5 w-40"
                                            id="linkedin-url">
                                    </div>
                                    <!-- GitHub -->
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                        </svg>
                                        <input type="url" value="{{ $freelancer->github_url }}" placeholder="GitHub URL"
                                            class="ml-1 text-sm bg-transparent border-b border-transparent hover:border-gray-300 focus:border-blue-500 focus:outline-none px-1 py-0.5 w-40"
                                            id="github-url">
                                    </div>
                                @else
                                    @if ($freelancer->linkedin_url)
                                        <a href="{{ $freelancer->linkedin_url }}" target="_blank"
                                            class="text-gray-400 hover:text-blue-700 transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                            </svg>
                                        </a>
                                    @endif
                                    @if ($freelancer->github_url)
                                        <a href="{{ $freelancer->github_url }}" target="_blank"
                                            class="text-gray-400 hover:text-gray-900 transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                            </svg>
                                        </a>
                                    @endif
                                @endif
                            @else
                                @if ($freelancer->linkedin_url)
                                    <a href="{{ $freelancer->linkedin_url }}" target="_blank"
                                        class="text-gray-400 hover:text-blue-700 transition">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                        </svg>
                                    </a>
                                @endif
                                @if ($freelancer->github_url)
                                    <a href="{{ $freelancer->github_url }}" target="_blank"
                                        class="text-gray-400 hover:text-gray-900 transition">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                        </svg>
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-3 w-full md:w-auto">
                    @auth
                        @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                            <!-- Save All Button for freelancer -->
                            <button type="submit"
                                class="flex-1 md:flex-none bg-gray-800 hover:bg-black text-white font-medium py-3 px-6 rounded-lg transition duration-300 text-sm select-none">
                                Save All Changes
                            </button>
                        @else
                            <!-- Hire Button for other users -->
                            @if ($freelancer->freelancer->availability === 'unavailable')
                                <button
                                    class="flex-1 md:flex-none bg-gray-300 text-gray-500 font-medium py-3 px-6 rounded-lg cursor-not-allowed text-sm"
                                    disabled title="This freelancer is currently unavailable for hire">
                                    Unavailable
                                </button>
                            @else
                                <button
                                    class="flex-1 md:flex-none bg-gray-800 hover:bg-black text-white font-medium py-3 px-6 rounded-lg transition duration-300 text-sm select-none">
                                    Hire Now
                                </button>
                            @endif
                        @endif
                    @else
                        <!-- Hire Button for guests -->
                        @if ($freelancer->freelancer->availability === 'unavailable')
                            <button
                                class="flex-1 md:flex-none bg-gray-300 text-gray-500 font-medium py-3 px-6 rounded-lg cursor-not-allowed text-sm"
                                disabled title="This freelancer is currently unavailable for hire">
                                Unavailable
                            </button>
                        @else
                            <button
                                class="flex-1 md:flex-none bg-gray-800 hover:bg-black text-white font-medium py-3 px-6 rounded-lg transition duration-300 text-sm select-none">
                                Hire Now
                            </button>
                        @endif
                    @endauth

                    @if (auth()->user()->role === 'clients')
                        <button class="p-3 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                        <button class="p-3 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-3">
                <!-- Navigation Tabs -->
                <div x-data="{ activeTab: 'overview' }" class="bg-white rounded-2xl shadow-sm border border-gray-200">
                    <!-- Tab Headers -->
                    <div class="border-b border-gray-200">
                        <nav class="flex space-x-1 px-6 pt-2 overflow-x-auto">
                            <button type="button" @click="activeTab = 'overview'"
                                :class="activeTab === 'overview' ?
                                    'border-b-3 border-blue-500 text-blue-600 font-semibold' : 'text-gray-600'"
                                class="px-4 py-3 text-sm font-medium hover:text-blue-600 transition duration-300 whitespace-nowrap">
                                Overview
                            </button>
                            <button type="button" @click="activeTab = 'portfolio'"
                                :class="activeTab === 'portfolio' ?
                                    'border-b-3 border-blue-500 text-blue-600 font-semibold' : 'text-gray-600'"
                                class="px-4 py-3 text-sm font-medium hover:text-blue-600 transition duration-300 whitespace-nowrap">
                                Portfolio
                            </button>
                            <button type="button" @click="activeTab = 'reviews'"
                                :class="activeTab === 'reviews' ?
                                    'border-b-3 border-blue-500 text-blue-600 font-semibold' : 'text-gray-600'"
                                class="px-4 py-3 text-sm font-medium hover:text-blue-600 transition duration-300 whitespace-nowrap">
                                Reviews
                            </button>
                            <button type="button" @click="activeTab = 'experience'"
                                :class="activeTab === 'experience' ?
                                    'border-b-3 border-blue-500 text-blue-600 font-semibold' : 'text-gray-600'"
                                class="px-4 py-3 text-sm font-medium hover:text-blue-600 transition duration-300 whitespace-nowrap">
                                Experience
                            </button>
                            <button type="button" @click="activeTab = 'education'"
                                :class="activeTab === 'education' ?
                                    'border-b-3 border-blue-500 text-blue-600 font-semibold' : 'text-gray-600'"
                                class="px-4 py-3 text-sm font-medium hover:text-blue-600 transition duration-300 whitespace-nowrap">
                                Education
                            </button>
                            <button type="button" @click="activeTab = 'certifications'"
                                :class="activeTab === 'certifications' ?
                                    'border-b-3 border-blue-500 text-blue-600 font-semibold' : 'text-gray-600'"
                                class="px-4 py-3 text-sm font-medium hover:text-blue-600 transition duration-300 whitespace-nowrap">
                                Certifications
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="p-6">
                        <!-- Overview Tab -->
                        <div x-show="activeTab === 'overview'" x-transition>
                            <div class="space-y-6">
                                <!-- Bio -->
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="text-lg font-bold text-gray-900">About Me</h3>
                                        @auth
                                            @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                                <button type="button" onclick="editBio()"
                                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                            @endif
                                        @endauth
                                    </div>
                                    @auth
                                        @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                            <p id="bio" class="text-gray-600 text-sm leading-relaxed">
                                                {{ $freelancer->freelancer->bio ?: 'Talented freelancer ready to help bring your project to life with clean, efficient solutions.' }}
                                            </p>
                                            <div id="bio-container" class="hidden">
                                                <textarea id="bio-text" name="bio"
                                                    class="w-full text-gray-600 text-sm leading-relaxed bg-transparent border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-200 min-h-[120px]"
                                                    placeholder="Tell clients about yourself, your experience, and what you can do...">{{ $freelancer->freelancer->bio ?: 'Talented freelancer ready to help bring your project to life with clean, efficient solutions.' }}</textarea>
                                                <div class="flex justify-end gap-2 mt-2">
                                                    <button type="button" onclick="cancelEditBio()"
                                                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg transition duration-300 text-sm">
                                                        Cancel
                                                    </button>
                                                    <button type="submit"
                                                        class="bg-gray-800 hover:bg-black text-white font-medium px-4 py-2 rounded-lg transition duration-300 text-sm select-none">
                                                        Save Bio
                                                    </button>
                                                </div>
                                            </div>
                                        @else
                                            <p class="text-gray-600 text-sm leading-relaxed">
                                                {{ $freelancer->freelancer->bio ?: 'Talented freelancer ready to help bring your project to life with clean, efficient solutions.' }}
                                            </p>
                                        @endif
                                    @else
                                        <p class="text-gray-600 text-sm leading-relaxed">
                                            {{ $freelancer->freelancer->bio ?: 'Talented freelancer ready to help bring your project to life with clean, efficient solutions.' }}
                                        </p>
                                    @endauth
                                </div>

                                <!-- Skills -->
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="text-lg font-bold text-gray-900">Skills & Expertise</h3>
                                        @auth
                                            @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                                <button type="button" onclick="editSkills()"
                                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                            @endif
                                        @endauth
                                    </div>
                                    @auth
                                        @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                            <div id="skills-edit-mode" class="hidden">
                                                <div class="flex flex-wrap gap-2 mb-3">
                                                    @forelse($freelancer->skills as $skill)
                                                        <span
                                                            class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full flex items-center">
                                                            {{ $skill->name }}
                                                            <button type="button" onclick="removeSkill(this)"
                                                                class="ml-2 text-blue-600 hover:text-blue-800">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </span>
                                                    @empty
                                                        <p class="text-gray-500 text-sm">No skills added yet.</p>
                                                    @endforelse
                                                </div>
                                                <div class="flex gap-2">
                                                    <input type="text" id="new-skill-input"
                                                        placeholder="Add a new skill..."
                                                        class="flex-1 text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-200">
                                                    <button type="button" onclick="addSkill()"
                                                        class="bg-gray-800 hover:bg-black text-white font-medium px-4 py-2 rounded-lg transition duration-300 text-sm">
                                                        Add
                                                    </button>
                                                </div>
                                                <div class="flex justify-end gap-2 mt-3">
                                                    <button type="button" onclick="cancelEditSkills()"
                                                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg transition duration-300 text-sm">
                                                        Cancel
                                                    </button>
                                                    <button type="button" onclick="saveSkills()"
                                                        class="bg-gray-800 hover:bg-black text-white font-medium px-4 py-2 rounded-lg transition duration-300 text-sm">
                                                        Save Skills
                                                    </button>
                                                </div>
                                            </div>
                                            <div id="skills-view-mode">
                                                <div class="flex flex-wrap gap-2">
                                                    @forelse($freelancer->skills as $skill)
                                                        <span
                                                            class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full transition-all duration-200 ease-in-out cursor-pointer hover:bg-blue-200">
                                                            {{ $skill->name }}
                                                        </span>
                                                    @empty
                                                        <!-- Fallback skills when none are added -->
                                                        <span
                                                            class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">React.js</span>
                                                        <span
                                                            class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">TypeScript</span>
                                                        <span
                                                            class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">Next.js</span>
                                                        <span
                                                            class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">Node.js</span>
                                                        <span
                                                            class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">MongoDB</span>
                                                        <span
                                                            class="bg-purple-100 text-purple-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">Tailwind
                                                            CSS</span>
                                                    @endforelse
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex flex-wrap gap-2">
                                                @forelse($freelancer->skills as $skill)
                                                    <span
                                                        class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full transition-all duration-200 ease-in-out cursor-pointer hover:bg-blue-200">
                                                        {{ $skill->name }}
                                                    </span>
                                                @empty
                                                    <!-- Fallback skills when none are added -->
                                                    <span
                                                        class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">React.js</span>
                                                    <span
                                                        class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">TypeScript</span>
                                                    <span
                                                        class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">Next.js</span>
                                                    <span
                                                        class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">Node.js</span>
                                                    <span
                                                        class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">MongoDB</span>
                                                    <span
                                                        class="bg-purple-100 text-purple-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">Tailwind
                                                        CSS</span>
                                                @endforelse
                                            </div>
                                        @endif
                                    @else
                                        <div class="flex flex-wrap gap-2">
                                            @forelse($freelancer->skills as $skill)
                                                <span
                                                    class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full transition-all duration-200 ease-in-out cursor-pointer hover:bg-blue-200">
                                                    {{ $skill->name }}
                                                </span>
                                            @empty
                                                <!-- Fallback skills when none are added -->
                                                <span
                                                    class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">React.js</span>
                                                <span
                                                    class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">TypeScript</span>
                                                <span
                                                    class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">Next.js</span>
                                                <span
                                                    class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">Node.js</span>
                                                <span
                                                    class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">MongoDB</span>
                                                <span
                                                    class="bg-purple-100 text-purple-800 text-sm font-medium px-3 py-1.5 rounded-full opacity-60 select-none">Tailwind
                                                    CSS</span>
                                            @endforelse
                                        </div>
                                    @endauth
                                </div>

                                <!-- Stats -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                                        <div class="text-2xl font-bold text-gray-900">
                                            {{ $freelancer->freelancer->total_projects ?: '0' }}</div>
                                        <div class="text-gray-500 text-sm mt-1">Total Projects</div>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                                        <div class="text-2xl font-bold text-gray-900">
                                            {{ $freelancer->freelancer->job_success_rate ?: '0' }}%</div>
                                        <div class="text-gray-500 text-sm mt-1">Job Success</div>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                                        <div class="text-2xl font-bold text-gray-900">
                                            {{ number_format($freelancer->freelancer->total_hours) }}</div>
                                        <div class="text-gray-500 text-sm mt-1">Hours Worked</div>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                                        <div class="text-2xl font-bold text-gray-900">
                                            ${{ number_format($freelancer->freelancer->total_earned) }}</div>
                                        <div class="text-gray-500 text-sm mt-1">Total Earned</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Portfolio Tab -->
                        <div x-show="activeTab === 'portfolio'" x-transition>
                            <div class="space-y-8">
                                <!-- Portfolio Website Section -->
                                <div
                                    class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-2xl p-6">
                                    <div
                                        class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                                </svg>
                                                Portfolio Website
                                            </h3>
                                            <p class="text-gray-600 text-sm mt-1">View my complete work and
                                                case studies</p>

                                            @if ($freelancer->freelancer->portfolio_url)
                                                <p class="text-gray-500 text-sm mt-1">
                                                    {{ $freelancer->freelancer->portfolio_url }}</p>
                                            @else
                                                <p class="text-gray-500 text-sm mt-1">No portfolio website
                                                    added yet.</p>
                                            @endif
                                        </div>

                                        @if ($freelancer->freelancer->portfolio_url)
                                            <a href="{{ $freelancer->freelancer->portfolio_url }}" target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-3 rounded-lg transition duration-300 shadow-md text-sm select-none">
                                                <p>Visit
                                                    Portfolio</p><svg class="w-4 h-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div x-show="activeTab === 'reviews'" x-transition>
                            <div class="space-y-6">
                                <h3 class="text-lg font-bold text-gray-900">Client Reviews</h3>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-3xl font-bold text-gray-900">
                                                {{ number_format($freelancer->freelancer->rating, 1) }}</div>
                                            <div class="flex items-center mt-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($freelancer->freelancer->rating))
                                                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @elseif($i - 0.5 <= $freelancer->freelancer->rating)
                                                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path
                                                                d="M10 1l2.5 6.5H19l-5 4.5 2 6.5-6-4.5-6 4.5 2-6.5-5-4.5h6.5L10 1z" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5 text-gray-300" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endif
                                                @endfor
                                                <span
                                                    class="ml-2 text-gray-600 text-sm">{{ $freelancer->freelancer->rating_count }}
                                                    reviews</span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-gray-600 text-sm">Job Success</div>
                                            <div class="text-2xl font-bold text-gray-900">
                                                {{ $freelancer->freelancer->job_success_rate ?? '0' }}%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Experience Tab -->
                        <div x-show="activeTab === 'experience'" x-transition>
                            <div class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-bold text-gray-900">Work Experience</h3>
                                    @auth
                                        @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                            <button type="button" onclick="showAddExperienceModal()"
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        @endif
                                    @endauth
                                </div>
                                <div class="space-y-4" id="experience-list">
                                    @forelse ($experiences as $experience)
                                        <div class="border-l-4 border-blue-500 pl-4 py-2 relative group"
                                            data-experience-id="{{ $experience->id }}">
                                            <div
                                                class="absolute top-2 right-2 flex flex-col gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <!-- Edit Button -->
                                                <button type="button"
                                                    onclick="showEditExperienceModal({{ $experience->id }})"
                                                    class="text-gray-400 hover:text-blue-600 transition-colors duration-200 p-1 rounded-full hover:bg-blue-50"
                                                    title="Edit experience">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <!-- Remove Button -->
                                                <button type="button"
                                                    onclick="confirmRemoveExperience({{ $experience->id }})"
                                                    class="text-gray-400 hover:text-red-600 transition-colors duration-200 p-1 rounded-full hover:bg-red-50"
                                                    title="Remove experience">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="flex justify-between items-start pr-10">
                                                <div>
                                                    <h4 class="font-bold text-gray-900 text-base">
                                                        {{ $experience->jobRole->title ?? 'Job Role Not Found' }}
                                                    </h4>
                                                    <p class="text-gray-600 text-sm">
                                                        {{ $experience->company }}</p>
                                                    @if ($experience->location)
                                                        <p class="text-gray-500 text-xs mt-1">
                                                            {{ $experience->location }}</p>
                                                    @endif
                                                </div>
                                                <span class="text-sm text-gray-500">
                                                    {{ date('M Y', strtotime($experience->start_date)) }} -
                                                    @if ($experience->is_current)
                                                        Present
                                                    @elseif($experience->end_date)
                                                        {{ date('M Y', strtotime($experience->end_date)) }}
                                                    @else
                                                        Present
                                                    @endif
                                                </span>
                                            </div>
                                            @if ($experience->description)
                                                <p class="text-gray-600 text-sm mt-2 pr-10">
                                                    {{ $experience->description }}</p>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="text-center py-8">
                                            <p class="text-gray-500 text-sm">No work experience added yet</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <script>
                            // Experience Modal Functions
                            function showAddExperienceModal() {
                                document.getElementById('addExperienceModal').style.display = 'flex';
                                document.body.style.overflow = 'hidden';
                            }

                            function hideAddExperienceModal() {
                                document.getElementById('addExperienceModal').style.display = 'none';
                                document.body.style.overflow = 'auto';
                                document.getElementById('experienceForm').reset();
                            }

                            function showEditExperienceModal(experienceId) {
                                const modal = document.getElementById('editExperienceModal');
                                modal.style.display = 'flex';
                                document.body.style.overflow = 'hidden';

                                // Clear previous data
                                document.getElementById('edit_experience_id').value = '';
                                document.getElementById('edit_job_role_id').value = '';
                                document.getElementById('edit_company').value = '';
                                document.getElementById('edit_description').value = '';
                                document.getElementById('edit_employment_type').value = '';
                                document.getElementById('edit_start_date').value = '';
                                document.getElementById('edit_end_date').value = '';
                                document.getElementById('edit_location').value = '';
                                document.getElementById('edit_is_current').checked = false;

                                // Fetch experience data
                                fetch(`/freelancer-profile/experience/${experienceId}/edit`)
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Failed to fetch experience data');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        console.log('Experience data loaded:', data);

                                        // Populate form fields
                                        document.getElementById('edit_experience_id').value = data.id;
                                        document.getElementById('edit_job_role_id').value = data.job_role_id || '';
                                        document.getElementById('edit_company').value = data.company || '';
                                        document.getElementById('edit_description').value = data.description || '';
                                        document.getElementById('edit_employment_type').value = data.employment_type || '';
                                        document.getElementById('edit_location').value = data.location || '';

                                        // Format dates for input[type="month"]
                                        if (data.start_date) {
                                            const startDate = new Date(data.start_date);
                                            document.getElementById('edit_start_date').value =
                                                startDate.toISOString().slice(0, 7);
                                        }

                                        if (data.end_date) {
                                            const endDate = new Date(data.end_date);
                                            document.getElementById('edit_end_date').value =
                                                endDate.toISOString().slice(0, 7);
                                        }

                                        // Handle current job checkbox
                                        const isCurrent = data.is_current || false;
                                        document.getElementById('edit_is_current').checked = isCurrent;

                                        // Disable end date if currently working here
                                        const endDateInput = document.getElementById('edit_end_date');
                                        if (isCurrent) {
                                            endDateInput.disabled = true;
                                            endDateInput.value = '';
                                        } else {
                                            endDateInput.disabled = false;
                                        }

                                        // Set form action
                                        document.getElementById('editExperienceForm').action =
                                            `/freelancer-profile/experience/${experienceId}`;
                                    })
                                    .catch(error => {
                                        console.error('Error fetching experience:', error);
                                        alert('Failed to load experience data. Please try again.');
                                        hideEditExperienceModal();
                                    });
                            }

                            function hideEditExperienceModal() {
                                document.getElementById('editExperienceModal').style.display = 'none';
                                document.body.style.overflow = 'auto';
                                document.getElementById('editExperienceForm').reset();
                            }

                            // Close experience modals when clicking outside
                            document.getElementById('addExperienceModal')?.addEventListener('click', function(e) {
                                if (e.target === this) {
                                    hideAddExperienceModal();
                                }
                            });

                            document.getElementById('editExperienceModal')?.addEventListener('click', function(e) {
                                if (e.target === this) {
                                    hideEditExperienceModal();
                                }
                            });

                            // Handle current job checkbox in edit modal
                            document.getElementById('edit_is_current')?.addEventListener('change', function(e) {
                                const endDateInput = document.getElementById('edit_end_date');
                                if (e.target.checked) {
                                    endDateInput.disabled = true;
                                    endDateInput.value = '';
                                } else {
                                    endDateInput.disabled = false;
                                }
                            });

                            // Handle current job checkbox in add modal
                            document.getElementById('is_current')?.addEventListener('change', function(e) {
                                const endDateInput = document.getElementById('end_date');
                                if (e.target.checked) {
                                    endDateInput.disabled = true;
                                    endDateInput.value = '';
                                } else {
                                    endDateInput.disabled = false;
                                }
                            });

                            // Handle add experience form submission
                            document.getElementById('experienceForm')?.addEventListener('submit', function(e) {
                                e.preventDefault();

                                const formData = new FormData(this);

                                // Get CSRF token
                                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                                if (!csrfToken) {
                                    alert('Security token not found. Please refresh the page.');
                                    return;
                                }

                                // Show loading state
                                const submitBtn = this.querySelector('button[type="submit"]');
                                const originalText = submitBtn.textContent;
                                submitBtn.textContent = 'Saving...';
                                submitBtn.disabled = true;

                                // Make request
                                fetch(this.action, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'Accept': 'application/json'
                                        },
                                        body: formData
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success || data.experience) {
                                            // Use the proper addExperienceToDOM function to ensure consistent design
                                            addExperienceToDOM(data.experience || data);
                                            hideAddExperienceModal();
                                            showSuccessToast('Experience added successfully!');

                                            // Sort the list after adding
                                            sortExperienceList();
                                        } else {
                                            throw new Error(data.message || 'Failed to add experience');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error adding experience:', error);
                                        alert('Failed to add experience: ' + error.message);
                                    })
                                    .finally(() => {
                                        submitBtn.textContent = originalText;
                                        submitBtn.disabled = false;
                                    });
                            });

                            // Handle edit experience form submission
                            document.getElementById('editExperienceForm')?.addEventListener('submit', function(e) {
                                e.preventDefault();

                                const formData = new FormData(this);
                                const experienceId = formData.get('id');

                                // Convert is_current checkbox to boolean
                                const isCurrentCheckbox = document.getElementById('edit_is_current');
                                formData.set('is_current', isCurrentCheckbox ? isCurrentCheckbox.checked : false);

                                // Get CSRF token
                                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                                if (!csrfToken) {
                                    alert('Security token not found. Please refresh the page.');
                                    return;
                                }

                                // Show loading state
                                const submitBtn = this.querySelector('button[type="submit"]');
                                const originalText = submitBtn.textContent;
                                submitBtn.textContent = 'Updating...';
                                submitBtn.disabled = true;

                                // Make update request
                                fetch(this.action, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            'Accept': 'application/json',
                                            'X-Requested-With': 'XMLHttpRequest'
                                        },
                                        body: formData
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            return response.json().then(errData => {
                                                throw new Error(errData.message || `Server error: ${response.status}`);
                                            });
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data.success) {
                                            // Update the item in DOM
                                            updateExperienceItem(experienceId, data.experience);
                                            hideEditExperienceModal();
                                            showSuccessToast('Experience updated successfully!');

                                            // Sort the list after updating
                                            sortExperienceList();
                                        } else {
                                            throw new Error(data.message || 'Failed to update experience');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error updating experience:', error);
                                        alert('Failed to update experience: ' + error.message);
                                    })
                                    .finally(() => {
                                        submitBtn.textContent = originalText;
                                        submitBtn.disabled = false;
                                    });
                            });

                            // Updated addExperienceToDOM function to insert in correct position
                            function addExperienceToDOM(experience) {
                                const experienceList = document.getElementById('experience-list');

                                // Remove empty state if it exists
                                const emptyState = experienceList.querySelector('.text-center');
                                if (emptyState) {
                                    emptyState.remove();
                                }

                                // Format dates
                                const startDate = experience.start_date ? formatDate(experience.start_date) : '';
                                const endDate = experience.is_current ? 'Present' :
                                    (experience.end_date ? formatDate(experience.end_date) : '');

                                const experienceHTML = `
                                            <div class="border-l-4 border-blue-500 pl-4 py-2 relative group" data-experience-id="${experience.id}">
                                                <div class="absolute top-2 right-2 flex flex-col gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <!-- Edit Button -->
                                                    <button type="button" onclick="showEditExperienceModal(${experience.id})"
                                                        class="text-gray-400 hover:text-blue-600 transition-colors duration-200 p-1 rounded-full hover:bg-blue-50"
                                                        title="Edit experience">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>
                                                    <!-- Remove Button -->
                                                    <button type="button" onclick="confirmRemoveExperience(${experience.id})"
                                                        class="text-gray-400 hover:text-red-600 transition-colors duration-200 p-1 rounded-full hover:bg-red-50"
                                                        title="Remove experience">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="flex justify-between items-start pr-10">
                                                    <div>
                                                        <h4 class="font-bold text-gray-900 text-base">${experience.job_role_title || (experience.job_role ? experience.job_role.title : 'Job Role Not Found')}</h4>
                                                        <p class="text-gray-600 text-sm">${experience.company}</p>
                                                        ${experience.location ? `<p class="text-gray-500 text-xs mt-1">${experience.location}</p>` : ''}
                                                    </div>
                                                    <span class="text-sm text-gray-500">
                                                        ${startDate} -
                                                        ${experience.is_current ? 'Present' : (experience.end_date ? formatDate(experience.end_date) : 'Present')}
                                                    </span>
                                                </div>
                                                ${experience.description ? `<p class="text-gray-600 text-sm mt-2 pr-10">${experience.description}</p>` : ''}
                                            </div>
                                        `;

                                // Add the new experience
                                experienceList.insertAdjacentHTML('beforeend', experienceHTML);
                            }

                            // Function to sort experiences by date
                            function sortExperienceList() {
                                const experienceList = document.getElementById('experience-list');
                                const experiences = Array.from(experienceList.querySelectorAll('[data-experience-id]'));

                                if (experiences.length <= 1) return;

                                experiences.sort((a, b) => {
                                    const aDateSpan = a.querySelector('span.text-sm.text-gray-500');
                                    const bDateSpan = b.querySelector('span.text-sm.text-gray-500');

                                    // Extract dates
                                    const aDateInfo = extractDateInfo(aDateSpan ? aDateSpan.textContent : '');
                                    const bDateInfo = extractDateInfo(bDateSpan ? bDateSpan.textContent : '');

                                    // Sort logic:
                                    // 1. "Present" experiences come first
                                    if (aDateInfo.isPresent && !bDateInfo.isPresent) return -1;
                                    if (!aDateInfo.isPresent && bDateInfo.isPresent) return 1;

                                    // 2. Both present or both not present - sort by start date (most recent first)
                                    if (aDateInfo.startDate && bDateInfo.startDate) {
                                        return bDateInfo.startDate.getTime() - aDateInfo.startDate.getTime();
                                    }

                                    // 3. If one has a date and the other doesn't, put the one with date first
                                    if (aDateInfo.startDate && !bDateInfo.startDate) return -1;
                                    if (!aDateInfo.startDate && bDateInfo.startDate) return 1;

                                    return 0;
                                });

                                // Clear the list and re-add in sorted order
                                const fragment = document.createDocumentFragment();
                                experiences.forEach(exp => {
                                    fragment.appendChild(exp);
                                });

                                experienceList.innerHTML = '';
                                experienceList.appendChild(fragment);
                            }

                            // Helper function to extract date information from the date span text
                            function extractDateInfo(dateText) {
                                const result = {
                                    isPresent: false,
                                    startDate: null,
                                    endDate: null
                                };

                                if (!dateText) return result;

                                // Check if it contains "Present"
                                result.isPresent = dateText.includes('Present');

                                // Extract start date (first part before " - ")
                                const parts = dateText.split(' - ');
                                if (parts.length > 0) {
                                    const startDateStr = parts[0].trim();
                                    result.startDate = parseDateString(startDateStr);
                                }

                                return result;
                            }

                            // Helper function to parse date strings like "Jan 2023" or "January 2023"
                            function parseDateString(dateStr) {
                                if (!dateStr) return null;

                                // Try to parse the date
                                const date = new Date(dateStr);
                                if (!isNaN(date.getTime())) {
                                    return date;
                                }

                                // Try parsing common month abbreviations
                                const monthAbbreviations = {
                                    'Jan': 0,
                                    'Feb': 1,
                                    'Mar': 2,
                                    'Apr': 3,
                                    'May': 4,
                                    'Jun': 5,
                                    'Jul': 6,
                                    'Aug': 7,
                                    'Sep': 8,
                                    'Oct': 9,
                                    'Nov': 10,
                                    'Dec': 11
                                };

                                const parts = dateStr.split(' ');
                                if (parts.length === 2) {
                                    const monthStr = parts[0];
                                    const yearStr = parts[1];

                                    if (monthAbbreviations.hasOwnProperty(monthStr) && !isNaN(yearStr)) {
                                        return new Date(parseInt(yearStr), monthAbbreviations[monthStr], 1);
                                    }
                                }

                                return null;
                            }

                            // Update experience item in DOM
                            function updateExperienceItem(experienceId, experienceData) {
                                const item = document.querySelector(`[data-experience-id="${experienceId}"]`);
                                if (item) {
                                    // Update item content with consistent design
                                    const title = item.querySelector('h4');
                                    const company = item.querySelector('.text-gray-600.text-sm');
                                    const location = item.querySelector('.text-gray-500.text-xs');
                                    const dateSpan = item.querySelector('.text-sm.text-gray-500');
                                    const description = item.querySelector('.text-gray-600.text-sm.mt-2');

                                    const jobRoleTitle = experienceData.job_role_title ||
                                        (experienceData.job_role ? experienceData.job_role.title : 'Job Role Not Found');

                                    if (title) title.textContent = jobRoleTitle;
                                    if (company) company.textContent = experienceData.company;

                                    // Update location
                                    if (location) {
                                        if (experienceData.location) {
                                            location.textContent = experienceData.location;
                                            location.classList.remove('hidden');
                                        } else {
                                            location.remove();
                                        }
                                    } else if (experienceData.location) {
                                        const locationHTML = `<p class="text-gray-500 text-xs mt-1">${experienceData.location}</p>`;
                                        company.insertAdjacentHTML('afterend', locationHTML);
                                    }

                                    // Update date
                                    if (dateSpan) {
                                        const startDate = experienceData.start_date ? formatDate(experienceData.start_date) : '';
                                        const endDate = experienceData.is_current ? 'Present' :
                                            (experienceData.end_date ? formatDate(experienceData.end_date) : 'Present');
                                        dateSpan.textContent = `${startDate} - ${endDate}`;
                                    }

                                    // Update description
                                    if (description) {
                                        if (experienceData.description) {
                                            description.textContent = experienceData.description;
                                            description.classList.remove('hidden');
                                        } else {
                                            description.remove();
                                        }
                                    } else if (experienceData.description) {
                                        const container = item.querySelector('.flex.justify-between.items-start').parentElement;
                                        const descHTML = `<p class="text-gray-600 text-sm mt-2 pr-10">${experienceData.description}</p>`;
                                        container.insertAdjacentHTML('beforeend', descHTML);
                                    }
                                }
                            }

                            // Format date to "MMM YYYY"
                            function formatDate(dateString) {
                                if (!dateString) return '';
                                const date = new Date(dateString);
                                return date.toLocaleDateString('en-US', {
                                    month: 'short',
                                    year: 'numeric'
                                });
                            }

                            // Show success toast notification
                            function showSuccessToast(message) {
                                // Create toast if it doesn't exist
                                let toast = document.getElementById('successToast');
                                if (!toast) {
                                    toast = document.createElement('div');
                                    toast.id = 'successToast';
                                    toast.className =
                                        'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-y-full opacity-0 transition-all duration-300 z-50';
                                    document.body.appendChild(toast);
                                }

                                toast.textContent = message;
                                toast.classList.remove('translate-y-full', 'opacity-0');
                                toast.classList.add('translate-y-0', 'opacity-100');

                                setTimeout(() => {
                                    toast.classList.remove('translate-y-0', 'opacity-100');
                                    toast.classList.add('translate-y-full', 'opacity-0');
                                }, 3000);
                            }

                            // Enhanced confirm and remove experience function
                            function confirmRemoveExperience(experienceId) {
                                if (!confirm('Are you sure you want to remove this experience?')) {
                                    return;
                                }

                                // Get the CSRF token
                                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                                if (!csrfToken) {
                                    alert('Security token not found. Please refresh the page.');
                                    return;
                                }

                                // Show loading state on the button
                                const item = document.querySelector(`[data-experience-id="${experienceId}"]`);
                                const removeBtn = item?.querySelector('button[onclick*="confirmRemoveExperience"]');
                                if (removeBtn) {
                                    const originalHTML = removeBtn.innerHTML;
                                    removeBtn.innerHTML =
                                        '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>';
                                    removeBtn.disabled = true;
                                }

                                // Make the AJAX request
                                fetch(`/freelancer-profile/experience/${experienceId}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                            'X-Requested-With': 'XMLHttpRequest'
                                        },
                                        credentials: 'same-origin'
                                    })
                                    .then(response => {
                                        // Check if response is JSON
                                        const contentType = response.headers.get('content-type');
                                        if (contentType && contentType.includes('application/json')) {
                                            return response.json();
                                        }
                                        return response.text().then(text => {
                                            try {
                                                return JSON.parse(text);
                                            } catch {
                                                throw new Error(`Server returned: ${text.substring(0, 200)}`);
                                            }
                                        });
                                    })
                                    .then(data => {
                                        if (data.success) {
                                            // Remove the item with animation
                                            const item = document.querySelector(`[data-experience-id="${experienceId}"]`);
                                            if (item) {
                                                item.style.opacity = '0';
                                                item.style.transition = 'all 0.3s ease';

                                                setTimeout(() => {
                                                    item.remove();
                                                    showSuccessToast('Experience removed successfully!');

                                                    // If no experiences left, show empty state
                                                    const experienceList = document.getElementById('experience-list');
                                                    if (experienceList && experienceList.children.length === 0) {
                                                        experienceList.innerHTML = `
                                    <div class="text-center py-8">
                                        <p class="text-gray-500 text-sm">No work experience added yet</p>
                                    </div>
                                `;
                                                    }
                                                }, 300);
                                            }
                                        } else {
                                            throw new Error(data.message || 'Failed to remove experience');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Delete error:', error);
                                        alert('Failed to remove experience: ' + error.message);
                                    })
                                    .finally(() => {
                                        // Restore button state
                                        if (removeBtn) {
                                            removeBtn.innerHTML = originalHTML;
                                            removeBtn.disabled = false;
                                        }
                                    });
                            }

                            // Initialize and sort experiences on page load
                            document.addEventListener('DOMContentLoaded', function() {
                                // Sort experiences when page loads
                                sortExperienceList();

                                // Set up edit experience form action
                                const editExperienceForm = document.getElementById('editExperienceForm');
                                if (editExperienceForm) {
                                    editExperienceForm.action = '/freelancer-profile/experience/' + (document.getElementById(
                                        'edit_experience_id')?.value || '');
                                }
                            });
                        </script>

                        <!-- Education Tab -->
                        <div x-show="activeTab === 'education'" x-transition>
                            <div class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-bold text-gray-900">Education</h3>
                                    @auth
                                        @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                            <button type="button" onclick="showAddEducationModal()"
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        @endif
                                    @endauth
                                </div>
                                <div class="space-y-4" id="education-list">
                                    @forelse ($educations as $education)
                                        <div class="border-l-4 border-indigo-500 pl-4 py-2 relative group"
                                            data-education-id="{{ $education->id }}">
                                            <div
                                                class="absolute top-2 right-2 flex flex-col gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <!-- Edit Button -->
                                                <button type="button"
                                                    onclick="showEditEducationModal({{ $education->id }})"
                                                    class="text-gray-400 hover:text-blue-600 transition-colors duration-200 p-1 rounded-full hover:bg-blue-50"
                                                    title="Edit education">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <!-- Remove Button -->
                                                <button type="button"
                                                    onclick="confirmRemoveEducation({{ $education->id }})"
                                                    class="text-gray-400 hover:text-red-600 transition-colors duration-200 p-1 rounded-full hover:bg-red-50"
                                                    title="Remove education">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="flex justify-between items-start pr-10">
                                                <div>
                                                    <h4 class="font-bold text-gray-900 text-base">{{ $education->degree }}
                                                    </h4>
                                                    <p class="text-gray-600 text-sm">
                                                        {{ $education->university->name ?? 'University' }}</p>
                                                    @if ($education->major)
                                                        <p class="text-gray-500 text-xs mt-1">
                                                            {{ $education->major->name }}</p>
                                                    @endif
                                                    @if ($education->field_of_study)
                                                        <p class="text-gray-500 text-xs mt-1">
                                                            {{ $education->field_of_study }}</p>
                                                    @endif
                                                </div>
                                                <span class="text-sm text-gray-500">
                                                    {{ $education->start_year }} -
                                                    @if ($education->is_current)
                                                        Present
                                                    @elseif($education->end_year)
                                                        {{ $education->end_year }}
                                                    @else
                                                        Present
                                                    @endif
                                                </span>
                                            </div>
                                            @if ($education->grade)
                                                <p class="text-gray-600 text-sm mt-1 pr-10">Grade: {{ $education->grade }}
                                                </p>
                                            @endif
                                            @if ($education->description)
                                                <p class="text-gray-600 text-sm mt-2 pr-10">{{ $education->description }}
                                                </p>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="text-center py-8">
                                            <p class="text-gray-500 text-sm">No education added yet</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <script>
                            // Education Modal Functions
                            function showAddEducationModal() {
                                document.getElementById('addEducationModal').style.display = 'flex';
                                document.body.style.overflow = 'hidden';
                            }

                            function hideAddEducationModal() {
                                document.getElementById('addEducationModal').style.display = 'none';
                                document.body.style.overflow = 'auto';
                                document.getElementById('educationForm').reset();
                            }

                            function showEditEducationModal(educationId) {
                                const modal = document.getElementById('editEducationModal');
                                modal.style.display = 'flex';
                                document.body.style.overflow = 'hidden';

                                // Clear previous data
                                document.getElementById('edit_education_id').value = '';
                                document.getElementById('edit_university_id').value = '';
                                document.getElementById('edit_major_id').value = '';
                                document.getElementById('edit_degree').value = '';
                                document.getElementById('edit_field_of_study').value = '';
                                document.getElementById('edit_start_year').value = '';
                                document.getElementById('edit_end_year').value = '';
                                document.getElementById('edit_grade').value = '';
                                document.getElementById('edit_description').value = '';
                                document.getElementById('edit_is_current').checked = false;

                                // Fetch education data
                                fetch(`/freelancer-profile/education/${educationId}/edit`)
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Failed to fetch education data');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        // Populate form fields
                                        document.getElementById('edit_education_id').value = data.id;
                                        document.getElementById('edit_university_id').value = data.university_id || '';
                                        document.getElementById('edit_major_id').value = data.major_id || '';
                                        document.getElementById('edit_degree').value = data.degree || '';
                                        document.getElementById('edit_field_of_study').value = data.field_of_study || '';
                                        document.getElementById('edit_grade').value = data.grade || '';
                                        document.getElementById('edit_description').value = data.description || '';

                                        // Handle years
                                        if (data.start_year) {
                                            document.getElementById('edit_start_year').value = data.start_year;
                                        }

                                        if (data.end_year) {
                                            if (data.is_current || data.end_year === 'present') {
                                                document.getElementById('edit_end_year').value = 'present';
                                            } else {
                                                document.getElementById('edit_end_year').value = data.end_year;
                                            }
                                        }

                                        // Handle current studying checkbox
                                        const isCurrent = data.is_current || false;
                                        document.getElementById('edit_is_current').checked = isCurrent;

                                        // Disable end year if currently studying
                                        const endYearSelect = document.getElementById('edit_end_year');
                                        if (isCurrent) {
                                            endYearSelect.value = 'present';
                                            endYearSelect.disabled = true;
                                        } else {
                                            endYearSelect.disabled = false;
                                        }

                                        // Set form action
                                        document.getElementById('editEducationForm').action =
                                            `/freelancer-profile/education/${educationId}`;
                                    })
                                    .catch(error => {
                                        console.error('Error fetching education:', error);
                                        alert('Failed to load education data. Please try again.');
                                        hideEditEducationModal();
                                    });
                            }

                            function hideEditEducationModal() {
                                document.getElementById('editEducationModal').style.display = 'none';
                                document.body.style.overflow = 'auto';
                                document.getElementById('editEducationForm').reset();
                            }

                            // Close education modals when clicking outside
                            document.getElementById('addEducationModal')?.addEventListener('click', function(e) {
                                if (e.target === this) {
                                    hideAddEducationModal();
                                }
                            });

                            document.getElementById('editEducationModal')?.addEventListener('click', function(e) {
                                if (e.target === this) {
                                    hideEditEducationModal();
                                }
                            });

                            // Handle current studying checkbox in edit modal
                            document.getElementById('edit_is_current')?.addEventListener('change', function(e) {
                                const endYearSelect = document.getElementById('edit_end_year');
                                if (e.target.checked) {
                                    endYearSelect.value = 'present';
                                    endYearSelect.disabled = true;
                                } else {
                                    endYearSelect.disabled = false;
                                    endYearSelect.value = '';
                                }
                            });

                            // Handle current studying checkbox in add modal
                            document.getElementById('is_current')?.addEventListener('change', function(e) {
                                const endYearSelect = document.getElementById('end_year');
                                if (e.target.checked) {
                                    endYearSelect.value = 'present';
                                    endYearSelect.disabled = true;
                                } else {
                                    endYearSelect.disabled = false;
                                    endYearSelect.value = '';
                                }
                            });

                            // Handle add education form submission
                            document.getElementById('educationForm')?.addEventListener('submit', function(e) {
                                e.preventDefault();

                                const formData = new FormData(this);

                                // Get CSRF token
                                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                                if (!csrfToken) {
                                    alert('Security token not found. Please refresh the page.');
                                    return;
                                }

                                // Show loading state
                                const submitBtn = this.querySelector('button[type="submit"]');
                                const originalText = submitBtn.textContent;
                                submitBtn.textContent = 'Saving...';
                                submitBtn.disabled = true;

                                // Make request
                                fetch(this.action, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'Accept': 'application/json'
                                        },
                                        body: formData
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success || data.education) {
                                            addEducationToDOM(data.education || data);
                                            hideAddEducationModal();
                                            showSuccessToast('Education added successfully!');

                                            // Sort the list after adding
                                            sortEducationList();
                                        } else {
                                            throw new Error(data.message || 'Failed to add education');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error adding education:', error);
                                        alert('Failed to add education: ' + error.message);
                                    })
                                    .finally(() => {
                                        submitBtn.textContent = originalText;
                                        submitBtn.disabled = false;
                                    });
                            });

                            // Handle edit education form submission
                            document.getElementById('editEducationForm')?.addEventListener('submit', function(e) {
                                e.preventDefault();

                                const formData = new FormData(this);
                                const educationId = formData.get('id');

                                // Convert is_current checkbox to boolean
                                const isCurrentCheckbox = document.getElementById('edit_is_current');
                                formData.set('is_current', isCurrentCheckbox ? isCurrentCheckbox.checked : false);

                                // Get CSRF token
                                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                                if (!csrfToken) {
                                    alert('Security token not found. Please refresh the page.');
                                    return;
                                }

                                // Show loading state
                                const submitBtn = this.querySelector('button[type="submit"]');
                                const originalText = submitBtn.textContent;
                                submitBtn.textContent = 'Updating...';
                                submitBtn.disabled = true;

                                // Make update request
                                fetch(this.action, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            'Accept': 'application/json',
                                            'X-Requested-With': 'XMLHttpRequest'
                                        },
                                        body: formData
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            return response.json().then(errData => {
                                                throw new Error(errData.message || `Server error: ${response.status}`);
                                            });
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data.success) {
                                            // Update the item in DOM
                                            updateEducationItem(educationId, data.education);
                                            hideEditEducationModal();
                                            showSuccessToast('Education updated successfully!');

                                            // Sort the list after updating
                                            sortEducationList();
                                        } else {
                                            throw new Error(data.message || 'Failed to update education');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error updating education:', error);
                                        alert('Failed to update education: ' + error.message);
                                    })
                                    .finally(() => {
                                        submitBtn.textContent = originalText;
                                        submitBtn.disabled = false;
                                    });
                            });

                            // Add education to DOM
                            function addEducationToDOM(education) {
                                const educationList = document.getElementById('education-list');

                                // Remove empty state if it exists
                                const emptyState = educationList.querySelector('.text-center');
                                if (emptyState) {
                                    emptyState.remove();
                                }

                                const educationHTML = `
            <div class="border-l-4 border-indigo-500 pl-4 py-2 relative group" data-education-id="${education.id}">
                <div class="absolute top-2 right-2 flex flex-col gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <!-- Edit Button -->
                    <button type="button" onclick="showEditEducationModal(${education.id})"
                        class="text-gray-400 hover:text-blue-600 transition-colors duration-200 p-1 rounded-full hover:bg-blue-50"
                        title="Edit education">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                    <!-- Remove Button -->
                    <button type="button" onclick="confirmRemoveEducation(${education.id})"
                        class="text-gray-400 hover:text-red-600 transition-colors duration-200 p-1 rounded-full hover:bg-red-50"
                        title="Remove education">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
                <div class="flex justify-between items-start pr-10">
                    <div>
                        <h4 class="font-bold text-gray-900 text-base">${education.degree}</h4>
                        <p class="text-gray-600 text-sm">${education.university_name || education.university?.name || 'University'}</p>
                        ${education.major_name ? `<p class="text-gray-500 text-xs mt-1">${education.major_name}</p>` : ''}
                        ${education.field_of_study ? `<p class="text-gray-500 text-xs mt-1">${education.field_of_study}</p>` : ''}
                    </div>
                    <span class="text-sm text-gray-500">
                        ${education.start_year} -
                        ${education.is_current ? 'Present' : (education.end_year ? education.end_year : 'Present')}
                    </span>
                </div>
                ${education.grade ? `<p class="text-gray-600 text-sm mt-1 pr-10">Grade: ${education.grade}</p>` : ''}
                ${education.description ? `<p class="text-gray-600 text-sm mt-2 pr-10">${education.description}</p>` : ''}
            </div>
        `;

                                // Add the new education
                                educationList.insertAdjacentHTML('beforeend', educationHTML);
                            }

                            // Function to sort educations by year
                            function sortEducationList() {
                                const educationList = document.getElementById('education-list');
                                const educations = Array.from(educationList.querySelectorAll('[data-education-id]'));

                                if (educations.length <= 1) return;

                                educations.sort((a, b) => {
                                    const aDateSpan = a.querySelector('span.text-sm.text-gray-500');
                                    const bDateSpan = b.querySelector('span.text-sm.text-gray-500');

                                    // Extract years
                                    const aDateInfo = extractYearInfo(aDateSpan ? aDateSpan.textContent : '');
                                    const bDateInfo = extractYearInfo(bDateSpan ? bDateSpan.textContent : '');

                                    // Sort logic:
                                    // 1. "Present" educations come first
                                    if (aDateInfo.isPresent && !bDateInfo.isPresent) return -1;
                                    if (!aDateInfo.isPresent && bDateInfo.isPresent) return 1;

                                    // 2. Both present or both not present - sort by end year (most recent first)
                                    if (aDateInfo.endYear && bDateInfo.endYear) {
                                        return bDateInfo.endYear - aDateInfo.endYear;
                                    }

                                    // 3. If one has an end year and the other doesn't, put the one with end year first
                                    if (aDateInfo.endYear && !bDateInfo.endYear) return -1;
                                    if (!aDateInfo.endYear && bDateInfo.endYear) return 1;

                                    return 0;
                                });

                                // Clear the list and re-add in sorted order
                                const fragment = document.createDocumentFragment();
                                educations.forEach(edu => {
                                    fragment.appendChild(edu);
                                });

                                educationList.innerHTML = '';
                                educationList.appendChild(fragment);
                            }

                            // Helper function to extract year information
                            function extractYearInfo(dateText) {
                                const result = {
                                    isPresent: false,
                                    startYear: null,
                                    endYear: null
                                };

                                if (!dateText) return result;

                                // Check if it contains "Present"
                                result.isPresent = dateText.includes('Present');

                                // Extract years from format like "2014 - 2016" or "2018 - Present"
                                const parts = dateText.split(' - ');
                                if (parts.length >= 2) {
                                    const startYear = parseInt(parts[0].trim());
                                    const endYearStr = parts[1].trim();

                                    if (!isNaN(startYear)) {
                                        result.startYear = startYear;
                                    }

                                    if (endYearStr !== 'Present') {
                                        const endYear = parseInt(endYearStr);
                                        if (!isNaN(endYear)) {
                                            result.endYear = endYear;
                                        }
                                    }
                                }

                                return result;
                            }

                            // Update education item in DOM
                            function updateEducationItem(educationId, educationData) {
                                const item = document.querySelector(`[data-education-id="${educationId}"]`);
                                if (item) {
                                    // Update item content
                                    const title = item.querySelector('h4');
                                    const university = item.querySelector('.text-gray-600.text-sm');
                                    const dateSpan = item.querySelector('.text-sm.text-gray-500');

                                    const universityName = educationData.university_name ||
                                        (educationData.university ? educationData.university.name : 'University');
                                    const majorName = educationData.major_name ||
                                        (educationData.major ? educationData.major.name : null);

                                    if (title) title.textContent = educationData.degree || '';
                                    if (university) university.textContent = universityName;

                                    // Update date
                                    if (dateSpan) {
                                        const endYear = educationData.is_current ? 'Present' :
                                            (educationData.end_year ? educationData.end_year : 'Present');
                                        dateSpan.textContent = `${educationData.start_year || ''} - ${endYear}`;
                                    }

                                    // Update major field
                                    const majorField = item.querySelector('.text-gray-500.text-xs.mt-1');
                                    if (majorName) {
                                        if (majorField) {
                                            majorField.textContent = majorName;
                                        } else {
                                            const majorHTML = `<p class="text-gray-500 text-xs mt-1">${majorName}</p>`;
                                            university.insertAdjacentHTML('afterend', majorHTML);
                                        }
                                    } else if (majorField) {
                                        majorField.remove();
                                    }

                                    // Update field of study
                                    const fieldOfStudy = educationData.field_of_study;
                                    let fieldElement = item.querySelectorAll('.text-gray-500.text-xs.mt-1')[1];
                                    if (fieldOfStudy) {
                                        if (fieldElement) {
                                            fieldElement.textContent = fieldOfStudy;
                                        } else {
                                            const fieldHTML = `<p class="text-gray-500 text-xs mt-1">${fieldOfStudy}</p>`;
                                            const lastElement = item.querySelector('.text-gray-500.text-xs.mt-1:last-child') || university;
                                            lastElement.insertAdjacentHTML('afterend', fieldHTML);
                                        }
                                    } else if (fieldElement && !majorName) {
                                        fieldElement.remove();
                                    }

                                    // Update grade
                                    const gradeElement = item.querySelector('.text-gray-600.text-sm.mt-1');
                                    if (educationData.grade) {
                                        if (gradeElement) {
                                            gradeElement.textContent = `Grade: ${educationData.grade}`;
                                        } else {
                                            const container = item.querySelector('.flex.justify-between.items-start').parentElement;
                                            const gradeHTML = `<p class="text-gray-600 text-sm mt-1 pr-10">Grade: ${educationData.grade}</p>`;
                                            container.insertAdjacentHTML('beforeend', gradeHTML);
                                        }
                                    } else if (gradeElement) {
                                        gradeElement.remove();
                                    }

                                    // Update description
                                    const descElement = item.querySelector('.text-gray-600.text-sm.mt-2');
                                    if (educationData.description) {
                                        if (descElement) {
                                            descElement.textContent = educationData.description;
                                        } else {
                                            const container = item.querySelector('.flex.justify-between.items-start').parentElement;
                                            const descHTML = `<p class="text-gray-600 text-sm mt-2 pr-10">${educationData.description}</p>`;
                                            container.insertAdjacentHTML('beforeend', descHTML);
                                        }
                                    } else if (descElement) {
                                        descElement.remove();
                                    }
                                }
                            }

                            // Enhanced confirm and remove education function
                            function confirmRemoveEducation(educationId) {
                                if (!confirm('Are you sure you want to remove this education?')) {
                                    return;
                                }

                                // Get the CSRF token
                                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                                if (!csrfToken) {
                                    alert('Security token not found. Please refresh the page.');
                                    return;
                                }

                                // Show loading state on the button
                                const item = document.querySelector(`[data-education-id="${educationId}"]`);
                                const removeBtn = item?.querySelector('button[onclick*="confirmRemoveEducation"]');
                                if (removeBtn) {
                                    const originalHTML = removeBtn.innerHTML;
                                    removeBtn.innerHTML =
                                        '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>';
                                    removeBtn.disabled = true;
                                }

                                // Make the AJAX request
                                fetch(`/freelancer-profile/education/${educationId}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                            'X-Requested-With': 'XMLHttpRequest'
                                        },
                                        credentials: 'same-origin'
                                    })
                                    .then(response => {
                                        // Check if response is JSON
                                        const contentType = response.headers.get('content-type');
                                        if (contentType && contentType.includes('application/json')) {
                                            return response.json();
                                        }
                                        return response.text().then(text => {
                                            try {
                                                return JSON.parse(text);
                                            } catch {
                                                throw new Error(`Server returned: ${text.substring(0, 200)}`);
                                            }
                                        });
                                    })
                                    .then(data => {
                                        if (data.success) {
                                            // Remove the item with animation
                                            const item = document.querySelector(`[data-education-id="${educationId}"]`);
                                            if (item) {
                                                item.style.opacity = '0';
                                                item.style.transition = 'all 0.3s ease';

                                                setTimeout(() => {
                                                    item.remove();
                                                    showSuccessToast('Education removed successfully!');

                                                    // If no educations left, show empty state
                                                    const educationList = document.getElementById('education-list');
                                                    if (educationList && educationList.children.length === 0) {
                                                        educationList.innerHTML = `
                                    <div class="text-center py-8">
                                        <p class="text-gray-500 text-sm">No education added yet</p>
                                    </div>
                                `;
                                                    }
                                                }, 300);
                                            }
                                        } else {
                                            throw new Error(data.message || 'Failed to remove education');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Delete error:', error);
                                        alert('Failed to remove education: ' + error.message);
                                    })
                                    .finally(() => {
                                        // Restore button state
                                        if (removeBtn) {
                                            removeBtn.innerHTML = originalHTML;
                                            removeBtn.disabled = false;
                                        }
                                    });
                            }

                            // Initialize and sort educations on page load
                            document.addEventListener('DOMContentLoaded', function() {
                                // Sort educations when page loads
                                sortEducationList();

                                // Set up edit education form action
                                const editEducationForm = document.getElementById('editEducationForm');
                                if (editEducationForm) {
                                    editEducationForm.action = '/freelancer-profile/education/' + (document.getElementById(
                                        'edit_education_id')?.value || '');
                                }
                            });
                        </script>

                        <!-- Certifications Tab -->
                        <div x-show="activeTab === 'certifications'" x-transition>
                            <div class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-bold text-gray-900">Certifications</h3>
                                    @auth
                                        @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                            <button type="button" onclick="showAddCertificationModal()"
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        @endif
                                    @endauth
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="certifications-list">
                                    @forelse ($certificates as $certificate)
                                        <div class="border border-gray-200 rounded-xl p-4 relative group"
                                            data-certificate-id="{{ $certificate->id }}">
                                            <div class="absolute top-3 right-3 flex gap-1">
                                                <!-- Edit Button -->
                                                <button type="button"
                                                    onclick="showEditCertificationModal({{ $certificate->id }})"
                                                    class="text-gray-400 hover:text-blue-600 transition-colors duration-200 p-1 rounded-full hover:bg-blue-50"
                                                    title="Edit certification">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>

                                                <!-- Remove Button -->
                                                <button type="button"
                                                    onclick="confirmRemoveCertification({{ $certificate->id }})"
                                                    class="text-gray-400 hover:text-red-600 transition-colors duration-200 p-1 rounded-full hover:bg-red-50"
                                                    title="Remove certification">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <div class="flex items-start gap-3 pr-8">
                                                <div
                                                    class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-green-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <h4 class="font-bold text-gray-900">
                                                        {{ $certificate->name }}</h4>
                                                    <p class="text-gray-600 text-sm">
                                                        {{ $certificate->issuer }}</p>
                                                    <p class="text-gray-500 text-xs mt-1">Issued:
                                                        {{ $certificate->issued_year ?? 'No Issued Date' }} |
                                                        {{ $certificate->expiry_year ?? 'No Expiry' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-span-2 text-center py-8">
                                            <p class="text-gray-500 text-sm">No certifications added yet</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Success Message Toast -->
                        <div id="successToast"
                            class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-y-full opacity-0 transition-all duration-300 z-50">
                            Certification added successfully!
                        </div>

                        <script>
                            // Existing functions remain the same
                            function showAddCertificationModal() {
                                document.getElementById('addCertificationModal').style.display = 'flex';
                                document.body.style.overflow = 'hidden';
                            }

                            function hideAddCertificationModal() {
                                document.getElementById('addCertificationModal').style.display = 'none';
                                document.body.style.overflow = 'auto';
                                document.getElementById('certificationForm').reset();
                            }

                            function showEditCertificationModal(certificateId) {
                                // Show loading state
                                const modal = document.getElementById('editCertificationModal');
                                modal.style.display = 'flex';
                                document.body.style.overflow = 'hidden';

                                // Clear previous data
                                document.getElementById('edit_certificate_id').value = '';
                                document.getElementById('edit_certification_name').value = '';
                                document.getElementById('edit_issuer').value = '';
                                document.getElementById('edit_issued_year').value = '';
                                document.getElementById('edit_expiry_year').value = '';
                                document.getElementById('edit_certificate_url').value = '';

                                // Fetch certificate data
                                fetch(`/freelancer-profile/certificate/${certificateId}/edit`)
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Failed to fetch certificate data');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        // Populate form fields
                                        document.getElementById('edit_certificate_id').value = data.id;
                                        document.getElementById('edit_certification_name').value = data.name || '';
                                        document.getElementById('edit_issuer').value = data.issuer || '';
                                        document.getElementById('edit_issued_year').value = data.issued_year || '';
                                        document.getElementById('edit_expiry_year').value = data.expiry_year || '';
                                        document.getElementById('edit_certificate_url').value = data.certificate_url || '';
                                    })
                                    .catch(error => {
                                        console.error('Error fetching certificate:', error);
                                        alert('Failed to load certification data. Please try again.');
                                        hideEditCertificationModal();
                                    });
                            }

                            function hideEditCertificationModal() {
                                document.getElementById('editCertificationModal').style.display = 'none';
                                document.body.style.overflow = 'auto';
                            }

                            // Close modals when clicking outside
                            document.getElementById('addCertificationModal')?.addEventListener('click', function(e) {
                                if (e.target === this) {
                                    hideAddCertificationModal();
                                }
                            });

                            document.getElementById('editCertificationModal')?.addEventListener('click', function(e) {
                                if (e.target === this) {
                                    hideEditCertificationModal();
                                }
                            });

                            // Handle edit form submission
                            document.getElementById('editCertificationForm')?.addEventListener('submit', function(e) {
                                e.preventDefault();

                                const formData = new FormData(this);
                                const certificateId = formData.get('id');

                                // Get CSRF token
                                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                                if (!csrfToken) {
                                    alert('Security token not found. Please refresh the page.');
                                    return;
                                }

                                // Show loading state
                                const submitBtn = this.querySelector('button[type="submit"]');
                                const originalText = submitBtn.textContent;
                                submitBtn.textContent = 'Updating...';
                                submitBtn.disabled = true;

                                // Make update request
                                fetch(`/freelancer-profile/certificate/${certificateId}`, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'Accept': 'application/json'
                                        },
                                        body: formData
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Network response was not ok');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data.success || data.message) {
                                            // Update the certificate card in the DOM
                                            updateCertificateCard(certificateId, {
                                                name: formData.get('name'),
                                                issuer: formData.get('issuer'),
                                                issued_year: formData.get('issued_year'),
                                                expiry_year: formData.get('expiry_year'),
                                                certificate_url: formData.get('certificate_url')
                                            });

                                            hideEditCertificationModal();
                                            showSuccessToast('Certification updated successfully!');
                                        } else {
                                            throw new Error(data.message || 'Failed to update certification');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error updating certification:', error);
                                        alert('Failed to update certification: ' + error.message);
                                    })
                                    .finally(() => {
                                        submitBtn.textContent = originalText;
                                        submitBtn.disabled = false;
                                    });
                            });

                            // Update certificate card in the DOM
                            function updateCertificateCard(certificateId, certificateData) {
                                const card = document.querySelector(`[data-certificate-id="${certificateId}"]`);
                                if (card) {
                                    // Update card content
                                    const title = card.querySelector('h4');
                                    const issuer = card.querySelector('.text-gray-600.text-sm');
                                    const dateInfo = card.querySelector('.text-gray-500.text-xs');

                                    if (title) title.textContent = certificateData.name;
                                    if (issuer) issuer.textContent = certificateData.issuer;
                                    if (dateInfo) {
                                        dateInfo.textContent =
                                            `Issued: ${certificateData.issued_year || 'No Issued Date'} | ${certificateData.expiry_year || 'No Expiry'}`;
                                    }
                                }
                            }

                            // Show success toast notification
                            function showSuccessToast(message) {
                                const toast = document.getElementById('successToast');
                                if (toast) {
                                    toast.textContent = message;
                                    toast.classList.remove('translate-y-full', 'opacity-0');
                                    toast.classList.add('translate-y-0', 'opacity-100');

                                    setTimeout(() => {
                                        toast.classList.remove('translate-y-0', 'opacity-100');
                                        toast.classList.add('translate-y-full', 'opacity-0');
                                    }, 3000);
                                }
                            }

                            // Enhanced confirmRemoveCertification function
                            function confirmRemoveCertification(certificateId) {
                                if (!confirm('Are you sure you want to remove this certification?')) {
                                    return;
                                }

                                // Get the base URL dynamically
                                const baseUrl = window.location.origin;

                                // Get CSRF token safely
                                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                                if (!csrfToken) {
                                    alert('Security token not found. Please refresh the page.');
                                    return;
                                }

                                // Show loading state on the button
                                const card = document.querySelector(`[data-certificate-id="${certificateId}"]`);
                                const removeBtn = card?.querySelector('button[onclick*="confirmRemoveCertification"]');
                                if (removeBtn) {
                                    const originalHTML = removeBtn.innerHTML;
                                    removeBtn.innerHTML =
                                        '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>';
                                    removeBtn.disabled = true;
                                }

                                // Make the AJAX request
                                fetch(`${baseUrl}/freelancer-profile/certificate/${certificateId}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                            'X-Requested-With': 'XMLHttpRequest'
                                        },
                                        credentials: 'same-origin'
                                    })
                                    .then(response => {
                                        // Check if response is JSON
                                        const contentType = response.headers.get('content-type');
                                        if (contentType && contentType.includes('application/json')) {
                                            return response.json();
                                        }
                                        return response.text().then(text => {
                                            try {
                                                return JSON.parse(text);
                                            } catch {
                                                throw new Error(`Server returned: ${text.substring(0, 200)}`);
                                            }
                                        });
                                    })
                                    .then(data => {
                                        if (data.success) {
                                            // Remove the card with animation
                                            const card = document.querySelector(`[data-certificate-id="${certificateId}"]`);
                                            if (card) {
                                                card.style.opacity = '0';
                                                card.style.transition = 'all 0.3s ease';

                                                setTimeout(() => {
                                                    card.remove();
                                                    showSuccessToast('Certification removed successfully!');

                                                    // If no certifications left, show empty state
                                                    const certificationsList = document.getElementById('certifications-list');
                                                    if (certificationsList && certificationsList.children.length === 0) {
                                                        certificationsList.innerHTML = `
                                                                    <div class="col-span-2 text-center py-8">
                                                                        <p class="text-gray-500 text-sm">No certifications added yet</p>
                                                                    </div>
                                                                `;
                                                    }
                                                }, 300);
                                            }
                                        } else {
                                            throw new Error(data.message || 'Failed to remove certificate');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Delete error:', error);
                                        alert('Failed to remove certification: ' + error.message);
                                    })
                                    .finally(() => {
                                        // Restore button state
                                        if (removeBtn) {
                                            removeBtn.innerHTML = originalHTML;
                                            removeBtn.disabled = false;
                                        }
                                    });
                            }

                            // Handle add certification form submission
                            document.getElementById('certificationForm')?.addEventListener('submit', function(e) {
                                e.preventDefault();

                                const formData = new FormData(this);

                                // Get CSRF token
                                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                                if (!csrfToken) {
                                    alert('Security token not found. Please refresh the page.');
                                    return;
                                }

                                // Show loading state
                                const submitBtn = this.querySelector('button[type="submit"]');
                                const originalText = submitBtn.textContent;
                                submitBtn.textContent = 'Saving...';
                                submitBtn.disabled = true;

                                // Make request
                                fetch(this.action, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'Accept': 'application/json'
                                        },
                                        body: formData
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success || data.certificate) {
                                            addCertificationToDOM(data.certificate || data);
                                            hideAddCertificationModal();
                                            showSuccessToast('Certification added successfully!');
                                        } else {
                                            throw new Error(data.message || 'Failed to add certification');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error adding certification:', error);
                                        alert('Failed to add certification: ' + error.message);
                                    })
                                    .finally(() => {
                                        submitBtn.textContent = originalText;
                                        submitBtn.disabled = false;
                                    });
                            });

                            // Updated addCertificationToDOM function
                            function addCertificationToDOM(certificate) {
                                const certificationsList = document.getElementById('certifications-list');

                                // Remove empty state if it exists
                                const emptyState = certificationsList.querySelector('.col-span-2');
                                if (emptyState) {
                                    emptyState.remove();
                                }

                                const certificationHTML = `
                                            <div class="border border-gray-200 rounded-xl p-4 relative group" data-certificate-id="${certificate.id}">
                                                <div class="absolute top-3 right-3 flex gap-1">
                                                    <!-- Edit Button -->
                                                    <button type="button" onclick="showEditCertificationModal(${certificate.id})"
                                                        class="text-gray-400 hover:text-blue-600 transition-colors duration-200 p-1 rounded-full hover:bg-blue-50"
                                                        title="Edit certification">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>
                                                    <!-- Remove Button -->
                                                    <button type="button" onclick="confirmRemoveCertification(${certificate.id})"
                                                        class="text-gray-400 hover:text-red-600 transition-colors duration-200 p-1 rounded-full hover:bg-red-50"
                                                        title="Remove certification">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="flex items-start gap-3 pr-8">
                                                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h4 class="font-bold text-gray-900">${certificate.name}</h4>
                                                        <p class="text-gray-600 text-sm">${certificate.issuer}</p>
                                                        <p class="text-gray-500 text-xs mt-1">Issued: ${certificate.issued_year || 'No Issued Date'} | ${certificate.expiry_year || 'No Expiry'}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        `;

                                // Add new certification
                                certificationsList.insertAdjacentHTML('beforeend', certificationHTML);
                            }
                        </script>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-3">
                <!-- Contact Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Contact Information</h3>
                        @auth
                            @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                <button type="button" onclick="editContactInfo()"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            @endif
                        @endauth
                    </div>
                    <div class="space-y-3 text-sm" id="contact-info-view">
                        @if ($freelancer->email)
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89-5.26a2 2 0 012.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $freelancer->email }}
                            </div>
                        @endif
                        @if ($freelancer->phone)
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $freelancer->phone }}
                            </div>
                        @endif
                        @if ($freelancer->location)
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $freelancer->location }}
                            </div>
                        @endif
                        @if ($freelancer->freelancer->portfolio_url)
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                                <a href="{{ $freelancer->freelancer->portfolio_url }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 text-sm">
                                    {{ parse_url($freelancer->freelancer->portfolio_url, PHP_URL_HOST) }}
                                </a>
                            </div>
                        @endif
                    </div>

                    @auth
                        @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                            <div id="contact-info-edit" class="hidden space-y-3">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89-5.26a2 2 0 012.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <input type="email" value="{{ $freelancer->email }}"
                                        class="flex-1 text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-200"
                                        id="edit-email" placeholder="Email" disabled>
                                    <input type="hidden" value="{{ $freelancer->email }}">
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <input type="tel" value="{{ $freelancer->phone }}"
                                        class="flex-1 text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-200"
                                        id="edit-phone" name="phone" placeholder="Phone number">
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <input type="tel" value="{{ $freelancer->location }}"
                                        class="flex-1 text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-200"
                                        id="edit-phone" name="location" placeholder="Location">
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                    </svg>
                                    <input type="text" value="{{ $freelancer->freelancer->portfolio_url }}"
                                        class="flex-1 text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-200"
                                        id="edit-phone" name="portfolio_url" placeholder="Portfolio URL">
                                </div>
                                <div class="flex justify-end gap-2 mt-3">
                                    <button type="button" onclick="cancelEditContactInfo()"
                                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg transition duration-300 text-sm select-none">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="bg-gray-800 hover:bg-black text-white font-medium px-4 py-2 rounded-lg transition duration-300 text-sm select-none">
                                        Save
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endauth

                    @if (auth()->user()->role === 'clients')
                        <button
                            class="w-full mt-6 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 rounded-lg transition duration-300 text-sm select-none">
                            Send Message
                        </button>
                    @endif
                </div>

                <!-- Hourly Rate Breakdown -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Hourly Rate Breakdown</h3>
                        @auth
                            @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                <button type="button" onclick="editHourlyRate()" id="edit-hourly-rate-btn"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            @endif
                        @endauth
                    </div>

                    <!-- View Mode -->
                    <div class="space-y-3" id="hourly-rate-view">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 text-sm">Base Rate</span>
                            <span class="text-gray-900 font-medium">
                                ${{ number_format($freelancer->freelancer->hourly_rate, 2) }}/hr
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 text-sm">Minimum Hours</span>
                            <span class="text-gray-900 text-sm font-medium">
                                {{ $freelancer->freelancer->minimum_hours ?? '10' }} hours
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 text-sm">Response Time</span>
                            <span class="text-gray-900 text-sm font-medium">
                                {{ $freelancer->freelancer->response_time ?? '2' }} hours
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 text-sm">Revision Limit</span>
                            <span class="text-gray-900 text-sm font-medium">
                                {{ $freelancer->freelancer->revision_limit ?? '3' }} revisions
                            </span>
                        </div>
                        <div class="pt-3 border-t border-gray-100">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-900 text-sm font-medium">Estimated 20-hour
                                    project</span>
                                <span class="text-xl font-bold text-gray-900">
                                    ${{ number_format($freelancer->freelancer->hourly_rate * 20, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Mode (Only for freelancer viewing their own profile) -->
                    @auth
                        @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                            <div id="hourly-rate-edit" class="hidden space-y-4">
                                <div class="space-y-3">
                                    <div class="flex flex-col">
                                        <label class="text-gray-600 text-sm mb-1">Base Rate ($/hr)</label>
                                        <div class="flex items-center">
                                            <span class="text-gray-500 mr-2">$</span>
                                            <input type="number" value="{{ $freelancer->freelancer->hourly_rate }}"
                                                step="0.01" min="0"
                                                class="flex-1 text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-200"
                                                id="edit-hourly-rate" name="hourly_rate">
                                        </div>
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="text-gray-600 text-sm mb-1">Minimum Hours</label>
                                        <input type="number" value="{{ $freelancer->freelancer->minimum_hours ?? '10' }}"
                                            min="1"
                                            class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-200"
                                            id="edit-minimum-hours" name="minimum_hours">
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="text-gray-600 text-sm mb-1">Response Time (hours)</label>
                                        <input type="number" value="{{ $freelancer->freelancer->response_time ?? '2' }}"
                                            min="1" max="24"
                                            class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-200"
                                            id="edit-response-time" name="response_time">
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="text-gray-600 text-sm mb-1">Revision Limit</label>
                                        <input type="number" value="{{ $freelancer->freelancer->revision_limit ?? '3' }}"
                                            min="0"
                                            class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-200"
                                            id="edit-revision-limit">
                                    </div>
                                </div>

                                <!-- Preview of estimated project cost -->
                                <div class="pt-3 border-t border-gray-100 bg-gray-50 rounded-lg p-3">
                                    <div class="text-sm text-gray-600 mb-1">Estimated 20-hour project cost:</div>
                                    <div class="text-lg font-bold text-gray-900" id="estimated-cost-preview">
                                        ${{ number_format($freelancer->freelancer->hourly_rate * 20, 2) }}
                                    </div>
                                </div>

                                <div class="flex justify-end gap-2 pt-3">
                                    <button type="button" onclick="cancelEditHourlyRate()"
                                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg transition duration-300 text-sm">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="bg-gray-800 hover:bg-black text-white font-medium px-4 py-2 rounded-lg transition duration-300 text-sm">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>

                <script>
                    function editHourlyRate() {
                        document.getElementById('hourly-rate-view').classList.add('hidden');
                        document.getElementById('hourly-rate-edit').classList.remove('hidden');
                        document.getElementById('edit-hourly-rate-btn').classList.add('hidden');

                        // Add event listener for real-time calculation
                        document.getElementById('edit-hourly-rate').addEventListener('input', updateEstimatedCost);
                    }

                    function cancelEditHourlyRate() {
                        document.getElementById('hourly-rate-edit').classList.add('hidden');
                        document.getElementById('hourly-rate-view').classList.remove('hidden');
                        document.getElementById('edit-hourly-rate-btn').classList.remove('hidden');

                        // Remove event listener
                        document.getElementById('edit-hourly-rate').removeEventListener('input', updateEstimatedCost);
                    }

                    function updateEstimatedCost() {
                        const hourlyRate = parseFloat(document.getElementById('edit-hourly-rate').value) || 0;
                        const estimatedCost = hourlyRate * 20;
                        document.getElementById('estimated-cost-preview').textContent = `$${estimatedCost.toFixed(2)}`;
                    }

                    function saveHourlyRate() {
                        const hourlyRate = document.getElementById('edit-hourly-rate').value;
                        const minimumHours = document.getElementById('edit-minimum-hours').value;
                        const responseTime = document.getElementById('edit-response-time').value;
                        const revisionLimit = document.getElementById('edit-revision-limit').value;

                        // Prepare form data
                        const formData = new FormData();
                        formData.append('hourly_rate', hourlyRate);
                        formData.append('minimum_hours', minimumHours);
                        formData.append('response_time_hours', responseTime);
                        formData.append('revision_limit', revisionLimit);
                        formData.append('_method', 'PUT');

                        // Get the CSRF token
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        // Make the API call
                        fetch("{{ route('freelancer-profile.update', $freelancer->id) }}", {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                },
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Update the view with new values
                                    document.querySelector('#hourly-rate-view div:nth-child(1) span:nth-child(2)').textContent =
                                        `$${parseFloat(hourlyRate).toFixed(2)}/hr`;
                                    document.querySelector('#hourly-rate-view div:nth-child(2) span:nth-child(2)').textContent =
                                        `${minimumHours} hours`;
                                    document.querySelector('#hourly-rate-view div:nth-child(3) span:nth-child(2)').textContent =
                                        `${responseTime} hours`;
                                    document.querySelector('#hourly-rate-view div:nth-child(4) span:nth-child(2)').textContent =
                                        `${revisionLimit} revisions`;
                                    document.querySelector('#hourly-rate-view div:nth-child(5) div span:nth-child(2)').textContent =
                                        `$${(parseFloat(hourlyRate) * 20).toFixed(2)}`;

                                    cancelEditHourlyRate();
                                    alert('Hourly rate breakdown updated successfully!');
                                } else {
                                    alert('Error updating hourly rate: ' + (data.message || 'Unknown error'));
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Error updating hourly rate. Please try again.');
                            });
                    }
                </script>

                <!-- Availability Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Availability</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 text-sm">Current Status:</span>
                            @switch($freelancer->freelancer->availability)
                                @case('available')
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium select-none">Available</span>
                                @break

                                @case('busy')
                                    <span
                                        class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm font-medium select-none">Busy</span>
                                @break

                                @case('unavailable')
                                    <span
                                        class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium select-none">Unavailable</span>
                                @break
                            @endswitch
                        </div>
                        <div class="pt-4 border-t border-gray-100">
                            <h4 class="font-medium text-gray-900 text-sm mb-2">Response Time</h4>
                            <div class="flex items-center text-gray-600 text-sm">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Usually responds within
                                    {{ $freelancer->freelancer->response_time ?? '2' }} hours</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Languages Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Languages</h3>
                        @auth
                            @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                                <div class="flex gap-3">
                                    <button type="button" onclick="addEducation()"
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                    <button type="button" onclick="editLanguages()"
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        @endauth
                    </div>
                    <div class="space-y-3 text-sm" id="languages-view">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Myanmar</span>
                            <span class="text-gray-900 font-medium">Fluent</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">English</span>
                            <span class="text-gray-900 font-medium">Professional</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">French</span>
                            <span class="text-gray-900 font-medium">Intermediate</span>
                        </div>
                    </div>

                    @auth
                        @if (auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer')
                            <div id="languages-edit" class="hidden space-y-3">
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" value="Myanmar"
                                        class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-200"
                                        placeholder="Language">
                                    <select
                                        class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-200">
                                        <option value="fluent" selected>Fluent</option>
                                        <option value="professional">Professional</option>
                                        <option value="intermediate">Intermediate</option>
                                        <option value="basic">Basic</option>
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" value="English"
                                        class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-200"
                                        placeholder="Language">
                                    <select
                                        class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-200">
                                        <option value="fluent">Fluent</option>
                                        <option value="professional" selected>Professional</option>
                                        <option value="intermediate">Intermediate</option>
                                        <option value="basic">Basic</option>
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" value="French"
                                        class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-200"
                                        placeholder="Language">
                                    <select
                                        class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-200">
                                        <option value="fluent">Fluent</option>
                                        <option value="professional">Professional</option>
                                        <option value="intermediate" selected>Intermediate</option>
                                        <option value="basic">Basic</option>
                                    </select>
                                </div>
                                <div class="flex justify-end gap-2 mt-3 select-none">
                                    <button type="button" onclick="cancelEditLanguages()"
                                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg transition duration-300 text-sm">
                                        Cancel
                                    </button>
                                    <button type="button" onclick="saveLanguages()"
                                        class="bg-gray-800 hover:bg-black text-white font-medium px-4 py-2 rounded-lg transition duration-300 text-sm select-none">
                                        Save
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {});

        console.log('Freelancer profile loaded:', {
            name: '{{ $freelancer->name }}',
            availability: '{{ $freelancer->freelancer->availability }}',
            isOwner: {{ auth()->check() && auth()->user()->id === $freelancer->id && auth()->user()->role === 'freelancer' ? 'true' : 'false' }}
        });

        // Edit functions for freelancer
        function editBio() {
            const bio = document.getElementById('bio');
            const bioTextarea = document.getElementById('bio-text');
            const bioContainer = document.getElementById('bio-container');
            if (bioTextarea && bioContainer) {
                bioTextarea.focus();

                bio.classList.add('hidden');
                bioContainer.classList.remove('hidden');
            }
        }

        function cancelEditBio() {
            const bio = document.getElementById('bio');
            const bioContainer = document.getElementById('bio-container');
            if (bio && bioContainer) {
                bio.classList.remove('hidden');
                bioContainer.classList.add('hidden');
            }
        }

        function editSkills() {
            document.getElementById('skills-view-mode').classList.add('hidden');
            document.getElementById('skills-edit-mode').classList.remove('hidden');
        }

        function cancelEditSkills() {
            document.getElementById('skills-edit-mode').classList.add('hidden');
            document.getElementById('skills-view-mode').classList.remove('hidden');
        }

        function addSkill() {
            const input = document.getElementById('new-skill-input');
            const skill = input.value.trim();
            if (skill) {
                // Here you would add the skill to the list and make an API call
                console.log('Adding skill:', skill);
                input.value = '';
            }
        }

        function removeSkill(button) {
            const skillElement = button.parentElement;
            skillElement.remove();
            console.log('Removing skill');
        }

        function saveSkills() {
            console.log('Saving skills');
            // Here you would make an API call to save all skills
            alert('Skills saved successfully!');
            cancelEditSkills();
        }

        function editContactInfo() {
            document.getElementById('contact-info-view').classList.add('hidden');
            document.getElementById('contact-info-edit').classList.remove('hidden');
        }

        function cancelEditContactInfo() {
            document.getElementById('contact-info-edit').classList.add('hidden');
            document.getElementById('contact-info-view').classList.remove('hidden');
        }

        function editLanguages() {
            document.getElementById('languages-view').classList.add('hidden');
            document.getElementById('languages-edit').classList.remove('hidden');
        }

        function cancelEditLanguages() {
            document.getElementById('languages-edit').classList.add('hidden');
            document.getElementById('languages-view').classList.remove('hidden');
        }

        function saveLanguages() {
            console.log('Saving languages');
            // Here you would make an API call to save languages
            alert('Languages saved successfully!');
            cancelEditLanguages();
        }

        function saveSocialLinks() {
            const linkedinUrl = document.getElementById('linkedin-url').value;
            const githubUrl = document.getElementById('github-url').value;

            console.log('Saving social links:', {
                linkedinUrl,
                githubUrl
            });
            // Here you would make an API call to save social links
            alert('Social links saved successfully!');
        }

        function addExperience() {
            console.log('Adding new experience');
            // Here you would show a modal or form to add new experience
            alert('Feature: Add new work experience');
        }

        function addEducation() {
            console.log('Adding new education');
            // Here you would show a modal or form to add new education
            alert('Feature: Add new education');
        }

        function addCertification() {
            console.log('Adding new certification');
            // Here you would show a modal or form to add new certification
            alert('Feature: Add new certification');
        }

        // Profile photo upload
        document.getElementById('profile-photo-upload')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                console.log('Uploading profile photo:', file.name);
                // Here you would upload the file to your server
                alert('Profile photo uploaded successfully!');
            }
        });
    </script>
@endpush
