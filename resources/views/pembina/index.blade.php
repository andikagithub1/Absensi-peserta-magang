@extends('layout')

@section('title', 'Data Pembina')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 col-md-8 mb-2 mb-md-0">
            <h1 class="mb-0"><i class="fas fa-users"></i> Manajemen Data Pembina</h1>
            <small class="text-muted">Total: <strong>{{ $pembinas->total() }}</strong> pembina</small>
        </div>
        <div class="col-12 col-md-4 d-grid d-md-block">
            <a href="{{ route('pembina.create') }}" class="btn btn-primary w-100 w-md-auto">
                <i class="fas fa-plus-circle"></i> Tambah Pembina
            </a>
        </div>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <i class="fas fa-table"></i> <strong>Daftar Pembina</strong>
        </div>
        <div class="card-body p-0">
            @if($pembinas->count() > 0)
                {{-- Desktop View --}}
                <div class="d-none d-md-block table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>NIP</th>
                                <th>Nama Lengkap</th>
                                <th class="d-none d-lg-table-cell">Jabatan</th>
                                <th class="d-none d-xl-table-cell">Nomor HP</th>
                                <th class="d-none d-lg-table-cell">Email</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembinas as $pembina)
                                <tr>
                                    <td><code>{{ $pembina->nip }}</code></td>
                                    <td><strong>{{ $pembina->nama_lengkap }}</strong></td>
                                    <td class="d-none d-lg-table-cell"><span class="badge bg-primary">{{ $pembina->jabatan }}</span></td>
                                    <td class="d-none d-xl-table-cell"><i class="fas fa-phone"></i> {{ $pembina->nomor_hp }}</td>
                                    <td class="d-none d-lg-table-cell"><i class="fas fa-envelope"></i> {{ $pembina->user->email }}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('pembina.show', $pembina->id) }}" class="btn btn-info" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('pembina.edit', $pembina->id) }}" class="btn btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('pembina.edit-password', $pembina->id) }}" class="btn btn-secondary" title="Ubah Password">
                                                <i class="fas fa-key"></i>
                                            </a>
                                            <form action="{{ route('pembina.destroy', $pembina->id) }}" method="POST" style="display: inline;">
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
                    @foreach($pembinas as $pembina)
                        <div class="card m-2">
                            <div class="card-body p-3">
                                <div class="mb-2">
                                    <small class="text-muted">NIP</small>
                                    <p class="mb-1"><code>{{ $pembina->nip }}</code></p>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Nama</small>
                                    <p class="mb-1"><strong>{{ $pembina->nama_lengkap }}</strong></p>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Jabatan</small>
                                    <p class="mb-1"><span class="badge bg-primary">{{ $pembina->jabatan }}</span></p>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Nomor HP</small>
                                    <p class="mb-1"><i class="fas fa-phone"></i> {{ $pembina->nomor_hp }}</p>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Email</small>
                                    <p class="mb-1"><i class="fas fa-envelope"></i> {{ $pembina->user->email }}</p>
                                </div>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('pembina.show', $pembina->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <a href="{{ route('pembina.edit', $pembina->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="{{ route('pembina.edit-password', $pembina->id) }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-key"></i> Ubah Password
                                    </a>
                                    <form action="{{ route('pembina.destroy', $pembina->id) }}" method="POST">
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
                        <small class="text-muted">Menampilkan {{ $pembinas->count() }} dari {{ $pembinas->total() }} data</small>
                        <div class="d-flex justify-content-center justify-content-md-end">
                            {{ $pembinas->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info m-0">
                    <i class="fas fa-info-circle"></i> Belum ada data pembina. 
                    <a href="{{ route('pembina.create') }}" class="alert-link">Tambah pembina sekarang</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
