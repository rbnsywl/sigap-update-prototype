{{-- Global toast stack (bottom-right). Triggered via sigapToast('msg','tone') --}}
<div x-data class="fixed bottom-5 right-5 z-[70] space-y-2 w-80 pointer-events-none">
    <template x-for="t in $store.toast.items" :key="t.id">
        <div x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-end="opacity-0 translate-y-1"
             class="pointer-events-auto flex items-start gap-3 bg-white rounded-lg shadow-lg border px-4 py-3"
             :class="{
                'border-teal-200': t.tone==='teal',
                'border-green-200': t.tone==='green',
                'border-rose-200': t.tone==='rose',
                'border-amber-200': t.tone==='amber',
                'border-blue-200': t.tone==='blue'
             }">
            <span class="mt-0.5 w-5 h-5 rounded-full grid place-items-center shrink-0 text-white"
                  :class="{
                    'bg-teal-500': t.tone==='teal',
                    'bg-green-500': t.tone==='green',
                    'bg-rose-500': t.tone==='rose',
                    'bg-amber-500': t.tone==='amber',
                    'bg-blue-500': t.tone==='blue'
                  }">
                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6 9 17l-5-5"/></svg>
            </span>
            <div class="text-sm text-slate-700 flex-1" x-text="t.msg"></div>
            <button @click="$store.toast.remove(t.id)" class="text-slate-300 hover:text-slate-500">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>
    </template>
</div>
