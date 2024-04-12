@props([
    'message'
])

<x-message.panel class="px-6 py-4">

    <pre class="text-sm text-neutral-600">{{ $message->content }}</pre>

</x-message.panel>