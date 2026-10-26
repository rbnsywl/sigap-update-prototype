@extends('layouts.app')
@section('title', 'Arsip Pengajuan Prodi')
@section('breadcrumb', 'Surat Tugas / Arsip')

@section('content')
    @include('partials.page-head', ['heading' => 'Arsip Pengajuan Prodi', 'sub' => 'Riwayat seluruh usulan ST prodi yang telah diproses.'])
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        @include('prodi.partials.queue-table', ['st' => $st])
    </div>
@endsection
