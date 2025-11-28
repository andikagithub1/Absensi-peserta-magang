@extends('layout')

@section('title', 'Ubah Password Peserta')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-key"></i> Ubah Password Peserta</h1>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user"></i> {{ $peserta->nama_lengkap }}
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Email:</strong> {{ $peserta->user->email }}</p>
                    <p class="mb-3"><strong>Sekolah:</strong> {{ $peserta->sekolah }}</p>
                    <div class="mb-3">
                        <small class="text-muted d-block">Password Saat Ini:</small>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" id="current-password" value="{{ $peserta->user->plain_password ?? '••••••••' }}" readonly>
                            <button class="btn btn-outline-secondary" type="button" id="toggle-current-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <form action="{{ route('peserta.update-password', $peserta) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted d-block mt-1">Minimal 6 karakter</small>
                            @error('password')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       id="password_confirmation" name="password_confirmation" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggle-password-confirm">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Password
                            </button>
                            <a href="{{ route('peserta.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle current password visibility
        const toggleCurrentBtn = document.getElementById('toggle-current-password');
        const currentPasswordInput = document.getElementById('current-password');
        
        if (toggleCurrentBtn && currentPasswordInput) {
            toggleCurrentBtn.addEventListener('click', function() {
                const type = currentPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                currentPasswordInput.setAttribute('type', type);
                
                const icon = toggleCurrentBtn.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }
        
        // Toggle password visibility
        const toggleBtn = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');
        
        if (toggleBtn && passwordInput) {
            toggleBtn.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                const icon = toggleBtn.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }
        
        // Toggle password confirmation visibility
        const toggleConfirmBtn = document.getElementById('toggle-password-confirm');
        const confirmInput = document.getElementById('password_confirmation');
        
        if (toggleConfirmBtn && confirmInput) {
            toggleConfirmBtn.addEventListener('click', function() {
                const type = confirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmInput.setAttribute('type', type);
                
                const icon = toggleConfirmBtn.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }
    });
</script>
@endsection
