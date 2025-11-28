@extends('layout')

@section('title', 'Detail Absensi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-eye"></i> Detail Absensi</h1>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Informasi Absensi
                </div>
                <div class="card-body">
                    <p><strong>Peserta:</strong> {{ $attendance->peserta->nama_lengkap }}</p>
                    <p><strong>Tanggal:</strong> {{ $attendance->tanggal->format('d M Y') }}</p>
                    <p><strong>Jam Masuk:</strong> {{ $attendance->jam_masuk ? $attendance->jam_masuk->format('H:i') : '-' }}</p>
                    <p><strong>Jam Keluar:</strong> {{ $attendance->jam_keluar ? $attendance->jam_keluar->format('H:i') : '-' }}</p>
                    <p><strong>Status:</strong> <span class="badge @if($attendance->status == 'hadir') bg-success @elseif($attendance->status == 'izin') bg-info @elseif($attendance->status == 'sakit') bg-warning @else bg-danger @endif">{{ ucfirst($attendance->status) }}</span></p>
                    <p><strong>Keterangan:</strong> {{ $attendance->keterangan ?? '-' }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-map-marker-alt"></i> Lokasi
                </div>
                <div class="card-body">
                    <p><strong>Latitude Masuk:</strong> {{ $attendance->latitude_masuk ?? '-' }}</p>
                    <p><strong>Longitude Masuk:</strong> {{ $attendance->longitude_masuk ?? '-' }}</p>
                    <p><strong>Latitude Keluar:</strong> {{ $attendance->latitude_keluar ?? '-' }}</p>
                    <p><strong>Longitude Keluar:</strong> {{ $attendance->longitude_keluar ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-camera"></i> Foto Masuk
                </div>
                <div class="card-body">
                    @if($attendance->foto_masuk)
                        <img src="{{ asset('storage/' . $attendance->foto_masuk) }}" alt="Foto Masuk" style="max-width: 100%; height: auto;">
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada foto masuk.
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-camera"></i> Foto Keluar
                </div>
                <div class="card-body">
                    @if($attendance->foto_keluar)
                        <img src="{{ asset('storage/' . $attendance->foto_keluar) }}" alt="Foto Keluar" style="max-width: 100%; height: auto;">
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada foto keluar.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-pen-fancy"></i> Tanda Tangan
                </div>
                <div class="card-body">
                    @if($attendance->tanda_tangan)
                        <img src="{{ $attendance->tanda_tangan }}" alt="Tanda Tangan" style="max-width: 100%; height: auto; max-height: 300px; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-check-circle text-success"></i> Ditandatangani oleh peserta
                        </small>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-circle"></i> Belum ada tanda tangan.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        <a href="{{ route('attendance.edit', $attendance) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('attendance.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
