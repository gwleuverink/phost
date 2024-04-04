@use('ZBateson\MailMimeParser\Header\HeaderConsts', 'Header')

@props([
    'message',
])


@php
    $parsed = $message->parsed()
@endphp


<div {{ $attributes }} @class([
    "block w-full px-4 py-5 transition border-b cursor-default hover:bg-neutral-100",
])>

    <div class="flex items-center justify-between">
        <h3 class="text-lg font-medium text-neutral-600">
            {{ $parsed->getHeaderValue(Header::FROM) ?? $parsed->getHeaderValue(Header::SENDER) }}
        </h3>

        <p class="text-neutral-400 text-md">
            {{ $message->created_at->diffForHumans() }}
        </p>
    </div>

    <div class="italic text-left text-neutral-400 text-md">
        {{ $parsed->getHeaderValue(Header::SUBJECT) }}
    </div>

</div>
