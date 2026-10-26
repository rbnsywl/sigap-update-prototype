@extends('layouts.app')
@section('title', 'Penetapan Penyetaraan S3')
@section('breadcrumb', 'Pengesahan / Penyetaraan S3')
@section('content')
    @include('shared.asesor-penilaian', ['roleLabel' => 'Dekan / Wakil Dekan'])
@endsection
