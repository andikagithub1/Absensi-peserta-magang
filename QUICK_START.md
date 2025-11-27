# QUICK START - Sistem Absensi PKL

## 🚀 Mulai Dalam 5 Menit

### 1. Setup Database

**Buat database MySQL baru:**
```bash
# Via MySQL Command Line
mysql -u root -p
CREATE DATABASE absensi_pkl;
EXIT;
```

### 2. Setup Environment

**Edit file `.env`:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_pkl
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Install & Migrate

```bash
# Masuk ke folder project
cd c:\Project Andika\absensi-pkl

# Install dependencies
composer install
npm install

# Generate key
php artisan key:generate

# Jalankan migrations
php artisan migrate

# Link storage (untuk upload foto)
php artisan storage:link

# Build assets
npm run build
```

### 4. Jalankan Server

**Terminal 1 - PHP Server:**
```bash
php artisan serve
```
Akses di: http://localhost:8000

**Terminal 2 - Vite Dev Server (optional):**
```bash
npm run dev
```

### 5. Test Aplikasi

1. Buka http://localhost:8000
2. Klik **Register** untuk buat akun peserta
3. Akun peserta otomatis terbuat dan bisa login
4. Untuk akun admin/pembina, buat manual dengan Tinker:

```bash
php artisan tinker

# Buat admin
$admin = App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password123'),
    'role' => 'admin'
]);

# Buat pembina
$pembina = App\Models\User::create([
    'name' => 'Pembina Aji',
    'email' => 'pembina@example.com',
    'password' => bcrypt('password123'),
    'role' => 'pembina'
]);

App\Models\Pembina::create([
    'user_id' => $pembina->id,
    'nip' => '123456789',
    'nama_lengkap' => 'Aji Satria, S.Pd.',
    'jabatan' => 'Instruktur',
    'nomor_hp' => '081234567890'
]);

exit;
```

---

## 📱 Akses per Role

### PESERTA
**Login**: Email & Password
**Dashboard**:
- Statistics: Hadir, Izin, Sakit, Alfa
- Button: Tambah Absensi
- View: Riwayat Absensi Pribadi

**Fitur Utama**:
1. Tambah Absensi → Upload foto + GPS Location
2. Edit Absensi → Update data
3. Lihat Detail → Preview foto + koordinat GPS
4. Dashboard → Statistik kehadiran

### PEMBINA
**Login**: Email & Password
**Dashboard**:
- Statistics: Total Peserta, Hadir Hari Ini
- Button: Lihat Absensi Peserta

**Fitur Utama**:
1. Monitor Absensi → Lihat semua peserta binaan
2. Edit Absensi → Verifikasi atau koreksi
3. Detail Peserta → Lihat riwayat lengkap

### ADMIN
**Login**: Email & Password
**Dashboard**:
- Statistics: Total Pembina, Total Peserta, Total Absensi

**Menu**:
1. **Data Pembina** → CRUD pembina
   - Create → Tambah pembina baru
   - Read → Lihat daftar pembina
   - Update → Edit data pembina
   - Delete → Hapus pembina
   - Detail → Lihat peserta binaan

2. **Data Peserta** → CRUD peserta
   - Create → Tambah peserta baru
   - Read → Lihat daftar peserta
   - Update → Edit data peserta
   - Delete → Hapus peserta
   - Detail → Lihat riwayat absensi

---

## 🔑 Test Account Default

Setelah setup, gunakan akun ini untuk testing:

### Admin
```
Email: admin@example.com
Password: password123
Role: admin
```

### Pembina
```
Email: pembina@example.com
Password: password123
Role: pembina
```

---

## 📁 File Struktur Penting

```
absensi-pkl/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php      ← Login/Register
│   │   │   ├── DashboardController.php ← Dashboard
│   │   │   ├── PembinaController.php   ← CRUD Pembina
│   │   │   ├── PesertaController.php   ← CRUD Peserta
│   │   │   └── AttendanceController.php ← CRUD Absensi
│   │   └── Middleware/
│   │       └── AdminRole.php            ← Role validation
│   └── Models/
│       ├── User.php
│       ├── Pembina.php
│       ├── Peserta.php
│       └── Attendance.php
├── database/
│   └── migrations/          ← Database schema
├── resources/views/         ← Frontend Blade
├── routes/
│   └── web.php             ← URL Routes
└── storage/
    └── app/public/attendance/ ← Foto absensi
```

---

## 🌐 URL Routes Reference

### Public Routes
```
GET  /                  → Welcome page
GET  /login             → Login form
POST /login             → Process login
GET  /register          → Register form
POST /register          → Process register
```

### Protected Routes
```
GET  /dashboard         → Dashboard sesuai role

# Pembina Management (Admin Only)
GET    /pembina                → Daftar pembina
GET    /pembina/create         → Form tambah
POST   /pembina                → Simpan pembina
GET    /pembina/{id}           → Detail pembina
GET    /pembina/{id}/edit      → Form edit
PUT    /pembina/{id}           → Update pembina
DELETE /pembina/{id}           → Hapus pembina

# Peserta Management (Admin Only)
GET    /peserta                → Daftar peserta
GET    /peserta/create         → Form tambah
POST   /peserta                → Simpan peserta
GET    /peserta/{id}           → Detail peserta
GET    /peserta/{id}/edit      → Form edit
PUT    /peserta/{id}           → Update peserta
DELETE /peserta/{id}           → Hapus peserta

# Attendance (All Auth Users)
GET    /attendance             → Daftar absensi
GET    /attendance/create      → Form tambah
POST   /attendance             → Simpan absensi
GET    /attendance/{id}        → Detail absensi
GET    /attendance/{id}/edit   → Form edit
PUT    /attendance/{id}        → Update absensi
DELETE /attendance/{id}        → Hapus absensi

# Auth
POST   /logout                 → Logout user
```

---

## 🐛 Troubleshooting

### Error: "SQLSTATE[HY000]: General error"
**Solusi:**
```bash
# Pastikan database sudah dibuat
# Check .env DB_DATABASE, DB_USERNAME, DB_PASSWORD

# Ulang migration
php artisan migrate:fresh
```

### Error: "File not found" pada foto
**Solusi:**
```bash
# Buat symbolic link
php artisan storage:link

# Set permission folder
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### Error: "No application key has been generated"
**Solusi:**
```bash
php artisan key:generate
```

### Geolocation tidak bekerja
**Solusi:**
- Aplikasi harus di HTTPS (atau localhost untuk development)
- Browser harus support Geolocation API
- User harus allow permission akses lokasi

### Port 8000 sudah digunakan
**Solusi:**
```bash
# Gunakan port lain
php artisan serve --port=8001
```

---

## 📋 Checklist Setup

- [ ] Database MySQL created (`absensi_pkl`)
- [ ] `.env` file configured
- [ ] `php artisan key:generate` executed
- [ ] `php artisan migrate` executed
- [ ] `php artisan storage:link` executed
- [ ] `npm install && npm run build` executed
- [ ] `php artisan serve` running on http://localhost:8000
- [ ] Register test peserta account
- [ ] Create admin & pembina via tinker
- [ ] Test login dengan semua role
- [ ] Test upload foto & GPS location
- [ ] Check storage folder untuk foto

---

## 🎯 Fitur yang Sudah Implemented

✅ User Authentication (3 roles: admin, pembina, peserta)
✅ CRUD Pembina (admin only)
✅ CRUD Peserta (admin only)
✅ CRUD Absensi (all roles with access control)
✅ Foto upload & storage
✅ Geolocation GPS capture
✅ Status enum (hadir/izin/sakit/alfa)
✅ Role-based dashboard
✅ Responsive Bootstrap UI
✅ Database migrations & relationships
✅ Eloquent models with relationships

---

## 🚀 Fitur Bonus (Dapat Dikembangkan)

📋 Report export (PDF, Excel)
📧 Email notifications
🔌 REST API
🎫 QR Code attendance
📊 Analytics dashboard
🤖 Biometric integration
📱 Mobile app (React Native/Flutter)
⚡ Real-time monitoring (WebSocket)
🔍 Advanced search & filter
📷 Face recognition

---

## 📞 Support

**Untuk troubleshooting lebih lanjut:**
1. Check `.env` configuration
2. Review database migrations: `php artisan migrate:status`
3. Check logs: `storage/logs/laravel.log`
4. Clear cache: `php artisan cache:clear`
5. Clear config: `php artisan config:clear`

---

## 📚 Dokumentasi Lengkap

Lihat file:
- `DOKUMENTASI.md` - Panduan lengkap sistem
- `ERD.md` - Entity Relationship Diagram
- `CRUD_GUIDE.md` - Detil semua CRUD operation

---

**Happy coding! 🎉**
