
<main class="flex w-full h-screen">


    @persist('scrollbar')

        <section
            wire:scroll
            class="flex flex-col w-4/12 h-full pt-3 overflow-y-scroll min-w-72 bg-gray-50"
        >

            <label class="px-3">
                <input class="w-full p-4 transition duration-200 bg-gray-100 rounded-lg focus:outline-none focus:ring-2" placeholder="Search...">
            </label>


            <ul class="mt-6">

                @forelse($messages as $message)

                    <li wire:key="{{ $message->id }}">

                        <a wire:navigate href="{{ route('inbox', $message->id) }}">
                            <x-message-list-item
                                :$message
                                {{-- x-bind:class="{ '!bg-neutral-200': {{ $message->id }} === $wire.selectedMessageId }" --}}
                            />
                        </a>

                    </li>

                @empty

                    <li class="block w-full px-4 py-5 font-medium text-center text-neutral-600">
                        Inbox zero 🎉
                    </li>

                @endforelse

            </ul>

        </section>

    @endpersist


    @if($this->message)


        <x-message wire:key="message" :message="$this->message" />


    @else


        <section wire:key="no-message" class="flex items-center justify-around w-full h-full px-4 bg-white">

            <x-heroicon-o-envelope class="w-44 h-44 text-neutral-200" />

        </section>


    @endif

</main>
