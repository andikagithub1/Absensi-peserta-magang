# 📋 Sistem Absensi PKL (Praktik Kerja Lapangan)

> Sistem manajemen absensi terintegrasi untuk Program Kerja Lapangan dengan fitur foto bukti, lokasi GPS akurat, dan monitoring pembina.

## 🏗️ Architecture Diagrams

### 📊 Entity Relationship Diagram (ERD)

```mermaid
erDiagram
    USERS ||--|| PEMBINAS : has
    USERS ||--|| PESERTAS : has
    PEMBINAS ||--o{ PESERTAS : supervises
    PESERTAS ||--o{ ATTENDANCES : records

    USERS {
        bigint id PK
        string name
        string email UK
        enum role "admin|pembina|peserta"
        string password
        string plain_password
        longtext encrypted_password
        timestamp email_verified_at
        string remember_token
        timestamp created_at
        timestamp updated_at
    }

    PEMBINAS {
        bigint id PK
        bigint user_id FK
        string nip UK
        string nama_lengkap
        string jabatan
        string nomor_hp
        timestamp created_at
        timestamp updated_at
    }

    PESERTAS {
        bigint id PK
        bigint user_id FK
        bigint pembina_id FK
        string nisn UK
        string nama_lengkap
        string sekolah
        string jurusan
        date tanggal_mulai
        date tanggal_selesai
        string nomor_hp
        decimal latitude_tempat_kerja
        decimal longitude_tempat_kerja
        int radius_toleransi
        timestamp created_at
        timestamp updated_at
    }

    ATTENDANCES {
        bigint id PK
        bigint peserta_id FK
        date tanggal
        time jam_masuk
        time jam_keluar
        varchar foto_masuk
        varchar foto_keluar
        decimal latitude_masuk
        decimal longitude_masuk
        decimal latitude_keluar
        decimal longitude_keluar
        enum status "hadir|izin|sakit|alfa"
        text keterangan
        longtext tanda_tangan
        timestamp created_at
        timestamp updated_at
    }
```

### 🎯 UML Class Diagram

```mermaid
classDiagram
    class User {
        -bigint id
        -string name
        -string email
        -enum role
        -string password
        -string plain_password
        -longtext encrypted_password
        +authenticate()
        +hasRole()
        +pembina()
        +peserta()
    }

    class Pembina {
        -bigint id
        -bigint user_id
        -string nip
        -string nama_lengkap
        -string jabatan
        -string nomor_hp
        +pesertas()
        +user()
    }

    class Peserta {
        -bigint id
        -bigint user_id
        -bigint pembina_id
        -string nisn
        -string nama_lengkap
        -string sekolah
        -string jurusan
        -date tanggal_mulai
        -date tanggal_selesai
        -decimal latitude_tempat_kerja
        -decimal longitude_tempat_kerja
        -int radius_toleransi
        +attendances()
        +pembina()
        +user()
        +getStatusKehadiran()
    }

    class Attendance {
        -bigint id
        -bigint peserta_id
        -date tanggal
        -time jam_masuk
        -time jam_keluar
        -varchar foto_masuk
        -varchar foto_keluar
        -decimal latitude_masuk
        -decimal longitude_masuk
        -decimal latitude_keluar
        -decimal longitude_keluar
        -enum status
        -text keterangan
        -longtext tanda_tangan
        +peserta()
        +isInRadius()
        +calculateDistance()
    }

    class UserController {
        +authenticate()
        +logout()
    }

    class PembinaController {
        +index()
        +create()
        +store()
        +edit()
        +update()
        +destroy()
        +show()
    }

    class PesertaController {
        +index()
        +create()
        +store()
        +edit()
        +update()
        +destroy()
    }

    class AttendanceController {
        +index()
        +create()
        +store()
        +edit()
        +update()
        +destroy()
        +show()
    }

    User "1" -- "1" Pembina : has
    User "1" -- "1" Peserta : has
    Pembina "1" -- "*" Peserta : supervises
    Peserta "1" -- "*" Attendance : records

    UserController --> User : manages
    PembinaController --> Pembina : manages
    PesertaController --> Peserta : manages
    AttendanceController --> Attendance : manages
```

### 🔄 System Flow Diagram

```mermaid
graph TD
    A[User Access] --> B{Check Role}
    B -->|Admin| C[Admin Dashboard]
    B -->|Pembina| D[Pembina Dashboard]
    B -->|Peserta| E[Peserta Dashboard]
    
    C --> C1[Manage Pembina]
    C --> C2[Manage Peserta]
    C --> C3[View Attendance]
    
    D --> D1[Monitor Peserta]
    D --> D2[View Attendance]
    
    E --> E1[Create Attendance]
    E1 --> E2[Upload Foto]
    E2 --> E3[Get GPS Location]
    E3 --> E4[Draw Signature]
    E4 --> E5[Submit]
    
    E5 --> F[Save to Database]
    F --> G[Notify Pembina]
    G --> D2
```

### 🛡️ Security Architecture

```mermaid
graph LR
    A[Request] --> B[CSRF Token]
    B --> C[Authentication]
    C --> D{Authorization}
    D -->|Allowed| E[Execute Action]
    D -->|Denied| F[403 Forbidden]
    E --> G[Validate Input]
    G --> H[Process]
    H --> I[Response]
    F --> I
```

## 🌟 Fitur Utama

- 📸 **Upload Foto Bukti** - Peserta dapat upload foto saat masuk dan keluar
- 📍 **GPS Location Tracking** - Pencatatan koordinat lokasi otomatis untuk verifikasi
- 👁️ **Monitoring Pembina** - Pembina dapat memantau kehadiran semua peserta binaan
- 📊 **Dashboard Analytics** - Dashboard untuk 3 role berbeda (Admin, Pembina, Peserta)
- ✅ **CRUD Lengkap** - Manajemen data pembina, peserta, dan absensi
- 🔐 **Role-Based Access** - Sistem security dengan 3 role berbeda
- 🎨 **UI/UX Responsive** - Interface yang user-friendly dan mobile-friendly
- ✍️ **Digital Signature** - Tanda tangan digital untuk verifikasi identitas peserta

## 📚 Dokumentasi

Dokumentasi lengkap tersedia dalam beberapa file:

| File | Deskripsi | Waktu Baca |
|------|-----------|-----------|
| **[INDEX.md](INDEX.md)** | 🎯 Start here - Index & navigasi | 5 min |
| **[QUICK_START.md](QUICK_START.md)** | 🚀 Setup dalam 5 menit | 10 min |
| **[DOKUMENTASI.md](DOKUMENTASI.md)** | 📖 Panduan lengkap & komprehensif | 30 min |
| **[ERD.md](ERD.md)** | 🗄️ Entity Relationship Diagram | 20 min |
| **[CRUD_GUIDE.md](CRUD_GUIDE.md)** | 🔄 Detail semua CRUD operation | 35 min |
| **[CHANGELOG.md](CHANGELOG.md)** | 📝 Version history & roadmap | 10 min |

## 🚀 Quick Start

### 1️⃣ Setup Database
```bash
# Buat database MySQL
mysql -u root -p
CREATE DATABASE absensi_pkl;
EXIT;
```

### 2️⃣ Configure Environment
Edit file `.env`:

``` Ubah File Environment
cp .env.example .env
 ```

```env    
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_pkl
DB_USERNAME=root
DB_PASSWORD=
```

### 3️⃣ Install & Run
```bash
# Install dependencies
composer install
npm install

# Generate key
php artisan key:generate

# Migrate database
php artisan migrate

# Link storage
php artisan storage:link

# Build assets
npm run build

# Run server
php artisan serve
```

**Aplikasi ready di**: http://localhost:8000

## 👥 User Roles

### 👤 PESERTA
- Input absensi dengan foto & GPS
- Lihat riwayat absensi pribadi
- Dashboard statistik kehadiran

### 👨‍💼 PEMBINA
- Monitor peserta binaan
- Verifikasi absensi
- Dashboard monitoring

### 🔑 ADMIN
- Kelola data pembina (CRUD)
- Kelola data peserta (CRUD)
- Lihat statistik keseluruhan

## 🗄️ Database Schema

Sistem menggunakan 4 tabel utama:

```
USERS → PEMBINAS → PESERTAS → ATTENDANCES
(1:1)   (1:N)     (1:N)      (with photos & GPS)
```

Lihat **[ERD.md](ERD.md)** untuk diagram lengkap.

## 📁 Project Structure

```
absensi-pkl/
├── app/Http/Controllers/      ← 5 controllers
├── app/Models/                ← 4 models
├── database/migrations/       ← 4 migrations
├── resources/views/           ← 18 blade views
├── routes/web.php            ← 25+ routes
├── storage/app/public/       ← Upload files
└── 📚 Dokumentasi files...
```

## 🔧 Tech Stack

- **Backend**: Laravel 12.0 + PHP 8.2
- **Database**: MySQL 8.0
- **Frontend**: Bootstrap 5.3 + Font Awesome 6.4
- **Build Tool**: Vite
- **Storage**: Local storage (photos)

## ✨ Fitur CRUD

### Pembina Management (Admin)
- ✅ Create pembina baru
- ✅ Read daftar pembina
- ✅ Update data pembina
- ✅ Delete pembina (cascade)

### Peserta Management (Admin)
- ✅ Create peserta baru
- ✅ Read daftar peserta
- ✅ Update data peserta
- ✅ Delete peserta (cascade)

### Attendance Management (All Roles)
- ✅ Create absensi + foto + GPS
- ✅ Read dengan role-based filter
- ✅ Update absensi & foto
- ✅ Delete dengan akses control

## 🔐 Security Features

- ✅ Password hashing (bcrypt)
- ✅ CSRF protection
- ✅ Input validation
- ✅ File upload validation
- ✅ Role-based authorization
- ✅ Cascade delete constraints
- ✅ Session management

## 📋 Routes Reference

```
# Public
GET  /                    → Homepage
GET  /login              → Login form
GET  /register           → Register form

# Auth Required
GET  /dashboard          → Dashboard (role-based)
GET  /logout             → Logout

# Pembina Management (Admin)
GET    /pembina          → Daftar pembina
POST   /pembina          → Create pembina
GET    /pembina/{id}     → Detail pembina
PUT    /pembina/{id}     → Update pembina
DELETE /pembina/{id}     → Delete pembina

# Peserta Management (Admin)
GET    /peserta          → Daftar peserta
POST   /peserta          → Create peserta
GET    /peserta/{id}     → Detail peserta
PUT    /peserta/{id}     → Update peserta
DELETE /peserta/{id}     → Delete peserta

# Attendance (All Auth Users)
GET    /attendance       → Daftar absensi
POST   /attendance       → Create absensi
GET    /attendance/{id}  → Detail absensi
PUT    /attendance/{id}  → Update absensi
DELETE /attendance/{id}  → Delete absensi
```

## 🧪 Test Account

Setelah setup, gunakan akun ini:

```
Admin:
  Email: admin@example.com
  Password: password123

Pembina:
  Email: pembina@example.com
  Password: password123

Peserta:
  Daftar sendiri atau gunakan:
  Email: peserta@example.com
  Password: password123
```

## 📖 How to Use

1. **Baca INDEX.md** untuk navigasi dokumentasi
2. **Ikuti QUICK_START.md** untuk setup
3. **Baca DOKUMENTASI.md** untuk pemahaman mendalam
4. **Referensi ERD.md** untuk struktur database
5. **Check CRUD_GUIDE.md** untuk detail operasi

## 🐛 Troubleshooting

### Database connection error?
```bash
# Check .env configuration
# Ensure database exists
php artisan migrate
```

### File not found?
```bash
php artisan storage:link
chmod -R 755 storage/
```

### Port 8000 already used?
```bash
php artisan serve --port=8001
```

Lihat **QUICK_START.md** untuk troubleshooting lebih lanjut.

## 📊 Statistics

- **5** Controllers
- **4** Models
- **18** Blade Views
- **4** Database Tables
- **25+** Routes
- **50+** Total Files

## 🚀 Fitur Bonus (Dapat Dikembangkan)

- 📊 Export ke PDF/Excel
- 📧 Email notifications
- 🔌 REST API
- 🎫 QR Code attendance
- 📱 Mobile app
- ⚡ Real-time monitoring
- 🤖 Face recognition

## 📝 Documentation Files

Semua dokumentasi tersedia dalam format Markdown:

- **INDEX.md** - Index & navigation guide
- **QUICK_START.md** - 5-minute setup
- **DOKUMENTASI.md** - Comprehensive guide
- **ERD.md** - Database schema
- **CRUD_GUIDE.md** - CRUD details
- **CHANGELOG.md** - Version history
- **README.md** - This file

## 📞 Support

**Untuk bantuan:**
1. Check troubleshooting di QUICK_START.md
2. Review documentations
3. Check Laravel logs: `storage/logs/laravel.log`
4. Clear cache: `php artisan cache:clear`

## 📄 License

MIT License - Free to use and modify

## 🎉 Getting Started

→ **Mulai dari sini: [INDEX.md](INDEX.md)**

---

**Dibuat dengan ❤️ menggunakan Laravel 12 & Bootstrap 5**

*Last Updated: 27 November 2025*
*Version: 1.0.0*
