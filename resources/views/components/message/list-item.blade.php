@use('ZBateson\MailMimeParser\Header\HeaderConsts', 'Header')

@props(['message', 'selected' => false])

<div
    {{ $attributes }}
    @class([
        'flex items-center block w-full px-4 py-5 transition border-b cursor-default dark:border-neutral-800',
        'shadow-inner bg-neutral-200 dark:bg-neutral-800 dark:shadow-neutral-800' => $selected,
        'hover:bg-neutral-100 dark:hover:bg-neutral-700' => !$selected,
    ])
>

    <div class="flex items-center">

        {{-- ping --}}
        @unless ($message->read_at)
            <span
                wire:key="unread-ping"
                class="relative mr-3 flex h-3 w-3"
            >
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-sky-400 opacity-75"></span>
                <span class="relative inline-flex h-3 w-3 rounded-full bg-sky-500"></span>
            </span>
        @endunless

        {{-- bookmark --}}
        @if ($message->bookmarked)
            <x-heroicon-m-bookmark
                wire:key="bookmark-icon"
                class="mr-2.5 h-3.5 w-3.5 text-rose-600"
            />
        @endif

    </div>

    <div class="w-full">

        <div class="flex items-center justify-between">
            <h3 @class([
                'text-lg font-medium transition-colors',
                'text-neutral-600 dark:text-neutral-100' => !$selected,
                'text-neutral-700 dark:text-white' => $selected,
            ])>
                {{ $message->parsed->getHeaderValue(Header::FROM) ?? $message->parsed->getHeaderValue(Header::SENDER) }}
            </h3>

            <p @class([
                'text-sm transition-colors',
                'text-neutral-400 dark:text-neutral-200' => !$selected,
                'text-neutral-500 dark:text-neutral-300' => $selected,
            ])>
                {{ $message->created_at->diffForHumans() }}
            </p>
        </div>

        <div @class([
            'text-base italic text-left transition-colors',
            'text-neutral-400 dark:text-neutral-200' => !$selected,
            'text-neutral-500 dark:text-neutral-300' => $selected,
        ])>
            {{ $message->parsed->getHeaderValue(Header::SUBJECT) }}
        </div>

    </div>
</div>
