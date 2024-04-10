@use('ZBateson\MailMimeParser\Header\HeaderConsts', 'Header')

@props([
    'message',
    'selected' => false
])

<div {{ $attributes }}
    @class([
        "flex items-center block w-full px-4 py-5 transition border-b cursor-default",
        "shadow-inner bg-neutral-200" => $selected,
        "hover:bg-neutral-100" => !$selected,
    ])
>

    <div class="flex items-center">

        {{-- ping --}}
        @unless($message->read_at)
            <span wire:key="unread-ping" class="relative flex w-3 h-3 mr-3">
                <span class="absolute inline-flex w-full h-full rounded-full opacity-75 animate-ping bg-sky-400"></span>
                <span class="relative inline-flex w-3 h-3 rounded-full bg-sky-500"></span>
            </span>
        @endunless

        {{-- bookmark --}}
        @if($message->bookmarked)
            <x-heroicon-m-bookmark wire:key="bookmark-icon" class="w-3.5 h-3.5 mr-2.5 text-rose-600" />
        @endif

    </div>

    <div class="w-full">

        <div class="flex items-center justify-between">
            <h3 @class([
                'text-lg font-medium text-neutral-600 transition-colors',
                '!text-neutral-700' => $selected,
            ])>
                {{ $message->parsed->getHeaderValue(Header::FROM) ?? $message->parsed->getHeaderValue(Header::SENDER) }}
            </h3>

            <p @class([
                'text-sm text-neutral-400 transition-colors',
                '!text-neutral-500' => $selected,
            ])>
                {{ $message->created_at->diffForHumans() }}
            </p>
        </div>

        <div @class([
            'text-base italic text-left text-neutral-400 transition-colors',
            '!text-neutral-500' => $selected,
        ])>
            {{ $message->parsed->getHeaderValue(Header::SUBJECT) }}
        </div>

    </div>
</div>
