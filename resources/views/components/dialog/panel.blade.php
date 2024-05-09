<template x-teleport="#dialog-provider">
    <div
        {{ $attributes }}
        x-dialog
        x-model="dialogOpen"
        style="display: none"
        class="fixed inset-0 z-10 overflow-y-auto pt-[30%] text-left text-neutral-800 sm:pt-0"
    >
        <!-- Overlay -->
        <div
            x-dialog:overlay
            x-transition:enter.opacity
            class="fixed inset-0 bg-black/25 backdrop-blur transition-colors dark:bg-neutral-100/15"
        ></div>

        <!-- Panel -->
        <div class="relative flex min-h-full items-end justify-center p-0 sm:items-center sm:p-4">
            <div
                x-dialog:panel
                x-transition.in.out
                class="relative w-full max-w-3xl overflow-hidden rounded-t-xl bg-white shadow-lg transition-colors sm:rounded-b-xl dark:bg-neutral-950"
            >
                <!-- Mobile: Top "grab" handle... -->
                <div
                    class="absolute left-0 right-0 top-[-10px] h-[50px] sm:hidden"
                    x-data="{ startY: 0, currentY: 0, moving: false, get distance() { return this.moving ? Math.max(0, this.currentY - this.startY) : 0 } }"
                    x-on:touchstart="moving = true; startY = currentY = $event.touches[0].clientY"
                    x-on:touchmove="currentY = $event.touches[0].clientY"
                    x-on:touchend="if (distance > 100) $dialog.close(); moving = false;"
                    x-effect="$el.parentElement.style.transform = 'translateY('+distance+'px)'"
                >
                    <div class="flex justify-center pt-[12px]">
                        <div class="h-[5px] w-[10%] rounded-full bg-gray-400"></div>
                    </div>
                </div>

                <!-- Close Button -->
                <div class="absolute right-0 top-0 pr-4 pt-4">
                    <button
                        type="button"
                        x-on:click="$dialog.close()"
                        class="cursor-default rounded-lg bg-gray-50 p-1 text-gray-600 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-600 focus-visible:ring-offset-2 dark:bg-neutral-800 dark:text-neutral-100"
                    >
                        <span class="sr-only">Close modal</span>
                        <x-heroicon-m-x-mark class="h-5 w-5" />
                    </button>
                </div>

                <!-- Panel -->
                <div class="p-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</template>
