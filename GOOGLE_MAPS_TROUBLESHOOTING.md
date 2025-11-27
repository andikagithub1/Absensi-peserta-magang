# Google Maps Troubleshooting Guide

## ❌ Error: "Oops! Something went wrong. This page didn't load Google Maps correctly."

## 🔍 Diagnosis Steps

### 1. Check Browser Console for Errors
**Steps:**
1. Open attendance/create page: `http://localhost:8000/attendance/create`
2. Press `F12` to open Developer Tools
3. Go to **Console** tab
4. Look for red error messages

**Expected Output if Working:**
```
📄 Page loaded, akan load Google Maps...
🔄 Memulai load Google Maps API...
✅ Google Maps API script loaded
✓ Google Maps berhasil dimuat
```

### 2. Common Errors & Solutions

#### Error A: API Key Invalid
**Error Message:**
```
Google Maps API error: ApiKeyInvalid
The provided API key is invalid.
```

**Solution:**
- Check if API key is correct: `AIzaSyDzcKMTmV1yHj3tP2rN1m0q8n7p3i0d5Q8`
- Go to [Google Cloud Console](https://console.cloud.google.com)
- Verify API key is enabled for Maps JavaScript API
- Check API key restrictions (should be unrestricted for development)

#### Error B: API Key Not Provided
**Error Message:**
```
Google Maps API warning: ApiKeyInvalid
The provided API key is invalid.
```

**Solution:**
- Ensure API key is in view file at line 193:
  ```php
  script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDzcKMTmV1yHj3tP2rN1m0q8n7p3i0d5Q8&libraries=geometry';
  ```

#### Error C: Network Error / CORS Issue
**Error Message:**
```
Failed to load resource: net::ERR_FAILED
```

**Solution:**
- Check internet connection
- Check if Google Maps domain is accessible
- Try accessing: `https://maps.googleapis.com/maps/api/js?key=AIzaSyDzcKMTmV1yHj3tP2rN1m0q8n7p3i0d5Q8`
- If blocked by firewall, contact IT

#### Error D: Script Load Timeout
**Symptoms:**
- Maps show "Loading peta..." forever
- No console errors

**Solution:**
- Wait 10 seconds for map to load
- Check internet speed
- Refresh page
- Check browser network tab for slow requests

### 3. Quick Health Check

Open browser console and run:
```javascript
// Check if Google Maps loaded
console.log(window.google ? '✓ Google Maps API loaded' : '✗ Google Maps API NOT loaded');

// Check if script is in DOM
console.log(document.querySelectorAll('script[src*="maps.googleapis"]').length > 0 ? '✓ Maps script in DOM' : '✗ Maps script NOT in DOM');

// Check map containers
console.log('Map reference:', document.getElementById('map_reference') ? '✓ Found' : '✗ Not found');
console.log('Map masuk:', document.getElementById('map_masuk') ? '✓ Found' : '✗ Not found');
console.log('Map keluar:', document.getElementById('map_keluar') ? '✓ Found' : '✗ Not found');
```

## 🔧 Manual Fix Steps

### Option 1: Clear Cache
1. Press `Ctrl + Shift + Delete` (Windows/Linux) or `Cmd + Shift + Delete` (Mac)
2. Select "Cached images and files"
3. Click "Clear data"
4. Refresh page

### Option 2: Try Different Browser
- Chrome ✓
- Firefox ✓
- Safari ✓
- Edge ✓
- IE ✗ (Not supported)

### Option 3: Use VPN
If Google Maps is blocked by firewall:
1. Enable VPN
2. Refresh page
3. Check if maps load

### Option 4: Update API Key
If API key expired or invalid:

**Get New API Key:**
1. Go to [Google Cloud Console](https://console.cloud.google.com)
2. Create new project or select existing
3. Enable "Maps JavaScript API"
4. Create API key (Credentials > Create Credentials > API Key)
5. Copy key
6. Update in `resources/views/attendance/create.blade.php` line 193

**Replace:**
```php
script.src = 'https://maps.googleapis.com/maps/api/js?key=YOUR_NEW_KEY_HERE&libraries=geometry';
```

### Option 5: Check Network Tab
1. Open DevTools (F12)
2. Go to **Network** tab
3. Refresh page
4. Look for requests to `maps.googleapis.com`
5. Check if status is 200 (success)
6. If status is other, check the response

## ✅ Verification Checklist

- [ ] Browser console shows no red errors
- [ ] Maps containers have height: 250px/300px
- [ ] Script loads from `maps.googleapis.com`
- [ ] Google Maps API key is valid
- [ ] Internet connection is active
- [ ] JavaScript is enabled in browser
- [ ] No browser extensions blocking maps
- [ ] Page loads within 10 seconds

## 🐛 If Still Not Working

1. **Check server logs:**
```bash
cd "c:\Project Andika\absensi-pkl"
php artisan serve --host=localhost --port=8000
```

2. **Check Laravel logs:**
```bash
tail -f storage/logs/laravel.log
```

3. **Test API directly:**
```bash
curl "https://maps.googleapis.com/maps/api/js?key=AIzaSyDzcKMTmV1yHj3tP2rN1m0q8n7p3i0d5Q8"
```

4. **Ask for help:**
- Screenshot of browser console errors
- Copy full error message
- Check network tab requests to maps.googleapis.com

## 📱 Development vs Production

### Development (Current)
```php
// Development - No restrictions
script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDzcKMTmV1yHj3tP2rN1m0q8n7p3i0d5Q8&libraries=geometry';
```

### Production (Recommended)
```php
// Production - Use environment variable
$apiKey = env('GOOGLE_MAPS_API_KEY', 'AIzaSyDzcKMTmV1yHj3tP2rN1m0q8n7p3i0d5Q8');
script.src = 'https://maps.googleapis.com/maps/api/js?key=' . $apiKey . '&libraries=geometry';
```

## 🎯 Expected Behavior

When page loads correctly:
1. Three maps appear with "Loading peta..." message
2. Within 2-5 seconds, maps initialize with markers
3. Reference map shows green circle (500m radius)
4. Masuk map shows blue marker
5. Keluar map shows red marker
6. GPS buttons are clickable
7. Distance display shows "-" until location is set

## 📞 Support

If error persists after all steps above:
1. Check Google Cloud Console for quota limits
2. Verify Maps API is enabled: https://console.cloud.google.com/apis/library
3. Check billing account is active
4. Consider using different API key
5. Contact Google Maps support

---

**Last Updated**: 2025-11-27
**Status**: ✅ All fixes applied
