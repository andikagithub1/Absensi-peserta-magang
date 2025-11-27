<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Absensi PKL - Manajemen Kehadiran Modern</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #4e73df;
            --primary-dark: #224abe;
            --primary-light: #6c8bef;
            --secondary: #858796;
            --success: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74c3c;
            --light: #f8f9fc;
            --dark: #2e3338;
            --gray-100: #f3f3f3;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-400: #ced4da;
        }

        html, body {
            height: 100%;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary) !important;
            transition: transform 0.3s;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .navbar-brand i {
            margin-right: 8px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Button Styles */
        .btn-modern {
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .btn-modern-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            box-shadow: 0 4px 15px rgba(78, 115, 223, 0.4);
        }

        .btn-modern-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 115, 223, 0.6);
            color: white;
            text-decoration: none;
        }

        .btn-modern-secondary {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .btn-modern-secondary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 115, 223, 0.4);
            text-decoration: none;
        }

        /* Hero Section */
        .hero-section {
            min-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            position: relative;
            overflow: hidden;
            padding: 2rem;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 800px;
            animation: slideInDown 0.8s ease-out;
        }

        .hero-section h1 {
            font-size: clamp(2.5rem, 8vw, 4rem);
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            letter-spacing: -1px;
        }

        .hero-section p {
            font-size: 1.25rem;
            opacity: 0.95;
            margin-bottom: 2.5rem;
            font-weight: 300;
            line-height: 1.6;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 3rem;
        }

        /* Floating Shape */
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            background: white;
            top: 10%;
            right: 10%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            background: white;
            bottom: 20%;
            left: 10%;
            animation-delay: 2s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            25% { transform: translateY(20px) translateX(10px); }
            50% { transform: translateY(-20px) translateX(-10px); }
            75% { transform: translateY(10px) translateX(20px); }
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Features Section */
        .features-section {
            background: white;
            padding: 5rem 2rem;
            position: relative;
            z-index: 2;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            text-align: center;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .section-subtitle {
            text-align: center;
            color: var(--secondary);
            font-size: 1.1rem;
            margin-bottom: 3.5rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .feature-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 30px rgba(78, 115, 223, 0.2);
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            transition: transform 0.3s;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .feature-card h5 {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        .feature-card p {
            color: var(--secondary);
            line-height: 1.7;
            margin: 0;
        }

        /* Roles Section */
        .roles-section {
            background: linear-gradient(135deg, var(--light) 0%, #f0f4ff 100%);
            padding: 5rem 2rem;
        }

        .role-card {
            background: white;
            border-radius: 12px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 5px solid var(--primary);
            position: relative;
        }

        .role-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, rgba(78, 115, 223, 0.1), transparent);
            border-radius: 50%;
            z-index: 0;
        }

        .role-card-content {
            position: relative;
            z-index: 1;
        }

        .role-card:hover {
            transform: translateX(10px);
            box-shadow: 0 8px 30px rgba(78, 115, 223, 0.15);
        }

        .role-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .role-card h4 {
            font-weight: 700;
            color: var(--dark);
            font-size: 1.4rem;
            margin-bottom: 1rem;
        }

        .role-card p {
            color: var(--secondary);
            line-height: 1.8;
            margin: 0;
        }

        /* Stats */
        .stats-section {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 3rem 2rem;
            margin: 3rem 0;
            border-radius: 15px;
        }

        .stat-item {
            text-align: center;
            padding: 1.5rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.95;
            font-weight: 500;
        }

        /* Footer */
        .footer-custom {
            background: var(--dark);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-custom p {
            margin: 0.5rem 0;
            opacity: 0.85;
        }

        .footer-custom small {
            display: block;
            margin-top: 0.5rem;
        }

        .heart {
            color: var(--danger);
            animation: heartbeat 1.5s ease-in-out infinite;
        }

        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-buttons {
                flex-direction: column;
            }

            .btn-modern {
                justify-content: center;
                width: 100%;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .hero-section h1 {
                font-size: 2rem;
            }

            .hero-section p {
                font-size: 1rem;
            }
        }

        /* Accessibility */
        .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border-width: 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    @if (Route::has('login'))
    <nav class="navbar-custom">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center" style="width: 100%;">
                <a href="{{ url('/') }}" class="navbar-brand">
                    <i class="fas fa-fingerprint"></i> Absensi PKL
                </a>
                <div class="d-flex gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-modern btn-modern-primary">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-modern btn-modern-secondary" style="border: none; padding: 10px 25px;">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-modern btn-modern-primary">
                            <i class="fas fa-sign-in-alt"></i> Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-modern btn-modern-secondary">
                                <i class="fas fa-user-plus"></i> Daftar
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    @endif

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        
        <div class="hero-content">
            <h1>Sistem Manajemen Absensi PKL</h1>
            <p>Platform terintegrasi untuk mencatat kehadiran praktik kerja lapangan dengan foto dokumentasi dan sistem yang mudah digunakan</p>
            
            <div class="hero-buttons">
                @guest
                    <a href="{{ route('login') }}" class="btn-modern btn-modern-primary">
                        <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-modern btn-modern-secondary">
                            <i class="fas fa-user-plus"></i> Buat Akun
                        </a>
                    @endif
                @else
                    <a href="{{ route('dashboard') }}" class="btn-modern btn-modern-primary">
                        <i class="fas fa-tachometer-alt"></i> Ke Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title">Fitur Unggulan</h2>
            <p class="section-subtitle">Kemudahan dalam mengelola kehadiran PKL secara efisien dan terorganisir</p>
            
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-camera"></i>
                        </div>
                        <h5>Foto Kehadiran</h5>
                        <p>Tangkap foto dokumentasi saat absensi untuk verifikasi dan keamanan data kehadiran.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h5>Pencatatan Waktu</h5>
                        <p>Sistem pencatatan jam masuk dan keluar yang akurat untuk setiap sesi kerja.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h5>Laporan Kehadiran</h5>
                        <p>Laporan kehadiran terperinci yang dapat diakses oleh admin dan pembina kapan saja.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5>Manajemen Multi Pengguna</h5>
                        <p>Sistem role-based untuk admin, pembina, dan peserta dengan hak akses berbeda.</p>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="stats-section mt-5">
                <div class="row">
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <div class="stat-number">3</div>
                            <div class="stat-label">Role Pengguna</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <div class="stat-number">24/7</div>
                            <div class="stat-label">Tersedia</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <div class="stat-number">100%</div>
                            <div class="stat-label">Aman</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <div class="stat-number">⚡</div>
                            <div class="stat-label">Cepat</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Roles Section -->
    <section class="roles-section">
        <div class="container">
            <h2 class="section-title">Peran Pengguna</h2>
            <p class="section-subtitle">Sistem dirancang dengan tiga peran utama untuk manajemen yang optimal</p>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="role-card">
                        <div class="role-card-content">
                            <div class="role-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h4>Peserta PKL</h4>
                            <p>Melakukan absensi harian, melihat riwayat kehadiran pribadi, mengelola profil, dan mengupload dokumentasi.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="role-card">
                        <div class="role-card-content">
                            <div class="role-icon">
                                <i class="fas fa-chalkboard-user"></i>
                            </div>
                            <h4>Pembina/Mentor</h4>
                            <p>Mengelola peserta binaan, memverifikasi data absensi, membuat laporan kehadiran, dan monitoring progress.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="role-card">
                        <div class="role-card-content">
                            <div class="role-icon">
                                <i class="fas fa-shield"></i>
                            </div>
                            <h4>Administrator</h4>
                            <p>Mengelola seluruh sistem, user management, konfigurasi, laporan keseluruhan, dan maintenance aplikasi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-custom">
        <div class="container">
            <p>
                <strong>Sistem Manajemen Absensi PKL</strong>
            </p>
            <p>
                Dibangun dengan <span class="heart"><i class="fas fa-heart"></i></span> menggunakan teknologi Laravel, Bootstrap, dan AI.
            </p>
            <p>
                <small>&copy; 2024 - Sistem Absensi PKL. Hak cipta dilindungi.</small>
            </p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
