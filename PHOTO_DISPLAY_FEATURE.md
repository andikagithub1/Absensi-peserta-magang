# Foto Display Feature - Sistem Absensi PKL

## 📸 Overview
Fitur foto display memungkinkan peserta dan pembina untuk melihat foto bukti absensi (masuk & keluar) melalui interface yang user-friendly.

## 🎯 Lokasi Foto Display

### 1. Attendance Index Page
**URL**: `/attendance`
**Fitur:**
- Kolom "Foto" dengan 2 tombol: "Masuk" dan "Keluar"
- Tombol akan **disabled** (abu-abu) jika foto tidak ada
- Tombol akan **enabled** (biru/oranye) jika foto ada
- Click tombol akan membuka Modal Lightbox
- Modal menampilkan foto fullscreen dengan loading indicator
- Download button tersedia untuk save foto

### 2. Attendance Show Page  
**URL**: `/attendance/{id}`
**Fitur:**
- Dua kartu terpisah: "Foto Masuk" dan "Foto Keluar"
- Foto ditampilkan fullwidth dalam kartu
- Jika foto tidak ada, menampilkan pesan info
- View lengkap untuk detail absensi

### 3. Attendance Edit Page
**URL**: `/attendance/{id}/edit`
**Fitur:**
- Preview foto lama sebelum upload file baru
- Opsi untuk replace foto dengan upload baru
- Helpful text: "Max 2MB, format: JPG, PNG, GIF"

## 💾 Storage Location
```
Folder: storage/app/public/attendance/
Public Access: /storage/attendance/{filename}
```

**Contoh:**
- Storage: `storage/app/public/attendance/4eyyOjR5v8Fwd42ZTz1bo2EGV0gVWaEzG8PXYY6g.gif`
- URL: `http://localhost:8000/storage/attendance/4eyyOjR5v8Fwd42ZTz1bo2EGV0gVWaEzG8PXYY6g.gif`

## 🖼️ Technical Details

### Storage Configuration
```php
// Laravel config/filesystems.php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
],
```

### Symlink Status
```
✓ Public symlink created: public/storage -> storage/app/public
```

### Photo Encoding
```php
// AttendanceController.php - Photo Storage
$file->store('attendance', 'public');
// Hasil: attendance/[random-hash].gif (or jpg/png)
```

## 🎨 UI Components

### Button States
```html
<!-- Foto Masuk ada -->
<button class="btn btn-outline-info">
    <i class="fas fa-image"></i> Masuk
</button>

<!-- Foto Masuk tidak ada -->
<button class="btn btn-outline-secondary" disabled>
    <i class="fas fa-image"></i> -
</button>
```

### Modal Lightbox
```
┌─────────────────────────────────┐
│  Foto Absensi              [×]  │
├─────────────────────────────────┤
│                                 │
│   [⏳ Loading...]  atau  [🖼️]   │
│                                 │
├─────────────────────────────────┤
│ [Tutup]     [⬇️ Download]        │
└─────────────────────────────────┘
```

### Loading States
- Initial: Spinner icon dengan text loading
- Success: Foto tampil dengan download button
- Error: Alert merah dengan pesan error & URL

## 🔄 Display Flow

### User Click "Masuk" Button
```
1. Click tombol "Masuk" → showFoto() dipanggil
2. Set label: "Foto Masuk - 27 Nov 2025"
3. Show spinner di modal body
4. Create Image object dengan src = URL foto
5. Image load:
   - Success → Display foto + enable download button
   - Error → Show error message
6. Modal tetap terbuka sampai user click "Tutup"
```

## 📱 Responsive Design
- Modal menggunakan `modal-lg` untuk layar besar
- Foto scale otomatis: `max-width: 100%; max-height: 600px`
- Border-radius: 5px untuk aesthetic
- Tombol responsive di semua ukuran layar

## 🔐 Security Features
1. **Path Traversal Protection**: Laravel `asset()` helper sanitize URLs
2. **Storage Layer**: File disimpan di folder private, served via public symlink
3. **File Type Validation**: Server-side validation required|image|mimes:jpeg,png,jpg,gif
4. **CSRF Protection**: Semua form dilindungi @csrf token

## 📊 Database Fields
```php
Attendance Table:
- foto_masuk: string (nullable) - File path relative to public disk
- foto_keluar: string (nullable) - File path relative to public disk

Contoh value:
- foto_masuk = "attendance/4eyyOjR5v8Fwd42ZTz1bo2EGV0gVWaEzG8PXYY6g.gif"
```

## 🐛 Troubleshooting

### Foto tidak muncul
**Penyebab 1**: Symlink tidak ada
```bash
cd "c:\Project Andika\absensi-pkl"
php artisan storage:link
```

**Penyebab 2**: File sudah dihapus
```bash
dir storage/app/public/attendance/
# Check if file exists
```

**Penyebab 3**: Database field NULL
```bash
php artisan tinker
>>> $att = Attendance::first();
>>> echo $att->foto_masuk;  // Should not be NULL
```

### Foto loading terlalu lama
- Check server response time di Network tab
- File size: Harus < 2MB per spesifikasi
- Internet connection: Check bandwidth

### Modal tidak terbuka
- Check browser console untuk JavaScript errors
- Verify Bootstrap 5 CSS/JS loaded
- Check data-bs-toggle="modal" attribute

## 📋 Testing Checklist

### Test Case 1: View Foto di Index
- [ ] Buka `/attendance`
- [ ] Lihat kolom "Foto"
- [ ] Ada foto masuk → Tombol "Masuk" enabled (biru)
- [ ] Tidak ada foto → Tombol "Masuk" disabled (abu-abu)
- [ ] Click tombol → Modal terbuka
- [ ] Foto terlihat jelas
- [ ] Download button ada

### Test Case 2: View Foto di Show Detail
- [ ] Klik eye icon di index
- [ ] Halaman `/attendance/{id}` terbuka
- [ ] Foto Masuk terlihat di kiri
- [ ] Foto Keluar terlihat di kanan
- [ ] Kualitas foto bagus

### Test Case 3: View Foto di Edit Form
- [ ] Klik pencil icon
- [ ] Halaman `/attendance/{id}/edit` terbuka
- [ ] Foto lama terlihat di atas input file
- [ ] Can replace dengan foto baru

### Test Case 4: Mobile View
- [ ] Open index di mobile browser
- [ ] Tombol foto tetap terlihat
- [ ] Modal responsive
- [ ] Foto fit dalam screen

## ✅ Verification

### Check Foto di Browser
```javascript
// Open browser console dan jalankan:
fetch('/storage/attendance/4eyyOjR5v8Fwd42ZTz1bo2EGV0gVWaEzG8PXYY6g.gif')
  .then(r => r.ok ? console.log('✓ Foto accessible') : console.log('✗ Foto 404'));
```

### Check Database
```php
php artisan tinker
>>> Attendance::where('foto_masuk', '!=', null)->count()
=> 6  // Jumlah attendance dengan foto masuk

>>> Attendance::first()->foto_masuk
=> "attendance/4eyyOjR5v8Fwd42ZTz1bo2EGV0gVWaEzG8PXYY6g.gif"
```

## 📞 File References

### Views Updated
- `resources/views/attendance/index.blade.php` - Photo buttons & modal
- `resources/views/attendance/show.blade.php` - Large photo display
- `resources/views/attendance/edit.blade.php` - Photo preview

### Controllers
- `app/Http/Controllers/AttendanceController.php` - Photo storage logic

### Configuration
- `config/filesystems.php` - Storage disk config
- `public/storage/` - Symlink to storage/app/public

---

**Last Updated**: 2025-11-27
**Version**: 1.0.0
**Status**: ✅ Production Ready
