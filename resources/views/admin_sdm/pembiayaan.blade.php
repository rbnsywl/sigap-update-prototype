@extends('layouts.app')
@section('title', 'Catatan Pembiayaan & Reimburs')
@section('breadcrumb', 'Studi PID / Pembiayaan')

@section('content')
@php $rp = fn($v) => \App\Support\MockData::rupiah($v); $pct = round($profil['semester_direimburs']/$profil['semester_total']*100); @endphp
<div x-data="{ tab:'semester', open:0, nde:false, ndeRow:'' }">

    {{-- Financial header --}}
    <div class="bg-white rounded-lg border border-slate-200 p-6 mb-6">
        <div class="flex flex-wrap items-center gap-4 mb-5">
            <div class="w-14 h-14 rounded-full bg-teal-600 text-white grid place-items-center text-lg font-bold">{{ $profil['avatar'] }}</div>
            <div>
                <div class="font-semibold text-slate-900">{{ $profil['nama'] }}</div>
                <div class="text-sm text-slate-500">{{ $profil['nip'] }} · {{ $profil['program'] }}</div>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
            <div class="rounded-lg bg-slate-50 p-4"><div class="text-xs text-slate-500">Total Plafon</div><div class="mt-1 text-lg font-bold text-slate-900 tnum">{{ $rp($profil['plafon']) }}</div></div>
            <div class="rounded-lg bg-green-50 p-4"><div class="text-xs text-green-700">Realisasi Cair</div><div class="mt-1 text-lg font-bold text-green-700 tnum">{{ $rp($profil['realisasi']) }}</div></div>
            <div class="rounded-lg bg-teal-50 p-4"><div class="text-xs text-teal-700">Sisa Plafon</div><div class="mt-1 text-lg font-bold text-teal-700 tnum">{{ $rp($profil['sisa']) }}</div></div>
            <div class="rounded-lg bg-slate-50 p-4"><div class="text-xs text-slate-500">Lama Beasiswa</div><div class="mt-1 text-lg font-bold text-slate-900">{{ $profil['lama'] }}</div></div>
        </div>
        <div>
            <div class="flex items-center justify-between text-xs text-slate-500 mb-1.5">
                <span>{{ $profil['semester_direimburs'] }} dari {{ $profil['semester_total'] }} Semester Direimburs</span>
                <span class="font-semibold tnum">{{ $pct }}%</span>
            </div>
            <div class="h-2 rounded-full bg-slate-100 overflow-hidden"><div class="h-full rounded-full bg-teal-500" style="width: {{ $pct }}%"></div></div>
        </div>
    </div>

    {{-- Tabs --}}
    <div role="tablist" aria-label="Data pembiayaan" class="mb-6 flex w-full gap-1 overflow-x-auto rounded-lg bg-slate-100 p-1 sm:w-fit">
        <button id="tab-semester" role="tab" type="button" @click="tab='semester'" :aria-selected="(tab==='semester').toString()" aria-controls="panel-semester" class="whitespace-nowrap rounded-md px-4 py-2 text-sm font-semibold transition" :class="tab==='semester'?'bg-white text-teal-700 shadow-sm':'text-slate-600'">Per semester</button>
        <button id="tab-eviden" role="tab" type="button" @click="tab='eviden'" :aria-selected="(tab==='eviden').toString()" aria-controls="panel-eviden" class="whitespace-nowrap rounded-md px-4 py-2 text-sm font-semibold transition" :class="tab==='eviden'?'bg-white text-teal-700 shadow-sm':'text-slate-600'">Eviden reimburs</button>
        <button id="tab-manual" role="tab" type="button" @click="tab='manual'" :aria-selected="(tab==='manual').toString()" aria-controls="panel-manual" class="whitespace-nowrap rounded-md px-4 py-2 text-sm font-semibold transition" :class="tab==='manual'?'bg-white text-teal-700 shadow-sm':'text-slate-600'">Input manual</button>
    </div>

    {{-- Per Semester accordion --}}
    <div id="panel-semester" role="tabpanel" aria-labelledby="tab-semester" x-show="tab==='semester'" class="space-y-3">
        @foreach($semesters as $i => $s)
            @php $toneMap=['Selesai'=>'green','Diproses'=>'amber','Belum Ada Data'=>'slate']; @endphp
            <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
                <button type="button" @click="open = open==={{ $i }} ? -1 : {{ $i }}" :aria-expanded="(open==={{ $i }}).toString()" aria-controls="semester-panel-{{ $i }}" class="flex w-full flex-col items-start justify-between gap-3 px-4 py-4 text-left transition hover:bg-slate-50 sm:flex-row sm:items-center sm:px-6">
                    <div class="flex items-center gap-3">
                        <span class="transition" :class="open==={{ $i }}?'rotate-180':''">@include('partials.icon', ['name' => 'chevron-down', 'class' => 'w-4 h-4 text-slate-600'])</span>
                        <div class="text-left">
                            <div class="font-semibold text-slate-800 text-sm">{{ $s['semester'] }}</div>
                            <div class="text-xs text-slate-400">{{ $s['tahun'] }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm font-semibold text-slate-800 tnum">{{ $rp($s['total']) }}</span>
                        @include('partials.badge', ['label' => $s['status'], 'tone' => $toneMap[$s['status']] ?? 'slate'])
                    </div>
                </button>
                <div id="semester-panel-{{ $i }}" x-show="open==={{ $i }}" x-collapse x-cloak class="border-t border-slate-100">
                    @if(count($s['items']))
                        <table class="w-full text-sm">
                            <thead><tr class="bg-slate-50/60 text-left text-[11px] uppercase tracking-wider text-slate-500">
                                <th class="px-6 py-2.5 font-semibold">Komponen</th><th class="px-6 py-2.5 font-semibold text-right">Nominal</th>
                                <th class="px-6 py-2.5 font-semibold">Tanggal</th><th class="px-6 py-2.5 font-semibold">Sumber</th><th class="px-6 py-2.5 font-semibold">Status</th>
                            </tr></thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($s['items'] as $it)
                                    @php $srcTone=['LKS Approved'=>'green','Upload Dosen'=>'blue','Input Manual'=>'indigo']; @endphp
                                    <tr>
                                        <td class="px-6 py-2.5 text-slate-700">{{ $it['komponen'] }}</td>
                                        <td class="px-6 py-2.5 text-right font-medium text-slate-800 tnum">{{ $rp($it['nominal']) }}</td>
                                        <td class="px-6 py-2.5 text-slate-500">{{ $it['tanggal'] }}</td>
                                        <td class="px-6 py-2.5">@include('partials.badge', ['label' => $it['sumber'], 'tone' => $srcTone[$it['sumber']] ?? 'slate'])</td>
                                        <td class="px-6 py-2.5">@include('partials.badge', ['label' => $it['status'], 'tone' => $it['status']==='Selesai'?'green':'amber'])</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="px-6 py-6 text-center text-sm text-slate-400">Belum ada data transaksi untuk semester ini.</div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- Eviden table --}}
    <div id="panel-eviden" role="tabpanel" aria-labelledby="tab-eviden" x-show="tab==='eviden'" x-cloak class="overflow-hidden rounded-lg border border-slate-200 bg-white">
        <table class="w-full text-sm">
            <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-6 py-3 font-semibold">Tanggal</th><th class="px-6 py-3 font-semibold">Kategori</th>
                <th class="px-6 py-3 font-semibold text-right">Nominal</th><th class="px-6 py-3 font-semibold">File</th>
                <th class="px-6 py-3 font-semibold">Status</th><th class="px-6 py-3 font-semibold text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($eviden as $e)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-6 py-3.5 text-slate-500">{{ $e['tanggal'] }}</td>
                        <td class="px-6 py-3.5 text-slate-700">{{ $e['kategori'] }}<div class="text-xs text-slate-400">{{ $e['catatan'] }}</div></td>
                        <td class="px-6 py-3.5 text-right font-medium text-slate-800 tnum">{{ $rp($e['nominal']) }}</td>
                        <td class="px-6 py-3.5"><span class="text-xs text-teal-600 inline-flex items-center gap-1">@include('partials.icon', ['name' => 'file', 'class' => 'w-3.5 h-3.5']) {{ $e['file'] }}</span></td>
                        <td class="px-6 py-3.5">@include('partials.badge', ['label' => $e['status'], 'tone' => $e['status']==='Selesai'?'green':'amber'])</td>
                        <td class="px-6 py-3.5 text-right">
                            <div class="inline-flex items-center gap-2">
                                <button type="button" @click="sigapPreview(@js($e['file']), @js($rp($e['nominal']).' · '.$e['kategori']), [])" class="grid h-11 w-11 place-items-center rounded-md text-slate-600 hover:bg-slate-100 hover:text-teal-700" aria-label="Pratinjau {{ $e['file'] }}">@include('partials.icon', ['name' => 'eye', 'class' => 'w-4 h-4'])</button>
                                <button type="button" @click="sigapToast(@js('Simulasi unduh: '.$e['file']), 'teal')" class="grid h-11 w-11 place-items-center rounded-md text-slate-600 hover:bg-slate-100 hover:text-teal-700" aria-label="Unduh {{ $e['file'] }}">@include('partials.icon', ['name' => 'download', 'class' => 'w-4 h-4'])</button>
                                @if($e['status'] !== 'Selesai')
                                    <button @click="nde=true; ndeRow='{{ $e['kategori'] }}'" class="px-3 py-1.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-xs font-semibold">Proses NDE</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Input manual --}}
    <div id="panel-manual" role="tabpanel" aria-labelledby="tab-manual" x-show="tab==='manual'" x-cloak class="rounded-lg border border-slate-200 bg-white">
        <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">+ Tambah Item Pembiayaan Manual</h3></div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
            <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Semester</label><select class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none"><option>Semester 3</option><option>Semester 4</option></select></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Jenis Biaya</label><input class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none" placeholder="cth: Penyesuaian kurs"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Nominal</label><input class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none tnum" placeholder="Rp 0"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal</label><input type="date" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none"></div>
            <div class="md:col-span-2"><label class="block text-sm font-medium text-slate-700 mb-1.5">Keterangan</label><textarea rows="2" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none"></textarea></div>
            <div class="md:col-span-2 flex justify-end"><button @click="sigapToast('Item pembiayaan manual ditambahkan', 'green')" class="px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold">Simpan Item Manual</button></div>
        </div>
    </div>

    {{-- NDE modal --}}
    <div x-show="nde" x-cloak class="fixed inset-0 z-50 grid place-items-center p-4 bg-black/40" @click.self="nde=false">
        <div class="bg-white rounded-xl w-full max-w-md shadow-xl">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">Konfirmasi Proses NDE ke SDM Pusat</h3>
                <button @click="nde=false" class="text-slate-400">@include('partials.icon', ['name' => 'x', 'class' => 'w-5 h-5'])</button>
            </div>
            <div class="p-6 space-y-4">
                <p class="text-sm text-slate-500">Memproses pencairan untuk: <span class="font-medium text-slate-800" x-text="ndeRow"></span></p>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Nota Dinas Elektronik (NDE) <span class="text-rose-500">*</span></label>
                    <input placeholder="cth: NDE/FEB/SDM/X/2026/120" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none tnum">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Disposisi</label>
                    <input type="date" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3">
                <button @click="nde=false" class="px-4 py-2 rounded border border-slate-300 text-sm font-medium text-slate-600">Batal</button>
                <button @click="nde=false; sigapToast('Simulasi selesai: NDE diproses dan rekonsiliasi plafon diperbarui', 'green')" class="px-4 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold">Konfirmasi & Kirim</button>
            </div>
        </div>
    </div>
</div>
@endsection
