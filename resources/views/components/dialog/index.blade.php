<div
    x-modelable="dialogOpen"
    x-on:keydown.esc.window="dialogOpen = false"
    x-data="{
        dialogOpen: false,
        open: function() {
            this.dialogOpen = true
        },
        close: function() {
            this.dialogOpen = false
        }
    }"
    {{ $attributes }}
    tabindex="-1"
>
    {{ $slot }}
</div>
