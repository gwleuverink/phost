@use('ZBateson\MailMimeParser\Header\HeaderConsts', 'Header')

@props(['message'])

<section
    {{ $attributes }}
    x-tabs
    x-title="message-view"
    x-model="selectedTabIndex"
    x-data="{
        selectedTabIndex: 0,
    }"
    class="flex w-full flex-col overflow-y-scroll bg-white px-4"
>

    <div class="relative mb-3 flex h-48 flex-shrink-0 items-center justify-between">

        <div
            x-title="header-data"
            x-data="{ open: false }"
            class="flex"
        >

            <button
                x-on:click="open = !open"
                class="cursor-default p-2 text-gray-400 transition-colors hover:text-neutral-500"
            >
                <x-heroicon-m-chevron-right
                    class="h-5 w-5 transition-transform"
                    ::class="{ 'rotate-90': open }"
                />
            </button>

            <div class="flex flex-col">

                <h3 class="text-lg font-semibold">
                    {{ $message->parsed->getHeaderValue(Header::SUBJECT) }}

                    <span
                        x-cloak
                        x-transition
                        x-show="open"
                        class="mx-1 text-base font-normal text-neutral-400"
                    >
                        &lt;{{ $message->parsed->getHeaderValue(Header::FROM) }}&gt;
                    </span>
                </h3>

                <p class="text-light text-neutral-400">
                    To: {{ $message->parsed->getHeaderValue(Header::TO) }}
                </p>

            </div>

        </div>

        <div class="flex space-x-4 text-neutral-400">

            <button
                wire:click="selectPrevious"
                class="cursor-default transition-colors hover:text-neutral-500"
            >
                <x-heroicon-o-arrow-left-circle class="size-6" />
            </button>

            <button
                wire:click="selectNext"
                class="cursor-default transition-colors hover:text-neutral-500"
            >
                <x-heroicon-o-arrow-right-circle class="size-6" />
            </button>

            <button
                x-on:click="Helpers.print(@js($message->parsed->getHtmlContent() ?? $message->parsed->getTextContent()))"
                class="cursor-default transition-colors hover:text-neutral-500"
            >
                <x-heroicon-o-printer class="size-6" />
            </button>

            <button
                wire:click="deleteMessage({{ $message->id }})"
                class="cursor-default transition-colors hover:text-neutral-500"
            >
                <x-heroicon-o-trash class="size-6" />
            </button>

            <button
                wire:click="toggleBookmark({{ $message->id }})"
                class="cursor-default transition-colors hover:text-neutral-500"
            >
                @if ($message->bookmarked)
                    <x-heroicon-o-bookmark
                        fill="currentColor"
                        class="size-6 text-rose-500 transition-colors hover:text-rose-600"
                    />
                @else
                    <x-heroicon-o-bookmark class="size-6" />
                @endif
            </button>

        </div>

        {{-- tab list --}}
        <nav
            x-tabs:list
            class="absolute bottom-0 flex space-x-2 text-sm text-neutral-400"
        >
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
    <section
        x-cloak
        x-tabs:panels
    >

        <x-message.panel.preview :$message />
        <x-message.panel.source :$message />
        <x-message.panel.text :$message />
        <x-message.panel.raw :$message />
        <x-message.panel.headers :$message />

    </section>

</section>
