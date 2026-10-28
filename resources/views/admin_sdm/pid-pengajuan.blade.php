@extends('layouts.app')
@section('title', 'Pengajuan Masuk PID')
@section('breadcrumb', 'Studi PID / Pengajuan Masuk')

@section('content')
<div x-data="{
        open:false,
        current:{},
        files:[],
        setStatus:'',
        openKelola(row, files){ this.current=row; this.files=files; this.setStatus=row.kelola; this.open=true; },
        simpan(aksi){
            this.open=false;
            const peta = {
                'Perlu Revisi':['Pengajuan '+this.current.id+' dikembalikan ke dosen untuk revisi','rose'],
                'Diproses':['Pengajuan '+this.current.id+' ditandai sedang Diproses','blue'],
                'Selesai':['Pengajuan '+this.current.id+' ditetapkan Selesai','green'],
                'catatan':['Catatan untuk '+this.current.id+' tersimpan','teal'],
            };
            const [msg,tone] = peta[aksi] || ['Perubahan disimpan','teal'];
            sigapToast(msg, tone);
        }
     }">
    @include('partials.page-head', ['heading' => 'Pengajuan Masuk PID', 'sub' => 'Review izin belajar & registrasi beasiswa doktoral — unduh berkas, beri catatan, lalu revisi / proses / selesaikan.'])

    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-6 py-3 font-semibold">ID</th><th class="px-6 py-3 font-semibold">Dosen</th>
                <th class="px-6 py-3 font-semibold">Universitas Tujuan</th><th class="px-6 py-3 font-semibold">Skema</th>
                <th class="px-6 py-3 font-semibold">Plafon</th><th class="px-6 py-3 font-semibold">Status Kelola</th><th class="px-6 py-3 font-semibold text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($pid as $p)
                    @php $berkas = \App\Support\MockData::berkasPengajuanPid($p['id']); @endphp
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-6 py-3.5 font-medium text-slate-700 tnum">{{ $p['id'] }}</td>
                        <td class="px-6 py-3.5 text-slate-700">{{ $p['dosen'] }}<div class="text-xs text-slate-400 tnum">{{ $p['nip'] }} · {{ $p['prodi'] }}</div></td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $p['universitas'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $p['skema'] }}</td>
                        <td class="px-6 py-3.5 font-medium text-teal-600 tnum">{{ \App\Support\MockData::rupiah($p['plafon']) }}</td>
                        <td class="px-6 py-3.5">@include('partials.badge', ['label' => $p['kelola'], 'tone' => $statuses[$p['kelola']] ?? 'slate'])</td>
                        <td class="px-6 py-3.5 text-right">
                            <button type="button"
                                    @click="openKelola(@js($p), @js($berkas))"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-xs font-semibold transition active:scale-[0.98]">
                                @include('partials.icon', ['name' => 'settings', 'class' => 'w-3.5 h-3.5']) Kelola
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ===== Modal Kelola ===== --}}
    <div x-show="open" x-cloak class="fixed inset-0 z-[70] grid place-items-center p-4 bg-black/50"
         @keydown.escape.window="open=false" @click.self="open=false">
        <div class="bg-white rounded-xl w-full max-w-2xl shadow-2xl overflow-hidden flex flex-col max-h-[92vh]" x-transition>
            {{-- Header --}}
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between shrink-0">
                <div class="min-w-0">
                    <h3 class="font-semibold text-slate-800">Kelola Pengajuan PID</h3>
                    <div class="text-xs text-slate-400 tnum"><span x-text="current.id"></span> · <span x-text="current.dosen"></span></div>
                </div>
                <button @click="open=false" class="w-8 h-8 grid place-items-center rounded-full hover:bg-slate-100 text-slate-500">
                    @include('partials.icon', ['name' => 'x', 'class' => 'w-5 h-5'])
                </button>
            </div>

            <div class="p-6 space-y-6 overflow-y-auto">
                {{-- Ringkas --}}
                <dl class="grid grid-cols-2 gap-x-6 gap-y-2 text-sm">
                    <div><dt class="text-slate-400">Universitas Tujuan</dt><dd class="font-medium text-slate-700" x-text="current.universitas"></dd></div>
                    <div><dt class="text-slate-400">Prodi Tujuan</dt><dd class="font-medium text-slate-700" x-text="current.prodi_tujuan"></dd></div>
                    <div><dt class="text-slate-400">Skema</dt><dd class="font-medium text-slate-700" x-text="current.skema"></dd></div>
                    <div><dt class="text-slate-400">Tgl Masuk</dt><dd class="font-medium text-slate-700" x-text="current.tanggal"></dd></div>
                </dl>

                {{-- Berkas dari dosen: Preview + Unduh --}}
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-sm font-medium text-slate-700">Berkas Pengajuan dari Dosen</span>
                        <span class="text-xs text-slate-400">(<span x-text="files.length"></span> berkas)</span>
                        <button type="button" @click="sigapToast('Mengunduh semua berkas '+current.id+' (ZIP)', 'teal')"
                                class="ml-auto inline-flex items-center gap-1.5 px-2.5 py-1 rounded border border-slate-300 text-slate-600 text-xs font-medium hover:border-teal-400 hover:text-teal-600 transition">
                            @include('partials.icon', ['name' => 'download', 'class' => 'w-3.5 h-3.5']) Unduh Semua (ZIP)
                        </button>
                    </div>
                    <div class="rounded-lg border border-slate-200 divide-y divide-slate-50 overflow-hidden">
                        <template x-for="(f,idx) in files" :key="idx">
                            <div class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50/60">
                                <span class="w-9 h-9 rounded-lg bg-rose-50 text-rose-600 grid place-items-center shrink-0">
                                    @include('partials.icon', ['name' => 'file', 'class' => 'w-4 h-4'])
                                </span>
                                <div class="min-w-0 flex-1">
                                    <div class="text-sm font-medium text-slate-800 truncate" x-text="f.nama"></div>
                                    <div class="text-xs text-slate-400"><span x-text="f.ukuran"></span> · diunggah <span x-text="f.tanggal"></span></div>
                                </div>
                                <div class="flex items-center gap-1.5 shrink-0">
                                    <button type="button" @click="$store.preview.show(f.nama, f.ukuran+' · '+f.oleh, [])"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded border border-slate-300 text-slate-600 text-xs font-medium hover:border-teal-400 hover:text-teal-600 transition">
                                        @include('partials.icon', ['name' => 'eye', 'class' => 'w-3.5 h-3.5']) Preview
                                    </button>
                                    <button type="button" @click="sigapToast('Mengunduh: '+f.nama, 'teal')"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded border border-slate-300 text-slate-600 text-xs font-medium hover:border-teal-400 hover:text-teal-600 transition">
                                        @include('partials.icon', ['name' => 'download', 'class' => 'w-3.5 h-3.5']) Unduh
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Catatan admin --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Catatan untuk Dosen</label>
                    <textarea rows="3" x-ref="catatan" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none"
                              placeholder="Tuliskan catatan verifikasi / instruksi revisi…"></textarea>
                    <div class="mt-2 text-right">
                        <button type="button" @click="simpan('catatan')"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded border border-slate-300 text-slate-600 text-xs font-semibold hover:bg-slate-50">
                            @include('partials.icon', ['name' => 'edit', 'class' => 'w-3.5 h-3.5']) Simpan Catatan
                        </button>
                    </div>
                </div>
            </div>

            {{-- Footer: keputusan status --}}
            <div class="px-6 py-4 border-t border-slate-100 flex flex-wrap items-center justify-end gap-3 shrink-0 bg-slate-50/60">
                <span class="mr-auto text-xs text-slate-400">Pilih tindak lanjut pengajuan</span>
                <button type="button" @click="simpan('Perlu Revisi')"
                        class="px-4 py-2 rounded border border-rose-300 text-rose-600 text-sm font-semibold hover:bg-rose-50 inline-flex items-center gap-1.5">
                    @include('partials.icon', ['name' => 'x', 'class' => 'w-4 h-4']) Minta Revisi
                </button>
                <button type="button" @click="simpan('Diproses')"
                        class="px-4 py-2 rounded border border-blue-300 text-blue-600 text-sm font-semibold hover:bg-blue-50 inline-flex items-center gap-1.5">
                    @include('partials.icon', ['name' => 'clock', 'class' => 'w-4 h-4']) Tandai Diproses
                </button>
                <button type="button" @click="simpan('Selesai')"
                        class="px-4 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-1.5">
                    @include('partials.icon', ['name' => 'check', 'class' => 'w-4 h-4']) Tetapkan Selesai
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
