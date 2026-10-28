{{-- Global document preview modal (mock). Triggered via Alpine.store('preview').show(...)
     z-index sengaja sangat tinggi (z-[90]) agar selalu tampil DI DEPAN modal lain
     (mis. modal Kelola pengajuan / Detail penyetaraan yang memakai z-[70]/z-[80]). --}}
<div x-data x-show="$store.preview.open" x-cloak
     class="fixed inset-0 z-[90] grid place-items-center p-4 bg-black/50"
     @keydown.escape.window="$store.preview.close()"
     @click.self="$store.preview.close()">
    <div class="bg-white rounded-xl w-full max-w-3xl shadow-2xl overflow-hidden" x-transition>
        <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3 min-w-0">
                <span class="w-9 h-9 rounded-lg bg-rose-50 text-rose-600 grid place-items-center shrink-0">
                    @include('partials.icon', ['name' => 'file', 'class' => 'w-5 h-5'])
                </span>
                <div class="min-w-0">
                    <div class="font-semibold text-slate-800 text-sm truncate" x-text="$store.preview.name"></div>
                    <div class="text-xs text-slate-400" x-text="$store.preview.meta"></div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button @click="sigapToast('Berkas diunduh (mock): ' + $store.preview.name, 'teal')"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded border border-slate-300 text-slate-600 text-sm font-medium hover:bg-slate-50">
                    @include('partials.icon', ['name' => 'download', 'class' => 'w-4 h-4']) Unduh
                </button>
                <button @click="$store.preview.close()" class="w-8 h-8 grid place-items-center rounded-full hover:bg-slate-100 text-slate-500">
                    @include('partials.icon', ['name' => 'x', 'class' => 'w-5 h-5'])
                </button>
            </div>
        </div>

        {{-- Fake PDF viewer surface --}}
        <div class="bg-slate-100 p-6 max-h-[70vh] overflow-y-auto">
            {{-- Jika dokumen gabungan, tampilkan daftar bagian --}}
            <template x-if="$store.preview.parts.length">
                <div class="mb-4 rounded-lg bg-white border border-slate-200 p-4">
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Isi Berkas Gabungan</div>
                    <ol class="list-decimal list-inside space-y-1 text-sm text-slate-600">
                        <template x-for="(p, i) in $store.preview.parts" :key="i"><li x-text="p"></li></template>
                    </ol>
                </div>
            </template>
            {{-- Simulasi halaman PDF --}}
            <div class="mx-auto w-full max-w-xl space-y-4">
                <div class="bg-white rounded shadow-sm border border-slate-200 aspect-[1/1.3] p-8 flex flex-col">
                    <div class="h-3 w-2/3 bg-slate-200 rounded mb-4"></div>
                    <div class="space-y-2 flex-1">
                        <div class="h-2 bg-slate-100 rounded w-full"></div>
                        <div class="h-2 bg-slate-100 rounded w-11/12"></div>
                        <div class="h-2 bg-slate-100 rounded w-full"></div>
                        <div class="h-2 bg-slate-100 rounded w-4/5"></div>
                        <div class="h-24 bg-slate-50 border border-dashed border-slate-200 rounded mt-4 grid place-items-center text-xs text-slate-300">Pratinjau Dokumen (Mock)</div>
                        <div class="h-2 bg-slate-100 rounded w-full mt-4"></div>
                        <div class="h-2 bg-slate-100 rounded w-10/12"></div>
                    </div>
                    <div class="text-[10px] text-slate-300 text-center mt-4">Halaman 1 — pratinjau simulasi, bukan berkas nyata</div>
                </div>
            </div>
        </div>
    </div>
</div>
