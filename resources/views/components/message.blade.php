@use('ZBateson\MailMimeParser\Header\HeaderConsts', 'Header')

@props([
    'message'
])


@php
    $parsed = $message->parsed()
@endphp


<section {{ $attributes }} class="flex flex-col w-full px-4 overflow-y-scroll bg-white">

    <div class="flex items-center justify-between flex-shrink-0 h-48 mb-8 border-b">

        <div x-data="{ open: false }" class="flex">

            <button x-on:click="open = !open" class="p-2 text-gray-400 transition-colors cursor-default hover:text-neutral-500">
                <x-heroicon-m-chevron-right class="w-5 h-5 transition-transform" ::class="{ 'rotate-90': open }" />
            </button>

            <div class="flex flex-col">


                <h3 class="text-lg font-semibold">
                    {{ $parsed->getHeaderValue(Header::SUBJECT) }}

                    <span x-show="open" x-cloak x-transition class="mx-1 text-base font-normal text-neutral-400">
                        &lt;{{ $parsed->getHeaderValue(Header::FROM) }}&gt;
                    </span>
                </h3>

                <p class="text-neutral-400 text-light">
                    To: {{ $parsed->getHeaderValue(Header::TO) }}
                </p>

            </div>

        </div>

        <div class="flex space-x-4 text-neutral-400">

            <button class="transition-colors cursor-default hover:text-neutral-500">
                <x-heroicon-o-arrow-left-circle class="size-6" />
            </button>

            <button class="transition-colors cursor-default hover:text-neutral-500">
                <x-heroicon-o-arrow-right-circle class="size-6" />
            </button>

            <button class="transition-colors cursor-default hover:text-neutral-500">
                <x-heroicon-o-printer class="size-6" />
            </button>

            <button wire:click="deleteMessage({{ $message->id }})" class="transition-colors cursor-default hover:text-neutral-500 ">
                <x-heroicon-o-trash class="size-6" />
            </button>

            <button wire:click="toggleBookmark({{ $message->id }})" class="transition-colors cursor-default hover:text-neutral-500">
                @if($message->bookmarked)
                    <x-heroicon-o-bookmark class="transition-colors size-6 text-rose-500 hover:text-rose-600" fill="currentColor" />
                @else
                    <x-heroicon-o-bookmark class="size-6" />
                @endif
            </button>

        </div>

    </div>

    <section>

        <iframe
            x-data="{
                resize: () => $nextTick(function() {
                    $el.style.height = ($el.contentDocument.body.scrollHeight + 45) +'px'
                })
            }"
            srcdoc="{{ $parsed->getHtmlContent() ?? $parsed->getTextContent() }}"
            x-on:resize.window.debounce="resize()"
            x-on:load="resize()"
            x-init="resize()"
            x-cloak

            frameborder="0"
            class="w-full"
        ></iframe>

    </section>

</section>
