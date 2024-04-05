@use('ZBateson\MailMimeParser\Header\HeaderConsts', 'Header')

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
            resize: () => $nextTick(
                () => $el.style.height = $el.contentDocument.body?.scrollHeight +'px'
            )
        }"
        srcdoc="{{ $parsed->getHtmlContent() ?? $parsed->getTextContent() }}"
        x-on:reload-message-preview.window="$nextTick(() => resize())"
        x-on:resize.window.debounce="resize()"
        x-intersect:enter="resize()"
        x-on:load="resize()"
        x-init="resize()"
        x-cloak

        frameborder="0"
        class="w-full !min-h-[calc(100vh + 45px)]"
    ></iframe>

</x-message.panel>
