@php
    $classes =
        'p-6 bg-white rounded-lg cursor-pointer hover:border-primary hover:shadow-md hover:border-primary group transition-colors duration-1000  border border-gray-300   dark:bg-gray-800 dark:border-gray-700 ';
@endphp
<div {{ $attributes(['class' => $classes]) }}>
    {{ $slot }}
</div>
