@use('ZBateson\MailMimeParser\Header\HeaderConsts', 'Header')

@props(['message'])

<x-message.panel>

    <iframe
        wire:key="hmtl-preview-{{ str()->random(6) }}"
        x-title="html-preview"
        x-data="{
            resize: () => $nextTick(
                () => setTimeout(() => $el.style.height = $el.contentDocument.body?.scrollHeight + 1 + 'px')
            )
        }"
        srcdoc="{{ $message->parsed->getHtmlContent() ?? $message->parsed->getTextContent() }}"
        x-on:resize.window.debounce="resize()"
        x-intersect:enter="resize()"
        x-on:load="resize()"
        x-init="resize()"
        x-cloak
        frameborder="0"
        class="!min-h-[calc(100vh + 45px)] w-full"
    ></iframe>

</x-message.panel>
