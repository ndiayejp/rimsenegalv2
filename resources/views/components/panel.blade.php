@php
    $classes =
        'p-6 bg-white rounded-lg cursor-pointer hover:border-blue group border-gray-200 shadow dark:bg-gray-800 dark:border-gray-700';
@endphp
<div {{ $attributes(['class' => $classes]) }}>
    {{ $slot }}
</div>
