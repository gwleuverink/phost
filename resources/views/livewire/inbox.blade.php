<main
    wire:poll.keep-alive.6s="supervisor"
    x-on:keydown.meta.r.prevent="
        window.location.href = '/{{ $this->message?->id }}';
    "
    class="flex w-full h-screen"
>

    <section class="flex flex-col w-4/12 h-full pt-3 overflow-y-scroll min-w-80 bg-gray-50">

        <label class="px-3">
            <input
                placeholder="Search..."
                wire:model.live="search"
                class="w-full p-4 transition duration-200 bg-gray-100 rounded-lg focus:outline-none focus:ring-2"
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
            class="flex flex-col items-center justify-center w-full h-full px-4 bg-white"
        >
            <x-heroicon-o-envelope
                class="size-48 text-neutral-200"
                stroke-width="1"
            />

            <x-input.button
                level="secondary"
                x-on:click="$dispatch('open-settings-dialog')"
                class="flex items-center"
            >
                <x-heroicon-c-cog-6-tooth class="mr-1 size-3 text-neutral-400" />
                settings
            </x-input.button>
        </section>
    @endif

    {{-- Dialogs --}}
    <x-dialog x-on:open-settings-dialog.window="open()">
        <x-dialog.panel>
            <h2 class="mb-2 font-semibold">Configuration</h2>

            <livewire:settings />
        </x-dialog.panel>
    </x-dialog>

</main>
