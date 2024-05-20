@props(['value', 'label' => false, 'description' => false])

@php
    $model = $attributes->wire('model')->value;
@endphp

<div
    x-id="['input']"
    class="relative flex items-center"
    {{ $attributes->whereStartsWith(['wire:key']) }}
>
    <div class="flex h-6 items-center">

        <input
            {{ $attributes->whereStartsWith(['wire', 'x']) }}
            value="{{ $value ?? null }}"
            :id="$id('input')"
            type="radio"
            @class([
                'w-4 h-4 text-indigo-600 rounded-full read-only:ring-opacity-50',
                'border-gray-300 ring-gray-300 focus:ring-indigo-600' => $errors->missing(
                    $model),
                'border-red-400 ring-red-400 focus:ring-red-500' => $errors->has($model),
            ])
            @if (!$attributes->get('name')) name="{{ $attributes->get('wire:model') }}" @endif
            @error($model)
                aria-invalid="true"
                aria-description="{{ $message }}"
            @enderror
        >
    </div>

    <div class="ml-2 select-none text-sm leading-6">

        @if ($label)
            <label
                :for="$id('input')"
                @class([
                    'font-medium text-xs',
                    $label instanceof \Illuminate\View\ComponentSlot
                        ? $label->attributes->get('class')
                        : null,
                    'text-gray-900 dark:text-neutral-300' => $errors->missing($model),
                    'text-red-700' => $errors->has($model),
                ])
            >
                {{ $label }}
            </label>
        @endif

        @if ($description)
            <p class="text-gray-500">
                {{ $description }}
            </p>
        @endif
    </div>
</div>
