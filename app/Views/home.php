<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kuliner Sekitar Kampus</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --bg: #0f0e0d;
      --card: #1a1917;
      --border: #2e2c29;
      --accent: #f5a623;
      --accent2: #e8523a;
      --text: #f0ede8;
      --muted: #7a7672;
      --green: #4caf7d;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      color: var(--text);
      height: 100vh;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    header {
      padding: 14px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid var(--border);
      background: var(--card);
      z-index: 1000;
      flex-shrink: 0;
    }

    .logo {
      font-family: 'Syne', sans-serif;
      font-size: 1.2rem;
      font-weight: 800;
      letter-spacing: -0.5px;
    }

    .logo span { color: var(--accent); }

    .header-right {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .filter-bar {
      display: flex;
      gap: 8px;
      align-items: center;
      flex-shrink: 0;
    }

    .filter-btn {
      padding: 6px 14px;
      border-radius: 999px;
      border: 1px solid var(--border);
      background: transparent;
      color: var(--muted);
      font-family: 'DM Sans', sans-serif;
      font-size: 0.78rem;
      cursor: pointer;
      transition: all 0.2s;
    }

    .filter-btn:hover, .filter-btn.active {
      background: var(--accent);
      color: #000;
      border-color: var(--accent);
      font-weight: 600;
    }

    .btn-login {
      padding: 6px 16px;
      border-radius: 999px;
      border: 1px solid var(--accent);
      background: transparent;
      color: var(--accent);
      font-family: 'DM Sans', sans-serif;
      font-size: 0.78rem;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.2s;
    }

    .btn-login:hover {
      background: var(--accent);
      color: #000;
    }

    .main {
      display: flex;
      flex: 1;
      overflow: hidden;
    }

    .sidebar {
      width: 300px;
      flex-shrink: 0;
      background: var(--card);
      border-right: 1px solid var(--border);
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .sidebar-header {
      padding: 14px 16px;
      border-bottom: 1px solid var(--border);
      font-size: 0.75rem;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: 1px;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .search-input {
      width: 100%;
      padding: 8px 12px;
      border-radius: 6px;
      border: 1px solid var(--border);
      background: var(--bg);
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      font-size: 0.8rem;
    }
    .search-input:focus {
      outline: none;
      border-color: var(--accent);
    }

    .list {
      overflow-y: auto;
      flex: 1;
    }

    .list::-webkit-scrollbar { width: 4px; }
    .list::-webkit-scrollbar-track { background: transparent; }
    .list::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

    .item {
      padding: 14px 16px;
      border-bottom: 1px solid var(--border);
      cursor: pointer;
      transition: background 0.15s;
    }

    .item:hover, .item.active {
      background: rgba(245,166,35,0.08);
    }

    .item-top {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 8px;
      margin-bottom: 6px;
    }

    .item-name {
      font-weight: 600;
      font-size: 0.9rem;
      line-height: 1.3;
    }

    .item-cat {
      font-size: 0.72rem;
      color: var(--muted);
      margin-bottom: 4px;
    }

    .item-tags {
      display: flex;
      gap: 4px;
      flex-wrap: wrap;
      margin-top: 4px;
    }

    .tag {
      font-size: 0.65rem;
      padding: 2px 8px;
      border-radius: 999px;
      border: 1px solid var(--border);
      color: var(--muted);
    }

    #map {
      flex: 1;
      z-index: 1;
    }

    .detail-panel {
      position: absolute;
      bottom: 24px;
      right: 24px;
      width: 280px;
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 18px;
      z-index: 1000;
      transform: translateY(120%);
      transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      box-shadow: 0 20px 60px rgba(0,0,0,0.6);
    }

    .detail-panel.show {
      transform: translateY(0);
    }

    .detail-panel h3 {
      font-family: 'Syne', sans-serif;
      font-size: 1rem;
      margin-bottom: 4px;
    }

    .detail-cat {
      font-size: 0.75rem;
      color: var(--accent);
      margin-bottom: 10px;
    }

    .detail-addr {
      font-size: 0.78rem;
      color: var(--muted);
      margin-bottom: 14px;
      line-height: 1.5;
    }

    .detail-tags { display: flex; gap: 5px; flex-wrap: wrap; margin-bottom: 14px; }

    .btn-tutup {
      width: 100%;
      padding: 9px;
      background: var(--border);
      border: none;
      border-radius: 8px;
      color: var(--muted);
      font-family: 'DM Sans', sans-serif;
      font-size: 0.8rem;
      cursor: pointer;
      transition: background 0.2s;
    }

    .btn-tutup:hover { background: #3a3835; }

    .leaflet-tile-pane { filter: brightness(0.7) saturate(0.5); }

    .leaflet-popup-content-wrapper {
      background: var(--card);
      color: var(--text);
      border: 1px solid var(--border);
      border-radius: 10px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.5);
    }
    .leaflet-popup-tip { background: var(--card); }
    .leaflet-popup-content { margin: 10px 14px; font-family: 'DM Sans', sans-serif; }
    .popup-name { font-weight: 700; font-size: 0.9rem; margin-bottom: 2px; }
    .popup-cat { font-size: 0.72rem; color: var(--accent); }

    .empty-state {
      padding: 40px 16px;
      text-align: center;
      color: var(--muted);
      font-size: 0.85rem;
    }
  </style>
</head>
<body>

<header>
  <div class="logo"></div>
  <div class="header-right">
    <div class="filter-bar">
      <button class="filter-btn active" onclick="filterKat('semua', this)">Semua</button>
      <?php foreach ($kategori as $kat): ?>
      <button class="filter-btn" onclick="filterKat('<?= strtolower($kat['nama_kategori']) ?>', this)">
        <?= $kat['nama_kategori'] ?>
      </button>
      <?php endforeach; ?>
    </div>
    <a href="<?= base_url('login') ?>" class="btn-login">Masuk</a>
  </div>
</header>

<div class="main">
  <div class="sidebar">
    <div class="sidebar-header">
      <div>📍 <span id="count">0</span> tempat ditemukan</div>
      <input type="text" id="searchInput" class="search-input" placeholder="Cari nama atau alamat..." onkeyup="searchKuliner()">
    </div>
    <div class="list" id="list"></div>
  </div>
  <div style="position:relative; flex:1;">
    <div id="map"></div>
    <div class="detail-panel" id="detail">
      <h3 id="d-name"></h3>
      <div class="detail-cat" id="d-cat"></div>
      <div class="detail-addr" id="d-addr"></div>
      <div class="detail-tags" id="d-tags"></div>
      <button class="btn-tutup" onclick="closeDetail()">Tutup ✕</button>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
<script>
// Data dari PHP/database
const kuliner = <?= json_encode(array_map(function($k) {
    return [
        'id'       => $k['id'],
        'nama'     => $k['nama'],
        'kategori' => strtolower($k['kategori']),
        'alamat'   => $k['alamat'],
        'deskripsi'=> $k['deskripsi'],
        'lat'      => (float)$k['lat'],
        'lng'      => (float)$k['lon'],
    ];
}, $kuliner)) ?>;

// Init map
const map = L.map('map', { zoomControl: false }).setView([-6.9822, 110.4091], 15);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '© OpenStreetMap'
}).addTo(map);

L.control.zoom({ position: 'topright' }).addTo(map);

let markers = {};
let selectedId = null;

function makeIcon(selected = false) {
  return L.divIcon({
    className: '',
    html: `<div style="
      background: ${selected ? '#e8523a' : '#f5a623'};
      border: 2.5px solid white;
      border-radius: 50%;
      width: ${selected ? 18 : 12}px;
      height: ${selected ? 18 : 12}px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.5);
      transition: all 0.2s;
    "></div>`,
    iconSize: [selected ? 18 : 12, selected ? 18 : 12],
    iconAnchor: [selected ? 9 : 6, selected ? 9 : 6],
  });
}

kuliner.forEach(k => {
  if (!k.lat || !k.lng) return;
  const marker = L.marker([k.lat, k.lng], { icon: makeIcon() })
    .addTo(map)
    .bindPopup(`
      <div class="popup-name">${k.nama}</div>
      <div class="popup-cat">${k.kategori}</div>
    `)
    .on('click', () => showDetail(k));
  markers[k.id] = marker;
});

function renderList(data) {
  const list = document.getElementById('list');
  document.getElementById('count').textContent = data.length;
  if (data.length === 0) {
    list.innerHTML = '<div class="empty-state">Tidak ada tempat di kategori ini 😔</div>';
    return;
  }
  list.innerHTML = '';
  data.forEach(k => {
    const div = document.createElement('div');
    div.className = 'item';
    div.id = `item-${k.id}`;
    div.innerHTML = `
      <div class="item-top">
        <div class="item-name">${k.nama}</div>
      </div>
      <div class="item-cat">${k.kategori}</div>
      <div class="item-tags"></div>
    `;
    div.onclick = () => {
      if (k.lat && k.lng) map.flyTo([k.lat, k.lng], 17, { duration: 0.8 });
      showDetail(k);
    };
    list.appendChild(div);
  });
}

let activeFilter = 'semua';
let currentSearch = '';

function searchKuliner() {
  currentSearch = document.getElementById('searchInput').value.toLowerCase();
  applyFilters();
}

function filterKat(kat, btn) {
  document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  activeFilter = kat;
  applyFilters();
}

function applyFilters() {
  const filtered = kuliner.filter(k => {
    const matchKat = activeFilter === 'semua' || k.kategori === activeFilter;
    const matchSearch = k.nama.toLowerCase().includes(currentSearch) || k.alamat.toLowerCase().includes(currentSearch);
    return matchKat && matchSearch;
  });

  kuliner.forEach(k => {
    const show = filtered.find(f => f.id === k.id);
    if (markers[k.id]) {
      if (show) markers[k.id].addTo(map);
      else map.removeLayer(markers[k.id]);
    }
  });

  renderList(filtered);
  closeDetail();
}

function showDetail(k) {
  if (selectedId && markers[selectedId]) markers[selectedId].setIcon(makeIcon(false));
  selectedId = k.id;
  if (markers[k.id]) markers[k.id].setIcon(makeIcon(true));

  document.querySelectorAll('.item').forEach(el => el.classList.remove('active'));
  const item = document.getElementById(`item-${k.id}`);
  if (item) { item.classList.add('active'); item.scrollIntoView({ behavior: 'smooth', block: 'nearest' }); }

  document.getElementById('d-name').textContent = k.nama;
  document.getElementById('d-cat').textContent = k.kategori;
  document.getElementById('d-addr').textContent = '📍 ' + k.alamat;
  document.getElementById('d-tags').innerHTML = k.deskripsi
    ? `<span style="font-size:0.8rem;color:var(--muted);line-height:1.5">${k.deskripsi}</span>`
    : '';

  document.getElementById('detail').classList.add('show');
}

function closeDetail() {
  if (selectedId && markers[selectedId]) markers[selectedId].setIcon(makeIcon(false));
  selectedId = null;
  document.getElementById('detail').classList.remove('show');
  document.querySelectorAll('.item').forEach(el => el.classList.remove('active'));
}

renderList(kuliner);
</script>
</body>
</html>
