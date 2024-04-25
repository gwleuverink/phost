<button
    x-tabs:tab
    type="button"
    class="cursor-default rounded-md px-3 py-1 transition"
    x-bind:class="$tab.isSelected ? 'bg-neutral-100 text-neutral-500 shadow-inner' : 'hover:bg-neutral-100 hover:text-neutral-500'"
>
    {{ $slot }}
</button>
