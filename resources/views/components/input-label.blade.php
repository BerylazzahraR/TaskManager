@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[#37352f] dark:text-gray-300 transition-colors duration-300']) }}>
    {{ $value ?? $slot }}
</label>