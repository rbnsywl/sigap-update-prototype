@extends('layouts.app')
@section('title', 'Approval LKS Semesteran')
@section('breadcrumb', 'Pengesahan / Approval LKS')

@section('content')
<div x-data="{ sel:2, modal:false }">
    @include('partials.page-head', ['heading' => 'Approval LKS Semesteran', 'sub' => 'Tinjau capaian IPK & progres riset disertasi, lalu sahkan dengan tanda tangan digital.'])
    @php $queue = collect($lks)->where('status','Menunggu Approval Dekan')->values(); if($queue->isEmpty()) $queue = collect($lks); @endphp
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200 overflow-hidden self-start">
            <div class="px-5 py-3.5 border-b border-slate-100 font-semibold text-slate-800 text-sm">Antrean Approval</div>
            <div class="divide-y divide-slate-50">
                @foreach($lks as $i => $l)
                    <button @click="sel={{ $i }}" class="w-full text-left px-5 py-3.5 transition" :class="sel==={{ $i }}?'bg-teal-50':'hover:bg-slate-50'">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-sm font-medium text-slate-800 truncate">{{ $l['semester'] }}</span>
                            @include('partials.badge', ['label' => $l['status'], 'tone' => $statuses[$l['status']] ?? 'slate'])
                        </div>
                        <div class="text-xs text-slate-400 mt-0.5">Dr. Rangga Pratama · IPK {{ number_format($l['ipk'],2) }}</div>
                    </button>
                @endforeach
            </div>
        </div>
        <div class="lg:col-span-3">
            @foreach($lks as $i => $l)
                <div x-show="sel==={{ $i }}" x-cloak class="bg-white rounded-lg border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">Konsol Pengesahan — {{ $l['semester'] }}</h3></div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="rounded-lg border-2 border-dashed border-slate-200 bg-slate-50 grid place-items-center p-8 text-center">
                            @include('partials.icon', ['name' => 'file', 'class' => 'w-10 h-10 text-slate-300 mx-auto'])
                            <div class="text-sm text-slate-400 mt-2">Preview LKS (in-app)</div>
                        </div>
                        <div class="space-y-4">
                            <dl class="space-y-2 text-sm">
                                <div class="flex justify-between"><dt class="text-slate-400">IPK Semester</dt><dd class="font-semibold text-slate-800 tnum">{{ number_format($l['ipk'],2) }}</dd></div>
                                <div class="flex justify-between"><dt class="text-slate-400">Tanggal Submit</dt><dd class="font-medium text-slate-800">{{ $l['tanggal'] }}</dd></div>
                                <div class="flex justify-between"><dt class="text-slate-400">Verifikasi SDM</dt><dd class="font-medium text-green-600">Memenuhi Syarat ✓</dd></div>
                            </dl>
                            <label class="flex items-start gap-3 p-3 rounded-lg border border-slate-200">
                                <input type="checkbox" class="w-4 h-4 rounded text-teal-500 focus:ring-teal-500 mt-0.5">
                                <span class="text-xs text-slate-600">Saya telah meninjau capaian akademik dosen bersangkutan dan menyetujui kelanjutan studi untuk pencairan BPP semester berikutnya.</span>
                            </label>
                            <button @click="modal=true" class="w-full px-4 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center justify-center gap-2">
                                @include('partials.icon', ['name' => 'pen', 'class' => 'w-4 h-4']) Tandatangani & Sahkan LKS
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div x-show="modal" x-cloak class="fixed inset-0 z-50 grid place-items-center p-4 bg-black/40" @click.self="modal=false">
        <div class="bg-white rounded-xl w-full max-w-sm shadow-xl p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-teal-100 text-teal-600 grid place-items-center mx-auto mb-3">@include('partials.icon', ['name' => 'pen', 'class' => 'w-6 h-6'])</div>
            <h3 class="font-semibold text-slate-800">Masukkan PIN BSrE</h3>
            <input type="password" placeholder="••••••" class="mt-4 w-full text-center rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none tracking-[0.5em]">
            <div class="mt-4 flex gap-3">
                <button @click="modal=false" class="flex-1 px-4 py-2 rounded border border-slate-300 text-sm font-medium text-slate-600">Batal</button>
                <button @click="modal=false" class="flex-1 px-4 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold">Sahkan</button>
            </div>
        </div>
    </div>
</div>
@endsection
