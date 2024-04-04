@use('ZBateson\MailMimeParser\Header\HeaderConsts', 'Header')

@props([
    'message'
])


@php
    $parsed = $message->parsed()
@endphp


<section {{ $attributes }} class="flex flex-col w-full px-4 overflow-y-scroll bg-white">

    <div class="flex items-center justify-between flex-shrink-0 h-48 mb-8 border-b">

        <div class="flex flex-col">
            <h3 class="text-lg font-semibold">
                {{ $parsed->getHeaderValue(Header::SUBJECT) }}
            </h3>

            <p class="text-gray-400 text-light">
                willem@gedachtegoed.nl
            </p>
        </div>

        <div>

            <ul class="flex space-x-4 text-gray-400">

                <li class="w-6 h-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
                    </svg>
                </li>

                <li class="w-6 h-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </li>

                <li class="w-6 h-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                </li>

                <li class="w-6 h-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </li>

                <li class="w-6 h-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                </li>

            </ul>

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
