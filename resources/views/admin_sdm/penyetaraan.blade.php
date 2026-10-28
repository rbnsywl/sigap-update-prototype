@extends('layouts.app')
@section('title', 'Kelola Penyetaraan S3')
@section('breadcrumb', 'Penyetaraan S3 / Kelola')

@section('content')
@php
    // Siapkan payload JS ringkas + progres asesor untuk tiap baris.
    $prep = collect($rows)->map(function ($r) {
        $done = collect($r['asesor'] ?? [])->where('done', true)->count();
        $tot = count($r['asesor'] ?? []);
        return array_merge($r, ['asesor_done' => $done, 'asesor_total' => $tot]);
    })->values();
    $files = \App\Support\MockData::evidencePenyetaraan();
@endphp

<div x-data="{
        open:false, current:{},
        distribusi:false, ba:false, revisi:false,
        openDetail(row){ this.current=row; this.open=true; },
        toast(msg, tone){ sigapToast(msg, tone||'teal'); }
     }">
    @include('partials.page-head', ['heading' => 'Kelola Penyetaraan Ijazah S3', 'sub' => 'Validasi berkas, distribusi ke asesor, & pelaporan ke SDM Pusat. Klik Detail untuk mengelola satu pengajuan.'])

    {{-- Ringkasan statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        @php
            $cNeedVal = $prep->whereIn('status', ['Validasi Admin SDM'])->count();
            $cRevisi  = $prep->where('status', 'Perlu Revisi')->count();
            $cNilai   = $prep->where('status', 'Penilaian Internal Asesor')->count();
            $cDone    = $prep->where('status', 'Selesai')->count();
        @endphp
        @include('partials.stat-card', ['label' => 'Perlu Validasi Awal', 'value' => $cNeedVal, 'tone' => 'amber', 'icon' => 'inbox'])
        @include('partials.stat-card', ['label' => 'Perlu Revisi Dosen', 'value' => $cRevisi, 'tone' => 'rose', 'icon' => 'edit'])
        @include('partials.stat-card', ['label' => 'Penilaian Asesor', 'value' => $cNilai, 'tone' => 'blue', 'icon' => 'users'])
        @include('partials.stat-card', ['label' => 'Selesai', 'value' => $cDone, 'tone' => 'green', 'icon' => 'check'])
    </div>

    {{-- ===== TABEL (ganti tumpukan kartu / infinite scroll) ===== --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-800">Daftar Pengajuan Penyetaraan S3</h3>
            <input placeholder="Cari dosen / ID…" class="rounded border border-slate-300 px-3 py-1.5 text-sm w-56 focus:border-teal-500 outline-none">
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                    <th class="px-6 py-3 font-semibold">ID</th>
                    <th class="px-6 py-3 font-semibold">Dosen</th>
                    <th class="px-6 py-3 font-semibold">PT Asal S3</th>
                    <th class="px-6 py-3 font-semibold">Tgl Masuk</th>
                    <th class="px-6 py-3 font-semibold">Progres Asesor</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                </tr></thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($prep as $r)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-6 py-3.5 font-medium text-slate-700 tnum">{{ $r['id'] }}</td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-teal-600 text-white grid place-items-center text-xs font-semibold">{{ $r['avatar'] }}</div>
                                    <div>
                                        <div class="font-medium text-slate-800">{{ $r['dosen'] }}</div>
                                        <div class="text-xs text-slate-400">{{ $r['prodi'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 text-slate-600">{{ $r['pt'] }}</td>
                            <td class="px-6 py-3.5 text-slate-500">{{ $r['tanggal'] }}</td>
                            <td class="px-6 py-3.5">
                                @if($r['asesor_total'])
                                    <div class="flex items-center gap-2">
                                        <div class="w-24 h-2 rounded-full bg-slate-100 overflow-hidden">
                                            <div class="h-full bg-teal-500" style="width: {{ (int) round($r['asesor_done'] / max(1,$r['asesor_total']) * 100) }}%"></div>
                                        </div>
                                        <span class="text-xs text-slate-500 tnum">{{ $r['asesor_done'] }}/{{ $r['asesor_total'] }}</span>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5">@include('partials.badge', ['label' => $r['status'], 'tone' => $statuses[$r['status']] ?? 'slate'])</td>
                            <td class="px-6 py-3.5 text-right">
                                <button type="button" @click="openDetail(@js($r))"
                                        class="text-teal-600 font-semibold hover:underline text-sm">Detail</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== Modal Detail / Aksi (satu pengajuan) ===== --}}
    <div x-show="open" x-cloak class="fixed inset-0 z-[70] grid place-items-center p-4 bg-black/50"
         @keydown.escape.window="open=false" @click.self="open=false">
        <div class="bg-white rounded-xl w-full max-w-3xl shadow-2xl overflow-hidden flex flex-col max-h-[92vh]" x-transition>
            {{-- Header --}}
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-11 h-11 rounded-full bg-teal-600 text-white grid place-items-center font-semibold shrink-0" x-text="current.avatar"></div>
                    <div class="min-w-0">
                        <h3 class="font-semibold text-slate-800 truncate" x-text="current.dosen"></h3>
                        <div class="text-xs text-slate-400 tnum"><span x-text="current.id"></span> · <span x-text="current.prodi"></span> · <span x-text="current.tanggal"></span></div>
                    </div>
                </div>
                <button @click="open=false" class="w-8 h-8 grid place-items-center rounded-full hover:bg-slate-100 text-slate-500">
                    @include('partials.icon', ['name' => 'x', 'class' => 'w-5 h-5'])
                </button>
            </div>

            <div class="p-6 space-y-6 overflow-y-auto">
                {{-- Info disertasi --}}
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                    <div class="sm:col-span-2"><dt class="text-slate-400">Judul Disertasi</dt><dd class="font-medium text-slate-800" x-text="current.judul_disertasi"></dd></div>
                    <div><dt class="text-slate-400">PT Asal S3</dt><dd class="font-medium text-slate-700" x-text="current.pt"></dd></div>
                    <div><dt class="text-slate-400">Kelompok Keahlian</dt><dd class="font-medium text-slate-700" x-text="current.kk"></dd></div>
                </dl>

                {{-- Berkas gabungan dosen --}}
                @include('partials.evidence', ['title' => 'Berkas Gabungan dari Dosen', 'files' => $files])

                {{-- Progres asesor (jika sudah didistribusi) --}}
                <template x-if="current.asesor && current.asesor.length">
                    <div>
                        <div class="text-xs text-slate-500 mb-2"><span x-text="current.asesor_done"></span> dari <span x-text="current.asesor_total"></span> Asesor telah mengunggah nilai</div>
                        <div class="grid grid-cols-3 gap-3">
                            <template x-for="(a,idx) in current.asesor" :key="idx">
                                <div class="rounded-lg border p-3" :class="a.done ? 'border-green-200 bg-green-50' : 'border-slate-200 bg-slate-50'">
                                    <div class="flex items-center gap-2 text-xs font-semibold" :class="a.done ? 'text-green-700' : 'text-slate-500'">
                                        <span x-text="a.done ? '✓' : '⏳'"></span>
                                        <span x-text="a.peran"></span>
                                    </div>
                                    <div class="text-xs text-slate-500 mt-1" x-text="a.nama"></div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                {{-- Catatan revisi (jika Perlu Revisi) --}}
                <template x-if="current.status === 'Perlu Revisi' && current.catatan_admin">
                    <div class="flex items-start gap-3 bg-yellow-50 border border-yellow-200 rounded-lg px-4 py-3">
                        @include('partials.icon', ['name' => 'help', 'class' => 'w-5 h-5 text-yellow-600 shrink-0 mt-0.5'])
                        <span class="text-sm text-yellow-700" x-text="current.catatan_admin"></span>
                    </div>
                </template>
            </div>

            {{-- Footer: aksi kontekstual sesuai status --}}
            <div class="px-6 py-4 border-t border-slate-100 flex flex-wrap items-center justify-end gap-3 shrink-0 bg-slate-50/60">
                {{-- Belum ada asesor & belum selesai → validasi awal / distribusi --}}
                <template x-if="(!current.asesor || current.asesor.length === 0) && current.status !== 'Perlu Revisi'">
                    <div class="flex items-center gap-3 w-full justify-end">
                        <button type="button" @click="revisi=true"
                                class="px-4 py-2 rounded border border-rose-300 text-rose-600 text-sm font-semibold hover:bg-rose-50">Kembalikan — Perlu Revisi</button>
                        <button type="button" @click="distribusi=true"
                                class="px-4 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2">
                            @include('partials.icon', ['name' => 'users', 'class' => 'w-4 h-4']) Distribusi ke 3 Asesor
                        </button>
                    </div>
                </template>
                {{-- Penilaian berjalan, semua asesor selesai → Berita Acara --}}
                <template x-if="current.asesor && current.asesor.length && current.asesor_done === current.asesor_total && current.status !== 'Selesai'">
                    <button type="button" @click="ba=true"
                            class="px-4 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2">
                        @include('partials.icon', ['name' => 'report', 'class' => 'w-4 h-4']) Buat Berita Acara & Lapor NDE
                    </button>
                </template>
                {{-- Penilaian masih berjalan → info --}}
                <template x-if="current.asesor && current.asesor.length && current.asesor_done < current.asesor_total">
                    <span class="text-sm text-slate-500">Menunggu seluruh asesor menyelesaikan penilaian.</span>
                </template>
                {{-- Perlu revisi → kirim pengingat --}}
                <template x-if="current.status === 'Perlu Revisi'">
                    <button type="button" @click="toast('Pengingat revisi dikirim ke '+current.dosen, 'amber'); open=false"
                            class="px-4 py-2 rounded bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold inline-flex items-center gap-2">
                        @include('partials.icon', ['name' => 'send', 'class' => 'w-4 h-4']) Kirim Pengingat Revisi
                    </button>
                </template>
                {{-- Selesai → unduh berita acara --}}
                <template x-if="current.status === 'Selesai'">
                    <button type="button" @click="toast('Mengunduh Berita Acara '+current.id+' (PDF)', 'teal')"
                            class="px-4 py-2 rounded border border-slate-300 text-slate-600 text-sm font-semibold inline-flex items-center gap-2">
                        @include('partials.icon', ['name' => 'download', 'class' => 'w-4 h-4']) Unduh Berita Acara
                    </button>
                </template>
            </div>
        </div>
    </div>

    {{-- Distribusi modal --}}
    <div x-show="distribusi" x-cloak class="fixed inset-0 z-[80] grid place-items-center p-4 bg-black/40" @click.self="distribusi=false">
        <div class="bg-white rounded-xl w-full max-w-md shadow-xl">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">Distribusi ke Tim Asesor</h3>
                <button @click="distribusi=false" class="text-slate-400">@include('partials.icon', ['name' => 'x', 'class' => 'w-5 h-5'])</button>
            </div>
            <div class="p-6 space-y-2">
                @foreach(['Ketua Kelompok Keahlian (KK)','Ketua Program Studi (Kaprodi)','Dekan / Wakil Dekan'] as $a)
                    <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" checked class="w-4 h-4 rounded text-teal-500 focus:ring-teal-500">
                        <span class="text-sm text-slate-700">{{ $a }}</span>
                    </label>
                @endforeach
            </div>
            <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3">
                <button @click="distribusi=false" class="px-4 py-2 rounded border border-slate-300 text-sm font-medium text-slate-600">Batal</button>
                <button @click="distribusi=false; open=false; toast('Berkas '+current.id+' didistribusikan ke 3 asesor', 'green')" class="px-4 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold">Distribusikan</button>
            </div>
        </div>
    </div>

    {{-- Revisi modal --}}
    <div x-show="revisi" x-cloak class="fixed inset-0 z-[80] grid place-items-center p-4 bg-black/40" @click.self="revisi=false">
        <div class="bg-white rounded-xl w-full max-w-md shadow-xl">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">Kembalikan untuk Revisi</h3>
                <button @click="revisi=false" class="text-slate-400">@include('partials.icon', ['name' => 'x', 'class' => 'w-5 h-5'])</button>
            </div>
            <div class="p-6 space-y-3">
                <label class="block text-sm font-medium text-slate-700">Alasan / catatan revisi <span class="text-rose-500">*</span></label>
                <textarea rows="4" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none" placeholder="cth: Scan ijazah tidak terbaca, mohon unggah ulang…"></textarea>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3">
                <button @click="revisi=false" class="px-4 py-2 rounded border border-slate-300 text-sm font-medium text-slate-600">Batal</button>
                <button @click="revisi=false; open=false; toast(current.id+' dikembalikan ke dosen untuk revisi', 'rose')" class="px-4 py-2 rounded bg-rose-500 hover:bg-rose-600 text-white text-sm font-semibold">Kirim Revisi</button>
            </div>
        </div>
    </div>

    {{-- Berita Acara modal --}}
    <div x-show="ba" x-cloak class="fixed inset-0 z-[80] grid place-items-center p-4 bg-black/40" @click.self="ba=false">
        <div class="bg-white rounded-xl w-full max-w-md shadow-xl">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">Berita Acara & Pelaporan NDE</h3>
                <button @click="ba=false" class="text-slate-400">@include('partials.icon', ['name' => 'x', 'class' => 'w-5 h-5'])</button>
            </div>
            <div class="p-6 space-y-4">
                <button class="w-full px-4 py-2.5 rounded border border-teal-500 text-teal-600 text-sm font-semibold hover:bg-teal-50 inline-flex items-center justify-center gap-2">
                    @include('partials.icon', ['name' => 'download', 'class' => 'w-4 h-4']) Generate Berita Acara Rapat Penyetaraan
                </button>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor NDE Pengantar ke SDM Pusat <span class="text-rose-500">*</span></label>
                    <input placeholder="cth: NDE/FEB/SDM/X/2026/201" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none tnum">
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3">
                <button @click="ba=false" class="px-4 py-2 rounded border border-slate-300 text-sm font-medium text-slate-600">Batal</button>
                <button @click="ba=false; open=false; toast('Berita Acara & NDE '+current.id+' dikirim ke SDM Pusat', 'green')" class="px-4 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold">Kirim ke SDM Pusat</button>
            </div>
        </div>
    </div>
</div>
@endsection
