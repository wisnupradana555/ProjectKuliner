<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($kuliner['nama']) ?> — Detail Kuliner</title>

    <!-- Leaflet.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f1f5f9; color: #1e293b; }

        .navbar {
            background: #007bff;
            padding: 14px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
        }
        .navbar a { color: white; text-decoration: none; font-weight: 600; font-size: 15px; }
        .navbar .brand { font-size: 18px; font-weight: 700; }

        .container { max-width: 900px; margin: 30px auto; padding: 0 20px; }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .foto-tempat {
            width: 100%;
            height: 280px;
            object-fit: cover;
            display: block;
        }
        .foto-placeholder {
            width: 100%;
            height: 280px;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
        }

        .info-section { padding: 24px; }
        .badge-kategori {
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .nama-tempat { font-size: 26px; font-weight: 700; color: #0f172a; margin-bottom: 8px; }
        .alamat { color: #64748b; font-size: 15px; margin-bottom: 12px; display: flex; align-items: flex-start; gap: 6px; }
        .deskripsi { color: #475569; font-size: 15px; line-height: 1.7; }
        .meta { display: flex; gap: 20px; margin-top: 16px; padding-top: 16px; border-top: 1px solid #f1f5f9; }
        .meta-item { font-size: 13px; color: #94a3b8; }
        .meta-item span { color: #475569; font-weight: 600; }

        .map-section { padding: 0 24px 24px; }
        .map-section h3 { font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 12px; }
        #map { height: 350px; border-radius: 10px; border: 1px solid #e2e8f0; z-index: 1; }

        .koordinat-info {
            display: flex;
            gap: 16px;
            margin-top: 10px;
        }
        .koordinat-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 13px;
            color: #64748b;
        }
        .koordinat-box span { font-weight: 700; color: #007bff; }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: white;
            color: #007bff;
            border: 1.5px solid #007bff;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            margin-bottom: 20px;
            transition: all 0.2s;
        }
        .btn-back:hover { background: #007bff; color: white; }
    </style>
</head>
<body>

<nav class="navbar">
    <span class="brand">🍜 ProjectKuliner</span>
    <a href="/">← Kembali ke Peta</a>
</nav>

<div class="container">

    <a href="/" class="btn-back">← Kembali</a>

    <div class="card">
        <!-- Foto Tempat -->
        <?php if (!empty($kuliner['file_foto'])): ?>
            <img src="<?= base_url('uploads/' . esc($kuliner['file_foto'])) ?>" alt="<?= esc($kuliner['nama']) ?>" class="foto-tempat">
        <?php else: ?>
            <div class="foto-placeholder">🍽️</div>
        <?php endif; ?>

        <!-- Info Utama -->
        <div class="info-section">
            <span class="badge-kategori"><?= esc($kuliner['kategori']) ?></span>
            <div class="nama-tempat"><?= esc($kuliner['nama']) ?></div>
            <div class="alamat">📍 <?= esc($kuliner['alamat']) ?></div>
            <?php if (!empty($kuliner['deskripsi'])): ?>
                <div class="deskripsi"><?= esc($kuliner['deskripsi']) ?></div>
            <?php endif; ?>
            <div class="meta">
                <div class="meta-item">Ditambahkan: <span><?= date('d M Y', strtotime($kuliner['created_at'])) ?></span></div>
                <div class="meta-item">Status: <span style="color:#10b981;">✔ Verified</span></div>
            </div>
        </div>

        <!-- Peta Lokasi (Leaflet.js) -->
        <div class="map-section">
            <h3>📍 Lokasi di Peta</h3>
            <div id="map"></div>
            <div class="koordinat-info">
                <div class="koordinat-box">Lat: <span><?= esc($kuliner['lat']) ?></span></div>
                <div class="koordinat-box">Lon: <span><?= esc($kuliner['lon']) ?></span></div>
            </div>
        </div>
    </div>

</div>

<!-- Leaflet.js Script -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const lat = <?= json_encode((float)$kuliner['lat']) ?>;
    const lon = <?= json_encode((float)$kuliner['lon']) ?>;
    const nama = <?= json_encode(esc($kuliner['nama'])) ?>;
    const alamat = <?= json_encode(esc($kuliner['alamat'])) ?>;

    // Inisialisasi peta Leaflet di koordinat tempat kuliner
    const map = L.map('map').setView([lat, lon], 16);

    // Tile layer OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Marker di lokasi tempat kuliner
    const marker = L.marker([lat, lon]).addTo(map);
    marker.bindPopup(`
        <strong>${nama}</strong><br>
        <small>${alamat}</small>
    `).openPopup();
</script>

</body>
</html>
