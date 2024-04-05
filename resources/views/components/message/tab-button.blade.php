<button x-tabs:tab
    type="button"
    class="px-3 py-1 transition rounded-md cursor-default"
    x-bind:class="$tab.isSelected ? 'bg-neutral-100 text-neutral-500 shadow-inner': 'hover:bg-neutral-100 hover:text-neutral-500'"
>
    {{ $slot }}
</button>
