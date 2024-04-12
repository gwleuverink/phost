<main
    wire:poll.keep-alive.6s="supervisor"
    x-on:keydown.meta.r.prevent="
        window.location.href = '/{{ $this->message?->id }}';
    "
    class="flex h-screen w-full"
>

    <section class="flex h-full w-4/12 min-w-80 flex-col overflow-y-scroll bg-gray-50 pt-3">

        <label class="px-3">
            <input
                placeholder="Search..."
                wire:model.live="search"
                class="w-full rounded-lg bg-gray-100 p-4 transition duration-200 focus:outline-none focus:ring-2"
            >
        </label>

        <ul class="mt-6">

            @forelse ($this->inbox as $message)
                <li wire:key="{{ $message->id }}">

                    <button
                        wire:click="selectMessage({{ $message->id }})"
                        class="w-full"
                    >
                        <x-message.list-item
                            :$message
                            :selected="$message->id === $selectedMessageId"
                        />
                    </button>

                </li>

            @empty

                <li class="block w-full px-4 py-5 text-center text-neutral-500">
                    @if ($search)
                        Nothing found 🙈
                    @else
                        Inbox zero 🎉
                    @endif
                </li>
            @endforelse

        </ul>

    </section>

    @if ($this->message)
        <x-message
            wire:key="message"
            :message="$this->message"
        />
    @else
        <section
            wire:key="no-message"
            class="flex h-full w-full items-center justify-around bg-white px-4"
        >
            <x-heroicon-o-envelope
                class="size-48 text-neutral-200"
                stroke-width="1"
            />
        </section>
    @endif

</main>
