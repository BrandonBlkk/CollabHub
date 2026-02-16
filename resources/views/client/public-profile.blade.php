@extends('layouts.app')

@section('title', $clientUser->name . ' Profile')

@section('content')
    <div class="max-w-5xl mx-auto space-y-3">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    @if ($clientUser->profile_photo_path)
                        <img src="{{ asset('storage/' . $clientUser->profile_photo_path) }}" alt="{{ $clientUser->name }}"
                            class="w-32 h-32 rounded-full object-cover">
                    @else
                        <div
                            class="w-32 h-32 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center">
                            <span
                                class="text-white text-4xl font-bold">{{ strtoupper(substr($clientUser->name, 0, 1)) }}</span>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $clientUser->name }}</h1>
                        <p class="text-sm text-gray-600">{{ $clientUser->client->company ?? 'Independent client' }}</p>
                        @if ($clientUser->location)
                            <p class="text-xs text-gray-500 mt-1">{{ $clientUser->location }}</p>
                        @endif
                    </div>
                </div>
                @if ($clientUser->client?->website)
                    <a href="{{ $clientUser->client->website }}" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black text-sm">
                        Visit Website
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <p class="text-xs text-gray-500">Total Jobs</p>
                <p class="text-2xl font-bold text-gray-900">{{ $clientStats['total_jobs'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <p class="text-xs text-gray-500">Open Jobs</p>
                <p class="text-2xl font-bold text-green-700">{{ $clientStats['open_jobs'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <p class="text-xs text-gray-500">In Progress</p>
                <p class="text-2xl font-bold text-blue-700">{{ $clientStats['in_progress_jobs'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <p class="text-xs text-gray-500">Completed</p>
                <p class="text-2xl font-bold text-gray-900">{{ $clientStats['completed_jobs'] }}</p>
            </div>
        </div>
    </div>
@endsection
