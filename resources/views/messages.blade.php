@extends('layouts.app')

@section('title', 'Messages')

@section('content')
    <div class="flex flex-col h-[calc(99vh-100px)]">
        <!-- Main Chat Container -->
        <div class="flex flex-1 overflow-hidden">
            <!-- Sidebar: Conversation List -->
            <div class="w-80 border-r border-gray-200 bg-white overflow-y-auto conversation-list">
                <!-- Conversation Filters -->
                <div class="p-4 border-b border-gray-200 select-none">
                    <div class="flex space-x-2">
                        <button class="px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors">
                            All
                        </button>
                        <button
                            class="px-3 py-1.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                            Unread
                        </button>
                        <button
                            class="px-3 py-1.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                            Archived
                        </button>
                    </div>
                </div>

                <!-- Conversation List -->
                <div class="divide-y divide-gray-100">
                    @for ($i = 1; $i <= 5; $i++)
                        <div
                            class="p-3 hover:bg-gray-50 cursor-pointer border-l-2 {{ $i === 1 ? 'border-l-blue-500 bg-blue-50' : 'border-l-transparent' }} transition-colors">
                            <div class="flex items-start space-x-3">
                                <div class="relative flex-shrink-0 select-none">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">JD</span>
                                    </div>
                                    <div
                                        class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full">
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <h3 class="font-semibold text-gray-900 text-sm truncate">John Doe</h3>
                                        <span class="text-xs text-gray-500 whitespace-nowrap">10:24 AM</span>
                                    </div>
                                    <p class="text-gray-600 text-xs truncate mb-1">
                                        Hey! I've sent the latest design files...
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Main Chat Area -->
            <div class="flex-1 flex flex-col bg-gray-50">
                <!-- Chat Header -->
                <div class="bg-white border-b border-gray-200 p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="relative flex-shrink-0 select-none">
                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">JD</span>
                                </div>
                                <div
                                    class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full">
                                </div>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">John Doe</h3>
                                <div class="flex items-center">
                                    <span class="text-xs text-green-600 font-medium mr-2">Online</span>
                                    <span class="text-xs text-gray-500">Web Design Project • $2,500</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button
                                class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                            <button
                                class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </button>
                            <button id="rightSectionBtn"
                                class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                <i class="ri-layout-right-2-line text-xl"></i>
                            </button>
                            <button
                                class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Messages Container -->
                <div class="flex-1 overflow-y-auto p-4 space-y-4 messages-container">
                    <!-- Date Separator -->
                    <div class="text-center">
                        <span class="inline-block px-3 py-1 bg-gray-200 text-gray-700 text-xs font-medium rounded-full">
                            Today
                        </span>
                    </div>

                    <!-- Received Message -->
                    <div class="flex items-start space-x-3 max-w-2xl">
                        <div
                            class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center flex-shrink-0 mt-1 select-none">
                            <span class="text-white font-bold text-xs">JD</span>
                        </div>
                        <div class="flex-1">
                            <div
                                class="bg-white rounded-xl rounded-tl-none p-4 border border-gray-200 shadow-sm max-w-[85%]">
                                <p class="text-sm text-gray-800">Hey! I've sent the latest design files for the landing
                                    page. Let me
                                    know what you think!</p>
                                <div class="mt-2 flex items-center space-x-3">
                                    <a href="#"
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                        <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                        </svg>
                                        design_v2.zip (4.2 MB)
                                    </a>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500 mt-1 block ml-1">10:24 AM</span>
                        </div>
                    </div>

                    <!-- Sent Message -->
                    <div class="flex items-start space-x-3 max-w-2xl ml-auto justify-end">
                        <div class="text-right">
                            <div class="bg-blue-600 text-white text-sm rounded-xl rounded-tr-none p-4 max-w-[85%] ml-auto">
                                <p>Thanks John! The designs look great. I'll review them and share feedback by EOD.</p>
                            </div>
                            <div class="flex items-center justify-end space-x-1 mt-1">
                                <span class="text-xs text-gray-500">10:28 AM</span>
                                <i class="ri-check-double-line text-blue-500"></i>
                            </div>
                        </div>
                        <div
                            class="w-8 h-8 rounded-full bg-gradient-to-r from-gray-700 to-gray-900 flex items-center justify-center flex-shrink-0 mt-1 select-none">
                            <span class="text-white font-bold text-xs">Y</span>
                        </div>
                    </div>

                    <!-- Received Message -->
                    <div class="flex items-start space-x-3 max-w-2xl">
                        <div
                            class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center flex-shrink-0 mt-1 select-none">
                            <span class="text-white font-bold text-xs">JD</span>
                        </div>
                        <div class="flex-1">
                            <div
                                class="bg-white rounded-xl rounded-tl-none p-4 border border-gray-200 shadow-sm max-w-[85%]">
                                <p class="text-sm text-gray-800">Perfect! Also, can we schedule a quick call tomorrow to
                                    discuss
                                    the
                                    development timeline?</p>
                            </div>
                            <span class="text-xs text-gray-500 mt-1 block ml-1">10:32 AM</span>
                        </div>
                    </div>

                    <!-- Sent Message with Quick Replies -->
                    <div class="flex items-start space-x-3 max-w-2xl ml-auto justify-end">
                        <div class="text-right">
                            <div class="bg-blue-600 text-white text-sm rounded-xl rounded-tr-none p-4 max-w-[85%] ml-auto">
                                <p>Sure, how about 11 AM tomorrow?</p>
                            </div>
                            <div class="flex space-x-2 mt-2 justify-end">
                                <button
                                    class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition-colors whitespace-nowrap">
                                    11 AM
                                </button>
                                <button
                                    class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition-colors whitespace-nowrap">
                                    2 PM
                                </button>
                                <button
                                    class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition-colors whitespace-nowrap">
                                    4 PM
                                </button>
                            </div>
                            <div class="flex items-center justify-end space-x-1 mt-1">
                                <span class="text-xs text-gray-500">10:35 AM</span>
                                <i class="ri-check-double-line text-blue-500"></i>
                            </div>
                        </div>
                        <div
                            class="w-8 h-8 rounded-full bg-gradient-to-r from-gray-700 to-gray-900 flex items-center justify-center flex-shrink-0 mt-1 select-none">
                            <span class="text-white font-bold text-xs">Y</span>
                        </div>
                    </div>

                    <!-- System Message -->
                    <div class="text-center">
                        <div class="inline-block px-4 py-2 bg-amber-50 border border-amber-200 rounded-lg">
                            <p class="text-amber-800 text-sm">John Doe is typing...</p>
                        </div>
                    </div>
                </div>

                <!-- Message Input -->
                <div class="border-t border-gray-200 bg-white p-4 pb-0">
                    <div class="flex items-center space-x-3">
                        <div class="flex">
                            <button id="attachButton"
                                class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                            </button>

                            <!-- Hidden file input -->
                            <input type="file" id="fileInput" class="hidden" />

                            <button id="photoButton"
                                class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </button>

                            <!-- Hidden file input for photos only -->
                            <input type="file" id="photoInput" class="hidden" accept="image/*" />
                        </div>
                        <div class="flex-1 relative">
                            <textarea rows="1" placeholder="Type your message here..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none transition-all"
                                oninput="autoResize(this)"></textarea>
                            <div class="absolute right-3 bottom-3 flex items-center space-x-2">
                                <button
                                    class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button
                            class="text-gray-500 hover:text-gray-700 hover:bg-gray-100 p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar: Project Details -->
            <div id="rightSection"
                class="w-0 border-l border-gray-200 bg-white overflow-y-auto transition-all duration-300">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Project Details</h3>

                    <div class="space-y-6">
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-900 mb-3">Web Design Project</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 text-sm">Budget:</span>
                                    <span class="font-medium text-gray-900">$2,500</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 text-sm">Status:</span>
                                    <span
                                        class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded">Active</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 text-sm">Deadline:</span>
                                    <span class="font-medium text-sm text-gray-900">Dec 20, 2023</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <h4 class="font-semibold text-gray-900">Shared Files</h4>
                            <div class="space-y-2">
                                @for ($i = 1; $i <= 3; $i++)
                                    <div
                                        class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    design_v{{ $i }}.zip
                                                </p>
                                                <p class="text-xs text-gray-500">{{ $i * 2.1 }} MB •
                                                    {{ $i }} day ago</p>
                                            </div>
                                        </div>
                                        <button
                                            class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-200 rounded transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-200">
                            <h4 class="font-semibold text-gray-900 mb-3">Quick Actions</h4>
                            <div class="space-y-2">
                                <button
                                    class="w-full flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors">
                                    <span class="text-gray-700 text-sm font-medium">Schedule Meeting</span>
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </button>
                                <button
                                    class="w-full flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors">
                                    <span class="text-gray-700 text-sm font-medium">Create Milestone</span>
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </button>
                                <button
                                    class="w-full flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors">
                                    <span class="text-gray-700 text-sm font-medium">View Contract</span>
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/messages.js')

    <style>
        /* Custom scrollbar for chat areas */
        .conversation-list::-webkit-scrollbar,
        .messages-container::-webkit-scrollbar {
            width: 6px;
        }

        .conversation-list::-webkit-scrollbar-track,
        .messages-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .conversation-list::-webkit-scrollbar-thumb,
        .messages-container::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }

        .conversation-list::-webkit-scrollbar-thumb:hover,
        .messages-container::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .conversation-list::-webkit-scrollbar,
        .messages-container::-webkit-scrollbar {
            width: 6px;
        }
    </style>
@endsection
