# 🛠️ PANDUAN SETUP LENGKAP - Sistem Absensi PKL

Panduan detail langkah demi langkah untuk setup sistem dari awal.

## ⚠️ Prerequisite (Syarat Awal)

Sebelum memulai, pastikan sudah install:

- ✅ **PHP 8.2+** - Check dengan: `php -v`
- ✅ **Composer** - Check dengan: `composer -V`
- ✅ **Node.js 18+** - Check dengan: `node -v`
- ✅ **MySQL 8.0+** - Check dengan: `mysql -V`

Jika belum install, silakan download dari:
- [PHP](https://www.php.net/downloads)
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/)
- [MySQL](https://www.mysql.com/downloads/)

---

## 📋 Step-by-Step Installation

### STEP 1: Buka Terminal

```powershell
# PowerShell
cd "c:\Project Andika\absensi-pkl"
```

Pastikan Anda berada di folder project root.

---

### STEP 2: Setup Database MySQL

**2.1 Buka MySQL Command Line:**
```powershell
mysql -u root -p
```

Masukkan password MySQL Anda (biarkan kosong jika tidak ada password).

**2.2 Buat Database:**
```sql
CREATE DATABASE absensi_pkl;
EXIT;
```

**Output yang diharapkan:**
```
Query OK, 1 row affected (0.00 sec)
```

---

### STEP 3: Configure Environment (.env)

**3.1 Edit file `.env` di root folder:**

Cari line ini dan ubah:

```env
# BEFORE:
DB_CONNECTION=sqlite
DB_DATABASE=database.sqlite

# AFTER:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_pkl
DB_USERNAME=root
DB_PASSWORD=                    # Kosong jika tidak ada password
```

**IMPORTANT**: Jangan lupa `php artisan key:generate` di langkah berikutnya!

---

### STEP 4: Install Dependencies PHP

**4.1 Jalankan Composer Install:**
```powershell
composer install
```

**Expected output:**
```
...
Package operations: 120 installs
...
✓ Done
```

**Waktu**: ~2-3 menit tergantung kecepatan internet.

---

### STEP 5: Generate Application Key

```powershell
php artisan key:generate
```

**Expected output:**
```
✓ Application key set successfully.
```

---

### STEP 6: Install Dependencies Node.js

```powershell
npm install
```

**Expected output:**
```
added 200+ packages
...
audited 500 packages
```

**Waktu**: ~1-2 menit.

---

### STEP 7: Create Database Tables (Migration)

```powershell
php artisan migrate
```

**Expected output:**
```
Migrating: 2014_10_12_000000_create_users_table
Migrated:  2014_10_12_000000_create_users_table (0.xx seconds)
Migrating: 2014_10_12_100000_create_password_resets_table
Migrated:  2014_10_12_100000_create_password_resets_table (0.xx seconds)
...
Migrating: 2025_11_27_000004_add_role_to_users_table
Migrated:  2025_11_27_000004_add_role_to_users_table (0.xx seconds)
```

---

### STEP 8: Link Storage

```powershell
php artisan storage:link
```

**Expected output:**
```
✓ The [public/storage] link has been successfully created.
```

Ini diperlukan agar foto yang di-upload bisa diakses dari browser.

---

### STEP 9: Build Frontend Assets

```powershell
npm run build
```

**Expected output:**
```
  ✓ 1234 modules transformed
  ✓ built in 10.21s
```

Atau untuk development mode dengan auto-reload:
```powershell
npm run dev
```

---

### STEP 10: Start Laravel Development Server

```powershell
php artisan serve
```

**Expected output:**
```
Laravel development server started on http://127.0.0.1:8000
```

---

## 🎉 Selesai! Aplikasi Siap Digunakan

Akses aplikasi di: **http://localhost:8000**

---

## 📝 Membuat Test Account

Aplikasi sudah ready! Sekarang Anda perlu membuat test account.

### Opsi 1: Register Peserta via Web (Recommended)

1. Klik **"Daftar"** di homepage
2. Isi form:
   - **Nama Lengkap**: Test Peserta
   - **Email**: peserta@test.com
   - **Password**: password123
   - **Konfirmasi**: password123
3. Klik **"Daftar"**
4. Redirect ke dashboard peserta ✓

### Opsi 2: Create Admin via Tinker

```powershell
php artisan tinker
```

Copy-paste satu per satu:

```php
# Create Admin
$admin = new App\Models\User;
$admin->name = 'Admin Utama';
$admin->email = 'admin@test.com';
$admin->password = bcrypt('password123');
$admin->role = 'admin';
$admin->save();

# Create Pembina
$pembina = new App\Models\User;
$pembina->name = 'Pembina Satu';
$pembina->email = 'pembina@test.com';
$pembina->password = bcrypt('password123');
$pembina->role = 'pembina';
$pembina->save();

# Exit
exit()
```

---

## 🧪 Test Login

Setelah setup, test login dengan:

```
Admin:
  Email: admin@test.com
  Password: password123

Pembina:
  Email: pembina@test.com
  Password: password123

Peserta:
  Email: peserta@test.com
  Password: password123
  (atau register baru)
```

---

## 📁 File Structure yang Akan Dibuat/Dimodifikasi

```
Setelah langkah-langkah di atas, folder akan terlihat seperti:

absensi-pkl/
├── app/
│   ├── Http/
│   │   ├── Controllers/      ← 5 controllers
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── PembinaController.php
│   │   │   ├── PesertaController.php
│   │   │   └── AttendanceController.php
│   │   └── Middleware/
│   │       └── AdminRole.php
│   └── Models/              ← 4 models
│       ├── User.php
│       ├── Pembina.php
│       ├── Peserta.php
│       └── Attendance.php
│
├── database/
│   ├── migrations/          ← 4 migrations
│   │   ├── 2025_11_27_000001_create_pembina_table.php
│   │   ├── 2025_11_27_000002_create_peserta_table.php
│   │   ├── 2025_11_27_000003_create_attendances_table.php
│   │   └── 2025_11_27_000004_add_role_to_users_table.php
│   └── seeders/
│
├── resources/
│   └── views/               ← 18 blade templates
│       ├── layout.blade.php
│       ├── welcome.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── dashboard/
│       │   ├── admin.blade.php
│       │   ├── pembina.blade.php
│       │   └── peserta.blade.php
│       ├── pembina/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       ├── peserta/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       └── attendance/
│           ├── index.blade.php
│           ├── create.blade.php
│           ├── edit.blade.php
│           └── show.blade.php
│
├── routes/
│   └── web.php              ← 25+ routes
│
├── storage/
│   └── app/
│       └── public/
│           └── attendance/  ← Foto upload
│
├── bootstrap/
│   └── app.php              ← Middleware config
│
├── .env                     ← DB Configuration
│
├── README.md
├── QUICK_START.md
├── DOKUMENTASI.md
├── ERD.md
├── CRUD_GUIDE.md
├── CHANGELOG.md
└── SETUP.md                 ← This file
```

---

## 🐛 Troubleshooting

### ❌ "Database connection refused"

```powershell
# Check MySQL running
mysql -u root -p
```

Jika tidak bisa connect, pastikan MySQL service sudah running:
- Windows: Services → MySQL → Start
- macOS: `brew services start mysql`
- Linux: `sudo systemctl start mysql`

---

### ❌ "SQLSTATE[HY000]: General error"

```powershell
# Check migrations
php artisan migrate:status

# Rollback dan re-migrate
php artisan migrate:rollback
php artisan migrate
```

---

### ❌ "The file /public/storage does not exist"

```powershell
php artisan storage:link
```

---

### ❌ Port 8000 already in use

```powershell
php artisan serve --port=8001
```

Akses di: http://localhost:8001

---

### ❌ "composer install" stuck/timeout

```powershell
# Update composer
composer self-update

# Install with lower memory
php -d memory_limit=-1 composer install
```

---

### ❌ "npm install" error

```powershell
# Clear npm cache
npm cache clean --force

# Re-install
npm install
```

---

## ✅ Checklist Verifikasi

Setelah semua selesai, pastikan:

- [ ] Database `absensi_pkl` terbuat
- [ ] `.env` sudah dikonfigurasi MySQL
- [ ] `php artisan key:generate` sudah dijalankan
- [ ] Semua migrations sudah berjalan (`php artisan migrate`)
- [ ] `php artisan storage:link` sudah dijalankan
- [ ] `npm run build` sudah dijalankan
- [ ] Server berjalan dengan `php artisan serve`
- [ ] Bisa akses http://localhost:8000
- [ ] Bisa register peserta baru
- [ ] Dashboard menampilkan dengan benar

---

## 🎯 Next Steps

1. **Baca dokumentasi**: [INDEX.md](INDEX.md)
2. **Cek struktur database**: [ERD.md](ERD.md)
3. **Pelajari CRUD**: [CRUD_GUIDE.md](CRUD_GUIDE.md)
4. **Test semua fitur**:
   - Login dengan berbagai role
   - Upload attendance dengan foto + GPS
   - Lihat monitoring pembina
   - Admin manage pembina & peserta

---

## 📞 Need Help?

Jika ada error:

1. **Check logs**: `storage/logs/laravel.log`
2. **Clear cache**: `php artisan cache:clear`
3. **Re-run migrations**: 
   ```powershell
   php artisan migrate:rollback
   php artisan migrate
   ```
4. **Baca QUICK_START.md** untuk troubleshooting lebih lanjut

---

**Happy Coding! 🚀**

*Setup Guide v1.0 - November 27, 2025*
