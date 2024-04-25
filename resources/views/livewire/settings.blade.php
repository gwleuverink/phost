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
