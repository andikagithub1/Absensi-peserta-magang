# Sistem Absensi PKL (Praktik Kerja Lapangan)

Sistem manajemen absensi terintegrasi untuk Program Kerja Lapangan (PKL) dengan fitur foto bukti, lokasi GPS akurat, dan monitoring pembina.

## 📋 Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi Database](#konfigurasi-database)
- [ERD (Entity Relationship Diagram)](#erd-entity-relationship-diagram)
- [Struktur CRUD](#struktur-crud)
- [Penggunaan](#penggunaan)
- [Teknologi](#teknologi)

## ✨ Fitur Utama

### 1. **Manajemen User dengan Role-Based Access**
   - Admin: Mengelola pembina dan peserta
   - Pembina: Monitoring peserta binaan
   - Peserta: Input absensi pribadi

### 2. **Absensi dengan Bukti Nyata**
   - Upload foto masuk dan keluar
   - Pencatatan GPS location (latitude/longitude)
   - Timestamp otomatis

### 3. **Dashboard untuk Setiap Role**
   - Admin: Statistik pembina, peserta, dan absensi
   - Pembina: Monitoring peserta dan kehadiran harian
   - Peserta: Statistik kehadiran dan riwayat absensi

### 4. **Status Absensi Fleksibel**
   - Hadir
   - Izin
   - Sakit
   - Alfa

### 5. **Laporan dan Monitoring**
   - Riwayat absensi lengkap per peserta
   - Verifikasi pembina
   - Export data (dapat dikembangkan)

## 🖥️ Persyaratan Sistem

- PHP 8.2+
- Laravel 12.0
- MySQL 8.0+
- Node.js & NPM
- Composer

## 📦 Instalasi

### 1. Clone atau setup project
```bash
cd c:\Project Andika\absensi-pkl
```

### 2. Install dependencies
```bash
composer install
npm install
```

### 3. Generate Application Key
```bash
php artisan key:generate
```

### 4. Setup Database
```bash
# Buat database MySQL terlebih dahulu
CREATE DATABASE absensi_pkl;
```

### 5. Update .env
Sesuaikan konfigurasi database di file `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_pkl
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Jalankan Migrations
```bash
php artisan migrate
```

### 7. Build Assets
```bash
npm run build
```

### 8. Link Storage (untuk upload foto)
```bash
php artisan storage:link
```

## 🗄️ Konfigurasi Database

### Database Connection
```php
// config/database.php - Gunakan MySQL
'default' => env('DB_CONNECTION', 'mysql')
```

### File Storage untuk Foto
```
storage/app/public/attendance/  <- Foto absensi disimpan di sini
```

## 📊 ERD (Entity Relationship Diagram)

```
┌─────────────┐
│   USERS     │
├─────────────┤
│ id (PK)     │
│ name        │
│ email       │
│ password    │
│ role        │◄─────┐
│ timestamps  │      │
└─────────────┘      │
        ▲            │
        │            │
        ├────────────┼──────────────┐
        │            │              │
   ┌────┴───────┐   │         ┌────┴───────────┐
   │  PEMBINAS   │   │         │   PESERTAS     │
   ├─────────────┤   │         ├────────────────┤
   │ id (PK)     │   │         │ id (PK)        │
   │ user_id (FK)├───┘         │ user_id (FK)   ├───┐
   │ nip         │             │ pembina_id (FK)├───┼──┐
   │ nama_lengkap│             │ nisn           │   │  │
   │ jabatan     │             │ nama_lengkap   │   │  │
   │ nomor_hp    │             │ sekolah        │   │  │
   │ timestamps  │             │ jurusan        │   │  │
   └─────────────┘             │ tanggal_mulai  │   │  │
        ▲                       │ tanggal_selesai│   │  │
        │                       │ nomor_hp       │   │  │
        │                       │ timestamps     │   │  │
        │                       └────────────────┘   │  │
        │                              ▲             │  │
        │                              │             │  │
        │                              └─────────────┘  │
        │                                               │
   ┌────┴──────────────────────────────────────────────┴──┐
   │                  ATTENDANCES                         │
   ├─────────────────────────────────────────────────────┤
   │ id (PK)                                              │
   │ peserta_id (FK)  ──────────────┐                    │
   │ tanggal                         │                    │
   │ jam_masuk                       │                    │
   │ jam_keluar                      │                    │
   │ foto_masuk                      │                    │
   │ foto_keluar                     │                    │
   │ latitude_masuk                  │                    │
   │ longitude_masuk                 │                    │
   │ latitude_keluar                 │                    │
   │ longitude_keluar                │                    │
   │ status (hadir/izin/sakit/alfa) │                    │
   │ keterangan                      │                    │
   │ timestamps                      │                    │
   └─────────────────────────────────────────────────────┘

Relationship:
- USERS (1) ──── (1) PEMBINAS
- USERS (1) ──── (1) PESERTAS
- PEMBINAS (1) ──── (N) PESERTAS
- PESERTAS (1) ──── (N) ATTENDANCES
```

## 🔄 Struktur CRUD

### User Management (Auth)
- **CREATE**: Register user baru (role: peserta)
- **READ**: Login dan akses dashboard sesuai role
- **UPDATE**: Tidak diimplementasikan (dapat dikembangkan)
- **DELETE**: Otomatis saat delete pembina/peserta

### Pembina Management (Admin Only)
```
POST   /pembina           -> Create pembina baru
GET    /pembina           -> List semua pembina
GET    /pembina/{id}      -> Detail pembina & pesertanya
PUT    /pembina/{id}      -> Update data pembina
DELETE /pembina/{id}      -> Hapus pembina
```

### Peserta Management (Admin Only)
```
POST   /peserta           -> Create peserta baru
GET    /peserta           -> List semua peserta
GET    /peserta/{id}      -> Detail peserta & riwayat absensi
PUT    /peserta/{id}      -> Update data peserta
DELETE /peserta/{id}      -> Hapus peserta
```

### Attendance Management (All Roles)
```
POST   /attendance        -> Create/input absensi baru
GET    /attendance        -> List absensi (sesuai role)
GET    /attendance/{id}   -> Detail absensi lengkap
PUT    /attendance/{id}   -> Update absensi & foto
DELETE /attendance/{id}   -> Hapus absensi
```

## 🚀 Penggunaan

### 1. Jalankan Development Server
```bash
# Terminal 1: PHP Server
php artisan serve

# Terminal 2 (Optional): Watch assets
npm run dev

# Terminal 3 (Optional): Queue listener
php artisan queue:listen
```

Aplikasi akan berjalan di: `http://localhost:8000`

### 2. Login

#### User Admin (Register dulu atau buat via tinker)
```bash
php artisan tinker
>>> $user = App\Models\User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password'), 'role' => 'admin']);
```

#### User Peserta
- Register langsung di halaman register
- Role otomatis set ke 'peserta'

#### User Pembina
- Dibuat oleh admin melalui menu Data Pembina

### 3. Fitur Utama

#### Peserta:
1. Login ke dashboard
2. Klik "Tambah Absensi"
3. Isi form:
   - Tanggal
   - Jam masuk/keluar
   - Upload foto masuk/keluar
   - Ambil lokasi GPS (perlu browser permission)
   - Pilih status (Hadir/Izin/Sakit/Alfa)
4. Submit

#### Pembina:
1. Login ke dashboard
2. Lihat statistik peserta
3. Klik menu Absensi untuk memonitor kehadiran peserta
4. Bisa edit atau verifikasi absensi peserta

#### Admin:
1. Login ke dashboard
2. Kelola data Pembina (CRUD)
3. Kelola data Peserta (CRUD)
4. Lihat statistik keseluruhan

## 💻 Teknologi

### Backend
- **Framework**: Laravel 12.0
- **Language**: PHP 8.2
- **Database**: MySQL 8.0
- **ORM**: Eloquent

### Frontend
- **Template Engine**: Blade
- **CSS Framework**: Bootstrap 5.3
- **Icons**: Font Awesome 6.4
- **JavaScript**: Vanilla JS (untuk Geolocation)
- **Build Tool**: Vite

### Storage
- **Local Storage**: untuk penyimpanan foto
- **File System Disk**: public (publishable storage)

## 📝 File Penting

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php       # Login/Register
│   │   ├── DashboardController.php  # Dashboard per role
│   │   ├── PembinaController.php    # CRUD Pembina
│   │   ├── PesertaController.php    # CRUD Peserta
│   │   └── AttendanceController.php # CRUD Absensi
│   └── Middleware/
│       └── AdminRole.php            # Role validation
├── Models/
│   ├── User.php
│   ├── Pembina.php
│   ├── Peserta.php
│   └── Attendance.php
└── ...

database/
├── migrations/
│   ├── 2025_11_27_000001_create_pembina_table.php
│   ├── 2025_11_27_000002_create_peserta_table.php
│   ├── 2025_11_27_000003_create_attendances_table.php
│   └── 2025_11_27_000004_add_role_to_users_table.php
└── ...

resources/
├── views/
│   ├── layout.blade.php              # Master layout
│   ├── welcome.blade.php             # Home page
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── dashboard/
│   │   ├── admin.blade.php
│   │   ├── pembina.blade.php
│   │   └── peserta.blade.php
│   ├── pembina/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── show.blade.php
│   ├── peserta/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── show.blade.php
│   └── attendance/
│       ├── index.blade.php
│       ├── create.blade.php
│       ├── edit.blade.php
│       └── show.blade.php
└── ...

routes/
└── web.php                          # All routes
```

## 🔒 Security

- ✅ Password hashing dengan bcrypt
- ✅ CSRF protection (Laravel built-in)
- ✅ Role-based access control
- ✅ Input validation pada setiap form
- ✅ Middleware protection untuk routes

## 📸 Fitur Bonus yang Dapat Dikembangkan

1. **Report Export**: Export absensi ke PDF/Excel
2. **Email Notification**: Kirim notifikasi ke pembina/admin
3. **API Endpoint**: Untuk integrasi dengan aplikasi mobile
4. **QR Code**: Absensi via QR Code scanning
5. **Analytics Chart**: Dashboard dengan visualisasi data
6. **Biometric Integration**: Integrasi dengan sistem pengenalan wajah
7. **Mobile App**: Aplikasi mobile dengan React Native/Flutter
8. **Real-time Monitoring**: WebSocket untuk monitoring live

## 🆘 Troubleshooting

### Error: "SQLSTATE[HY000]: General error"
```bash
# Pastikan database sudah dibuat dan credentials benar di .env
# Jalankan migration ulang
php artisan migrate:fresh
```

### Error: "File not found" pada foto
```bash
# Pastikan storage link sudah dibuat
php artisan storage:link

# Set permission folder storage
chmod -R 775 storage/
```

### Geolocation tidak bekerja
```
- Pastikan aplikasi dijalankan dengan HTTPS (atau localhost)
- Chrome dan browser lain memerlukan HTTPS untuk Geolocation API
```

## 📞 Support

Untuk pertanyaan atau masalah, silakan hubungi admin sistem.

---

**Dibuat dengan ❤️ menggunakan Laravel dan Bootstrap**
