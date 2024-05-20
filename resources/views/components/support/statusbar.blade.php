@props([
    'online' => false,
])

{{-- Status bar --}}
<div class="sticky bottom-0 left-0 right-0 select-none bg-inherit px-4 py-1.5 shadow-inner dark:shadow-neutral-800">

    {{-- Online status --}}
    <div class="flex items-center space-x-2">
        <span class="relative flex h-3 w-3">
            <span @class([
                'absolute inline-flex w-full h-full rounded-full opacity-75 transition-all',
                'bg-rose-400 animate-ping' => !$online,
            ])></span>

            <span @class([
                'relative inline-flex w-3 h-3 rounded-full transition-all',
                'bg-rose-500' => !$online,
                'bg-emerald-500 dark:bg-emerald-600' => $online,
            ])></span>
        </span>

        <span class="text-xs text-neutral-700 dark:text-neutral-300">{{ $online ? 'online' : 'offline' }}</span>
    </div>

</div>
