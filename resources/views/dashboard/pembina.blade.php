@extends('layout')

@section('title', 'Dashboard Pembina')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0"><i class="fas fa-chart-line"></i> Dashboard Pembina</h1>
    </div>
    
    <div class="row">
        <div class="col-12 col-sm-6 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Peserta Anda</h6>
                            <h2 class="text-primary mb-0" style="font-size: 1.75rem;">{{ $stats['total_peserta'] }}</h2>
                        </div>
                        <div style="font-size: 2rem; color: #4e73df; opacity: 0.2;">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Peserta Hadir Hari Ini</h6>
                            <h2 class="text-success mb-0" style="font-size: 1.75rem;">{{ $stats['hadir_hari_ini'] }}</h2>
                        </div>
                        <div style="font-size: 2rem; color: #1cc88a; opacity: 0.2;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-graduation-cap"></i> Data Peserta Magang Anda
                </div>
                <div class="card-body">
                    <a href="{{ route('attendance.index') }}" class="btn btn-primary w-100 w-sm-auto">
                        <i class="fas fa-list"></i> Lihat Absensi Peserta
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
