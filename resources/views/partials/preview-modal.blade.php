<div x-data="{
        trapFocus(event) {
            const focusable = [...$refs.panel.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex=\'-1\'])')];
            if (!focusable.length) return;
            const first = focusable[0];
            const last = focusable[focusable.length - 1];
            if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
            if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
        }
     }"
     x-show="$store.preview.open" x-cloak
     class="fixed inset-0 z-[60] grid place-items-center bg-black/55 p-3 sm:p-4"
     @keydown.escape.window="$store.preview.close()"
     @keydown.tab="trapFocus($event)"
     @click.self="$store.preview.close()">
    <section id="document-preview-dialog" x-ref="panel" role="dialog" aria-modal="true" aria-labelledby="document-preview-title"
             class="sigap-dialog-panel w-full max-w-3xl overflow-hidden rounded-xl border border-slate-200 bg-white" x-transition>
        <header class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-4 py-3 sm:px-5">
            <div class="flex min-w-0 items-center gap-3">
                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-md bg-rose-50 text-rose-700" aria-hidden="true">
                    @include('partials.icon', ['name' => 'file', 'class' => 'w-5 h-5'])
                </span>
                <div class="min-w-0">
                    <h2 id="document-preview-title" class="truncate text-sm font-semibold text-slate-900" x-text="$store.preview.name"></h2>
                    <p class="text-xs text-slate-500" x-text="$store.preview.meta"></p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" @click="sigapToast('Simulasi unduh: ' + $store.preview.name, 'teal')"
                        class="inline-flex min-h-11 items-center gap-2 rounded-md border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    @include('partials.icon', ['name' => 'download', 'class' => 'w-4 h-4']) Unduh
                </button>
                <button type="button" data-dialog-close @click="$store.preview.close()"
                        class="grid h-11 w-11 place-items-center rounded-md text-slate-600 hover:bg-slate-100"
                        aria-label="Tutup pratinjau dokumen">
                    @include('partials.icon', ['name' => 'x', 'class' => 'w-5 h-5'])
                </button>
            </div>
        </header>

        <div class="max-h-[calc(100dvh-8rem)] overflow-y-auto bg-slate-100 p-3 sm:p-6">
            <template x-if="$store.preview.parts.length">
                <section class="mb-4 rounded-lg border border-slate-200 bg-white p-4" aria-labelledby="document-sections-title">
                    <h3 id="document-sections-title" class="mb-2 text-xs font-semibold text-slate-700">Isi berkas gabungan</h3>
                    <ol class="list-inside list-decimal space-y-1 text-sm text-slate-700">
                        <template x-for="(part, index) in $store.preview.parts" :key="index"><li x-text="part"></li></template>
                    </ol>
                </section>
            </template>

            <div class="mx-auto w-full max-w-xl">
                <div class="flex aspect-[1/1.3] flex-col rounded-sm border border-slate-300 bg-white p-5 shadow-sm sm:p-8" aria-label="Simulasi halaman pertama dokumen">
                    <div class="mb-4 h-3 w-2/3 rounded bg-slate-300"></div>
                    <div class="flex-1 space-y-2" aria-hidden="true">
                        <div class="h-2 w-full rounded bg-slate-200"></div>
                        <div class="h-2 w-11/12 rounded bg-slate-200"></div>
                        <div class="h-2 w-full rounded bg-slate-200"></div>
                        <div class="h-2 w-4/5 rounded bg-slate-200"></div>
                        <div class="mt-4 grid h-24 place-items-center rounded border border-dashed border-slate-300 bg-slate-50 text-xs text-slate-500">Pratinjau dokumen simulasi</div>
                        <div class="mt-4 h-2 w-full rounded bg-slate-200"></div>
                        <div class="h-2 w-10/12 rounded bg-slate-200"></div>
                    </div>
                    <div class="mt-4 text-center text-xs text-slate-500">Halaman 1. Berkas ini hanya simulasi untuk prototype.</div>
                </div>
            </div>
        </div>
    </section>
</div>
