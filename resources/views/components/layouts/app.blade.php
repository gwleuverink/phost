@php
    $config = resolve(\App\Settings\Config::class);
@endphp

<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="{{ $config->theme !== 'system' ? $config->theme : null }}"
>

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>{{ $title ?? 'Page Title' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <x-support.title-spacer />

    {{ $slot }}

    <x-support.dialog-provider />
</body>

@livewireScriptConfig

</html>
