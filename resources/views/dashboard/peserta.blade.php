@extends('layout')

@section('title', 'Dashboard Peserta')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0"><i class="fas fa-chart-line"></i> Dashboard Peserta</h1>
    </div>
    
    <div class="alert alert-info" role="alert">
        <i class="fas fa-info-circle"></i>
        Selamat datang, <strong>{{ $peserta->nama_lengkap }}</strong>!<br>
        <small>Status magang: <strong>{{ $peserta->tanggal_mulai }}</strong> s/d <strong>{{ $peserta->tanggal_selesai }}</strong></small>
    </div>
    
    @if($peserta->pembina)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-user-tie"></i> Informasi Pembina
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 mb-3 mb-sm-0">
                            <p class="mb-2"><strong>Nama Pembina:</strong><br>{{ $peserta->pembina->nama_lengkap }}</p>
                            <p class="mb-0"><strong>Jabatan:</strong><br>{{ $peserta->pembina->jabatan }}</p>
                        </div>
                        <div class="col-12 col-sm-6">
                            <p class="mb-2"><strong>NIP:</strong><br>{{ $peserta->pembina->nip }}</p>
                            <p class="mb-0"><strong>Nomor HP:</strong><br><a href="tel:{{ $peserta->pembina->nomor_hp }}">{{ $peserta->pembina->nomor_hp }}</a></p>
                        </div>
                    </div>
                    @if($peserta->pembina->user)
                    <p class="mt-3 mb-0"><strong>Email:</strong><br><a href="mailto:{{ $peserta->pembina->user->email }}">{{ $peserta->pembina->user->email }}</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <div class="row">
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Hadir</h6>
                            <h2 class="text-success mb-0" style="font-size: 1.75rem;">{{ $stats['total_hadir'] }}</h2>
                        </div>
                        <div style="font-size: 2rem; color: #1cc88a; opacity: 0.2;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Izin</h6>
                            <h2 class="text-info mb-0" style="font-size: 1.75rem;">{{ $stats['total_izin'] }}</h2>
                        </div>
                        <div style="font-size: 2rem; color: #36b9cc; opacity: 0.2;">
                            <i class="fas fa-hand-paper"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Sakit</h6>
                            <h2 class="text-warning mb-0" style="font-size: 1.75rem;">{{ $stats['total_sakit'] }}</h2>
                        </div>
                        <div style="font-size: 2rem; color: #f6c23e; opacity: 0.2;">
                            <i class="fas fa-hospital-user"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Alfa</h6>
                            <h2 class="text-danger mb-0" style="font-size: 1.75rem;">{{ $stats['total_alfa'] }}</h2>
                        </div>
                        <div style="font-size: 2rem; color: #e74c3c; opacity: 0.2;">
                            <i class="fas fa-times-circle"></i>
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
                    <span><i class="fas fa-clock"></i> Status Hari Ini</span>
                </div>
                <div class="card-body">
                    @if($today_attendance)
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle"></i>
                            <strong>Anda sudah mengisi absensi hari ini</strong>
                            <br>
                            <small>Status: <strong>{{ ucfirst($today_attendance->status) }}</strong></small>
                        </div>
                    @else
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Belum ada absensi hari ini</strong>
                        </div>
                    @endif
                    
                    <div class="d-grid gap-2 d-sm-flex">
                        <a href="{{ route('attendance.create') }}" class="btn btn-primary flex-sm-fill">
                            <i class="fas fa-plus"></i> Tambah Absensi Baru
                        </a>
                        <a href="{{ route('attendance.index') }}" class="btn btn-secondary flex-sm-fill">
                            <i class="fas fa-list"></i> Lihat Semua Absensi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
