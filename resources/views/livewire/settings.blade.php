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

        {{-- Color scheme --}}
        <x-input.fieldset
            legend="Color scheme"
            class="space-x-4"
        >

            <x-input.radio
                wire:model="color_scheme"
                label="system"
                value="system"
            />

            <x-input.radio
                wire:model="color_scheme"
                value="light"
            >
                <x-slot:label
                    class="flex"
                >
                    <x-heroicon-c-sun class="mr-1 size-4 text-neutral-600" /> light
                </x-slot:label>
            </x-input.radio>

            <x-input.radio
                wire:model="color_scheme"
                value="dark"
            >
                <x-slot:label
                    class="flex"
                >
                    <x-heroicon-c-moon class="mr-1 size-4 text-neutral-600" /> dark
                </x-slot:label>
            </x-input.radio>

        </x-input.fieldset>

        {{-- Danger zone --}}
        <x-input.fieldset legend="Danger zone">

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

        </x-input.fieldset>

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
