@extends('layouts.dashboard')

@section('title', 'Manajemen Tema - Lib-In MBS')
@section('page-title', 'Manajemen Tema')
@section('page-description', 'Kelola tema tampilan utama aplikasi')

@section('content')
    @livewire('manajemen-tema')
    @livewire('manajemen-jam-operasional')
@endsection
