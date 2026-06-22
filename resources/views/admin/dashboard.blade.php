@extends('layouts.adminlte4.main')

@section('header', 'Dashboard Statistik')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-primary">
            <div class="inner">
                <h3>{{ $totalUsers }}</h3>
                <p>Total Pengguna</p>
            </div>
            <div class="small-box-icon">
                <i class="bi bi-people-fill"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-success">
            <div class="inner">
                <h3>{{ $totalWatchlists }}</h3>
                <p>Total Film Disimpan</p>
            </div>
            <div class="small-box-icon">
                <i class="bi bi-film"></i>
            </div>
        </div>
    </div>
</div>
@endsection