<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>JajanMap | Explore & Reviews</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css"/>
  
  <style>
    :root {
      --primary: #4318FF;
      --primary-hover: #3311DB;
      --glass-bg: rgba(255, 255, 255, 0.95);
      --glass-border: rgba(255, 255, 255, 0.5);
      --text-main: #2B3674;
      --text-muted: #A3AED0;
      --shadow-soft: 0 18px 40px rgba(112, 144, 176, 0.15);
      --radius-lg: 24px;
      --radius-md: 16px;
      
      --star-color: #FFB547;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Inter', sans-serif;
      color: var(--text-main);
      overflow: hidden;
      height: 100vh;
      width: 100vw;
      background: #E9EDF7;
    }

    /* BACKGROUND PLACEHOLDER (Menggantikan Peta) */
    #map-placeholder {
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      z-index: 0;
      background-color: #F4F7FE;
      background-image: radial-gradient(rgba(163, 174, 208, 0.4) 1.5px, transparent 1.5px);
      background-size: 24px 24px;
    }
    
    .placeholder-text {
      position: absolute;
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      color: var(--text-muted);
      font-family: 'Outfit', sans-serif;
      font-size: 1.5rem;
      font-weight: 600;
      text-align: center;
      opacity: 0.6;
    }

    .ui-layer {
      position: absolute;
      top: 0; left: 0; width: 100%; height: 100%;
      z-index: 1000;
      pointer-events: none; 
      display: flex;
    }

    .pointer-events-auto { pointer-events: auto; }

    /* --- SIDEBAR PANEL (LEFT) --- */
    .sidebar-panel {
      width: 380px;
      height: calc(100% - 40px);
      margin: 20px;
      background: var(--glass-bg);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid var(--glass-border);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-soft);
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .sidebar-header {
      padding: 24px;
      border-bottom: 1px solid rgba(163, 174, 208, 0.15);
    }

    .brand {
      font-family: 'Outfit', sans-serif;
      font-size: 1.8rem;
      font-weight: 800;
      color: var(--primary);
      letter-spacing: -0.5px;
      margin-bottom: 20px;
      display: flex; align-items: center; gap: 8px;
    }
    .brand span { color: var(--text-main); }

    .search-box { position: relative; }
    .search-box i {
      position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-muted);
    }
    .search-input {
      width: 100%; padding: 14px 16px 14px 42px; border-radius: 12px;
      border: 1px solid rgba(163, 174, 208, 0.3); background: #fff;
      color: var(--text-main); font-family: 'Inter', sans-serif; font-size: 0.95rem; transition: all 0.2s;
    }
    .search-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(67, 24, 255, 0.1); }

    .list-header { padding: 16px 24px 8px; font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; }

    .list-container { flex: 1; overflow-y: auto; padding: 0 12px 24px; }
    .list-container::-webkit-scrollbar { width: 6px; }
    .list-container::-webkit-scrollbar-thumb { background: rgba(163, 174, 208, 0.3); border-radius: 10px; }

    .list-item {
      padding: 16px; margin: 8px; border-radius: var(--radius-md); background: #fff;
      border: 1px solid transparent; cursor: pointer; transition: all 0.2s;
      box-shadow: 0 4px 12px rgba(112, 144, 176, 0.05);
    }
    .list-item:hover, .list-item.active { border-color: var(--primary); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(67, 24, 255, 0.12); }

    .item-title { font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 1.1rem; margin-bottom: 4px; color: var(--text-main); }
    .item-category { font-size: 0.75rem; font-weight: 600; color: var(--primary); background: rgba(67, 24, 255, 0.1); padding: 4px 10px; border-radius: 6px; display: inline-block; margin-bottom: 8px; }
    .item-address { font-size: 0.85rem; color: var(--text-muted); line-height: 1.4; display: flex; gap: 6px; align-items: flex-start; }

    /* --- TOP FLOATING BAR (RIGHT) --- */
    .top-bar {
      position: absolute; top: 20px; right: 20px; display: flex; gap: 12px; align-items: center; z-index: 1050;
    }

    .filter-pills { display: flex; gap: 8px; background: var(--glass-bg); backdrop-filter: blur(20px); padding: 8px; border-radius: 99px; box-shadow: var(--shadow-soft); border: 1px solid var(--glass-border); }
    .filter-btn { padding: 8px 16px; border-radius: 99px; border: none; background: transparent; color: var(--text-muted); font-family: 'Inter', sans-serif; font-size: 0.85rem; font-weight: 500; cursor: pointer; transition: all 0.2s; }
    .filter-btn:hover { color: var(--text-main); background: rgba(163, 174, 208, 0.1); }
    .filter-btn.active { background: var(--primary); color: #fff; box-shadow: 0 4px 12px rgba(67, 24, 255, 0.3); }

    .user-pill { background: var(--glass-bg); backdrop-filter: blur(20px); padding: 8px 12px; border-radius: 99px; box-shadow: var(--shadow-soft); border: 1px solid var(--glass-border); display: flex; align-items: center; gap: 12px; }
    .btn-login { padding: 8px 20px; border-radius: 99px; background: var(--primary); color: #fff; font-family: 'Inter', sans-serif; font-size: 0.9rem; font-weight: 600; text-decoration: none; transition: all 0.2s; }
    .btn-login:hover { background: var(--primary-hover); box-shadow: 0 4px 12px rgba(67, 24, 255, 0.3); }
    .user-greeting { font-size: 0.85rem; color: var(--text-muted); font-weight: 500; }
    .user-greeting b { color: var(--text-main); font-family: 'Outfit', sans-serif; }
    .btn-logout-icon { width: 32px; height: 32px; border-radius: 50%; background: rgba(238, 93, 80, 0.1); color: #EE5D50; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s; }
    .btn-logout-icon:hover { background: #EE5D50; color: #fff; }

    /* --- RIGHT PANEL (DETAIL & REVIEW) --- */
    .right-panel {
      position: absolute;
      top: 80px; right: 20px; bottom: 20px;
      width: 420px;
      background: var(--glass-bg);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid var(--glass-border);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-soft);
      display: flex;
      flex-direction: column;
      transform: translateX(150%);
      transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
      z-index: 1000;
      overflow: hidden;
    }
    .right-panel.show { transform: translateX(0); }
    
    .rp-cover { width: 100%; height: 180px; background-color: #E9EDF7; background-image: url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=600&q=80'); background-size: cover; background-position: center; position: relative; }
    .btn-close-rp { position: absolute; top: 16px; right: 16px; background: rgba(255, 255, 255, 0.9); border: none; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; color: var(--text-main); transition: all 0.2s; z-index: 10; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .btn-close-rp:hover { background: #EE5D50; color: #fff; }

    .rp-header { padding: 20px 24px; position: relative; border-bottom: 1px solid rgba(163, 174, 208, 0.15); }

    .rp-title { font-family: 'Outfit', sans-serif; font-size: 1.5rem; font-weight: 700; color: var(--text-main); padding-right: 40px; margin-bottom: 4px; line-height: 1.2; }
    .rp-cat { font-size: 0.8rem; color: var(--primary); font-weight: 600; margin-bottom: 12px; }
    .rp-address { font-size: 0.9rem; color: var(--text-muted); line-height: 1.5; display: flex; gap: 8px; }
    .rp-address i { color: var(--primary); margin-top: 2px; }

    .rp-content { flex: 1; overflow-y: auto; padding: 24px; }
    .rp-content::-webkit-scrollbar { width: 6px; }
    .rp-content::-webkit-scrollbar-thumb { background: rgba(163, 174, 208, 0.3); border-radius: 10px; }

    /* REVIEWS SECTION */
    .review-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 16px; margin-top: 8px; }
    .review-title { font-family: 'Outfit', sans-serif; font-size: 1.2rem; font-weight: 700; color: var(--text-main); }
    .review-avg { display: flex; align-items: center; gap: 6px; font-weight: 700; font-size: 1rem; }
    .review-avg i { color: var(--star-color); }

    .review-list { display: flex; flex-direction: column; gap: 16px; margin-bottom: 24px; }
    .review-card { background: #fff; padding: 16px; border-radius: var(--radius-md); border: 1px solid rgba(163, 174, 208, 0.2); box-shadow: 0 4px 12px rgba(112, 144, 176, 0.03); }
    .review-card-top { display: flex; justify-content: space-between; margin-bottom: 8px; }
    .reviewer-name { font-weight: 600; font-size: 0.9rem; color: var(--text-main); }
    .reviewer-date { font-size: 0.75rem; color: var(--text-muted); }
    .review-stars { color: var(--star-color); font-size: 0.8rem; margin-bottom: 8px; }
    .review-text { font-size: 0.85rem; color: var(--text-muted); line-height: 1.5; }

    /* FORM REVIEW */
    .form-review { background: rgba(67, 24, 255, 0.03); padding: 20px; border-radius: var(--radius-md); border: 1px solid rgba(67, 24, 255, 0.1); }
    .form-review h4 { font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700; margin-bottom: 12px; }
    .star-rating { display: flex; gap: 4px; font-size: 1.2rem; color: #ddd; margin-bottom: 16px; cursor: pointer; }
    .star-rating i:hover, .star-rating i.active { color: var(--star-color); }
    .review-input { width: 100%; padding: 12px; border: 1px solid rgba(163, 174, 208, 0.3); border-radius: 12px; font-family: 'Inter', sans-serif; font-size: 0.85rem; margin-bottom: 12px; resize: vertical; min-height: 80px; }
    .review-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(67, 24, 255, 0.1); }
    .btn-submit-review { width: 100%; padding: 12px; background: var(--primary); color: #fff; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
    .btn-submit-review:hover { background: var(--primary-hover); }

    .login-prompt { background: rgba(255, 181, 71, 0.1); padding: 16px; border-radius: 12px; text-align: center; border: 1px dashed rgba(255, 181, 71, 0.5); }
    .login-prompt p { font-size: 0.85rem; color: #d9911e; font-weight: 500; margin-bottom: 12px; }

  </style>
</head>
<body>

<!-- KANVAS KOSONG PENGGANTI PETA -->
<div id="map-placeholder">
  <div class="placeholder-text">
  </div>
</div>

<div class="ui-layer">
  
  <!-- KIRI: SIDEBAR -->
  <div class="sidebar-panel pointer-events-auto">
    <div class="sidebar-header">
      <div class="brand"><i class="bi bi-geo-alt-fill"></i> Jajan<span>Map</span></div>
      <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" id="searchInput" class="search-input" placeholder="Cari nama tempat atau alamat..." onkeyup="searchKuliner()">
      </div>
    </div>
    
    <div class="list-header">📍 <span id="count">0</span> Tempat Ditemukan</div>
    <div class="list-container" id="list"></div>
  </div>

  <!-- KANAN: TOP BAR -->
  <div class="top-bar pointer-events-auto">
    <div class="filter-pills">
      <button class="filter-btn active" onclick="filterKat('semua', this)">Semua</button>
      <?php foreach ($kategori as $kat): ?>
      <button class="filter-btn" onclick="filterKat('<?= strtolower($kat['nama_kategori']) ?>', this)">
        <?= $kat['nama_kategori'] ?>
      </button>
      <?php endforeach; ?>
    </div>

    <div class="user-pill">
      <?php if(session()->get('isLoggedIn')): ?>
        <div class="user-greeting">Halo, <b><?= session()->get('nama') ?></b></div>
        <a href="<?= base_url(session()->get('role') === 'admin' ? 'admin' : 'dashboard') ?>" class="btn-login" style="padding: 6px 16px; font-size: 0.8rem;">Dashboard</a>
        <a href="<?= base_url('logout') ?>" class="btn-logout-icon" title="Logout"><i class="bi bi-box-arrow-right"></i></a>
      <?php else: ?>
        <a href="<?= base_url('login') ?>" class="btn-login">Masuk</a>
      <?php endif; ?>
    </div>
  </div>

  <!-- KANAN: PANEL DETAIL & REVIEW -->
  <div class="right-panel pointer-events-auto" id="rightPanel">
    <div class="rp-cover">
      <button class="btn-close-rp" onclick="closeDetail()"><i class="bi bi-x-lg"></i></button>
    </div>
    <div class="rp-header">
      <div class="rp-title" id="rp-title">-</div>
      <div class="rp-cat" id="rp-cat">-</div>
      <div class="rp-address"><i class="bi bi-geo-alt-fill"></i> <span id="rp-address">-</span></div>
    </div>
    
    <div class="rp-content">
      <div class="review-header">
        <div class="review-title">Review & Ulasan</div>
        <div class="review-avg"><i class="bi bi-star-fill"></i> 4.5 <span style="font-size:0.75rem; color:var(--text-muted); font-weight:500;">(2 ulasan)</span></div>
      </div>

      <!-- DUMMY REVIEWS (Siap disambung Database oleh Adit) -->
      <div class="review-list">
        <div class="review-card">
          <div class="review-card-top">
            <div class="reviewer-name">Budi Santoso</div>
            <div class="reviewer-date">2 hari lalu</div>
          </div>
          <div class="review-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
          <div class="review-text">Tempatnya bersih, makanannya enak banget porsinya gede! Recommended buat mahasiswa.</div>
        </div>
        <div class="review-card">
          <div class="review-card-top">
            <div class="reviewer-name">Siti Aisyah</div>
            <div class="reviewer-date">1 minggu lalu</div>
          </div>
          <div class="review-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i></div>
          <div class="review-text">Rasa lumayan, tapi kalau jam makan siang rame banget jadi susah cari tempat duduk.</div>
        </div>
      </div>

      <!-- FORM TAMBAH REVIEW -->
      <?php if(session()->get('isLoggedIn')): ?>
        <div class="form-review">
          <h4>Tulis Ulasan Kamu</h4>
          <form action="#" method="POST">
            <!-- Nanti ditambah id_tempat di hidden input -->
            <input type="hidden" name="tempat_id" id="form-tempat-id" value="">
            
            <div class="star-rating">
              <i class="bi bi-star-fill active"></i>
              <i class="bi bi-star-fill active"></i>
              <i class="bi bi-star-fill active"></i>
              <i class="bi bi-star-fill active"></i>
              <i class="bi bi-star-fill active"></i>
            </div>
            <textarea name="komentar" class="review-input" placeholder="Bagaimana pengalaman kamu makan di sini? Ceritakan selengkapnya..." required></textarea>
            <button type="submit" class="btn-submit-review">Kirim Review</button>
          </form>
        </div>
      <?php else: ?>
        <div class="login-prompt">
          <p>Kamu harus login untuk menulis review dan memberi rating di tempat ini.</p>
          <a href="<?= base_url('login') ?>" class="btn-login" style="display:inline-block;">Login Sekarang</a>
        </div>
      <?php endif; ?>

    </div>
  </div>

</div>

<script>
const kuliner = <?= json_encode(array_map(function($k) {
    return [
        'id'       => $k['id'],
        'nama'     => $k['nama'],
        'kategori' => strtolower($k['kategori']),
        'alamat'   => $k['alamat'],
        'deskripsi'=> $k['deskripsi']
    ];
}, $kuliner)) ?>;

function renderList(data) {
  const list = document.getElementById('list');
  document.getElementById('count').textContent = data.length;
  
  if (data.length === 0) {
    list.innerHTML = '<div class="empty-state" style="text-align:center; padding:40px 20px; color:var(--text-muted);"><i class="bi bi-search" style="font-size:2rem; margin-bottom:12px; display:block; color:#E9EDF7;"></i>Tidak ada kuliner yang sesuai pencarian</div>';
    return;
  }
  
  list.innerHTML = '';
  data.forEach(k => {
    const div = document.createElement('div');
    div.className = 'list-item';
    div.id = `item-${k.id}`;
    div.innerHTML = `<div class="item-title">${k.nama}</div><div class="item-category">${k.kategori.charAt(0).toUpperCase() + k.kategori.slice(1)}</div><div class="item-address"><i class="bi bi-geo-alt"></i> ${k.alamat}</div>`;
    
    div.onclick = () => {
      selectPlace(k);
    };
    
    list.appendChild(div);
  });
}

function selectPlace(k) {
  document.querySelectorAll('.list-item').forEach(el => el.classList.remove('active'));
  
  const item = document.getElementById(`item-${k.id}`);
  if (item) { item.classList.add('active'); item.scrollIntoView({ behavior: 'smooth', block: 'center' }); }

  // Update isi Right Panel
  document.getElementById('rp-title').textContent = k.nama;
  document.getElementById('rp-cat').textContent = k.kategori.charAt(0).toUpperCase() + k.kategori.slice(1);
  document.getElementById('rp-address').textContent = k.alamat;
  
  const formId = document.getElementById('form-tempat-id');
  if(formId) formId.value = k.id;

  document.getElementById('rightPanel').classList.add('show');
}

function closeDetail() {
  document.querySelectorAll('.list-item').forEach(el => el.classList.remove('active'));
  document.getElementById('rightPanel').classList.remove('show');
}

// Interactive Stars Dummy
document.querySelectorAll('.star-rating i').forEach((star, index) => {
  star.addEventListener('click', () => {
    document.querySelectorAll('.star-rating i').forEach((s, i) => {
      if(i <= index) { s.classList.add('active'); s.classList.replace('bi-star', 'bi-star-fill'); }
      else { s.classList.remove('active'); s.classList.replace('bi-star-fill', 'bi-star'); }
    });
  });
});

let activeFilter = 'semua';
let currentSearch = '';

function searchKuliner() { currentSearch = document.getElementById('searchInput').value.toLowerCase(); applyFilters(); }
function filterKat(kat, btn) {
  document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active'); activeFilter = kat; applyFilters();
}
function applyFilters() {
  const filtered = kuliner.filter(k => {
    return (activeFilter === 'semua' || k.kategori === activeFilter) && 
           (k.nama.toLowerCase().includes(currentSearch) || k.alamat.toLowerCase().includes(currentSearch));
  });
  renderList(filtered);
}

renderList(kuliner);
</script>
</body>
</html>
