<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sistem Absensi PKL</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 25%, #4facfe 50%, #00f2fe 75%, #43e97b 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Animated background shapes */
        .bg-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 20s ease-in-out infinite;
        }

        .bg-shape-1 {
            width: 300px;
            height: 300px;
            background: #fff;
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }

        .bg-shape-2 {
            width: 200px;
            height: 200px;
            background: #fff;
            bottom: -50px;
            left: -50px;
            animation-delay: 5s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            50% { transform: translateY(20px) translateX(20px); }
        }

        .register-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            position: relative;
            z-index: 10;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            padding: 45px 35px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .register-icon {
            font-size: 48px;
            background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .register-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 5px;
        }

        .register-header p {
            color: #666;
            font-size: 14px;
            margin: 0;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 14px;
            display: block;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            border-color: #f5576c;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(245, 87, 108, 0.1);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            background: #fff5f5;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }

        .form-section-title {
            font-size: 13px;
            font-weight: 600;
            color: #f5576c;
            margin-top: 25px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f5576c;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .register-btn {
            background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 10px;
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(245, 87, 108, 0.4);
            color: white;
        }

        .register-btn:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: #999;
            font-size: 13px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e0e0e0;
        }

        .divider::before {
            margin-right: 10px;
        }

        .divider::after {
            margin-left: 10px;
        }

        .login-link {
            text-align: center;
            color: #666;
            font-size: 14px;
        }

        .login-link a {
            color: #f5576c;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: #f093fb;
            text-decoration: underline;
        }

        .row-cols {
            margin-bottom: 18px;
        }

        .row-cols > div {
            margin-bottom: 0;
        }

        /* Scrollbar styling */
        .register-card {
            max-height: 90vh;
            overflow-y: auto;
        }

        .register-card::-webkit-scrollbar {
            width: 6px;
        }

        .register-card::-webkit-scrollbar-track {
            background: transparent;
        }

        .register-card::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 3px;
        }

        .register-card::-webkit-scrollbar-thumb:hover {
            background: #999;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .register-card {
                padding: 30px 20px;
            }

            .register-header h1 {
                font-size: 24px;
            }

            .register-icon {
                font-size: 40px;
            }

            .bg-shape-1,
            .bg-shape-2 {
                display: none;
            }

            body {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="bg-shape bg-shape-1"></div>
    <div class="bg-shape bg-shape-2"></div>

    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <div class="register-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <h1>Daftar Akun</h1>
                <p>Bergabunglah dengan Sistem Absensi PKL</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>Pendaftaran Gagal!</strong>
                    @foreach ($errors->all() as $error)
                        <div style="font-size: 13px;">{{ $error }}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" id="registerForm">
                @csrf

                <!-- INFORMASI DASAR -->
                <div class="form-section-title">
                    <i class="fas fa-user-circle"></i> Informasi Dasar
                </div>
                
                <div class="form-group">
                    <label for="name" class="form-label">
                        <i class="fas fa-id-card"></i> Nama Lengkap
                    </label>
                    <input 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        placeholder="Masukkan nama lengkap"
                        required
                    >
                    @error('name')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i> Email
                    </label>
                    <input 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="Masukkan email Anda"
                        required
                    >
                    @error('email')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>

                <!-- KEAMANAN -->
                <div class="form-section-title">
                    <i class="fas fa-lock"></i> Keamanan
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        id="password" 
                        name="password" 
                        placeholder="Minimal 6 karakter"
                        required
                    >
                    @error('password')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                    <small class="text-muted" style="display: block; margin-top: 5px;">
                        <i class="fas fa-info-circle"></i> Gunakan password yang kuat (huruf, angka, simbol)
                    </small>
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="Ulangi password Anda"
                        required
                    >
                </div>

                <!-- DATA PESERTA -->
                <div id="pesertaFields" style="display: block;">
                    <div class="form-section-title">
                        <i class="fas fa-graduation-cap"></i> Data Peserta
                    </div>
                    
                    <div class="form-group">
                        <label for="nisn" class="form-label">NISN</label>
                        <input 
                            type="text" 
                            class="form-control @error('nisn') is-invalid @enderror" 
                            id="nisn" 
                            name="nisn" 
                            value="{{ old('nisn') }}"
                            placeholder="Nomor Induk Siswa Nasional"
                        >
                        @error('nisn')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="sekolah" class="form-label">
                            <i class="fas fa-school"></i> Sekolah/Kampus
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('sekolah') is-invalid @enderror" 
                            id="sekolah" 
                            name="sekolah" 
                            value="{{ old('sekolah') }}"
                            placeholder="Nama sekolah atau kampus"
                        >
                        @error('sekolah')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jurusan" class="form-label">
                            <i class="fas fa-book"></i> Jurusan/Program Studi
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('jurusan') is-invalid @enderror" 
                            id="jurusan" 
                            name="jurusan" 
                            value="{{ old('jurusan') }}"
                            placeholder="Nama jurusan atau program studi"
                        >
                        @error('jurusan')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row row-cols">
                        <div class="col-12 col-sm-6">
                            <div class="form-group" style="margin-bottom: 18px;">
                                <label for="tanggal_mulai" class="form-label">
                                    <i class="fas fa-calendar-alt"></i> Tanggal Mulai
                                </label>
                                <input 
                                    type="date" 
                                    class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                    id="tanggal_mulai" 
                                    name="tanggal_mulai" 
                                    value="{{ old('tanggal_mulai') }}"
                                >
                                @error('tanggal_mulai')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="form-group" style="margin-bottom: 18px;">
                                <label for="tanggal_selesai" class="form-label">
                                    <i class="fas fa-calendar-alt"></i> Tanggal Selesai
                                </label>
                                <input 
                                    type="date" 
                                    class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                    id="tanggal_selesai" 
                                    name="tanggal_selesai" 
                                    value="{{ old('tanggal_selesai') }}"
                                >
                                @error('tanggal_selesai')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pembina_id" class="form-label">
                            <i class="fas fa-user-tie"></i> Pilih Pembina
                        </label>
                        <select 
                            class="form-control @error('pembina_id') is-invalid @enderror" 
                            id="pembina_id" 
                            name="pembina_id"
                        >
                            <option value="">-- Pilih Pembina --</option>
                            @foreach($pembinas as $pembina)
                                <option value="{{ $pembina->id }}" {{ old('pembina_id') == $pembina->id ? 'selected' : '' }}>
                                    {{ $pembina->nama_lengkap }} ({{ $pembina->jabatan }})
                                </option>
                            @endforeach
                        </select>
                        @error('pembina_id')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <input type="hidden" name="role" id="role" value="peserta">

                <button type="submit" class="register-btn">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </button>
            </form>
            
            <div class="divider">atau</div>
            
            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-fill peserta fields
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('pesertaFields').style.display = 'block';
        });
    </script>
</body>
</html>
