# CRUD Operation Guide - Sistem Absensi PKL

## Overview

Sistem ini mengimplementasikan CRUD (Create, Read, Update, Delete) untuk 4 entitas utama:
1. **Users** (Authentication)
2. **Pembinas** (Supervisors)
3. **Pesertas** (Interns)
4. **Attendances** (Attendance Records)

---

## 1. USERS - Authentication CRUD

### Create (Register)
**Endpoint**: `POST /register`
**View**: `resources/views/auth/register.blade.php`
**Controller Method**: `AuthController@store`

```php
// Form Input
- name (required, string)
- email (required, email, unique)
- password (required, min:6, confirmed)

// Proses
1. Validasi input
2. Hash password
3. Create user dengan role 'peserta'
4. Auto login user
5. Redirect ke dashboard

// Output
- User berhasil dibuat
- Role default: peserta
```

### Read (Login)
**Endpoint**: `GET|POST /login`
**View**: `resources/views/auth/login.blade.php`
**Controller Method**: `AuthController@authenticate`

```php
// Form Input
- email (required, email)
- password (required)

// Proses
1. Validasi credentials
2. Attempt login
3. Regenerate session
4. Redirect ke intended dashboard

// Output
- Redirect sesuai role user
```

### Update
**Note**: Update user (change password, email) belum diimplementasikan

### Delete (Logout)
**Endpoint**: `POST /logout`
**Controller Method**: `AuthController@logout`

```php
// Proses
1. Logout user
2. Invalidate session
3. Regenerate token
4. Redirect ke login

// Output
- Session cleared
- User logged out
```

---

## 2. PEMBINAS - Supervisor Management (Admin Only)

### CREATE - Tambah Pembina
**Endpoint**: `POST /pembina`
**View**: `resources/views/pembina/create.blade.php`
**Controller Method**: `PembinaController@store`

```php
// Form Input
- name (required, string) -> untuk users table
- email (required, email, unique) -> untuk users table
- password (required, min:6) -> untuk users table
- nip (required, unique) -> untuk pembinas table
- nama_lengkap (required, string)
- jabatan (required, string)
- nomor_hp (required, string)

// Database Queries
1. INSERT INTO users (name, email, password, role='pembina', ...)
2. INSERT INTO pembinas (user_id, nip, nama_lengkap, jabatan, nomor_hp, ...)

// Response
- Redirect ke /pembina dengan success message
```

### READ - Daftar Pembina
**Endpoint**: `GET /pembina`
**View**: `resources/views/pembina/index.blade.php`
**Controller Method**: `PembinaController@index`

```php
// Database Query
SELECT pembinas.*, users.* FROM pembinas
JOIN users ON pembinas.user_id = users.id
PAGINATE 10

// Display
- Tabel dengan kolom: NIP, Nama, Jabatan, HP, Email, Aksi
- Pagination links
- Button: Detail, Edit, Delete
```

### READ - Detail Pembina
**Endpoint**: `GET /pembina/{id}`
**View**: `resources/views/pembina/show.blade.php`
**Controller Method**: `PembinaController@show`

```php
// Database Query
SELECT * FROM pembinas WHERE id = {id}
SELECT * FROM pesertas WHERE pembina_id = {id} PAGINATE 10

// Display
- Card: Info Pembina (Nama, NIP, Jabatan, Email, HP)
- Table: Peserta yang dibina
- Pagination peserta
```

### UPDATE - Edit Pembina
**Endpoint**: `PUT /pembina/{id}`
**View**: `resources/views/pembina/edit.blade.php`
**Controller Method**: `PembinaController@update`

```php
// Form Input (yang bisa diedit)
- nama_lengkap
- jabatan
- nomor_hp

// Database Query
UPDATE pembinas SET nama_lengkap, jabatan, nomor_hp WHERE id = {id}

// Response
- Redirect ke /pembina dengan success message
```

### DELETE - Hapus Pembina
**Endpoint**: `DELETE /pembina/{id}`
**Controller Method**: `PembinaController@destroy`

```php
// Database Query (Cascade)
1. DELETE FROM users WHERE id = pembina.user_id (CASCADE)
2. DELETE FROM pembinas WHERE id = {id}

// Response
- Redirect ke /pembina dengan success message
```

---

## 3. PESERTAS - Intern Management (Admin Only)

### CREATE - Tambah Peserta
**Endpoint**: `POST /peserta`
**View**: `resources/views/peserta/create.blade.php`
**Controller Method**: `PesertaController@store`

```php
// Form Input
- name, email, password (untuk users table)
- pembina_id (required, select dari daftar pembina)
- nisn (required, unique)
- nama_lengkap (required)
- sekolah (required)
- jurusan (required)
- tanggal_mulai (required, date)
- tanggal_selesai (required, date)
- nomor_hp (required)

// Database Queries
1. INSERT INTO users (name, email, password, role='peserta', ...)
2. INSERT INTO pesertas (user_id, pembina_id, nisn, nama_lengkap, ...)

// Response
- Redirect ke /peserta dengan success message
```

### READ - Daftar Peserta
**Endpoint**: `GET /peserta`
**View**: `resources/views/peserta/index.blade.php`
**Controller Method**: `PesertaController@index`

```php
// Database Query
SELECT pesertas.*, users.*, pembinas.nama_lengkap as pembina_name
FROM pesertas
JOIN users ON pesertas.user_id = users.id
JOIN pembinas ON pesertas.pembina_id = pembinas.id
PAGINATE 10

// Display
- Tabel: NISN, Nama, Sekolah, Jurusan, Pembina, Periode, Aksi
- Pagination
```

### READ - Detail Peserta & Riwayat Absensi
**Endpoint**: `GET /peserta/{id}`
**View**: `resources/views/peserta/show.blade.php`
**Controller Method**: `PesertaController@show`

```php
// Database Queries
1. SELECT * FROM pesertas WHERE id = {id}
2. SELECT * FROM attendances WHERE peserta_id = {id} 
   ORDER BY tanggal DESC PAGINATE 10

// Display
- Card: Info Peserta (NISN, Nama, Sekolah, Jurusan, Pembina, HP, Periode)
- Table: Riwayat Absensi (Tanggal, Jam Masuk, Jam Keluar, Status, Aksi)
```

### UPDATE - Edit Peserta
**Endpoint**: `PUT /peserta/{id}`
**View**: `resources/views/peserta/edit.blade.php`
**Controller Method**: `PesertaController@update`

```php
// Form Input (yang bisa diedit)
- pembina_id
- nama_lengkap
- sekolah
- jurusan
- tanggal_mulai
- tanggal_selesai
- nomor_hp

// Database Query
UPDATE pesertas SET ... WHERE id = {id}

// Response
- Redirect ke /peserta dengan success message
```

### DELETE - Hapus Peserta
**Endpoint**: `DELETE /peserta/{id}`
**Controller Method**: `PesertaController@destroy`

```php
// Database Query (Cascade)
1. DELETE FROM users WHERE id = peserta.user_id
2. DELETE FROM pesertas WHERE id = {id}
   └─ Auto delete attendances (FK cascade)

// Response
- Redirect ke /peserta dengan success message
```

---

## 4. ATTENDANCES - Absensi CRUD

### CREATE - Tambah Absensi
**Endpoint**: `POST /attendance`
**View**: `resources/views/attendance/create.blade.php`
**Controller Method**: `AttendanceController@store`

```php
// Authorization
- Role: peserta saja yang bisa input absensi

// Form Input
- tanggal (required, date)
- jam_masuk (nullable, time format HH:MM)
- jam_keluar (nullable, time format HH:MM)
- foto_masuk (nullable, image|max:2048)
- foto_keluar (nullable, image|max:2048)
- latitude_masuk (nullable, numeric) -> dari Geolocation
- longitude_masuk (nullable, numeric) -> dari Geolocation
- latitude_keluar (nullable, numeric) -> dari Geolocation
- longitude_keluar (nullable, numeric) -> dari Geolocation
- status (required, enum: hadir/izin/sakit/alfa)
- keterangan (nullable, text)

// File Upload Processing
1. Foto masuk: store('attendance', 'public') -> storage/app/public/attendance/
2. Foto keluar: store('attendance', 'public') -> storage/app/public/attendance/
3. Save path ke database

// Database Query
INSERT INTO attendances (peserta_id, tanggal, jam_masuk, jam_keluar, 
    foto_masuk, foto_keluar, latitude_masuk, longitude_masuk, 
    latitude_keluar, longitude_keluar, status, keterangan, ...)

// Response
- Redirect ke /attendance dengan success message
```

### READ - Daftar Absensi
**Endpoint**: `GET /attendance`
**View**: `resources/views/attendance/index.blade.php`
**Controller Method**: `AttendanceController@index`

```php
// Authorization & Filtering
- Admin: Lihat semua absensi
- Pembina: Lihat absensi peserta binaan
- Peserta: Lihat absensi pribadi

// Database Query (sesuai role)
Admin:
  SELECT attendances.*, pesertas.nama_lengkap
  FROM attendances
  JOIN pesertas ON attendances.peserta_id = pesertas.id
  ORDER BY tanggal DESC PAGINATE 10

Pembina:
  SELECT attendances.*, pesertas.nama_lengkap
  FROM attendances
  JOIN pesertas ON attendances.peserta_id = pesertas.id
  WHERE pesertas.pembina_id = {pembina_id}
  ORDER BY tanggal DESC PAGINATE 10

Peserta:
  SELECT attendances.*
  FROM attendances
  WHERE peserta_id = {peserta_id}
  ORDER BY tanggal DESC PAGINATE 10

// Display
- Tabel: Tanggal, [Peserta], Jam Masuk, Jam Keluar, Status, Lokasi, Aksi
- Filter: Status, Tanggal Range (dapat dikembangkan)
```

### READ - Detail Absensi
**Endpoint**: `GET /attendance/{id}`
**View**: `resources/views/attendance/show.blade.php`
**Controller Method**: `AttendanceController@show`

```php
// Database Query
SELECT * FROM attendances WHERE id = {id}

// Display
- Info: Peserta, Tanggal, Jam masuk/keluar, Status, Keterangan
- Lokasi: GPS coordinates masuk/keluar
- Foto: Preview foto_masuk dan foto_keluar
  └─ Path: asset('storage/' . attendance.foto_masuk)
```

### UPDATE - Edit Absensi
**Endpoint**: `PUT /attendance/{id}`
**View**: `resources/views/attendance/edit.blade.php`
**Controller Method**: `AttendanceController@update`

```php
// Authorization
- Peserta: Hanya bisa edit absensi sendiri
- Pembina/Admin: Bisa edit semua absensi

// Form Input (yang bisa diedit)
- jam_masuk (nullable, time)
- jam_keluar (nullable, time)
- foto_masuk (nullable, image) -> replace old file jika ada
- foto_keluar (nullable, image) -> replace old file jika ada
- latitude_masuk, longitude_masuk, latitude_keluar, longitude_keluar
- status (required, enum)
- keterangan (nullable, text)

// File Upload Processing
1. Jika ada foto_masuk baru:
   - Hapus file lama: unlink(storage_path('app/public/' . old_foto_masuk))
   - Upload foto baru: store('attendance', 'public')
2. Sama untuk foto_keluar

// Database Query
UPDATE attendances SET ... WHERE id = {id}

// Response
- Redirect ke /attendance dengan success message
```

### DELETE - Hapus Absensi
**Endpoint**: `DELETE /attendance/{id}`
**Controller Method**: `AttendanceController@destroy`

```php
// Authorization
- Peserta: Hanya bisa delete absensi sendiri
- Admin: Bisa delete semua absensi
- Pembina: Cannot delete (hanya lihat & edit)

// File Cleanup
1. Jika ada foto_masuk: unlink(storage_path('app/public/' . foto_masuk))
2. Jika ada foto_keluar: unlink(storage_path('app/public/' . foto_keluar))

// Database Query
DELETE FROM attendances WHERE id = {id}

// Response
- Redirect ke /attendance dengan success message
```

---

## Geolocation Implementation

### JavaScript untuk Ambil Lokasi (HTML)

```html
<!-- Form elements -->
<input type="text" id="latitude_masuk" name="latitude_masuk" readonly>
<input type="text" id="longitude_masuk" name="longitude_masuk" readonly>
<button type="button" onclick="getLocationMasuk()">Ambil Lokasi Masuk</button>

<!-- JavaScript -->
<script>
function getLocationMasuk() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('latitude_masuk').value = position.coords.latitude;
            document.getElementById('longitude_masuk').value = position.coords.longitude;
        });
    } else {
        alert('Geolocation tidak didukung');
    }
}
</script>
```

### Persyaratan:
- Browser harus support Geolocation API
- Aplikasi harus di HTTPS (atau localhost)
- User harus memberikan permission untuk akses lokasi

---

## API Response Examples

### Success Response
```json
{
    "message": "Data berhasil disimpan",
    "status": "success",
    "redirect": "/attendance"
}
```

### Error Response
```json
{
    "message": "Email sudah terdaftar",
    "status": "error",
    "errors": {
        "email": ["Email sudah digunakan"]
    }
}
```

---

## Middleware & Authorization

### Role-Based Access
```php
// admin middleware - routes/web.php
Route::resource('pembina', PembinaController::class)->middleware('admin');
Route::resource('peserta', PesertaController::class)->middleware('admin');

// In controller
public function store(Request $request) {
    $this->authorize('admin');
    // ... logic
}
```

---

## Summary Table

| Resource | Create | Read | Update | Delete | Auth | Role |
|----------|--------|------|--------|--------|------|------|
| User | ✓ | ✓ | ✗ | ✗ | Guest | - |
| Pembina | ✓ | ✓ | ✓ | ✓ | Yes | Admin |
| Peserta | ✓ | ✓ | ✓ | ✓ | Yes | Admin |
| Attendance | ✓ | ✓ | ✓ | ✓ | Yes | All* |

*Attendance: Create/Update/Delete terbatas sesuai role

---

**Dokumentasi CRUD lengkap untuk referensi development dan maintenance sistem.**
