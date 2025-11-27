@extends('layout')

@section('title', 'Detail Peserta')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-user-circle"></i> Detail Peserta: {{ $peserta->nama_lengkap }}</h1>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Informasi Peserta
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong> {{ $peserta->nama_lengkap }}</p>
                    <p><strong>NISN:</strong> {{ $peserta->nisn }}</p>
                    <p><strong>Sekolah:</strong> {{ $peserta->sekolah }}</p>
                    <p><strong>Jurusan:</strong> {{ $peserta->jurusan }}</p>
                    <p><strong>Pembina:</strong> {{ $peserta->pembina->nama_lengkap }}</p>
                    <p><strong>Nomor HP:</strong> {{ $peserta->nomor_hp }}</p>
                    <p><strong>Periode:</strong><br>{{ $peserta->tanggal_mulai->format('d M Y') }} - {{ $peserta->tanggal_selesai->format('d M Y') }}</p>
                    <a href="{{ route('peserta.edit', $peserta) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('peserta.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-clock"></i> Riwayat Absensi ({{ $attendances->total() }})
                </div>
                <div class="card-body">
                    @if($attendances->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendances as $attendance)
                                        <tr>
                                            <td>{{ $attendance->tanggal->format('d M Y') }}</td>
                                            <td>{{ $attendance->jam_masuk ? $attendance->jam_masuk->format('H:i') : '-' }}</td>
                                            <td>{{ $attendance->jam_keluar ? $attendance->jam_keluar->format('H:i') : '-' }}</td>
                                            <td>
                                                <span class="badge @if($attendance->status == 'hadir') bg-success @elseif($attendance->status == 'izin') bg-info @elseif($attendance->status == 'sakit') bg-warning @else bg-danger @endif">
                                                    {{ ucfirst($attendance->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('attendance.show', $attendance) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $attendances->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada data absensi.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
