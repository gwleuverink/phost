<main
    x-on:keydown.meta.r.prevent="
        {{-- Make sure we stay on the same page when refreshing (workaround for snappier UI) --}}
        window.location.href = '/{{ $this->message?->id }}';
    "
    class="flex w-full h-screen"
>

    <section class="flex flex-col w-4/12 h-full pt-8 overflow-y-scroll min-w-80 bg-gray-50 dark:bg-neutral-900">

        <label class="px-3">
            <input
                placeholder="Search..."
                wire:model.live="search"
                class="w-full p-4 transition duration-200 bg-gray-100 border-none rounded-lg focus:outline-none focus:ring-2 dark:bg-neutral-800 dark:text-neutral-300 dark:placeholder:text-neutral-400"
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

                <li class="block w-full px-4 py-5 text-center select-none text-neutral-500">
                    @if ($search)
                        Nothing found 🙈
                    @else
                        Inbox zero 🎉
                    @endif
                </li>
            @endforelse

        </ul>

    </section>

    <div class="w-full overflow-y-auto">

        @if ($this->message)
            <x-message
                wire:key="message"
                :message="$this->message"
            />
        @else
            <section
                wire:key="no-message"
                class="flex flex-col items-center justify-center w-full h-full px-4 bg-white dark:bg-neutral-950"
            >
                <x-heroicon-o-envelope
                    class="size-48 text-neutral-200 dark:text-neutral-500"
                    stroke-width="1"
                />

                <x-input.button
                    level="secondary"
                    x-on:click="$dispatch('open-settings-dialog')"
                    class="flex items-center"
                >
                    <x-heroicon-c-cog-6-tooth class="mr-1 size-3 text-neutral-400 dark:text-neutral-600" />
                    settings
                </x-input.button>
            </section>
        @endif

    </div>

    {{-- Dialogs --}}
    <x-dialog
        x-on:open-settings-dialog.window="open()"
        x-on:close-settings-dialog.window="close()"
    >
        <x-dialog.panel>
            <h2 class="mb-3 font-semibold text-neutral-700 dark:text-neutral-200">Configuration</h2>

            <livewire:settings />
        </x-dialog.panel>
    </x-dialog>

</main>
