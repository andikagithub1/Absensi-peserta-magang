@extends('layout')

@section('title', 'Tambah Peserta')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-user-plus"></i> Tambah Data Peserta</h1>
    </div>
    
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-form"></i> Form Tambah Peserta
                </div>
                <div class="card-body">
                    <form action="{{ route('peserta.store') }}" method="POST">
                        @csrf
                        
                        <h6 class="mb-3"><i class="fas fa-user"></i> Data User</h6>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama User</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <hr>
                        
                        <h6 class="mb-3"><i class="fas fa-graduation-cap"></i> Data Peserta</h6>
                        
                        <div class="mb-3">
                            <label for="pembina_id" class="form-label">Pembina</label>
                            <select class="form-control @error('pembina_id') is-invalid @enderror" 
                                    id="pembina_id" name="pembina_id" required>
                                <option value="">-- Pilih Pembina --</option>
                                @foreach($pembinas as $pembina)
                                    <option value="{{ $pembina->id }}" @if(old('pembina_id') == $pembina->id) selected @endif>
                                        {{ $pembina->nama_lengkap }} ({{ $pembina->jabatan }})
                                    </option>
                                @endforeach
                            </select>
                            @error('pembina_id')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" class="form-control @error('nisn') is-invalid @enderror" 
                                   id="nisn" name="nisn" value="{{ old('nisn') }}" required>
                            @error('nisn')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                   id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                            @error('nama_lengkap')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="sekolah" class="form-label">Sekolah</label>
                            <input type="text" class="form-control @error('sekolah') is-invalid @enderror" 
                                   id="sekolah" name="sekolah" value="{{ old('sekolah') }}" required>
                            @error('sekolah')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <input type="text" class="form-control @error('jurusan') is-invalid @enderror" 
                                   id="jurusan" name="jurusan" value="{{ old('jurusan') }}" required>
                            @error('jurusan')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-12 col-sm-6 mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                       id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                                @error('tanggal_mulai')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-12 col-sm-6 mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                       id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                                @error('tanggal_selesai')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nomor_hp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" 
                                   id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}" required>
                            @error('nomor_hp')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-sm-flex">
                            <a href="{{ route('peserta.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
