@extends('layout')

@section('title', 'Data Peserta')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 col-md-8 mb-2 mb-md-0">
            <h1 class="mb-0"><i class="fas fa-graduation-cap"></i> Manajemen Data Peserta</h1>
            <small class="text-muted">Total: <strong>{{ $pesertas->total() }}</strong> peserta</small>
        </div>
        <div class="col-12 col-md-4 d-grid d-md-block">
            <a href="{{ route('peserta.create') }}" class="btn btn-primary w-100 w-md-auto">
                <i class="fas fa-plus-circle"></i> Tambah Peserta
            </a>
        </div>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <i class="fas fa-table"></i> <strong>Daftar Peserta</strong>
        </div>
        <div class="card-body p-0">
            @if($pesertas->count() > 0)
                {{-- Desktop View --}}
                <div class="d-none d-md-block table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th class="d-none d-lg-table-cell">Sekolah</th>
                                <th class="d-none d-lg-table-cell">Jurusan</th>
                                <th class="d-none d-xl-table-cell">Pembina</th>
                                <th class="d-none d-lg-table-cell">Periode</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesertas as $peserta)
                                <tr>
                                    <td><code>{{ $peserta->nisn }}</code></td>
                                    <td><strong>{{ $peserta->nama_lengkap }}</strong></td>
                                    <td class="d-none d-lg-table-cell"><span class="badge bg-secondary">{{ $peserta->sekolah }}</span></td>
                                    <td class="d-none d-lg-table-cell">{{ $peserta->jurusan }}</td>
                                    <td class="d-none d-xl-table-cell">
                                        @if($peserta->pembina)
                                            <span class="badge bg-info"><i class="fas fa-user-tie"></i> {{ $peserta->pembina?->nama_lengkap }}</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Belum di-assign</span>
                                        @endif
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <small>
                                            <i class="fas fa-calendar"></i>
                                            {{ $peserta->tanggal_mulai->format('d M Y') }}<br>
                                            s/d {{ $peserta->tanggal_selesai->format('d M Y') }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('peserta.show', $peserta->id) }}" class="btn btn-info" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('peserta.edit', $peserta->id) }}" class="btn btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('peserta.destroy', $peserta->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">
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
                    @foreach($pesertas as $peserta)
                        <div class="card m-2">
                            <div class="card-body p-3">
                                <div class="mb-2">
                                    <small class="text-muted">NISN</small>
                                    <p class="mb-1"><code>{{ $peserta->nisn }}</code></p>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Nama</small>
                                    <p class="mb-1"><strong>{{ $peserta->nama_lengkap }}</strong></p>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Sekolah</small>
                                    <p class="mb-1"><span class="badge bg-secondary">{{ $peserta->sekolah }}</span></p>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Jurusan</small>
                                    <p class="mb-1">{{ $peserta->jurusan }}</p>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Pembina</small>
                                    <p class="mb-1">
                                        @if($peserta->pembina)
                                            <span class="badge bg-info"><i class="fas fa-user-tie"></i> {{ $peserta->pembina?->nama_lengkap }}</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Belum di-assign</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Periode</small>
                                    <p class="mb-1">
                                        <i class="fas fa-calendar"></i>
                                        {{ $peserta->tanggal_mulai->format('d M Y') }}<br>
                                        s/d {{ $peserta->tanggal_selesai->format('d M Y') }}
                                    </p>
                                </div>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('peserta.show', $peserta->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <a href="{{ route('peserta.edit', $peserta->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('peserta.destroy', $peserta->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="card-footer bg-light">
                    <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center gap-2">
                        <small class="text-muted">Menampilkan {{ $pesertas->count() }} dari {{ $pesertas->total() }} data</small>
                        <div class="d-flex justify-content-center justify-content-md-end">
                            {{ $pesertas->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info m-0">
                    <i class="fas fa-info-circle"></i> Belum ada data peserta. 
                    <a href="{{ route('peserta.create') }}" class="alert-link">Tambah peserta sekarang</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
