@extends('layout')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-sm-items-center mb-4 gap-2">
        <div>
            <h1 class="mb-1"><i class="fas fa-chart-line"></i> Dashboard Admin</h1>
            <small class="text-muted">Selamat datang, {{ auth()->user()->name }}</small>
        </div>
        <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm w-100 w-sm-auto"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-12 col-sm-6 col-lg-4 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Pembina</h6>
                            <h2 class="text-primary mb-0" style="font-size: 1.75rem;">{{ $stats['total_pembina'] }}</h2>
                        </div>
                        <div style="font-size: 2rem; color: #4e73df; opacity: 0.2;">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-lg-4 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Peserta</h6>
                            <h2 class="text-success mb-0" style="font-size: 1.75rem;">{{ $stats['total_peserta'] }}</h2>
                        </div>
                        <div style="font-size: 2rem; color: #1cc88a; opacity: 0.2;">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-lg-4 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Absensi</h6>
                            <h2 class="text-warning mb-0" style="font-size: 1.75rem;">{{ $stats['total_absensi'] }}</h2>
                        </div>
                        <div style="font-size: 2rem; color: #f6c23e; opacity: 0.2;">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CRUD Management Section -->
    <div class="row mt-4">
        <div class="col-12 col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-users"></i> Manajemen Pembina
                </div>
                <div class="card-body">
                    <p class="text-muted">Kelola data pembina/supervisor yang mengawasi peserta magang.</p>
                    <div class="d-grid gap-2 d-sm-flex">
                        <a href="{{ route('pembina.index') }}" class="btn btn-primary btn-sm flex-sm-fill">
                            <i class="fas fa-list"></i> Lihat Semua
                        </a>
                        <a href="{{ route('pembina.create') }}" class="btn btn-success btn-sm flex-sm-fill">
                            <i class="fas fa-plus"></i> Tambah Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-graduation-cap"></i> Manajemen Peserta
                </div>
                <div class="card-body">
                    <p class="text-muted">Kelola data peserta magang yang terdaftar di sistem.</p>
                    <div class="d-grid gap-2 d-sm-flex">
                        <a href="{{ route('peserta.index') }}" class="btn btn-success btn-sm flex-sm-fill">
                            <i class="fas fa-list"></i> Lihat Semua
                        </a>
                        <a href="{{ route('peserta.create') }}" class="btn btn-info btn-sm flex-sm-fill">
                            <i class="fas fa-plus"></i> Tambah Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-secondary text-white">
                    <i class="fas fa-link"></i> Shortcut Menu
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-sm-start">
                        <a href="{{ route('pembina.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye"></i><span class="d-none d-sm-inline"> Daftar Pembina</span>
                        </a>
                        <a href="{{ route('pembina.create') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-user-plus"></i><span class="d-none d-sm-inline"> Pembina Baru</span>
                        </a>
                        <a href="{{ route('peserta.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye"></i><span class="d-none d-sm-inline"> Daftar Peserta</span>
                        </a>
                        <a href="{{ route('peserta.create') }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-user-plus"></i><span class="d-none d-sm-inline"> Peserta Baru</span>
                        </a>
                        <a href="{{ route('attendance.index') }}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-clock"></i><span class="d-none d-sm-inline"> Laporan Absensi</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stat-card {
    border: none;
    border-radius: 8px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.card {
    border-radius: 8px;
}

.btn-group-sm .btn-sm {
    flex: 1;
}

.gap-2 {
    gap: 0.5rem;
}
</style>
@endsection
