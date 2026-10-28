@extends('layouts.app')
@section('title', 'Detail Studi Dosen PID')
@section('breadcrumb', 'Studi PID / Monitoring / Detail')

@section('content')
@php
    $pemb = $studi['pembiayaan'];
    $pctBiaya = $pemb['plafon'] > 0 ? (int) round($pemb['realisasi'] / $pemb['plafon'] * 100) : 0;
    $rp = fn ($v) => \App\Support\MockData::rupiah((int) $v);
@endphp

<a href="/admin-sdm/pid/monitoring" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-teal-600 mb-4">← Kembali ke daftar monitoring</a>

<div x-data="{ tab: 'ringkasan' }">
    {{-- Profil dosen --}}
    <div class="bg-white rounded-lg border border-slate-200 p-6 flex flex-wrap items-center gap-4 mb-6">
        <div class="w-14 h-14 rounded-full bg-teal-600 text-white grid place-items-center text-lg font-bold">{{ $dosen['avatar'] }}</div>
        <div>
            <div class="font-semibold text-slate-900">{{ $dosen['dosen'] }}</div>
            <div class="text-sm text-slate-500 tnum">{{ $dosen['nip'] }} · {{ $dosen['prodi'] }}</div>
            <div class="text-sm text-slate-500 mt-0.5">{{ $dosen['universitas'] }} — {{ $dosen['prodi_tujuan'] }} · Skema {{ $dosen['skema'] }}</div>
        </div>
        <div class="ml-auto text-right">
            @include('partials.badge', ['label' => $dosen['kepatuhan'], 'tone' => ($dosen['kepatuhan']==='Tepat Waktu'?'green':($dosen['kepatuhan']==='Perlu Perhatian'?'amber':'rose'))])
            <div class="text-xs text-slate-400 mt-1 tnum">Semester {{ $dosen['semester_berjalan'] }}/{{ $dosen['durasi_total'] }}</div>
        </div>
    </div>

    {{-- Pemilih data yang ingin diperiksa (tab) --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-4 pt-3 border-b border-slate-100 flex flex-wrap gap-1">
            @php
                $tabs = [
                    'ringkasan'  => ['Ringkasan', 'chart'],
                    'lks'        => ['Pelaporan LKS', 'clipboard'],
                    'reimburs'   => ['Reimburs', 'wallet'],
                    'pembiayaan' => ['Pembiayaan & Catatan', 'report'],
                    'amandemen'  => ['Amandemen', 'doc'],
                ];
            @endphp
            @foreach($tabs as $key => [$label, $icon])
                <button type="button" @click="tab='{{ $key }}'"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium rounded-t-lg border-b-2 transition -mb-px"
                        :class="tab==='{{ $key }}' ? 'border-teal-500 text-teal-600 bg-teal-50/40' : 'border-transparent text-slate-500 hover:text-slate-700'">
                    @include('partials.icon', ['name' => $icon, 'class' => 'w-4 h-4']) {{ $label }}
                    @if($key === 'amandemen' && count($studi['amandemen']))
                        <span class="text-[10px] font-bold bg-indigo-500 text-white rounded-full px-1.5 py-0.5">{{ count($studi['amandemen']) }}</span>
                    @endif
                </button>
            @endforeach
        </div>

        <div class="p-6">
            {{-- ===== RINGKASAN ===== --}}
            <div x-show="tab==='ringkasan'" x-cloak>
                <p class="text-sm text-slate-500 mb-4">Pilih tab di atas untuk memeriksa data spesifik. Ringkasan cepat:</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="rounded-lg border border-slate-200 p-4">
                        <div class="text-xs text-slate-400">Laporan LKS</div>
                        <div class="text-2xl font-bold text-slate-900 tnum mt-1">{{ count($studi['lks']) }}</div>
                        <div class="text-xs text-slate-500 mt-1">semester dilaporkan</div>
                    </div>
                    <div class="rounded-lg border border-slate-200 p-4">
                        <div class="text-xs text-slate-400">Realisasi Pembiayaan</div>
                        <div class="text-2xl font-bold text-teal-600 tnum mt-1">{{ $pctBiaya }}%</div>
                        <div class="text-xs text-slate-500 mt-1 tnum">{{ $rp($pemb['realisasi']) }} dari {{ $rp($pemb['plafon']) }}</div>
                    </div>
                    <div class="rounded-lg border border-slate-200 p-4">
                        <div class="text-xs text-slate-400">Klaim Reimburs</div>
                        <div class="text-2xl font-bold text-slate-900 tnum mt-1">{{ count($studi['reimburs']) }}</div>
                        <div class="text-xs text-slate-500 mt-1">total pengajuan</div>
                    </div>
                </div>
            </div>

            {{-- ===== LKS ===== --}}
            <div x-show="tab==='lks'" x-cloak>
                <h3 class="font-semibold text-slate-800 mb-3">Pelaporan LKS per Semester</h3>
                <div class="rounded-lg border border-slate-200 overflow-hidden">
                    <table class="w-full text-sm">
                        <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                            <th class="px-4 py-3 font-semibold">Semester</th><th class="px-4 py-3 font-semibold">Tgl Lapor</th>
                            <th class="px-4 py-3 font-semibold">IPK</th><th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 font-semibold text-right">Berkas</th>
                        </tr></thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($studi['lks'] as $l)
                                <tr class="hover:bg-slate-50/60">
                                    <td class="px-4 py-3 font-medium text-slate-700">{{ $l['semester'] }}</td>
                                    <td class="px-4 py-3 text-slate-500">{{ $l['tanggal'] }}</td>
                                    <td class="px-4 py-3 text-slate-700 tnum">{{ number_format($l['ipk'], 2) }}</td>
                                    <td class="px-4 py-3">@include('partials.badge', ['label' => $l['status'], 'tone' => $lksStatuses[$l['status']] ?? 'slate'])</td>
                                    <td class="px-4 py-3 text-right">
                                        <button @click="$store.preview.show('LKS_{{ \Illuminate\Support\Str::slug($l['semester']) }}.pdf', '{{ $l['semester'] }} · {{ $dosen['dosen'] }}', ['Dokumen LKS (TTD Promotor)','Transkrip / KHS','Surat Keterangan Aktif','Bukti Transfer BPP'])"
                                                class="text-teal-600 font-semibold hover:underline text-sm inline-flex items-center gap-1">
                                            @include('partials.icon', ['name' => 'eye', 'class' => 'w-4 h-4']) Lihat
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ===== REIMBURS ===== --}}
            <div x-show="tab==='reimburs'" x-cloak>
                <h3 class="font-semibold text-slate-800 mb-3">Riwayat Reimburs</h3>
                <div class="rounded-lg border border-slate-200 overflow-hidden">
                    <table class="w-full text-sm">
                        <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                            <th class="px-4 py-3 font-semibold">Tanggal</th><th class="px-4 py-3 font-semibold">Kategori</th>
                            <th class="px-4 py-3 font-semibold">Semester</th><th class="px-4 py-3 font-semibold">Nominal</th><th class="px-4 py-3 font-semibold">Status</th>
                        </tr></thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($studi['reimburs'] as $rb)
                                <tr class="hover:bg-slate-50/60">
                                    <td class="px-4 py-3 text-slate-500">{{ $rb['tanggal'] }}</td>
                                    <td class="px-4 py-3 text-slate-700">{{ $rb['kategori'] }}</td>
                                    <td class="px-4 py-3 text-slate-500">{{ $rb['semester'] }}</td>
                                    <td class="px-4 py-3 font-medium text-slate-800 tnum">{{ $rp($rb['nominal']) }}</td>
                                    <td class="px-4 py-3">@include('partials.badge', ['label' => $rb['status'], 'tone' => $rb['status']==='Selesai'?'green':($rb['status']==='Diproses'?'blue':'rose')])</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ===== PEMBIAYAAN + CATATAN (digabung) ===== --}}
            <div x-show="tab==='pembiayaan'" x-cloak>
                <h3 class="font-semibold text-slate-800 mb-3">Rekap Pembiayaan</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
                    <div class="rounded-lg border border-slate-200 p-4"><div class="text-xs text-slate-400">Plafon</div><div class="text-xl font-bold text-slate-900 tnum mt-1">{{ $rp($pemb['plafon']) }}</div></div>
                    <div class="rounded-lg border border-slate-200 p-4"><div class="text-xs text-slate-400">Realisasi</div><div class="text-xl font-bold text-teal-600 tnum mt-1">{{ $rp($pemb['realisasi']) }}</div></div>
                    <div class="rounded-lg border border-slate-200 p-4"><div class="text-xs text-slate-400">Sisa</div><div class="text-xl font-bold text-slate-900 tnum mt-1">{{ $rp($pemb['sisa']) }}</div></div>
                </div>
                <div class="mb-6">
                    <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                        <span>Serapan plafon</span><span class="tnum">{{ $pctBiaya }}%</span>
                    </div>
                    <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden"><div class="h-full bg-teal-500" style="width: {{ $pctBiaya }}%"></div></div>
                </div>

                {{-- Catatan pembiayaan (fitur digabung di sini) --}}
                <div class="bg-amber-50 rounded-lg border border-amber-200 p-5">
                    <div class="flex items-center gap-2 text-amber-800 font-semibold text-sm mb-1">
                        @include('partials.icon', ['name' => 'shield', 'class' => 'w-4 h-4']) Catatan Pembiayaan (Internal SDM)
                    </div>
                    <p class="text-xs text-amber-700 mb-3">🔒 Catatan hanya terlihat oleh Admin SDM; tidak tampil di portal dosen.</p>
                    <textarea rows="4" class="w-full rounded border border-amber-300 bg-white px-3 py-2 text-sm focus:border-amber-500 outline-none"
                              placeholder="Catatan pembiayaan untuk {{ $dosen['dosen'] }}… (cth: sisa plafon kritis, perlu konfirmasi NDE)"></textarea>
                    <div class="flex items-center gap-2 mt-3">
                        <button @click="sigapToast('Catatan pembiayaan tersimpan', 'green')" class="px-3 py-2 rounded bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold">Simpan Catatan</button>
                        <a href="/admin-sdm/pid/pembiayaan" class="px-3 py-2 rounded border border-amber-300 text-amber-700 text-sm font-semibold hover:bg-amber-100 inline-flex items-center gap-1.5">
                            @include('partials.icon', ['name' => 'report', 'class' => 'w-4 h-4']) Buka Rincian Pembiayaan
                        </a>
                    </div>
                </div>
            </div>

            {{-- ===== AMANDEMEN ===== --}}
            <div x-show="tab==='amandemen'" x-cloak>
                <h3 class="font-semibold text-slate-800 mb-3">Amandemen / Perpanjangan Studi</h3>
                @if(count($studi['amandemen']))
                    <div class="space-y-3">
                        @foreach($studi['amandemen'] as $am)
                            <div class="rounded-lg border border-slate-200 p-4">
                                <div class="flex items-center justify-between">
                                    <div class="font-medium text-slate-800 tnum">{{ $am['nomor'] }}</div>
                                    @include('partials.badge', ['label' => $am['status'], 'tone' => $am['status']==='Disetujui'?'green':'amber'])
                                </div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $am['tanggal'] }}</div>
                                <p class="text-sm text-slate-600 mt-2">{{ $am['alasan'] }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-lg border border-dashed border-slate-200 p-8 text-center text-sm text-slate-400">
                        Belum ada amandemen untuk studi dosen ini.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
