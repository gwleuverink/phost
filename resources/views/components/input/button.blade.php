@props([
    'level' => 'primary',
    'type' => 'button',
    'href' => false,
])

@php
    $element = $href ? 'a' : 'button';

    $defaultClasses = 'text-sm font-medium rounded shadow-sm transition-all disabled:opacity-50 cursor-default select-none';

    $levelClasses = match ($level) {
        'round' => 'rounded-full bg-indigo-600 p-1 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 hover:scale-110 focus-visible:scale-110',
        'danger' => 'px-2 py-1 text-white bg-red-700 hover:bg-red-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600',
        'primary' => 'px-2 py-1 text-white bg-indigo-600 hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600',
        'secondary' => 'px-2 py-1 text-neutral-500 bg-white ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-gray-200 focus-visible:outline-2 dark:bg-neutral-200 dark:text-neutral-700',
    };
@endphp

<{{ $element }} {{ $attributes->merge([
    'type' => $type,
    'href' => $href,
    'class' => "{$defaultClasses} {$levelClasses}",
]) }}>{{ $slot }}</{{ $element }}>
