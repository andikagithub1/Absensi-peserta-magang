<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - 403</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .error-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            padding: 60px 40px;
            max-width: 500px;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-code {
            font-size: 80px;
            font-weight: 700;
            color: #667eea;
            line-height: 1;
            margin-bottom: 20px;
        }

        .error-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }

        .error-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
        }

        .error-message {
            font-size: 18px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .error-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .error-details {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: left;
            font-size: 13px;
            color: #555;
        }

        .error-details strong {
            color: #667eea;
            display: block;
            margin-bottom: 5px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #e0e0e0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #d0d0d0;
            transform: translateY(-2px);
        }

        .warning-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            font-size: 13px;
            color: #856404;
        }

        .warning-box strong {
            display: block;
            margin-bottom: 5px;
        }

        @media (max-width: 600px) {
            .error-container {
                padding: 40px 25px;
            }

            .error-code {
                font-size: 60px;
            }

            .error-title {
                font-size: 22px;
            }

            .error-message {
                font-size: 16px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">🚫</div>
        <div class="error-code">403</div>
        <h1 class="error-title">Akses Ditolak</h1>
        <p class="error-message">Ini bukan tempat anda</p>
        <p class="error-description">
            Anda tidak memiliki izin untuk mengakses halaman ini. 
            Silahkan periksa kembali URL atau hubungi administrator jika merasa ini adalah kesalahan.
        </p>

        <div class="error-details">
            <strong>Penyebab Kemungkinan:</strong>
            • Anda belum login ke sistem<br>
            • Peran akun Anda tidak memiliki akses ke halaman ini<br>
            • Sesi Anda telah berakhir<br>
            • Anda mencoba mengakses halaman yang dibatasi
        </div>

        <div class="action-buttons">
            @if(Auth::check())
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Login ke Sistem</a>
                <a href="/" class="btn btn-secondary">Kembali ke Beranda</a>
            @endif
        </div>

        <div class="warning-box">
            <strong>⚠️ Catatan Keamanan:</strong>
            Jika Anda terus menerima pesan ini, jangan ulangi percobaan. 
            Hubungi administrator untuk bantuan lebih lanjut.
        </div>
    </div>
</body>
</html>
