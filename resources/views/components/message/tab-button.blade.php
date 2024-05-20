<button
    x-tabs:tab
    type="button"
    class="cursor-default rounded-md px-3 py-1 transition"
    x-bind:class="{
        'text-sm text-neutral-400': true,
        'bg-neutral-100 text-neutral-500 shadow-inner dark:bg-neutral-200 dark:text-neutral-800': $tab.isSelected,
        'hover:bg-neutral-100 hover:text-neutral-500 hover:dark:bg-neutral-200 hover:dark:text-neutral-800': !$tab.isSelected,
    }"
>
    {{ $slot }}
</button>
