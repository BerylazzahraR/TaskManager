@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-[#1a1a1a] dark:text-gray-300 focus:border-[#0056b3] dark:focus:border-[#0056b3] focus:ring-[#0056b3] dark:focus:ring-[#0056b3] rounded-md shadow-sm transition-colors duration-300']) !!}>