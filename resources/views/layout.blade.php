<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>@yield('title') - Absensi PKL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }
        
        body {
            background-color: #f8f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .sidebar {
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            width: 200px;
            overflow-y: auto;
            transition: all 0.3s;
        }

        .sidebar-header {
            padding: 1.5rem;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-header h5 {
            margin-bottom: 0.25rem;
            font-weight: 700;
        }

        .sidebar-header small {
            opacity: 0.85;
        }
        
        .sidebar a {
            color: #fff;
            text-decoration: none;
            transition: all 0.3s;
            display: block;
            padding: 0.75rem 1rem;
            border-left: 3px solid transparent;
        }
        
        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 3px solid #fff;
            padding-left: 1rem;
        }
        
        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 3px solid #fff;
        }

        .sidebar nav {
            padding: 1rem 0;
        }

        .sidebar hr {
            background-color: rgba(255, 255, 255, 0.2);
            margin: 1rem 0;
        }

        .main-content {
            padding: 20px;
            transition: all 0.3s;
        }

        .sidebar-toggle {
            display: none;
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 1rem;
        }
        
        .navbar-top {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border-radius: 0.35rem;
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 600;
            color: #495057;
            padding: 1rem;
        }

        .card-body {
            padding: 1.5rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #224abe;
            border-color: #224abe;
        }
        
        .stat-card {
            border-left: 0.25rem solid var(--primary-color);
        }
        
        .alert-custom {
            border-radius: 0.35rem;
        }

        /* Enhanced CRUD Styling */
        .table-hover tbody tr {
            transition: all 0.3s ease;
        }
        
        .table-hover tbody tr:hover {
            background-color: #f0f3ff;
            transform: translateX(2px);
        }
        
        .btn-sm {
            border-radius: 0.25rem;
            font-size: 0.75rem;
            padding: 0.35rem 0.6rem;
            transition: all 0.2s;
        }
        
        .btn-sm:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.15);
        }
        
        .btn-sm.btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        
        .btn-sm.btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
        }
        
        .btn-sm.btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
        }
        
        .btn-sm.btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }
        
        .btn-sm.btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        
        .btn-sm.btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        
        .btn-primary {
            border-radius: 0.35rem;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s;
            box-shadow: 0 2px 4px rgba(78, 115, 223, 0.2);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(78, 115, 223, 0.3);
        }
        
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table-light {
            background-color: #f8f9fa;
        }
        
        .table-light th {
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
        }
        
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .page-link {
            border-radius: 0.25rem;
            margin: 0 2px;
        }
        
        .page-link:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        /* Form styling */
        .form-control, .form-select {
            border: 1px solid #e3e6f0;
            border-radius: 0.35rem;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
                background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            }

            .sidebar-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .sidebar nav {
                display: none;
                padding: 0;
            }

            .sidebar nav.show {
                display: block;
            }

            .sidebar-toggle {
                display: inline-block;
            }

            .main-content {
                padding: 15px;
            }

            .container-fluid {
                padding: 0;
            }

            .row {
                margin-left: -7.5px;
                margin-right: -7.5px;
            }

            .col-md-1, .col-md-2, .col-md-3, .col-md-4, 
            .col-md-5, .col-md-6, .col-md-7, .col-md-8, 
            .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
                padding-left: 7.5px;
                padding-right: 7.5px;
            }

            .card {
                margin-bottom: 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .table-responsive {
                font-size: 0.85rem;
            }

            .table-hover tbody tr:hover {
                transform: none;
            }

            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.7rem;
            }

            .btn-group-sm {
                gap: 0.25rem;
            }

            .btn-group-sm .btn {
                padding: 0.25rem 0.4rem;
            }

            .d-flex {
                flex-wrap: wrap;
            }

            .table thead {
                font-size: 0.8rem;
            }

            .table tbody {
                font-size: 0.85rem;
            }

            /* Collapsible table columns */
            .table th:nth-child(n+5),
            .table td:nth-child(n+5) {
                display: none;
            }

            @media (min-width: 576px) {
                .table th:nth-child(n+4),
                .table td:nth-child(n+4) {
                    display: none;
                }
            }

            h1 {
                font-size: 1.5rem;
            }

            h2 {
                font-size: 1.3rem;
            }

            h3 {
                font-size: 1.1rem;
            }

            .mb-4 {
                margin-bottom: 1rem !important;
            }

            .py-4 {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 10px;
            }

            .card-body {
                padding: 0.75rem;
            }

            .btn-primary {
                padding: 0.4rem 1rem;
                font-size: 0.9rem;
                width: 100%;
            }

            .btn-secondary {
                padding: 0.4rem 1rem;
                font-size: 0.9rem;
                width: 100%;
            }

            .d-flex.gap-2 {
                flex-direction: column;
                gap: 0.5rem !important;
            }

            .d-flex.gap-2 > * {
                width: 100%;
            }

            .form-control, .form-select {
                font-size: 16px;
            }

            .table thead {
                display: none;
            }

            .table tbody tr {
                border: 1px solid #dee2e6;
                display: block;
                margin-bottom: 1rem;
            }

            .table tbody td {
                display: block;
                text-align: right;
                padding-left: 50%;
                position: relative;
                border: none;
                padding-top: 0.5rem;
                padding-bottom: 0.5rem;
            }

            .table tbody td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                font-weight: bold;
                width: 50%;
                padding-left: 1rem;
                text-align: left;
            }

            .table-light th {
                display: none;
            }

            /* Utility classes for mobile */
            .d-none-sm {
                display: none !important;
            }

            .d-flex-sm {
                display: flex !important;
            }

            .text-center-sm {
                text-align: center !important;
            }

            .w-100-sm {
                width: 100% !important;
            }

            .mt-2-sm {
                margin-top: 0.5rem !important;
            }

            .mb-2-sm {
                margin-bottom: 0.5rem !important;
            }
        }

        @media (min-width: 769px) {
            body {
                display: flex;
            }

            .sidebar {
                position: fixed;
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
                flex: 1;
            }
        }
    </style>
</head>
<body>
    <div class="flex-container" style="display: flex; width: 100%;">
        {{-- Sidebar --}}
        @auth
        <div class="sidebar">
            <div class="sidebar-header">
                <div>
                    <h5><i class="fas fa-user-check"></i> Absensi PKL</h5>
                    <small>{{ ucfirst(auth()->user()->role) }}</small>
                </div>
                <button class="sidebar-toggle d-md-none" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <nav class="nav flex-column" id="sidebarNav">
                <a href="{{ route('dashboard') }}" class="nav-link @if(Route::currentRouteName() == 'dashboard') active @endif">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('pembina.index') }}" class="nav-link @if(Route::is('pembina.*')) active @endif">
                        <i class="fas fa-users"></i> Data Pembina
                    </a>
                    <a href="{{ route('peserta.index') }}" class="nav-link @if(Route::is('peserta.*')) active @endif">
                        <i class="fas fa-graduation-cap"></i> Data Peserta
                    </a>
                @endif
                
                @if(auth()->user()->role !== 'admin')
                    <a href="{{ route('attendance.index') }}" class="nav-link @if(Route::is('attendance.*')) active @endif">
                        <i class="fas fa-clock"></i> Absensi
                    </a>
                @endif
                
                <hr class="my-2" style="background-color: rgba(255,255,255,0.2);">
                
                <form action="{{ route('logout') }}" method="POST" style="display: inline; width: 100%;" id="logoutForm">
                    @csrf
                    <button type="submit" class="nav-link border-0 bg-transparent text-start w-100" onclick="this.form.submit(); return false;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </nav>
        </div>
        @endauth
        
        {{-- Main Content --}}
        <div class="@auth flex-grow-1 @else w-100 @endauth">
            <div class="main-content">
                {{-- Alert Messages --}}
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show alert-custom" role="alert">
                        <i class="fas fa-check-circle"></i> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show alert-custom" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                {{-- Content --}}
                @yield('content')
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggleSidebar() {
            const nav = document.getElementById('sidebarNav');
            nav.classList.toggle('show');
        }

        // Close sidebar when clicking on a link
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    document.getElementById('sidebarNav').classList.remove('show');
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                document.getElementById('sidebarNav').classList.remove('show');
            }
        });
    </script>
</body>
</html>
