@props([
    'label' => false,
])

@php
    $model = $attributes->wire('model')->value;
@endphp

<x-input.group
    :$label
    :$model
>

    <input
        {{ $attributes }}
        :id="$id('input')"
        @class([
            'block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset transition-all focus:ring-2 read-only:ring-opacity-50 read-only:text-opacity-50 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-neutral-950 dark:text-neutral-300',
            'text-gray-900 ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600 dark:ring-neutral-500' => $errors->missing(
                $model),
            'text-red-700 ring-red-400 placeholder:text-red-300 focus:ring-red-500 dark:ring-red-500' => $errors->has(
                $model),
            $attributes->get('class'),
        ])
        @error($model)
            aria-invalid="true"
            aria-description="{{ $message }}"
        @enderror
    />

</x-input.group>
