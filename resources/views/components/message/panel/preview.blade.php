@props([
    'message'
])

@php
    $parsed = $message->parsed();
@endphp

<x-message.panel>

    <iframe
        x-title="html-preview"
        x-data="{
            resize: () => $nextTick(function() {
                setTimeout(
                    () => $el.style.height = $el.contentDocument.body?.scrollHeight +'px',
                    10 // Might need some tweaking
                )
            })
        }"
        srcdoc="{{ $parsed->getHtmlContent() ?? $parsed->getTextContent() }}"
        x-on:reload-message-preview.window="selectedTabIndex = 0; $nextTick(() => resize())"
        x-on:resize.window.debounce="resize()"
        x-on:load="resize()"
        x-init="resize()"
        x-cloak

        frameborder="0"
        class="w-full !min-h-[calc(100vh + 45px)]"
    ></iframe>

</x-message.panel>
