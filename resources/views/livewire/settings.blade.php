@use(\App\Enums\Framework)

<div class="space-y-2">
    {{-- <p>Choose a framework to connect to PHOST</p> --}}

    <div class="flex flex-row px-2 space-x-4">
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

    <x-support.config :framework="$this->selectedFramework" />

    {{-- <p>Choose a SMTP port</p> --}}

    <form
        action=""
        class="pt-4"
    >
        <x-input.text label="Port" />

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
