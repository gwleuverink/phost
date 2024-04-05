@props([
    'message'
])

@php
    $parsed = $message->parsed();
@endphp

<x-message.panel class="px-6 py-4">

    <pre class="text-sm text-neutral-600">{{ $parsed->getTextContent() ?? 'No text version provided' }}</pre>

</x-message.panel>
