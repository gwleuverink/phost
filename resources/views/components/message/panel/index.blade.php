<div x-tabs:panel>
    <div
        class="mb-4 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-md dark:ring-neutral-700"
        x-cloak
    >
        <div {{ $attributes->class('overflow-x-auto') }}>
            {{ $slot }}
        </div>
    </div>
</div>
