{{-- Reusable evidence/document viewer.
     Props:
       $files  = array of ['nama','ukuran','tanggal','oleh', optional 'bagian'=>[]]
       $title  = optional heading (default: "Berkas Terunggah")
     Setiap berkas punya tombol Preview (buka modal) & Unduh (toast).
--}}
@php $title = $title ?? 'Berkas Terunggah'; @endphp
<div>
    <div class="flex items-center gap-2 mb-2">
        <span class="text-sm font-medium text-slate-700">{{ $title }}</span>
        <span class="text-xs text-slate-400">({{ count($files) }} berkas)</span>
    </div>
    <div class="rounded-lg border border-slate-200 divide-y divide-slate-50 overflow-hidden">
        @forelse($files as $f)
            @php $parts = $f['bagian'] ?? []; @endphp
            <div class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50/60">
                <span class="w-9 h-9 rounded-lg bg-rose-50 text-rose-600 grid place-items-center shrink-0">
                    @include('partials.icon', ['name' => 'file', 'class' => 'w-4 h-4'])
                </span>
                <div class="min-w-0 flex-1">
                    <div class="text-sm font-medium text-slate-800 truncate">{{ $f['nama'] }}</div>
                    <div class="text-xs text-slate-400">{{ $f['ukuran'] }} · diunggah {{ $f['tanggal'] }} · oleh {{ $f['oleh'] }}</div>
                </div>
                <div class="flex items-center gap-1.5 shrink-0">
                    <button type="button"
                            @click="sigapPreview(@js($f['nama']), @js($f['ukuran'].' · '.$f['oleh']), @js($parts))"
                            class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded border border-slate-300 text-slate-600 text-xs font-medium hover:border-teal-400 hover:text-teal-600 transition">
                        @include('partials.icon', ['name' => 'eye', 'class' => 'w-3.5 h-3.5']) Preview
                    </button>
                    <button type="button"
                            @click="sigapToast(@js('Mengunduh: '.$f['nama']), 'teal')"
                            class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded border border-slate-300 text-slate-600 text-xs font-medium hover:border-teal-400 hover:text-teal-600 transition">
                        @include('partials.icon', ['name' => 'download', 'class' => 'w-3.5 h-3.5']) Unduh
                    </button>
                </div>
            </div>
        @empty
            <div class="px-4 py-6 text-center text-sm text-slate-400">Belum ada berkas terunggah.</div>
        @endforelse
    </div>
</div>
