{{-- Reusable "Preview Surat Tugas" modal.
     Renders the full A4 ST letter inside a scrollable dialog with a download action.

     Props:
       $row     = ST data array (dibutuhkan partials.st-letter)
       $trigger = teks tombol pemicu (default: "Preview Surat Tugas")
       $nomor   = (opsional) override nomor surat untuk header & letter
       $compact = (opsional, bool) tampilkan tombol kecil bergaya link

     Setiap instance punya scope Alpine sendiri sehingga aman dipakai berulang
     di dalam loop tabel.
--}}
@php
    $trigger = $trigger ?? 'Preview Surat Tugas';
    $nomorSurat = $nomor ?? ($row['nomor_surat'] ?? null);
    $compact = $compact ?? false;
@endphp

{{-- CSS scaler: muat sekali saja. Menyusutkan surat A4 (794px) agar pas di dalam
     dialog tanpa menyisakan ruang kosong, dan responsif di layar sempit. --}}
@once
    <style>
        /* Surat A4 = 794x1123px. Diskalakan dengan --st-scale lalu lebar & tinggi
           kotak pembungkus ikut disusutkan agar tidak ada ruang kosong / overflow. */
        .st-preview-scaler {
            --st-scale: 1;
            width: calc(794px * var(--st-scale));
            height: calc(1123px * var(--st-scale));
            max-width: 100%;
        }
        .st-preview-scaler > .st-a4 {
            transform: scale(var(--st-scale));
            transform-origin: top left;
        }
        @media (max-width: 900px) { .st-preview-scaler { --st-scale: 0.80; } }
        @media (max-width: 760px) { .st-preview-scaler { --st-scale: 0.64; } }
        @media (max-width: 560px) { .st-preview-scaler { --st-scale: 0.46; } }
        @media (max-width: 440px) { .st-preview-scaler { --st-scale: 0.36; } }
    </style>
@endonce
<div x-data="{ open:false }" class="inline-block">
    @if($compact)
        <button type="button" @click="open=true"
                class="text-teal-600 font-semibold hover:underline text-sm inline-flex items-center gap-1">
            @include('partials.icon', ['name' => 'eye', 'class' => 'w-4 h-4']) {{ $trigger }}
        </button>
    @else
        <button type="button" @click="open=true"
                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded border border-slate-300 text-slate-600 text-xs font-semibold hover:border-teal-400 hover:text-teal-600 transition">
            @include('partials.icon', ['name' => 'eye', 'class' => 'w-3.5 h-3.5']) {{ $trigger }}
        </button>
    @endif

    {{-- Modal --}}
    <div x-show="open" x-cloak
         class="fixed inset-0 z-[70] grid place-items-center p-4 bg-black/50"
         @keydown.escape.window="open=false"
         @click.self="open=false">
        <div class="bg-white rounded-xl w-full max-w-[860px] shadow-2xl overflow-hidden flex flex-col max-h-[92vh]" x-transition>
            {{-- Header --}}
            <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="w-9 h-9 rounded-lg bg-teal-50 text-teal-600 grid place-items-center shrink-0">
                        @include('partials.icon', ['name' => 'doc', 'class' => 'w-5 h-5'])
                    </span>
                    <div class="min-w-0">
                        <div class="font-semibold text-slate-800 text-sm truncate">Pratinjau Surat Tugas — {{ $row['id'] ?? '' }}</div>
                        <div class="text-xs text-slate-400 tnum">{{ $nomorSurat ? 'Nomor: '.$nomorSurat : 'Draf — belum bernomor' }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <button type="button"
                            @click="sigapToast(@js('Mengunduh Surat Tugas '.($nomorSurat ?? ($row['id'] ?? '')).' (PDF)'), 'teal')"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold">
                        @include('partials.icon', ['name' => 'download', 'class' => 'w-4 h-4']) Unduh PDF
                    </button>
                    <button type="button" @click="open=false" class="w-8 h-8 grid place-items-center rounded-full hover:bg-slate-100 text-slate-500">
                        @include('partials.icon', ['name' => 'x', 'class' => 'w-5 h-5'])
                    </button>
                </div>
            </div>

            {{-- Body: A4 letter on a grey canvas.
                 Surat berukuran tetap 794px (A4). Agar rapi & tidak terpotong di
                 layar sempit, bungkus pakai wrapper ber-scale yang JUGA menyusutkan
                 tinggi kotaknya (pakai padding-ratio) sehingga tidak ada ruang kosong. --}}
            <div class="bg-slate-200/70 p-5 sm:p-8 overflow-y-auto grid place-items-center">
                <template x-if="open">
                    <div class="st-preview-scaler">
                        @include('partials.st-letter', ['row' => $row, 'nomor' => $nomorSurat])
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
