@extends('layout')

@section('title', 'Tambah Absensi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-plus-circle"></i> Tambah Data Absensi</h1>
    </div>
    
    <!-- Informasi Peserta & Pembina -->
    <div class="row mb-4">
        <div class="col-12 col-md-6 mb-3 mb-md-0">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-user-graduate"></i> Data Peserta
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong> {{ $peserta->nama_lengkap }}</p>
                    <p><strong>NISN:</strong> {{ $peserta->nisn }}</p>
                    <p><strong>Sekolah:</strong> {{ $peserta->sekolah }}</p>
                    <p><strong>Jurusan:</strong> {{ $peserta->jurusan }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-6">
            @if($peserta->pembina)
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-user-tie"></i> Data Pembina
                </div>
                <div class="card-body">
                    <p><strong>Nama Pembina:</strong> {{ $peserta->pembina->nama_lengkap }}</p>
                    <p><strong>Jabatan:</strong> {{ $peserta->pembina->jabatan }}</p>
                    <p><strong>NIP:</strong> {{ $peserta->pembina->nip }}</p>
                    <p><strong>Nomor HP:</strong> {{ $peserta->pembina->nomor_hp }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-form"></i> Form Tambah Absensi
                </div>
                <div class="card-body">
                    <form action="{{ route('attendance.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                   id="tanggal" name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}" required>
                            @error('tanggal')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jam_masuk" class="form-label">Jam Masuk</label>
                                <input type="time" class="form-control @error('jam_masuk') is-invalid @enderror" 
                                       id="jam_masuk" name="jam_masuk" value="{{ old('jam_masuk') }}">
                                @error('jam_masuk')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="jam_keluar" class="form-label">Jam Keluar</label>
                                <input type="time" class="form-control @error('jam_keluar') is-invalid @enderror" 
                                       id="jam_keluar" name="jam_keluar" value="{{ old('jam_keluar') }}">
                                @error('jam_keluar')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <h6 class="mb-3"><i class="fas fa-camera"></i> Foto Bukti</h6>
                        
                        <div class="row">
                            <div class="col-12 col-lg-6 mb-3">
                                <label class="form-label">Foto Masuk</label>
                                <ul class="nav nav-tabs mb-2" id="tabMasuk" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="upload-masuk-tab" data-bs-toggle="tab" data-bs-target="#upload-masuk" type="button">Upload</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="camera-masuk-tab" data-bs-toggle="tab" data-bs-target="#camera-masuk" type="button">Live Camera</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="tabMasukContent">
                                    <div class="tab-pane fade show active" id="upload-masuk" role="tabpanel">
                                        <input type="file" class="form-control @error('foto_masuk') is-invalid @enderror" 
                                               id="foto_masuk" name="foto_masuk" accept="image/*" onchange="previewFoto('foto_masuk', 'preview_masuk')">
                                        <small class="text-muted">Max 2MB, format: JPG, PNG, GIF</small>
                                        <div id="preview_masuk" class="mt-2"></div>
                                        @error('foto_masuk')
                                            <small class="invalid-feedback d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="tab-pane fade" id="camera-masuk" role="tabpanel">
                                        <div style="border: 2px solid #ddd; border-radius: 5px; padding: 10px; margin-bottom: 10px; background: #000;">
                                            <video id="video_masuk" style="width: 100%; max-height: 400px; display: none; border-radius: 5px; background: #000; object-fit: cover; transform: scaleX(-1);" playsinline autoplay muted></video>
                                            <canvas id="canvas_masuk" style="width: 100%; display: none; border-radius: 5px;"></canvas>
                                            <div id="camera_placeholder_masuk" style="width: 100%; height: 250px; background: #f5f5f5; border-radius: 5px; display: flex; align-items: center; justify-content: center; flex-direction: column; color: #999;">
                                                <i class="fas fa-camera" style="font-size: 48px; margin-bottom: 10px;"></i>
                                                <p>Klik tombol "Buka Kamera" untuk memulai</p>
                                            </div>
                                        </div>
                                        <div class="d-grid gap-2 d-sm-flex">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="startCameraMasuk()">
                                                <i class="fas fa-video"></i> Buka Kamera
                                            </button>
                                            <button type="button" class="btn btn-success btn-sm" onclick="capturePhotoMasuk()" id="capture_masuk_btn" style="display: none;">
                                                <i class="fas fa-camera"></i> Ambil Foto
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="stopCameraMasuk()" id="stop_masuk_btn" style="display: none;">
                                                <i class="fas fa-stop"></i> Tutup Kamera
                                            </button>
                                        </div>
                                        <div id="camera_result_masuk" class="mt-2"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 col-lg-6 mb-3">
                                <label class="form-label">Foto Keluar</label>
                                <ul class="nav nav-tabs mb-2" id="tabKeluar" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="upload-keluar-tab" data-bs-toggle="tab" data-bs-target="#upload-keluar" type="button">Upload</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="camera-keluar-tab" data-bs-toggle="tab" data-bs-target="#camera-keluar" type="button">Live Camera</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="tabKeluarContent">
                                    <div class="tab-pane fade show active" id="upload-keluar" role="tabpanel">
                                        <input type="file" class="form-control @error('foto_keluar') is-invalid @enderror" 
                                               id="foto_keluar" name="foto_keluar" accept="image/*" onchange="previewFoto('foto_keluar', 'preview_keluar')">
                                        <small class="text-muted">Max 2MB, format: JPG, PNG, GIF</small>
                                        <div id="preview_keluar" class="mt-2"></div>
                                        @error('foto_keluar')
                                            <small class="invalid-feedback d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="tab-pane fade" id="camera-keluar" role="tabpanel">
                                        <div style="border: 2px solid #ddd; border-radius: 5px; padding: 10px; margin-bottom: 10px; background: #000;">
                                            <video id="video_keluar" style="width: 100%; max-height: 400px; display: none; border-radius: 5px; background: #000; object-fit: cover; transform: scaleX(-1);" playsinline autoplay muted></video>
                                            <canvas id="canvas_keluar" style="width: 100%; display: none; border-radius: 5px;"></canvas>
                                            <div id="camera_placeholder_keluar" style="width: 100%; height: 250px; background: #f5f5f5; border-radius: 5px; display: flex; align-items: center; justify-content: center; flex-direction: column; color: #999;">
                                                <i class="fas fa-camera" style="font-size: 48px; margin-bottom: 10px;"></i>
                                                <p>Klik tombol "Buka Kamera" untuk memulai</p>
                                            </div>
                                        </div>
                                        <div class="d-grid gap-2 d-sm-flex">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="startCameraKeluar()">
                                                <i class="fas fa-video"></i> Buka Kamera
                                            </button>
                                            <button type="button" class="btn btn-success btn-sm" onclick="capturePhotoKeluar()" id="capture_keluar_btn" style="display: none;">
                                                <i class="fas fa-camera"></i> Ambil Foto
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="stopCameraKeluar()" id="stop_keluar_btn" style="display: none;">
                                                <i class="fas fa-stop"></i> Tutup Kamera
                                            </button>
                                        </div>
                                        <div id="camera_result_keluar" class="mt-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="hadir" @if(old('status') == 'hadir') selected @endif>Hadir</option>
                                <option value="izin" @if(old('status') == 'izin') selected @endif>Izin</option>
                                <option value="sakit" @if(old('status') == 'sakit') selected @endif>Sakit</option>
                                <option value="alfa" @if(old('status') == 'alfa') selected @endif>Alfa</option>
                            </select>
                            @error('status')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                      id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-sm-flex">
                            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Google Maps API -->
<script>
    // Function untuk load Google Maps API dengan fallback
    function loadGoogleMaps() {
        console.log('🔄 Memulai load Google Maps API...');
        const script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDzcKMTmV1yHj3tP2rN1m0q8n7p3i0d5Q8&libraries=geometry';
        script.async = true;
        script.defer = true;
        script.onload = function() {
            console.log('✅ Google Maps API script loaded');
            // Berikan delay kecil untuk memastikan Google object tersedia
            setTimeout(initMaps, 500);
        };
        script.onerror = function() {
            console.error('❌ Google Maps API failed to load - Menggunakan mode fallback');
            showMapsFallback();
        };
        document.head.appendChild(script);
    }
    
    function showMapsFallback() {
        const mapElements = ['map_reference', 'map_masuk', 'map_keluar'];
        mapElements.forEach(id => {
            const elem = document.getElementById(id);
            if (elem) {
                elem.innerHTML = `<div style="padding: 20px; background: #f8f9fa; border: 2px dashed #ccc; border-radius: 5px; text-align: center;">
                    <div style="margin-bottom: 15px;">
                        <i class="fas fa-map" style="font-size: 40px; color: #999; margin-bottom: 10px;"></i>
                    </div>
                    <h6 style="color: #333;">Google Maps Tidak Tersedia</h6>
                    <p style="color: #666; margin-bottom: 10px;">
                        <small>❌ Google Maps tidak dapat dimuat. Silakan masukkan koordinat secara manual.</small>
                    </p>
                    <p style="color: #666; font-size: 12px; margin-bottom: 0;">
                        <strong>Lokasi Referensi:</strong><br>
                        Lat: {{ $peserta->latitude_tempat_kerja ?? -7.2024967 }}<br>
                        Lng: {{ $peserta->longitude_tempat_kerja ?? 107.8905718 }}<br>
                        Radius: {{ $peserta->radius_toleransi ?? 500 }}m
                    </p>
                </div>`;
            }
        });
        console.log('⚠️ Menggunakan mode manual input koordinat');
    }
    
    // Panggil saat DOM ready
    console.log('📄 Page loaded, akan load Google Maps...');
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadGoogleMaps);
    } else {
        loadGoogleMaps();
    }
    
    // Tambahan: Deteksi error saat initMaps
    window.addEventListener('error', function(event) {
        if (event.message && event.message.includes('google')) {
            console.error('Google Maps Error:', event.message);
        }
    });
</script>

<script>
let mapMasuk, markerMasuk;
let mapKeluar, markerKeluar;
let mapReference, markerReference, circleReference;

// Data lokasi referensi (SMKN 1 Garut)
const referenceLocation = {
    lat: {{ $peserta->latitude_tempat_kerja ?? -7.2024967 }},
    lng: {{ $peserta->longitude_tempat_kerja ?? 107.8905718 }}
};
const radiusToleransi = {{ $peserta->radius_toleransi ?? 500 }};

// Flag untuk check jika Google Maps sudah loaded
let mapsLoaded = false;

// Function untuk hitung jarak antara 2 koordinat (Haversine formula)
function calculateDistance(lat1, lng1, lat2, lng2) {
    const R = 6371000; // Radius bumi dalam meter
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLng = (lng2 - lng1) * Math.PI / 180;
    const a = 
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLng / 2) * Math.sin(dLng / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c; // Distance in meters
}

// Initialize maps - dipanggil saat Google Maps API loaded
function initMaps() {
    // Check if Google Maps is available
    if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
        console.error('Google Maps tidak tersedia');
        showMapsFallback();
        return;
    }
    
    // Default location (Jakarta)
    const defaultLocation = { lat: -6.2088, lng: 106.8456 };
    
    try {
        // Map Reference (Lokasi Kerja)
        const mapRefElement = document.getElementById('map_reference');
        if (mapRefElement) {
            mapReference = new google.maps.Map(mapRefElement, {
                zoom: 16,
                center: referenceLocation
            });
            
            markerReference = new google.maps.Marker({
                position: referenceLocation,
                map: mapReference,
                title: 'Lokasi Wajib Absen',
                icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
            });
            
            circleReference = new google.maps.Circle({
                map: mapReference,
                center: referenceLocation,
                radius: radiusToleransi,
                fillColor: '#28a745',
                fillOpacity: 0.15,
                strokeColor: '#28a745',
                strokeOpacity: 0.8,
                strokeWeight: 2
            });
        }
        
        // Map Masuk
        const mapMasukElement = document.getElementById('map_masuk');
        if (mapMasukElement) {
            mapMasuk = new google.maps.Map(mapMasukElement, {
                zoom: 15,
                center: defaultLocation
            });
            
            markerMasuk = new google.maps.Marker({
                position: defaultLocation,
                map: mapMasuk,
                draggable: true,
                icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
            });
            
            mapMasuk.addListener('click', function(event) {
                updateMarkerMasuk(event.latLng);
            });
            
            markerMasuk.addListener('dragend', function() {
                updateMarkerMasuk(markerMasuk.getPosition());
            });
        }
        
        // Map Keluar
        const mapKeluarElement = document.getElementById('map_keluar');
        if (mapKeluarElement) {
            mapKeluar = new google.maps.Map(mapKeluarElement, {
                zoom: 15,
                center: defaultLocation
            });
            
            markerKeluar = new google.maps.Marker({
                position: defaultLocation,
                map: mapKeluar,
                draggable: true,
                icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
            });
            
            mapKeluar.addListener('click', function(event) {
                updateMarkerKeluar(event.latLng);
            });
            
            markerKeluar.addListener('dragend', function() {
                updateMarkerKeluar(markerKeluar.getPosition());
            });
        }
        
        mapsLoaded = true;
        console.log('✓ Google Maps berhasil dimuat');
    } catch (error) {
        console.error('Error initializing maps:', error);
        showMapsFallback();
    }
}

function updateMarkerMasuk(location) {
    if (!mapsLoaded || !mapMasuk) {
        console.error('Maps belum dimuat');
        return;
    }
    
    markerMasuk.setPosition(location);
    mapMasuk.setCenter(location);
    document.getElementById('latitude_masuk').value = location.lat().toFixed(6);
    document.getElementById('longitude_masuk').value = location.lng().toFixed(6);
    
    // Hitung jarak
    const distance = calculateDistance(
        referenceLocation.lat, 
        referenceLocation.lng,
        location.lat(),
        location.lng()
    );
    
    const distanceText = `Jarak dari tempat kerja: ${distance.toFixed(0)} meter`;
    const distanceElement = document.getElementById('distance_masuk');
    
    if (distance <= radiusToleransi) {
        distanceElement.innerHTML = `<span class="text-success"><i class="fas fa-check-circle"></i> ${distanceText} ✓ (Dalam jangkauan)</span>`;
    } else {
        distanceElement.innerHTML = `<span class="text-danger"><i class="fas fa-times-circle"></i> ${distanceText} ✗ (Terlalu jauh!)</span>`;
    }
}

function updateMarkerKeluar(location) {
    if (!mapsLoaded || !mapKeluar) {
        console.error('Maps belum dimuat');
        return;
    }
    
    markerKeluar.setPosition(location);
    mapKeluar.setCenter(location);
    document.getElementById('latitude_keluar').value = location.lat().toFixed(6);
    document.getElementById('longitude_keluar').value = location.lng().toFixed(6);
    
    // Hitung jarak
    const distance = calculateDistance(
        referenceLocation.lat, 
        referenceLocation.lng,
        location.lat(),
        location.lng()
    );
    
    const distanceText = `Jarak dari tempat kerja: ${distance.toFixed(0)} meter`;
    const distanceElement = document.getElementById('distance_keluar');
    
    if (distance <= radiusToleransi) {
        distanceElement.innerHTML = `<span class="text-success"><i class="fas fa-check-circle"></i> ${distanceText} ✓ (Dalam jangkauan)</span>`;
    } else {
        distanceElement.innerHTML = `<span class="text-danger"><i class="fas fa-times-circle"></i> ${distanceText} ✗ (Terlalu jauh!)</span>`;
    }
}

function getLocationMasuk() {
    if (!mapsLoaded || !mapMasuk) {
        alert('Google Maps belum selesai dimuat. Coba lagi dalam beberapa detik.');
        return;
    }
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const location = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            updateMarkerMasuk(new google.maps.LatLng(location.lat, location.lng));
        }, function(error) {
            console.error('Geolocation error:', error);
            alert('Tidak dapat mengakses lokasi. Pastikan:\n1. GPS/Location diaktifkan\n2. Browser diizinkan akses lokasi\n3. Atau manual set lokasi dengan klik di map');
        });
    } else {
        alert('Geolocation tidak didukung oleh browser Anda');
    }
}

function getLocationKeluar() {
    if (!mapsLoaded || !mapKeluar) {
        alert('Google Maps belum selesai dimuat. Coba lagi dalam beberapa detik.');
        return;
    }
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const location = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            updateMarkerKeluar(new google.maps.LatLng(location.lat, location.lng));
        }, function(error) {
            console.error('Geolocation error:', error);
            alert('Tidak dapat mengakses lokasi. Pastikan:\n1. GPS/Location diaktifkan\n2. Browser diizinkan akses lokasi\n3. Atau manual set lokasi dengan klik di map');
        });
    } else {
        alert('Geolocation tidak didukung oleh browser Anda');
    }
}

function previewFoto(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" style="max-width: 100%; max-height: 200px; border-radius: 5px;" alt="Preview">';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// ============ LIVE CAMERA FUNCTIONS ============

let streamMasuk = null;
let streamKeluar = null;

function startCameraMasuk() {
    const video = document.getElementById('video_masuk');
    const placeholder = document.getElementById('camera_placeholder_masuk');
    
    console.log('🎥 Meminta akses kamera untuk masuk...');
    
    const constraints = {
        video: {
            facingMode: 'user',
            width: { ideal: 1280 },
            height: { ideal: 720 }
        },
        audio: false
    };
    
    navigator.mediaDevices.getUserMedia(constraints)
        .then(stream => {
            console.log('✅ Kamera berhasil diakses (masuk)');
            streamMasuk = stream;
            video.srcObject = stream;
            
            // Tungup video siap dimainkan
            video.onloadedmetadata = function() {
                console.log('✅ Video metadata loaded');
                video.play().catch(err => {
                    console.error('❌ Error playing video:', err);
                });
            };
            
            video.style.display = 'block';
            placeholder.style.display = 'none';
            document.getElementById('capture_masuk_btn').style.display = 'inline-block';
            document.getElementById('stop_masuk_btn').style.display = 'inline-block';
        })
        .catch(err => {
            console.error('❌ Error mengakses kamera:', err);
            let errorMsg = 'Tidak dapat mengakses kamera. ';
            if (err.name === 'NotAllowedError') {
                errorMsg += 'Izin akses kamera ditolak. Silakan buka pengaturan browser dan izinkan akses kamera.';
            } else if (err.name === 'NotFoundError') {
                errorMsg += 'Kamera tidak ditemukan di perangkat Anda.';
            } else if (err.name === 'NotReadableError') {
                errorMsg += 'Kamera sudah digunakan oleh aplikasi lain.';
            } else {
                errorMsg += 'Silakan periksa koneksi kamera Anda.';
            }
            alert(errorMsg);
        });
}

function capturePhotoMasuk() {
    const video = document.getElementById('video_masuk');
    const canvas = document.getElementById('canvas_masuk');
    const ctx = canvas.getContext('2d');
    
    if (!video.srcObject) {
        alert('Video stream tidak tersedia');
        return;
    }
    
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    
    // Mirror horizontal
    ctx.translate(canvas.width, 0);
    ctx.scale(-1, 1);
    ctx.drawImage(video, 0, 0);
    
    canvas.toBlob(blob => {
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(new File([blob], 'foto_masuk.jpg', { type: 'image/jpeg' }));
        document.getElementById('foto_masuk').files = dataTransfer.files;
        
        canvas.style.display = 'block';
        document.getElementById('camera_result_masuk').innerHTML = '<div class="alert alert-success mt-2"><i class="fas fa-check"></i> Foto berhasil diambil!</div>';
        
        stopCameraMasuk();
    }, 'image/jpeg', 0.95);
}

function stopCameraMasuk() {
    if (streamMasuk) {
        streamMasuk.getTracks().forEach(track => {
            track.stop();
            console.log('🛑 Track stopped:', track.kind);
        });
        streamMasuk = null;
    }
    document.getElementById('video_masuk').style.display = 'none';
    document.getElementById('camera_placeholder_masuk').style.display = 'flex';
    document.getElementById('capture_masuk_btn').style.display = 'none';
    document.getElementById('stop_masuk_btn').style.display = 'none';
}

function startCameraKeluar() {
    const video = document.getElementById('video_keluar');
    const placeholder = document.getElementById('camera_placeholder_keluar');
    
    console.log('🎥 Meminta akses kamera untuk keluar...');
    
    const constraints = {
        video: {
            facingMode: 'user',
            width: { ideal: 1280 },
            height: { ideal: 720 }
        },
        audio: false
    };
    
    navigator.mediaDevices.getUserMedia(constraints)
        .then(stream => {
            console.log('✅ Kamera berhasil diakses (keluar)');
            streamKeluar = stream;
            video.srcObject = stream;
            
            // Tunggu video siap dimainkan
            video.onloadedmetadata = function() {
                console.log('✅ Video metadata loaded');
                video.play().catch(err => {
                    console.error('❌ Error playing video:', err);
                });
            };
            
            video.style.display = 'block';
            placeholder.style.display = 'none';
            document.getElementById('capture_keluar_btn').style.display = 'inline-block';
            document.getElementById('stop_keluar_btn').style.display = 'inline-block';
        })
        .catch(err => {
            console.error('❌ Error mengakses kamera:', err);
            let errorMsg = 'Tidak dapat mengakses kamera. ';
            if (err.name === 'NotAllowedError') {
                errorMsg += 'Izin akses kamera ditolak. Silakan buka pengaturan browser dan izinkan akses kamera.';
            } else if (err.name === 'NotFoundError') {
                errorMsg += 'Kamera tidak ditemukan di perangkat Anda.';
            } else if (err.name === 'NotReadableError') {
                errorMsg += 'Kamera sudah digunakan oleh aplikasi lain.';
            } else {
                errorMsg += 'Silakan periksa koneksi kamera Anda.';
            }
            alert(errorMsg);
        });
}

function capturePhotoKeluar() {
    const video = document.getElementById('video_keluar');
    const canvas = document.getElementById('canvas_keluar');
    const ctx = canvas.getContext('2d');
    
    if (!video.srcObject) {
        alert('Video stream tidak tersedia');
        return;
    }
    
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    
    // Mirror horizontal
    ctx.translate(canvas.width, 0);
    ctx.scale(-1, 1);
    ctx.drawImage(video, 0, 0);
    
    canvas.toBlob(blob => {
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(new File([blob], 'foto_keluar.jpg', { type: 'image/jpeg' }));
        document.getElementById('foto_keluar').files = dataTransfer.files;
        
        canvas.style.display = 'block';
        document.getElementById('camera_result_keluar').innerHTML = '<div class="alert alert-success mt-2"><i class="fas fa-check"></i> Foto berhasil diambil!</div>';
        
        stopCameraKeluar();
    }, 'image/jpeg', 0.95);
}

function stopCameraKeluar() {
    if (streamKeluar) {
        streamKeluar.getTracks().forEach(track => {
            track.stop();
            console.log('🛑 Track stopped:', track.kind);
        });
        streamKeluar = null;
    }
    document.getElementById('video_keluar').style.display = 'none';
    document.getElementById('camera_placeholder_keluar').style.display = 'flex';
    document.getElementById('capture_keluar_btn').style.display = 'none';
    document.getElementById('stop_keluar_btn').style.display = 'none';
}
</script>
@endsection
