@extends('layout')

@section('title', 'Detail Pembina')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-user-circle"></i> Detail Pembina: {{ $pembina->nama_lengkap }}</h1>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Informasi Pembina
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong> {{ $pembina->nama_lengkap }}</p>
                    <p><strong>NIP:</strong> {{ $pembina->nip }}</p>
                    <p><strong>Jabatan:</strong> {{ $pembina->jabatan }}</p>
                    <p><strong>Email:</strong> {{ $pembina->user->email }}</p>
                    <p><strong>Nomor HP:</strong> {{ $pembina->nomor_hp }}</p>
                    <a href="{{ route('pembina.edit', $pembina) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('pembina.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-graduation-cap"></i> Peserta Magang ({{ $pesertas->total() }})
                </div>
                <div class="card-body">
                    @if($pesertas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>NISN</th>
                                        <th>Nama</th>
                                        <th>Sekolah</th>
                                        <th>Periode</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pesertas as $peserta)
                                        <tr>
                                            <td>{{ $peserta->nisn }}</td>
                                            <td>{{ $peserta->nama_lengkap }}</td>
                                            <td>{{ $peserta->sekolah }}</td>
                                            <td>{{ $peserta->tanggal_mulai->format('d M Y') }} - {{ $peserta->tanggal_selesai->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('peserta.show', $peserta) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $pesertas->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada peserta yang ditugaskan kepada pembina ini.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
