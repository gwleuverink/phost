@use('ZBateson\MailMimeParser\Header\HeaderConsts', 'Header')

@props([
    'message'
])

@php
    $parsed = $message->parsed();
@endphp

<section {{ $attributes }}
    x-tabs
    x-title="message-view"
    x-model="selectedTabIndex"
    x-data="{
        selectedTabIndex: 0,
    }"
    class="flex flex-col w-full px-4 overflow-y-scroll bg-white"
>

    <div class="relative flex items-center justify-between flex-shrink-0 h-48 mb-3">

        <div x-title="header-data" x-data="{ open: false }" class="flex">

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

            <button x-on:click="Helpers.print(@js($parsed->getHtmlContent() ?? $parsed->getTextContent()))" class="transition-colors cursor-default hover:text-neutral-500">
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

        {{-- tab list --}}
        <nav x-tabs:list class="absolute bottom-0 flex space-x-2 text-sm text-neutral-400">
            <x-message.tab-button>
                Preview
            </x-message.tab-button>

            <x-message.tab-button>
                Source
            </x-message.tab-button>

            <x-message.tab-button>
                Text
            </x-message.tab-button>

            <x-message.tab-button>
                Raw
            </x-message.tab-button>

            <x-message.tab-button>
                Headers
            </x-message.tab-button>
        </nav>
    </div>

    {{-- tab panels --}}
    <section x-tabs:panels x-cloak>

        <x-message.panel.preview :$message />
        <x-message.panel.source :$message />
        <x-message.panel.text :$message />
        <x-message.panel.raw :$message />
        <x-message.panel.headers :$message />

    </section>

</section>
