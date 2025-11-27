@extends('layout')

@section('title', 'Tambah Pembina')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-1"><i class="fas fa-user-plus"></i> Tambah Data Pembina Baru</h1>
            <small class="text-muted">Lengkapi form di bawah untuk menambahkan pembina baru</small>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12 col-lg-8 mb-3 mb-lg-0">
            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <i class="fas fa-file-alt"></i> <strong>Form Pembina</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('pembina.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <h6 class="text-muted mb-3"><i class="fas fa-user"></i> Data User</h6>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label"><i class="fas fa-id-card"></i> Nama User</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama user" required>
                                @error('name')
                                    <small class="invalid-feedback d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
                                @error('email')
                                    <small class="invalid-feedback d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label"><i class="fas fa-lock"></i> Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Minimal 6 karakter" required>
                                @error('password')
                                    <small class="invalid-feedback d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="mb-4">
                            <h6 class="text-muted mb-3"><i class="fas fa-briefcase"></i> Data Pembina</h6>
                            
                            <div class="row">
                                <div class="col-12 col-sm-6 mb-3">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                                           id="nip" name="nip" value="{{ old('nip') }}" placeholder="Nomor Induk Pegawai" required>
                                    @error('nip')
                                        <small class="invalid-feedback d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                <div class="col-12 col-sm-6 mb-3">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control @error('jabatan') is-invalid @enderror" 
                                           id="jabatan" name="jabatan" value="{{ old('jabatan') }}" placeholder="Misal: Guru, Koordinator" required>
                                    @error('jabatan')
                                        <small class="invalid-feedback d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="nomor_hp" class="form-label"><i class="fas fa-phone"></i> Nomor HP</label>
                                <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" 
                                       id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}" placeholder="08xxxxxxxxxx" required>
                                @error('nomor_hp')
                                    <small class="invalid-feedback d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="d-grid gap-2 d-sm-flex">
                            <a href="{{ route('pembina.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Pembina
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-lg-4">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body">
                    <h6 class="card-title"><i class="fas fa-lightbulb"></i> Panduan</h6>
                    <p class="small mb-2">
                        <strong>NIP:</strong> Nomor induk pegawai harus unik
                    </p>
                    <p class="small mb-2">
                        <strong>Email:</strong> Email akan digunakan untuk login
                    </p>
                    <p class="small">
                        <strong>Password:</strong> Minimal 6 karakter
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
