# ERD (Entity Relationship Diagram) - Sistem Absensi PKL

## Diagram Lengkap

```
╔═══════════════════════════════════════════════════════════════════════════╗
║                        DATABASE SCHEMA - ABSENSI PKL                       ║
╚═══════════════════════════════════════════════════════════════════════════╝

┌────────────────────────────────────────┐
│              USERS TABLE               │
├────────────────────────────────────────┤
│ PK  id                    : BIGINT     │
│     name                  : VARCHAR    │
│     email            UNIQUE: VARCHAR   │
│     email_verified_at     : TIMESTAMP  │
│     password              : VARCHAR    │
│ NEW role          DEFAULT 'peserta'    │
│     remember_token        : VARCHAR    │
│     created_at            : TIMESTAMP  │
│     updated_at            : TIMESTAMP  │
└────────────────────────────────────────┘
           │                      │
           │ 1:1                  │ 1:1
           ▼                      ▼
┌────────────────────────────┐  ┌──────────────────────────────┐
│     PEMBINAS TABLE         │  │     PESERTAS TABLE          │
├────────────────────────────┤  ├──────────────────────────────┤
│ PK  id         : BIGINT    │  │ PK  id           : BIGINT   │
│ FK  user_id    : BIGINT    │  │ FK  user_id      : BIGINT   │
│     nip   UNIQUE: VARCHAR  │  │ FK  pembina_id   : BIGINT   │
│     nama_lengkap: VARCHAR  │  │     nisn    UNIQUE: VARCHAR │
│     jabatan      : VARCHAR │  │     nama_lengkap : VARCHAR  │
│     nomor_hp     : VARCHAR │  │     sekolah      : VARCHAR  │
│     created_at   : TIMESTAMP│  │     jurusan      : VARCHAR  │
│     updated_at   : TIMESTAMP│  │     tanggal_mulai: DATE     │
└────────────────────────────┘  │     tanggal_selesai: DATE   │
           ▲                     │     nomor_hp       : VARCHAR│
           │ N:1                 │     created_at     : TIMESTAMP
           │                     │     updated_at     : TIMESTAMP
           │                     └──────────────────────────────┘
           │                              │
           │                              │ 1:N
           │                              ▼
           │                     ┌──────────────────────────────────────┐
           │                     │     ATTENDANCES TABLE                │
           │                     ├──────────────────────────────────────┤
           │                     │ PK  id                  : BIGINT     │
           │                     │ FK  peserta_id          : BIGINT     │
           │                     │     tanggal             : DATE       │
           │                     │     jam_masuk           : TIME       │
           │                     │     jam_keluar          : TIME       │
           │                     │     foto_masuk          : VARCHAR    │
           │                     │     foto_keluar         : VARCHAR    │
           │                     │     latitude_masuk      : DECIMAL    │
           │                     │     longitude_masuk     : DECIMAL    │
           │                     │     latitude_keluar     : DECIMAL    │
           │                     │     longitude_keluar    : DECIMAL    │
           │                     │     status              : ENUM       │
           │                     │     keterangan          : TEXT       │
           │                     │     created_at          : TIMESTAMP  │
           │                     │     updated_at          : TIMESTAMP  │
           └─────────────────────┤                                      │
         PEMBINA 1 : N PESERTA   └──────────────────────────────────────┘

```

## Penjelasan Relationships

### 1. USERS ↔ PEMBINAS (1:1)
- Satu user dapat menjadi satu pembina
- Seorang pembina hanya punya satu user account
- **Foreign Key**: `pembinas.user_id` → `users.id`

### 2. USERS ↔ PESERTAS (1:1)
- Satu user dapat menjadi satu peserta
- Seorang peserta hanya punya satu user account
- **Foreign Key**: `pesertas.user_id` → `users.id`

### 3. PEMBINAS ↔ PESERTAS (1:N)
- Satu pembina dapat menangani banyak peserta
- Seorang peserta hanya punya satu pembina
- **Foreign Key**: `pesertas.pembina_id` → `pembinas.id`

### 4. PESERTAS ↔ ATTENDANCES (1:N)
- Satu peserta dapat memiliki banyak record absensi
- Satu record absensi hanya untuk satu peserta
- **Foreign Key**: `attendances.peserta_id` → `pesertas.id`

## Tabel Detail

### USERS
| Kolom | Tipe | Constraint | Deskripsi |
|-------|------|-----------|-----------|
| id | BIGINT | PK, AUTO_INCREMENT | Identifier unik |
| name | VARCHAR(255) | NOT NULL | Nama user |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Email unik |
| email_verified_at | TIMESTAMP | NULLABLE | Verifikasi email |
| password | VARCHAR(255) | NOT NULL | Password ter-hash |
| role | ENUM('admin','pembina','peserta') | DEFAULT 'peserta' | Peran user |
| remember_token | VARCHAR(100) | NULLABLE | Token remember-me |
| created_at | TIMESTAMP | DEFAULT CURRENT | Waktu pembuatan |
| updated_at | TIMESTAMP | DEFAULT CURRENT | Waktu update |

**Indeks**: 
- PK: id
- UNIQUE: email

---

### PEMBINAS
| Kolom | Tipe | Constraint | Deskripsi |
|-------|------|-----------|-----------|
| id | BIGINT | PK, AUTO_INCREMENT | Identifier unik |
| user_id | BIGINT | FK, NOT NULL | Referensi ke users |
| nip | VARCHAR(50) | UNIQUE, NOT NULL | Nomor Induk Pegawai |
| nama_lengkap | VARCHAR(255) | NOT NULL | Nama lengkap pembina |
| jabatan | VARCHAR(255) | NOT NULL | Jabatan di institusi |
| nomor_hp | VARCHAR(20) | NOT NULL | Kontak telepon |
| created_at | TIMESTAMP | DEFAULT CURRENT | Waktu pembuatan |
| updated_at | TIMESTAMP | DEFAULT CURRENT | Waktu update |

**Indeks**:
- PK: id
- FK: user_id
- UNIQUE: nip

---

### PESERTAS
| Kolom | Tipe | Constraint | Deskripsi |
|-------|------|-----------|-----------|
| id | BIGINT | PK, AUTO_INCREMENT | Identifier unik |
| user_id | BIGINT | FK, NOT NULL | Referensi ke users |
| pembina_id | BIGINT | FK, NOT NULL | Referensi ke pembinas |
| nisn | VARCHAR(30) | UNIQUE, NOT NULL | Nomor Induk Siswa |
| nama_lengkap | VARCHAR(255) | NOT NULL | Nama lengkap siswa |
| sekolah | VARCHAR(255) | NOT NULL | Nama sekolah asal |
| jurusan | VARCHAR(255) | NOT NULL | Jurusan/Program keahlian |
| tanggal_mulai | DATE | NOT NULL | Tanggal mulai PKL |
| tanggal_selesai | DATE | NOT NULL | Tanggal akhir PKL |
| nomor_hp | VARCHAR(20) | NOT NULL | Kontak telepon siswa |
| created_at | TIMESTAMP | DEFAULT CURRENT | Waktu pembuatan |
| updated_at | TIMESTAMP | DEFAULT CURRENT | Waktu update |

**Indeks**:
- PK: id
- FK: user_id, pembina_id
- UNIQUE: nisn

---

### ATTENDANCES
| Kolom | Tipe | Constraint | Deskripsi |
|-------|------|-----------|-----------|
| id | BIGINT | PK, AUTO_INCREMENT | Identifier unik |
| peserta_id | BIGINT | FK, NOT NULL | Referensi ke pesertas |
| tanggal | DATE | NOT NULL | Tanggal absensi |
| jam_masuk | TIME | NULLABLE | Jam masuk (HH:MM) |
| jam_keluar | TIME | NULLABLE | Jam keluar (HH:MM) |
| foto_masuk | VARCHAR(255) | NULLABLE | Path foto masuk |
| foto_keluar | VARCHAR(255) | NULLABLE | Path foto keluar |
| latitude_masuk | DECIMAL(10,8) | NULLABLE | Koordinat latitude masuk |
| longitude_masuk | DECIMAL(11,8) | NULLABLE | Koordinat longitude masuk |
| latitude_keluar | DECIMAL(10,8) | NULLABLE | Koordinat latitude keluar |
| longitude_keluar | DECIMAL(11,8) | NULLABLE | Koordinat longitude keluar |
| status | ENUM('hadir','izin','sakit','alfa') | DEFAULT 'alfa' | Status kehadiran |
| keterangan | TEXT | NULLABLE | Keterangan tambahan |
| created_at | TIMESTAMP | DEFAULT CURRENT | Waktu pembuatan |
| updated_at | TIMESTAMP | DEFAULT CURRENT | Waktu update |

**Indeks**:
- PK: id
- FK: peserta_id
- Composite: (peserta_id, tanggal)

---

## Migrasi Database

### Urutan Eksekusi:
1. **0001_01_01_000000_create_users_table.php** - Table users (sudah ada)
2. **2025_11_27_000001_create_pembina_table.php** - Table pembinas
3. **2025_11_27_000002_create_peserta_table.php** - Table pesertas
4. **2025_11_27_000003_create_attendances_table.php** - Table attendances
5. **2025_11_27_000004_add_role_to_users_table.php** - Add role column to users

### SQL untuk Setup Manual

```sql
-- Database
CREATE DATABASE IF NOT EXISTS absensi_pkl;
USE absensi_pkl;

-- Table Pembinas
CREATE TABLE pembinas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL UNIQUE,
    nip VARCHAR(50) NOT NULL UNIQUE,
    nama_lengkap VARCHAR(255) NOT NULL,
    jabatan VARCHAR(255) NOT NULL,
    nomor_hp VARCHAR(20) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id)
);

-- Table Pesertas
CREATE TABLE pesertas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL UNIQUE,
    pembina_id BIGINT UNSIGNED NOT NULL,
    nisn VARCHAR(30) NOT NULL UNIQUE,
    nama_lengkap VARCHAR(255) NOT NULL,
    sekolah VARCHAR(255) NOT NULL,
    jurusan VARCHAR(255) NOT NULL,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    nomor_hp VARCHAR(20) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (pembina_id) REFERENCES pembinas(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_pembina_id (pembina_id)
);

-- Table Attendances
CREATE TABLE attendances (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    peserta_id BIGINT UNSIGNED NOT NULL,
    tanggal DATE NOT NULL,
    jam_masuk TIME NULL,
    jam_keluar TIME NULL,
    foto_masuk VARCHAR(255) NULL,
    foto_keluar VARCHAR(255) NULL,
    latitude_masuk DECIMAL(10, 8) NULL,
    longitude_masuk DECIMAL(11, 8) NULL,
    latitude_keluar DECIMAL(10, 8) NULL,
    longitude_keluar DECIMAL(11, 8) NULL,
    status ENUM('hadir', 'izin', 'sakit', 'alfa') DEFAULT 'alfa',
    keterangan TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (peserta_id) REFERENCES pesertas(id) ON DELETE CASCADE,
    INDEX idx_peserta_id (peserta_id),
    INDEX idx_tanggal (tanggal),
    UNIQUE KEY unique_peserta_tanggal (peserta_id, tanggal)
);

-- Alter Users Table
ALTER TABLE users ADD COLUMN role ENUM('admin', 'pembina', 'peserta') DEFAULT 'peserta' AFTER email;
```

## Data Flow

### Proses Absensi Peserta:

```
Peserta Login
    │
    ├─→ Dashboard Peserta
    │
    ├─→ Klik "Tambah Absensi"
    │
    ├─→ Input Form:
    │   ├─ Tanggal
    │   ├─ Jam masuk/keluar
    │   ├─ Foto (upload)
    │   ├─ GPS Location (geolocation)
    │   ├─ Status (Hadir/Izin/Sakit/Alfa)
    │   └─ Keterangan
    │
    ├─→ Validasi Input
    │
    ├─→ Upload Foto ke storage/app/public/attendance/
    │
    ├─→ Insert ke Table ATTENDANCES
    │
    └─→ Redirect Dashboard dengan Success Message
```

### Proses Monitoring Pembina:

```
Pembina Login
    │
    ├─→ Dashboard Pembina
    │   └─ Statistik: Total Peserta, Hadir Hari Ini
    │
    ├─→ Menu Absensi
    │   └─ Query ATTENDANCES WHERE peserta.pembina_id = pembina.id
    │
    ├─→ Lihat Detail Absensi
    │   ├─ Foto masuk/keluar
    │   ├─ Lokasi GPS
    │   └─ Status
    │
    └─→ Bisa Edit Status atau Beri Verifikasi
```

## Constraints & Validasi

### Database Constraints:
- **Foreign Key**: Cascade delete untuk data consistency
- **Unique**: nip (pembinas), nisn (pesertas), email (users)
- **Enum**: Status absensi terbatas 4 pilihan
- **Not Null**: Kolom-kolom penting wajib diisi

### Application Validasi (Laravel):
- Email format validation
- Password min 6 character
- Date validation
- Image validation (max 2MB)
- GPS coordinate range validation
- Unique check untuk nip, nisn, email

---

**Diagram ini menjelaskan struktur database lengkap dan relationships antar tabel untuk sistem Absensi PKL.**
