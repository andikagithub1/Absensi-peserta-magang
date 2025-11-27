@extends('layout')

@section('title', 'Edit Peserta')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-edit"></i> Edit Data Peserta</h1>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-form"></i> Form Edit Peserta
                </div>
                <div class="card-body">
                    <form action="{{ route('peserta.update', $peserta) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="pembina_id" class="form-label">Pembina</label>
                            <select class="form-control @error('pembina_id') is-invalid @enderror" 
                                    id="pembina_id" name="pembina_id" required>
                                <option value="">-- Pilih Pembina --</option>
                                @foreach($pembinas as $pembina)
                                    <option value="{{ $pembina->id }}" @if(old('pembina_id', $peserta->pembina_id) == $pembina->id) selected @endif>
                                        {{ $pembina->nama_lengkap }} ({{ $pembina->jabatan }})
                                    </option>
                                @endforeach
                            </select>
                            @error('pembina_id')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                   id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $peserta->nama_lengkap) }}" required>
                            @error('nama_lengkap')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="sekolah" class="form-label">Sekolah</label>
                            <input type="text" class="form-control @error('sekolah') is-invalid @enderror" 
                                   id="sekolah" name="sekolah" value="{{ old('sekolah', $peserta->sekolah) }}" required>
                            @error('sekolah')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <input type="text" class="form-control @error('jurusan') is-invalid @enderror" 
                                   id="jurusan" name="jurusan" value="{{ old('jurusan', $peserta->jurusan) }}" required>
                            @error('jurusan')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                       id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $peserta->tanggal_mulai?->format('Y-m-d')) }}" required>
                                @error('tanggal_mulai')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                       id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $peserta->tanggal_selesai?->format('Y-m-d')) }}" required>
                                @error('tanggal_selesai')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nomor_hp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" 
                                   id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp', $peserta->nomor_hp) }}" required>
                            @error('nomor_hp')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <a href="{{ route('peserta.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Perbarui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
