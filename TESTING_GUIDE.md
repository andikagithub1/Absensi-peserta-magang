# End-to-End Testing Guide - Sistem Absensi PKL

## 🚀 Quick Start Testing

### Prerequisites
- Server berjalan di `http://localhost:8000`
- Database seeded dengan test data
- Browser dengan GPS/Geolocation support

### Test Accounts
```
Admin:
  Email: admin@absensi-pkl.local
  Password: Admin123456

Pembina:
  Email: pembina@absensi-pkl.local
  Password: Pembina123456

Peserta:
  Email: peserta@absensi-pkl.local
  Password: Peserta123456
  Lokasi Kerja: SMKN 1 Garut (-7.2024967, 107.8905718)
  Radius: 500 meter
```

## 📋 Test Case 1: Login & Navigation

### Steps:
1. Open `http://localhost:8000`
2. Click "Login"
3. Enter peserta credentials
4. Click "Masuk"

### Expected Results:
- [ ] Login successful
- [ ] Redirect to `/peserta/dashboard`
- [ ] Sidebar menu visible with "Absensi" option
- [ ] User dropdown shows "peserta@absensi-pkl.local"

---

## 📋 Test Case 2: Access Attendance Create Page

### Steps:
1. From dashboard, click "Absensi" menu
2. Click "Tambah Absensi" button
3. Wait for page to load (5 seconds)

### Expected Results:
- [ ] Page loads without errors
- [ ] Form title: "Tambah Data Absensi"
- [ ] Three maps visible (reference, masuk, keluar)
- [ ] Maps show "Loading peta..." initially
- [ ] Within 3-5 seconds, maps initialize with markers
- [ ] Browser console shows: "✅ Google Maps API script loaded"
- [ ] Browser console shows: "✓ Google Maps berhasil dimuat"

---

## 📋 Test Case 3: Map Reference Display

### Steps:
1. Page loaded with maps visible
2. Observe reference map (green border, top)

### Expected Results:
- [ ] Reference map shows green circle
- [ ] Circle centered at SMKN 1 Garut
- [ ] Green marker in center of circle
- [ ] Circle radius ~500 pixels (zoom 16)
- [ ] Map title: "Peta Referensi Lokasi Kerja"

**Reference Coordinates:**
- Latitude: -7.2024967
- Longitude: 107.8905718
- Radius: 500 meters

---

## 📋 Test Case 4: Photo Upload & Preview

### Steps:
1. Click file input "Foto Masuk"
2. Select any image from device
3. Wait 2 seconds

### Expected Results:
- [ ] Image preview appears below input
- [ ] Image max size: 200px height
- [ ] Image has border-radius: 5px
- [ ] Same works for "Foto Keluar" input

---

## 📋 Test Case 5: Manual Marker Placement (Click Map)

### Steps:
1. On "Peta Lokasi Anda (Absensi Masuk)"
2. Click anywhere on map
3. Observe marker movement

### Expected Results:
- [ ] Marker (blue dot) moves to clicked location
- [ ] Map centers on new marker
- [ ] Latitude & Longitude inputs auto-fill
- [ ] Distance display shows calculation

### Distance Display Tests:

#### Sub-Test 5a: Within Radius (PASS ✓)
1. Click on/near SMKN 1 Garut (center of green circle)
2. Check distance display

**Expected:**
```
✓ Jarak dari tempat kerja: 0-500 meter ✓ (Dalam jangkauan)
(Text in GREEN with checkmark icon)
```

#### Sub-Test 5b: Outside Radius (FAIL ✗)
1. Click far from SMKN 1 Garut (outside green circle)
2. Check distance display

**Expected:**
```
✗ Jarak dari tempat kerja: 500+ meter ✗ (Terlalu jauh!)
(Text in RED with X icon)
```

---

## 📋 Test Case 6: GPS Button (Get Real Location)

### Prerequisites:
- Device with GPS enabled
- Browser permission for location allowed
- Device actual location is different from SMKN 1 Garut (for testing)

### Steps:
1. Click "Ambil Lokasi Saat Ini" button (Masuk)
2. Browser may request location permission
3. Click "Allow"
4. Wait 3-5 seconds

### Expected Results:
- [ ] Map centers on device location
- [ ] Blue marker appears at device location
- [ ] Latitude & Longitude fields populate
- [ ] Distance calculation shows result
- [ ] If within 500m: Green ✓
- [ ] If outside 500m: Red ✗

### Alternative (If GPS Not Available):
1. No error message
2. Continue with manual marker placement
3. Or use nearby location simulator if testing from office/home

---

## 📋 Test Case 7: Marker Dragging

### Steps:
1. On "Peta Lokasi Anda (Absensi Masuk)"
2. Click and hold blue marker
3. Drag to different location
4. Release mouse

### Expected Results:
- [ ] Marker follows mouse
- [ ] Map NOT center on marker while dragging
- [ ] After release, location updates
- [ ] Latitude & Longitude inputs change
- [ ] Distance recalculates automatically

---

## 📋 Test Case 8: Form Submission - VALID Location

### Setup:
1. Fill date: Today
2. Upload photo for "Foto Masuk"
3. Set location within 500m radius (near green circle)
4. Ensure distance shows ✓ (Dalam jangkauan)
5. Set status: "Hadir"
6. Leave "Foto Keluar" empty
7. Leave "Jam Masuk/Keluar" empty

### Steps:
1. Scroll to bottom
2. Click "Simpan" button
3. Wait for submission

### Expected Results:
- [ ] Form submits successfully
- [ ] Redirect to `/attendance` (index page)
- [ ] Success message: "Absensi berhasil dicatat"
- [ ] New attendance record appears in list

---

## 📋 Test Case 9: Form Submission - INVALID Location

### Setup:
1. Fill date: Today
2. Upload photo for "Foto Masuk"
3. Set location OUTSIDE 500m radius (far from green circle)
4. Ensure distance shows ✗ (Terlalu jauh!)
5. Set status: "Hadir"
6. Leave others empty

### Steps:
1. Scroll to bottom
2. Click "Simpan" button
3. Wait for response

### Expected Results:
- [ ] Form NOT submitted
- [ ] Error message appears:
  ```
  "Anda tidak berada di lokasi tempat kerja yang diharuskan! 
   Jarak melampaui radius toleransi (500m)"
  ```
- [ ] Redirect back to form with error
- [ ] Form data preserved
- [ ] No record created in database

---

## 📋 Test Case 10: Both Masuk & Keluar Locations

### Setup:
1. Set location masuk: WITHIN radius ✓
2. Set location keluar: OUTSIDE radius ✗
3. Upload both photos
4. Set status: "Hadir"

### Steps:
1. Click "Simpan"

### Expected Results:
- [ ] Form rejected with error:
  ```
  "Lokasi keluar Anda tidak berada di lokasi tempat kerja 
   yang diharuskan!"
  ```
- [ ] Form redirected, not submitted

---

## 📋 Test Case 11: Role-Based Access Control

### Test Admin Access:
1. Login as admin@absensi-pkl.local
2. Navigate to `/attendance`
3. Should see ALL attendances from all peserta

**Expected:** Can see attendance list

### Test Pembina Access:
1. Login as pembina@absensi-pkl.local
2. Navigate to `/attendance`
3. Should see attendances from their peserta only

**Expected:** Can see only Ahmad Rizki's attendance

### Test Peserta Access:
1. Login as peserta@absensi-pkl.local
2. Navigate to `/attendance`
3. Should see only their own attendances

**Expected:** Can see only their own records

---

## 📋 Test Case 12: Database Validation

### Check Seeded Data:
```bash
cd "c:\Project Andika\absensi-pkl"
php artisan tinker

# Check if peserta has location data
>>> $peserta = \App\Models\Peserta::first();
>>> echo $peserta->latitude_tempat_kerja;    // Should: -7.2024967
>>> echo $peserta->longitude_tempat_kerja;   // Should: 107.8905718
>>> echo $peserta->radius_toleransi;          // Should: 500
```

### Expected Output:
```
=> -7.2024967
=> 107.8905718
=> 500
```

---

## 📋 Test Case 13: Browser Console Logging

### Steps:
1. Open attendance/create page
2. Press F12 (Developer Tools)
3. Go to "Console" tab
4. Observe logs

### Expected Console Output:
```
📄 Page loaded, akan load Google Maps...
🔄 Memulai load Google Maps API...
✅ Google Maps API script loaded
✓ Google Maps berhasil dimuat
```

### No Red Errors Expected:
```
❌ Tidak boleh ada error merah
❌ Tidak boleh ada "undefined reference"
❌ Tidak boleh ada "Cannot read property"
```

---

## 🐛 Troubleshooting Results

| Issue | Solution | Result |
|-------|----------|--------|
| Maps not loading | Clear cache, refresh | Should load within 5s |
| "Oops! Something wrong" | Check console logs | Should show ✅ loaded |
| GPS not working | Check browser permission | Allow permission, retry |
| Location too far | Move near SMKN 1 Garut | Should show ✓ green |
| Photo not preview | Select different image | Should show preview |
| Form won't submit | Check distance ✓ | Should show ✓ status |

---

## ✅ Complete Verification Checklist

- [ ] All 3 maps initialize
- [ ] Reference map shows green circle & marker
- [ ] Photo preview works (masuk & keluar)
- [ ] Manual marker click works
- [ ] Marker dragging works
- [ ] Distance calculation correct
- [ ] Distance display color-coded (green/red)
- [ ] GPS button works (if device has GPS)
- [ ] Form validates location before submit
- [ ] Valid location allows submission
- [ ] Invalid location prevents submission
- [ ] Error message shows for invalid location
- [ ] Database stores attendance correctly
- [ ] Console logs show success messages
- [ ] No JavaScript errors in console
- [ ] Role-based access working

---

## 📊 Performance Metrics

- **Map Load Time**: < 5 seconds
- **Distance Calculation**: < 100ms
- **Form Submission**: < 2 seconds
- **Page Load Time**: < 3 seconds

---

## 📞 Reporting Issues

If test fails, provide:
1. Screenshot of error
2. Browser console error message
3. Network tab requests (DevTools)
4. Test case number
5. Device location (approximate)
6. Browser type & version

---

**Last Updated**: 2025-11-27
**Version**: 1.0.0
**Status**: ✅ Ready for Testing
