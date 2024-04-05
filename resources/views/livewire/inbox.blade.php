
<main
    x-on:keydown.meta.r.prevent="
        window.location.href = '/{{ $this->message?->id }}';
    "
    class="flex w-full h-screen"
>


    <section class="flex flex-col w-4/12 h-full pt-3 overflow-y-scroll bg-gray-50 min-w-80">

        <label class="px-3">
            <input wire:model.live="search" class="w-full p-4 transition duration-200 bg-gray-100 rounded-lg focus:outline-none focus:ring-2" placeholder="Search...">
        </label>


        <ul class="mt-6">

            @forelse($this->inbox as $message)

                <li wire:key="{{ $message->id }}">

                    <button
                        wire:click="selectMessage({{ $message->id }})"
                        class="w-full"
                    >
                        <x-message-list-item
                            :$message
                            :selected="$message->id === $selectedMessageId"
                        />
                    </button>

                </li>

            @empty

                <li class="block w-full px-4 py-5 text-center text-neutral-500">
                    @if($search)
                        Nothing found 🙈
                    @else
                        Inbox zero 🎉
                    @endif
                </li>

            @endforelse

        </ul>

    </section>


    @if($this->message)

        <x-message wire:key="message" :message="$this->message" />

    @else

        <section wire:key="no-message" class="flex items-center justify-around w-full h-full px-4 bg-white">
            <x-heroicon-o-envelope class="size-48 text-neutral-200" stroke-width="1" />
        </section>

    @endif

</main>
