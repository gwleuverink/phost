@props(['message'])

<x-message.panel class="px-6 py-4 dark:bg-neutral-900">

    <pre class="text-sm text-neutral-600 dark:text-neutral-300">{{ $message->content }}</pre>

</x-message.panel>
