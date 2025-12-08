<!-- resources/views/components/sidebar-item.blade.php -->
@props([
    'href' => '#',
    'icon' => null,
    'badge' => null,
    'badgeColor' => 'blue',
    'active' => false,
])

@php
    $classes =
        'flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700 transition-colors duration-200';
    if ($active) {
        $classes .= ' bg-blue-50 text-blue-700';
    }
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if ($icon)
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
        </svg>
    @endif
    <span class="font-medium text-sm">{{ $slot }}</span>

    @if ($badge)
        @php
            $badgeClasses =
                [
                    'blue' => 'bg-blue-100 text-blue-800',
                    'red' => 'bg-red-100 text-red-800',
                    'green' => 'bg-green-100 text-green-800',
                    'yellow' => 'bg-yellow-100 text-yellow-800',
                    'purple' => 'bg-purple-100 text-purple-800',
                ][$badgeColor] ?? 'bg-blue-100 text-blue-800';
        @endphp
        <span class="ml-auto {{ $badgeClasses }} text-xs font-semibold px-2 py-1 rounded-full">
            {{ $badge }}
        </span>
    @endif
</a>
