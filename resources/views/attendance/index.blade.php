@extends('layout')

@section('title', 'Data Absensi')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-sm-items-center mb-4 gap-2">
        <h1><i class="fas fa-clock"></i> Data Absensi</h1>
        @if(auth()->user()->role === 'peserta')
            <a href="{{ route('attendance.create') }}" class="btn btn-primary w-100 w-sm-auto">
                <i class="fas fa-plus"></i> Tambah Absensi
            </a>
        @endif
    </div>
    
    <div class="card">
        <div class="card-header">
            <i class="fas fa-table"></i> Daftar Absensi
        </div>
        <div class="card-body p-0">
            @if($attendances->count() > 0)
                {{-- Desktop View --}}
                <div class="d-none d-md-block table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                @if(auth()->user()->role !== 'peserta')
                                    <th class="d-none d-lg-table-cell">Peserta</th>
                                @endif
                                <th>Jam Masuk</th>
                                <th class="d-none d-lg-table-cell">Jam Keluar</th>
                                <th>Status</th>
                                <th class="d-none d-lg-table-cell">Foto</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $attendance)
                                <tr>
                                    <td><strong>{{ $attendance->tanggal->format('d M Y') }}</strong></td>
                                    @if(auth()->user()->role !== 'peserta')
                                        <td class="d-none d-lg-table-cell">{{ $attendance->peserta->nama_lengkap }}</td>
                                    @endif
                                    <td>{{ $attendance->jam_masuk ? $attendance->jam_masuk->format('H:i') : '-' }}</td>
                                    <td class="d-none d-lg-table-cell">{{ $attendance->jam_keluar ? $attendance->jam_keluar->format('H:i') : '-' }}</td>
                                    <td>
                                        <span class="badge @if($attendance->status == 'hadir') bg-success @elseif($attendance->status == 'izin') bg-info @elseif($attendance->status == 'sakit') bg-warning @else bg-danger @endif">
                                            {{ ucfirst($attendance->status) }}
                                        </span>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <div class="btn-group btn-group-sm" role="group">
                                            @if($attendance->foto_masuk)
                                                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#fotoModal" onclick="showFoto('{{ asset('storage/' . $attendance->foto_masuk) }}', 'Foto Masuk - ' + '{{ $attendance->tanggal->format('d M Y') }}')">
                                                    <i class="fas fa-image"></i> Masuk
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-outline-secondary btn-sm" disabled>
                                                    <i class="fas fa-image"></i> -
                                                </button>
                                            @endif
                                            
                                            @if($attendance->foto_keluar)
                                                <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#fotoModal" onclick="showFoto('{{ asset('storage/' . $attendance->foto_keluar) }}', 'Foto Keluar - ' + '{{ $attendance->tanggal->format('d M Y') }}')">
                                                    <i class="fas fa-image"></i> Keluar
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-outline-secondary btn-sm" disabled>
                                                    <i class="fas fa-image"></i> -
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('attendance.show', $attendance) }}" class="btn btn-info btn-sm" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('attendance.edit', $attendance) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('attendance.destroy', $attendance) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile View --}}
                <div class="d-md-none">
                    @foreach($attendances as $attendance)
                        <div class="card m-2">
                            <div class="card-body p-3">
                                <div class="mb-2">
                                    <small class="text-muted">Tanggal</small>
                                    <p class="mb-1"><strong>{{ $attendance->tanggal->format('d M Y') }}</strong></p>
                                </div>
                                @if(auth()->user()->role !== 'peserta')
                                <div class="mb-2">
                                    <small class="text-muted">Peserta</small>
                                    <p class="mb-1">{{ $attendance->peserta->nama_lengkap }}</p>
                                </div>
                                @endif
                                <div class="mb-2">
                                    <small class="text-muted">Jam Masuk</small>
                                    <p class="mb-1">{{ $attendance->jam_masuk ? $attendance->jam_masuk->format('H:i') : '-' }}</p>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Jam Keluar</small>
                                    <p class="mb-1">{{ $attendance->jam_keluar ? $attendance->jam_keluar->format('H:i') : '-' }}</p>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Status</small>
                                    <p class="mb-1">
                                        <span class="badge @if($attendance->status == 'hadir') bg-success @elseif($attendance->status == 'izin') bg-info @elseif($attendance->status == 'sakit') bg-warning @else bg-danger @endif">
                                            {{ ucfirst($attendance->status) }}
                                        </span>
                                    </p>
                                </div>
                                <div class="d-grid gap-2 mb-2">
                                    <div class="btn-group d-flex" role="group">
                                        @if($attendance->foto_masuk)
                                            <button type="button" class="btn btn-outline-info btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#fotoModal" onclick="showFoto('{{ asset('storage/' . $attendance->foto_masuk) }}', 'Foto Masuk - ' + '{{ $attendance->tanggal->format('d M Y') }}')">
                                                <i class="fas fa-image"></i> Masuk
                                            </button>
                                        @endif
                                        @if($attendance->foto_keluar)
                                            <button type="button" class="btn btn-outline-warning btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#fotoModal" onclick="showFoto('{{ asset('storage/' . $attendance->foto_keluar) }}', 'Foto Keluar - ' + '{{ $attendance->tanggal->format('d M Y') }}')">
                                                <i class="fas fa-image"></i> Keluar
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('attendance.show', $attendance) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('attendance.edit', $attendance) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('attendance.destroy', $attendance) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-center">
                        {{ $attendances->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <div class="alert alert-info m-0">
                    <i class="fas fa-info-circle"></i> Belum ada data absensi. 
                    @if(auth()->user()->role === 'peserta')
                        <a href="{{ route('attendance.create') }}">Buat absensi baru</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan foto -->
<div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fotoModalLabel">Foto Absensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" style="min-height: 300px; display: flex; align-items: center; justify-content: center;">
                <div id="fotoContainer">
                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a id="fotoDownload" href="#" class="btn btn-primary" style="display: none;">
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function showFoto(url, label) {
    document.getElementById('fotoModalLabel').textContent = label;
    const container = document.getElementById('fotoContainer');
    const downloadBtn = document.getElementById('fotoDownload');
    
    // Show loading
    container.innerHTML = '<i class="fas fa-spinner fa-spin fa-2x text-primary"></i>';
    downloadBtn.style.display = 'none';
    
    // Create image
    const img = new Image();
    img.onload = function() {
        container.innerHTML = '<img src="' + url + '" alt="Foto" style="max-width: 100%; max-height: 600px; border-radius: 5px;">';
        downloadBtn.href = url;
        downloadBtn.style.display = 'inline-block';
    };
    img.onerror = function() {
        container.innerHTML = '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Gagal memuat foto. URL: ' + url + '</div>';
        downloadBtn.style.display = 'none';
    };
    img.src = url;
}
</script>
@endsection
