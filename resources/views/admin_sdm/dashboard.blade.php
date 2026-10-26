@extends('layouts.app')
@section('title', 'Dashboard Admin SDM')
@section('breadcrumb', 'Utama / Dashboard Admin SDM')

@section('content')
    @include('partials.page-head', ['heading' => 'Dashboard Admin SDM Fakultas', 'sub' => 'Pusat kontrol operasional seluruh alur administrasi SDM FEB.'])
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        @include('partials.stat-card', ['label' => 'Antrean Draf ST', 'value' => 2, 'tone' => 'amber', 'icon' => 'edit'])
        @include('partials.stat-card', ['label' => 'Dosen PID Aktif', 'value' => 9, 'tone' => 'teal', 'icon' => 'cap'])
        @include('partials.stat-card', ['label' => 'LKS Pending', 'value' => 5, 'tone' => 'blue', 'icon' => 'clipboard'])
        @include('partials.stat-card', ['label' => 'Klaim NDE Diproses', 'value' => 3, 'tone' => 'rose', 'icon' => 'wallet'])
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">Draf ST Perlu Disusun</h3></div>
            @php $drafting = collect($st)->where('status','Menunggu Drafting SDM'); @endphp
            @include('prodi.partials.queue-table', ['st' => $drafting->isEmpty() ? array_slice($st,0,2) : $drafting->all()])
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Eligibilitas Dosen PID</h3>
            <div class="space-y-3">
                @foreach($kstats as $s)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-600">{{ $s['label'] }}</span>
                        <span class="font-semibold tnum text-slate-800">{{ $s['value'] }}</span>
                    </div>
                @endforeach
            </div>
            <a href="/admin-sdm/pid/kelayakan" class="mt-4 block text-center text-sm text-teal-600 font-semibold hover:underline">Buka Monitor Kelayakan →</a>
        </div>
    </div>
@endsection
