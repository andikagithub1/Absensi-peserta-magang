@extends('layout')

@section('title', 'Edit Absensi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-edit"></i> Edit Data Absensi</h1>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-form"></i> Form Edit Absensi
                </div>
                <div class="card-body">
                    <form action="{{ route('attendance.update', $attendance) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jam_masuk" class="form-label">Jam Masuk</label>
                                <input type="time" class="form-control @error('jam_masuk') is-invalid @enderror" 
                                       id="jam_masuk" name="jam_masuk" value="{{ old('jam_masuk', $attendance->jam_masuk ? $attendance->jam_masuk->format('H:i') : '') }}">
                                @error('jam_masuk')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="jam_keluar" class="form-label">Jam Keluar</label>
                                <input type="time" class="form-control @error('jam_keluar') is-invalid @enderror" 
                                       id="jam_keluar" name="jam_keluar" value="{{ old('jam_keluar', $attendance->jam_keluar ? $attendance->jam_keluar->format('H:i') : '') }}">
                                @error('jam_keluar')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <h6 class="mb-3"><i class="fas fa-camera"></i> Foto Bukti</h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="foto_masuk" class="form-label">Foto Masuk</label>
                                @if($attendance->foto_masuk)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $attendance->foto_masuk) }}" alt="Foto Masuk" style="max-width: 100%; height: auto;">
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('foto_masuk') is-invalid @enderror" 
                                       id="foto_masuk" name="foto_masuk" accept="image/*">
                                <small class="text-muted">Max 2MB, format: JPG, PNG, GIF</small>
                                @error('foto_masuk')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="foto_keluar" class="form-label">Foto Keluar</label>
                                @if($attendance->foto_keluar)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $attendance->foto_keluar) }}" alt="Foto Keluar" style="max-width: 100%; height: auto;">
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('foto_keluar') is-invalid @enderror" 
                                       id="foto_keluar" name="foto_keluar" accept="image/*">
                                <small class="text-muted">Max 2MB, format: JPG, PNG, GIF</small>
                                @error('foto_keluar')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="hadir" @if(old('status', $attendance->status) == 'hadir') selected @endif>Hadir</option>
                                <option value="izin" @if(old('status', $attendance->status) == 'izin') selected @endif>Izin</option>
                                <option value="sakit" @if(old('status', $attendance->status) == 'sakit') selected @endif>Sakit</option>
                                <option value="alfa" @if(old('status', $attendance->status) == 'alfa') selected @endif>Alfa</option>
                            </select>
                            @error('status')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                      id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $attendance->keterangan) }}</textarea>
                            @error('keterangan')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">
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
