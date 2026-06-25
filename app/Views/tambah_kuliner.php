<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tempat Kuliner</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body { 
            background-color: #f8f9fa; 
            font-family: 'Outfit', sans-serif;
            color: #333;
            padding: 40px 20px;
            margin: 0;
            min-height: 100vh;
        }
        .form-container {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 100%; 
            max-width: 600px;
            padding: 40px;
            margin: 0 auto;
        }
        .form-container h2 { margin-top: 0; color: #007bff; font-weight: 700; border-bottom: 1px solid #e5e7eb; padding-bottom: 15px; margin-bottom: 25px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px; color: #4b5563; }
        .form-control { 
            width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #d1d5db; background: #ffffff; box-sizing: border-box; font-size: 14px; font-family: inherit; transition: all 0.2s ease; 
        }
        .form-control:focus { border-color: #007bff; outline: none; box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25); }
        .row { display: flex; gap: 15px; }
        .col { flex: 1; }
        .btn-group { margin-top: 30px; display: flex; gap: 15px; align-items: center; }
        .btn-save { background-color: #007bff; color: white; border: none; padding: 12px 25px; border-radius: 8px; cursor: pointer; font-size: 15px; font-weight: 600; transition: background-color 0.2s; }
        .btn-save:hover { background-color: #0056b3; }
        .btn-cancel { color: #64748b; text-decoration: none; font-size: 15px; padding: 12px 25px; border-radius: 8px; font-weight: 600; transition: all 0.2s ease; border: 1px solid transparent; }
        .btn-cancel:hover { background: #f1f5f9; color: #007bff; }
        
        /* CSS Tambahan untuk tombol action (Cari Koordinat) */
        .btn-action { 
            background-color: #10b981; 
            color: white; 
            border: none; 
            padding: 10px 15px; 
            border-radius: 8px; 
            cursor: pointer; 
            font-size: 13px; 
            font-weight: 600; 
            margin-top: 10px;
            transition: background-color 0.2s;
            display: inline-block;
        }
        .btn-action:hover { background-color: #059669; }
        .btn-action:disabled { background-color: #a7f3d0; cursor: not-allowed; }

        /* Mini Map Pick on Map */
        .map-picker-wrapper { margin-bottom: 20px; }
        .map-picker-wrapper label { display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px; color: #4b5563; }
        .map-hint { font-size: 12px; color: #888; margin-bottom: 8px; }
        #map-picker { height: 260px; border-radius: 8px; border: 1px solid #d1d5db; z-index: 1; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Tambah Tempat Kuliner</h2>
        
        <?php if (session()->getFlashdata('errors')) : ?>
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <form action="/simpan-kuliner" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            
            <div class="form-group">
                <label>Nama Tempat</label>
                <input type="text" name="nama" class="form-control" placeholder="Contoh: Nasi Goreng Babat Pak Karmin" required>
            </div>

            <div class="form-group">
                <label>Kategori Kuliner</label>
                <select name="kategori_id" class="form-control" required>
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    <?php foreach ($kategori as $k) : ?>
                        <option value="<?= $k['id'] ?>"><?= esc($k['nama_kategori']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="alamat" id="alamat" rows="3" class="form-control" placeholder="Tuliskan alamat lengkap jalan, RT/RW, dll..." required></textarea>
                <button type="button" id="btnCariKoordinat" class="btn-action">📍 Cari Koordinat Otomatis</button>
            </div>

            <div class="form-group">
                <label>Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="3" class="form-control" placeholder="Ceritakan ciri khas atau menu andalan dari tempat ini..."></textarea>
            </div>
            
            <div class="form-group">
                <label>Foto Tempat Kuliner</label>
                <input type="file" name="gambar" class="form-control" accept="image/*" style="padding: 9px;" required>
                <small style="color: #888; font-size: 12px; margin-top: 5px; display: block;">Format: JPG, PNG, JPEG. Maksimal 2MB.</small>
            </div>

            <div class="row">
                <div class="col form-group">
                    <label>Latitude (Lat) Peta</label>
                    <input type="text" name="lat" id="lat" class="form-control" placeholder="Terisi otomatis..." readonly required>
                </div>
                <div class="col form-group">
                    <label>Longitude (Lon) Peta</label>
                    <input type="text" name="lon" id="lon" class="form-control" placeholder="Terisi otomatis..." readonly required>
                </div>
            </div>

            <!-- PICK ON MAP -->
            <div class="map-picker-wrapper">
                <label>📍 Atau Pilih Lokasi Langsung di Peta</label>
                <p class="map-hint">Klik titik di peta untuk mengisi koordinat secara akurat</p>
                <div id="map-picker"></div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-save">Simpan Data</button>
                <a href="/dashboard" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('btnCariKoordinat').addEventListener('click', function() {
            let alamat = document.getElementById('alamat').value.trim();
            
            if (!alamat) {
                alert("Mohon isi alamat lengkap terlebih dahulu sebelum mencari koordinat.");
                return;
            }

            let btn = this;
            let originalText = btn.innerHTML;
            btn.innerHTML = '⏳ Mencari...';
            btn.disabled = true;

            // Memanggil endpoint API Controller yang sudah kita buat sebelumnya
            fetch('/api/get-coordinates?alamat=' + encodeURIComponent(alamat))
                .then(response => response.json())
                .then(data => {
                    // Jika sukses menemukan koordinat
                    if (data.lat && data.lon) {
                        document.getElementById('lat').value = data.lat;
                        document.getElementById('lon').value = data.lon;
                        
                        // Menambahkan style visual bahwa koordinat berhasil didapat
                        document.getElementById('lat').style.borderColor = '#10b981';
                        document.getElementById('lon').style.borderColor = '#10b981';
                        
                        // Opsional: Alert sukses bisa dihapus kalau dirasa mengganggu
                        // alert("Koordinat berhasil ditemukan!"); 
                    } else {
                        // Jika Controller mengembalikan error / koordinat tidak ditemukan
                        alert("Gagal: Koordinat tidak ditemukan. Pastikan nama jalan / kota ditulis dengan benar.");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Terjadi kesalahan sistem saat menghubungi server.");
                })
                .finally(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                });
        });

        // ================================
        // PICK ON MAP — Klik peta → isi lat/lon
        // ================================
        // Leaflet harus diload dulu
    </script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inisialisasi mini map di Semarang
        const pickerMap = L.map('map-picker').setView([-6.9903, 110.4229], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(pickerMap);

        let pickerMarker = null;

        // Reverse geocoding: koordinat → alamat (Nominatim)
        function reverseGeocode(lat, lon) {
            fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`, {
                headers: { 'User-Agent': 'ProjectKuliner/1.0' }
            })
            .then(r => r.json())
            .then(data => {
                if (data && data.display_name) {
                    const alamatField = document.getElementById('alamat');
                    alamatField.value = data.display_name;
                    alamatField.style.borderColor = '#10b981';
                }
            })
            .catch(() => {}); // Gagal reverse geocode → alamat tetap kosong, tidak masalah
        }

        // Fungsi update marker, isi lat/lon + auto-fetch alamat
        function setKoordinat(lat, lon, fillAlamat = false) {
            const latField = document.getElementById('lat');
            const lonField = document.getElementById('lon');
            latField.value = lat.toFixed(7);
            lonField.value = lon.toFixed(7);
            latField.style.borderColor = '#10b981';
            lonField.style.borderColor = '#10b981';

            if (pickerMarker) {
                pickerMarker.setLatLng([lat, lon]);
            } else {
                pickerMarker = L.marker([lat, lon], { draggable: true }).addTo(pickerMap);
                // Marker bisa di-drag untuk akurasi lebih
                pickerMarker.on('dragend', function(e) {
                    const pos = e.target.getLatLng();
                    setKoordinat(pos.lat, pos.lng, true); // drag → isi alamat juga
                });
            }
            pickerMap.setView([lat, lon], 17);

            // Kalau dari klik/drag peta → auto isi alamat
            if (fillAlamat) reverseGeocode(lat, lon);
        }

        // Klik di peta → taruh marker + isi alamat otomatis
        pickerMap.on('click', function(e) {
            setKoordinat(e.latlng.lat, e.latlng.lng, true);
        });

        // Sinkronisasi: jika Nominatim berhasil → update marker di peta juga
        document.getElementById('btnCariKoordinat').addEventListener('click', function() {
            setTimeout(function checkResult() {
                const lat = parseFloat(document.getElementById('lat').value);
                const lon = parseFloat(document.getElementById('lon').value);
                if (lat && lon) setKoordinat(lat, lon, false); // Nominatim → jangan timpa alamat
            }, 2000);
        }, true);
    </script>

</body>
</html>