@extends('layouts.app')
@section('title', 'Reimburs Biaya')
@section('breadcrumb', 'Studi PID / Reimburs Biaya')

@section('content')
    @php
        $total = \App\Support\MockData::rupiah(11000000);
        $proses = \App\Support\MockData::rupiah(1500000);
        $toneMap = ['Selesai'=>'green','Diproses'=>'amber','Ditolak'=>'rose'];
    @endphp

    <div class="mb-6 flex items-start gap-2 text-sm text-teal-800 bg-teal-50 border border-teal-100 rounded-lg px-4 py-3">
        @include('partials.icon', ['name' => 'help', 'class' => 'w-4 h-4 shrink-0 mt-0.5'])
        <span>Ajukan reimburs dengan mengunggah eviden dalam 1 file PDF beserta rincian biaya. Admin SDM akan memproses via Nota Dinas Elektronik (NDE) ke SDM Pusat Universitas.</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        {{-- Form --}}
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">Pengajuan Reimburs</h3></div>
            <div class="p-6 space-y-5" x-data="{ nominal:'' , fmt(){ let n=this.nominal.replace(/\D/g,''); this.nominal = n? 'Rp '+Number(n).toLocaleString('id-ID') : ''; } }">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori Biaya <span class="text-rose-500">*</span></label>
                    <select class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                        <option>Biaya BPP Kuliah</option>
                        <option>Biaya Buku Referensi Disertasi</option>
                        <option>Biaya Publikasi Jurnal Terindeks Scopus</option>
                        <option>Biaya Operasional Penelitian Lapangan</option>
                        <option>Biaya Transportasi Akademik</option>
                        <option>Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Semester Terkait</label>
                    <select class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                        <option value="">— (non-semesteran)</option><option>Semester 5</option><option>Semester 4</option><option>Semester 3</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nominal Diajukan <span class="text-rose-500">*</span></label>
                    <input x-model="nominal" @input="fmt()" inputmode="numeric" placeholder="Rp 0" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none tnum">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Keterangan Penggunaan <span class="text-rose-500">*</span></label>
                    <textarea rows="3" placeholder="Rincian belanja & tanggal nota fisik…" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Eviden (1 PDF, maks 10MB)</label>
                    @include('partials.dropzone', ['label' => 'Gabungkan faktur, kuitansi, bukti transfer'])
                </div>
                <button type="button" @click="sigapToast('Reimburs diajukan — menunggu proses Admin SDM', 'green')" class="w-full px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center justify-center gap-2 transition active:scale-[0.98]">
                    @include('partials.icon', ['name' => 'send', 'class' => 'w-4 h-4'])
                    Ajukan Reimburs
                </button>
            </div>
        </div>

        {{-- History + summary --}}
        <div class="lg:col-span-3 space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-lg border border-slate-200 p-5">
                    <div class="text-sm text-slate-500">Total Direimburs</div>
                    <div class="mt-2 text-2xl font-bold text-green-600 tnum">{{ $total }}</div>
                    <div class="text-xs text-slate-400 mt-1">Akumulasi dana cair</div>
                </div>
                <div class="bg-white rounded-lg border border-slate-200 p-5">
                    <div class="text-sm text-slate-500">Sedang Diproses</div>
                    <div class="mt-2 text-2xl font-bold text-amber-600 tnum">{{ $proses }}</div>
                    <div class="text-xs text-slate-400 mt-1">Dalam antrean NDE SDM Pusat</div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-800">Riwayat Klaim</h3>
                    <input placeholder="Cari…" class="rounded border border-slate-300 px-3 py-1.5 text-sm w-40 focus:border-teal-500 outline-none">
                </div>
                <table class="w-full text-sm">
                    <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-3 font-semibold">Tanggal</th>
                        <th class="px-6 py-3 font-semibold">Kategori</th>
                        <th class="px-6 py-3 font-semibold text-right">Nominal</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                    </tr></thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($rows as $r)
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-6 py-3.5 text-slate-500">{{ $r['tanggal'] }}</td>
                                <td class="px-6 py-3.5 text-slate-700">{{ $r['kategori'] }}</td>
                                <td class="px-6 py-3.5 text-right font-medium text-slate-800 tnum">{{ \App\Support\MockData::rupiah($r['nominal']) }}</td>
                                <td class="px-6 py-3.5">@include('partials.badge', ['label' => $r['status'], 'tone' => $toneMap[$r['status']] ?? 'slate'])</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
