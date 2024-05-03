@use(\App\Enums\Framework)

<div class="space-y-2">

    <div class="flex flex-row space-x-4 px-2">
        @foreach (Framework::cases() as $framework)
            <x-input.radio
                wire:model.live="framework"
                :wire:key="$framework->value"
                :value="$framework->value"
                :label="$framework->value"
            />
        @endforeach
    </div>

    <x-support.divider />

    <x-support.config
        :framework="$this->selectedFramework"
        :$port
    />

    <form
        wire:submit="save"
        class="pt-6"
        novalidate
    >
        <x-input.text
            label="Port"
            wire:model.lazy="port"
            inputmode="numeric"
            pattern="[0-9]"
            maxlength="4"
            x-mask="9999"
        />

        {{-- Danger zone --}}
        <div>

            <h2 class="-mb-2 mt-6 text-base font-semibold text-neutral-700">Danger zone</h2>
            <x-support.divider />

            <x-input.button
                type="button"
                level="danger"
                wire:click="clearInbox"
                wire:confirm="Are you sure you want to delete all messages?"
                class="flex items-center"
            >
                <x-heroicon-c-trash class="mr-1 size-3" />
                Clear inbox
            </x-input.button>
        </div>

        <x-dialog.footer>
            <x-input.button
                type="button"
                level="secondary"
                x-on:click="close()"
            >
                Cancel
            </x-input.button>

            <x-input.button type="submit">
                Save
            </x-input.button>
        </x-dialog.footer>
    </form>

</div>
