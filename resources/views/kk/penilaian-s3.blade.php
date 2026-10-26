@extends('layouts.app')
@section('title', 'Penilaian Penyetaraan S3')
@section('breadcrumb', 'Penilaian / Penyetaraan S3')
@section('content')
    @include('shared.asesor-penilaian', ['roleLabel' => 'Ketua Kelompok Keahlian'])
@endsection
