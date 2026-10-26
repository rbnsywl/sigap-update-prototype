<div x-data class="pointer-events-none fixed inset-x-3 bottom-3 z-[70] flex flex-col items-end gap-2 sm:inset-x-auto sm:bottom-5 sm:right-5 sm:w-96"
     aria-live="polite" aria-atomic="false">
    <template x-for="toast in $store.toast.items" :key="toast.id">
        <div role="status"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="translate-y-2 opacity-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-end="translate-y-1 opacity-0"
             class="pointer-events-auto flex w-full items-start gap-3 rounded-lg border bg-white px-4 py-3 shadow-lg"
             :class="{
                'border-teal-300': toast.tone === 'teal',
                'border-green-300': toast.tone === 'green',
                'border-rose-300': toast.tone === 'rose',
                'border-amber-300': toast.tone === 'amber',
                'border-blue-300': toast.tone === 'blue'
             }">
            <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full text-white"
                  :class="{
                    'bg-teal-600': toast.tone === 'teal',
                    'bg-green-700': toast.tone === 'green',
                    'bg-rose-700': toast.tone === 'rose',
                    'bg-amber-700': toast.tone === 'amber',
                    'bg-blue-700': toast.tone === 'blue'
                  }" aria-hidden="true">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6 9 17l-5-5"/></svg>
            </span>
            <div class="min-w-0 flex-1">
                <div class="text-[11px] font-semibold text-slate-500">Aksi prototype</div>
                <p class="text-sm text-slate-800" x-text="toast.message"></p>
            </div>
            <button type="button" @click="$store.toast.remove(toast.id)"
                    class="grid h-11 w-11 shrink-0 place-items-center rounded-md text-slate-600 hover:bg-slate-100"
                    aria-label="Tutup pemberitahuan">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>
    </template>
</div>
