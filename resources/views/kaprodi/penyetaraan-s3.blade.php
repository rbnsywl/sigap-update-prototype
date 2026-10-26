@extends('layouts.app')
@section('title', 'Review Penyetaraan S3')
@section('breadcrumb', 'Approval / Penyetaraan S3')
@section('content')
    @include('shared.asesor-penilaian', ['roleLabel' => 'Ketua Program Studi'])
@endsection
