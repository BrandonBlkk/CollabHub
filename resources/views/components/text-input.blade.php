@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'w-full border border-gray-200 rounded-lg p-3 pl-9 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300']) }}>
