@extends('layouts.dashboard')

@section('title', 'Laporan - Lib-In MBS')
@section('page-title', 'Laporan & Rekapitulasi')
@section('page-description', 'Generate dan export laporan kunjungan')

@section('content')
    @livewire('laporan-rekapitulasi')
@endsection
