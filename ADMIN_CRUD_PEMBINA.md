# Admin CRUD Pembina - Sistem Absensi PKL

## 📋 Overview

Fitur CRUD Pembina memungkinkan Admin untuk mengelola data pembina/supervisor yang mengawasi peserta magang. Dengan fitur ini, Admin dapat:
- ✅ **Create**: Menambahkan pembina baru (include login credentials)
- ✅ **Read**: Melihat daftar semua pembina
- ✅ **Update**: Mengubah data pembina
- ✅ **Delete**: Menghapus pembina

## 🔐 Access Control

**Hanya Admin yang dapat akses CRUD Pembina:**
- Email: `admin@basensi-pkl.local`
- Password: `Admin123456`

**Middleware Protection:**
```php
Route::middleware('admin')->resource('pembina', PembinaController::class);
```

**Authorization Check di Controller:**
```php
$this->authorize('admin'); // Di setiap method
```

Jika user bukan admin, akan redirect ke dashboard dengan error message.

## 📍 Navigasi

### Dari Dashboard Admin
1. Login dengan akun admin
2. Lihat dashboard dengan 3 stat cards:
   - Total Pembina
   - Total Peserta
   - Total Absensi
3. Klik tombol "Tambah Pembina" atau "Lihat Semua"
4. Atau gunakan shortcut menu di bawah

### URL Routes
```
GET    /pembina                - List semua pembina (index)
GET    /pembina/create         - Form tambah pembina (create)
POST   /pembina                - Store data pembina baru (store)
GET    /pembina/{id}           - Detail pembina (show)
GET    /pembina/{id}/edit      - Form edit pembina (edit)
PUT    /pembina/{id}           - Update pembina (update)
DELETE /pembina/{id}           - Delete pembina (destroy)
```

## 📊 Data Fields

### User Fields (Saat Create)
- **Name**: Nama user untuk login
- **Email**: Email unique untuk login
- **Password**: Password untuk login (min 6 chars)

### Pembina Fields
- **NIP**: Nomor Induk Pegawai (unique)
- **Nama Lengkap**: Nama lengkap pembina
- **Jabatan**: Posisi/jabatan (contoh: Pembina Magang, Supervisor)
- **Nomor HP**: Nomor telepon

## 🎯 Use Cases

### Use Case 1: Tambah Pembina Baru

**Step by Step:**
1. Admin login dengan akun: `admin@basensi-pkl.local`
2. Di dashboard, klik "Tambah Pembina" atau "Pembina Baru"
3. Isi form dengan data:
   ```
   Nama User: Doni Sutrisno
   Email: doni@absensi-pkl.local
   Password: DoniPass123
   ---
   NIP: 19851020201510102
   Nama Lengkap: Doni Sutrisno
   Jabatan: Pembina Praktik
   Nomor HP: 081234567890
   ```
4. Klik "Simpan"
5. Berhasil! Pembina baru terdaftar dengan login credentials

**Pembina Baru Bisa Login Dengan:**
- Email: `doni@absensi-pkl.local`
- Password: `DoniPass123`

### Use Case 2: Lihat Daftar Pembina

**Step by Step:**
1. Admin di dashboard, klik "Lihat Semua" (Pembina)
2. Tampil tabel dengan kolom:
   - NIP
   - Nama Lengkap
   - Jabatan
   - Nomor HP
   - Email
   - Aksi (View/Edit/Delete)
3. Pagination jika pembina > 10

**Aksi di Tabel:**
- 👁️ **View**: Lihat detail pembina + peserta yang dibimbing
- ✏️ **Edit**: Ubah nama/jabatan/nomor HP
- 🗑️ **Delete**: Hapus pembina (akan hapus user juga)

### Use Case 3: Edit Data Pembina

**Step by Step:**
1. Di daftar pembina, klik icon edit (✏️)
2. Form edit terbuka dengan data saat ini
3. Ubah yang diperlukan:
   - Nama Lengkap
   - Jabatan
   - Nomor HP
   (Email & NIP tidak bisa diubah di edit)
4. Klik "Perbarui"
5. Berhasil!

### Use Case 4: Lihat Detail Pembina

**Step by Step:**
1. Di daftar pembina, klik icon view (👁️)
2. Tampil halaman detail:
   - **Kiri**: Info pembina (Nama, NIP, Jabatan, Email, HP)
   - **Kanan**: Daftar peserta yang dibimbing pembina ini
3. Dari detail, bisa:
   - Klik "Edit" untuk ubah data
   - Klik nama peserta untuk lihat detail peserta
   - Klik "Kembali" ke daftar pembina

### Use Case 5: Hapus Pembina

**Step by Step:**
1. Di daftar pembina, klik icon delete (🗑️)
2. Confirmation dialog: "Yakin ingin menghapus?"
3. Klik OK untuk hapus
4. Pembina & user-nya terhapus dari database
5. Peserta yang dibimbing pembina tetap ada (pembina_id jadi NULL)

## 🗄️ Database Schema

### Tabel `pembinas`
```sql
id              BIGINT PRIMARY KEY AUTO_INCREMENT
user_id         BIGINT FOREIGN KEY -> users(id)
nip             VARCHAR(20) UNIQUE
nama_lengkap    VARCHAR(255)
jabatan         VARCHAR(255)
nomor_hp        VARCHAR(15)
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### Tabel `users` (Pembina)
```sql
id              BIGINT PRIMARY KEY AUTO_INCREMENT
name            VARCHAR(255)
email           VARCHAR(255) UNIQUE
password        VARCHAR(255) HASHED
role            VARCHAR(50) = 'pembina'
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

## 🎨 UI Components

### Admin Dashboard Cards
```
┌─ Manajemen Pembina ──────┐  ┌─ Manajemen Peserta ──────┐
│                          │  │                          │
│ Kelola data pembina...   │  │ Kelola data peserta...   │
│                          │  │                          │
│ [Lihat Semua] [Tambah]   │  │ [Lihat Semua] [Tambah]   │
└──────────────────────────┘  └──────────────────────────┘
```

### CRUD Views Structure
```
CREATE/EDIT:
┌─ Form Tambah/Edit Pembina ────┐
│                               │
│ Nama User/Lengkap     [_____] │
│ Email                 [_____] │
│ Password              [_____] │
│ NIP                   [_____] │
│ Jabatan               [_____] │
│ Nomor HP              [_____] │
│                               │
│ [Kembali] [Simpan/Perbarui]  │
└───────────────────────────────┘

INDEX:
┌─ Daftar Pembina ──────────────────────┐
│ [Tambah Pembina]                      │
│                                       │
│ NIP  │ Nama │ Jabatan │ HP  │ Email │ Aksi
│──────┼──────┼─────────┼─────┼───────┼─────
│ 1980 │ Budi │ Pembina │ 0812│ budi@ │ 👁️✏️🗑️
│ 1985 │ Doni │ Pembina │ 0812│ doni@ │ 👁️✏️🗑️
│      │ ... [next page]
└───────────────────────────────────────┘

SHOW:
┌─ Detail Pembina ─────────┐  ┌─ Peserta Magang (5) ─┐
│                          │  │                      │
│ Nama: Budi Santoso       │  │ NISN │ Nama │ Sekolah
│ NIP: 198001152008...     │  │──────┼──────┼───────
│ Jabatan: Pembina Magang  │  │ 1234 │ Ahmad│ SMK N1
│ Email: budi@...          │  │ 5678 │ Bela │ SMK N2
│ HP: 0812...              │  │  ... │ ...  │ ...
│                          │  │                      │
│ [Edit] [Kembali]         │  └──────────────────────┘
└──────────────────────────┘
```

## ✅ Validation Rules

### Store (Create)
```php
'name'          => 'required|string|max:255'
'email'         => 'required|email|unique:users'
'password'      => 'required|min:6'
'nip'           => 'required|unique:pembinas'
'nama_lengkap'  => 'required|string'
'jabatan'       => 'required|string'
'nomor_hp'      => 'required|string'
```

### Update (Edit)
```php
'nama_lengkap'  => 'required|string'
'jabatan'       => 'required|string'
'nomor_hp'      => 'required|string'
```

## 🔄 Relationships

### Pembina Model
```php
// Belongs to User
$pembina->user  // Return User object

// Has Many Peserta
$pembina->pesertas()  // Return Peserta collection
```

### User Model
```php
// Has One Pembina (if role === 'pembina')
$user->pembina  // Return Pembina object
```

### Peserta Model
```php
// Belongs to Pembina
$peserta->pembina  // Return Pembina object
```

## 📱 Responsive Design

- ✅ Mobile-friendly CRUD forms
- ✅ Responsive table dengan horizontal scroll
- ✅ Touch-friendly buttons
- ✅ Full responsive dashboard cards

## 🔒 Security Features

1. **Authorization**: Hanya admin bisa akses
2. **CSRF Protection**: Form dilindungi @csrf token
3. **Input Validation**: Server-side validation untuk semua input
4. **Password Hashing**: Password di-hash dengan bcrypt
5. **Unique Constraints**: Email & NIP dijamin unique
6. **Soft Delete**: (Optional) Bisa implement soft delete di future

## 📊 Flow Diagram

```
Admin Login
    ↓
Dashboard Admin
    ├─ Stat Card: Total Pembina
    ├─ Manajemen Pembina Card
    │   ├─ [Lihat Semua] → Index Pembina
    │   │   ├─ Lihat Daftar
    │   │   ├─ [Edit] → Edit Pembina
    │   │   ├─ [View] → Show Pembina Detail
    │   │   └─ [Delete] → Delete Pembina
    │   └─ [Tambah Baru] → Create Pembina
    │       └─ Form Tambah → Store → Success
    └─ Shortcut Menu
        ├─ Daftar Pembina
        ├─ Pembina Baru
        ├─ Daftar Peserta
        ├─ Peserta Baru
        └─ Laporan Absensi
```

## 🧪 Testing Checklist

### Test Admin Access
- [ ] Login dengan admin@basensi-pkl.local
- [ ] Akses /pembina → Success
- [ ] Login dengan pembina@absensi-pkl.local
- [ ] Akses /pembina → Redirect dengan error

### Test Create
- [ ] Buka form tambah pembina
- [ ] Isi semua field dengan valid data
- [ ] Click Simpan
- [ ] Data muncul di tabel
- [ ] Coba login dengan email/password baru

### Test Read
- [ ] Lihat daftar pembina
- [ ] Click view untuk lihat detail
- [ ] Lihat peserta yang dibimbing

### Test Update
- [ ] Click edit di daftar
- [ ] Ubah nama lengkap, jabatan, HP
- [ ] Click Perbarui
- [ ] Verify perubahan di list

### Test Delete
- [ ] Click delete di daftar
- [ ] Confirm dialog
- [ ] Verify pembina hilang dari list

### Test Validation
- [ ] Submit form kosong → Error messages
- [ ] Email duplicate → Error "email already exists"
- [ ] NIP duplicate → Error "nip already exists"
- [ ] Password < 6 chars → Error message

## 📞 Troubleshooting

### Error: "Anda tidak memiliki akses"
- Pastikan login sebagai admin
- Check cookie/session di browser

### Form tidak submit
- Verify @csrf token ada di form
- Check console untuk JavaScript errors

### Email already exists
- Use unique email untuk pembina baru
- Check database untuk duplicate

### Pembina tidak bisa login
- Verify email & password di seeder
- Check password di-hash dengan bcrypt

## 🚀 Future Enhancements

1. **Bulk Import**: Import pembina dari CSV/Excel
2. **Assign Peserta**: Admin assign peserta ke pembina
3. **Edit User Credentials**: Update email/password pembina
4. **Soft Delete**: Implement soft delete untuk archive
5. **Activity Log**: Track who created/edited/deleted pembina
6. **Filter & Search**: Search pembina by name/NIP/email
7. **Export**: Export daftar pembina ke PDF/Excel
8. **Notifications**: Notify pembina via email saat create account

---

**Last Updated**: 2025-11-27
**Version**: 1.0.0
**Status**: ✅ Production Ready
