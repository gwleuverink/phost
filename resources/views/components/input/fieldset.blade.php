@props([
    'legend' => false,
    'bordered' => isset($bordered),
])

<fieldset @class([
    'relative pt-6 mt-10 pb-4 border-gray-300',
    'border-t' => !$bordered,
    'ring-1 ring-inset ring-gray-300 shadow-sm px-4 rounded-lg' => $bordered,
])>

    <legend class="absolute -top-2.5 left-2 inline-block select-none bg-white px-1 text-sm font-medium text-gray-700">
        {{ $legend }}
    </legend>

    <div {{ $attributes->class('flex') }}>
        {{ $slot }}
    </div>

</fieldset>
