<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Admin | Panel Profesional</title>
  
  <!-- Font Modern SaaS (Outfit untuk heading, Inter untuk teks) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css"/>
  <style>
    :root {
      --bg-body: #F4F7FE;
      --sidebar-bg: #0B1437;
      --card-bg: #FFFFFF;
      --text-main: #2B3674;
      --text-muted: #A3AED0;
      
      --primary: #4318FF;
      --primary-hover: #3311DB;
      --success: #01B574;
      --warning: #FFB547;
      --danger: #EE5D50;
      
      --sidebar-width: 260px;
      --shadow-card: 0px 18px 40px rgba(112, 144, 176, 0.12);
      --shadow-soft: 0px 4px 12px rgba(112, 144, 176, 0.08);
      --border-radius: 16px;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--bg-body);
      color: var(--text-main);
      display: flex;
      min-height: 100vh;
      -webkit-font-smoothing: antialiased;
    }

    /* --- SIDEBAR --- */
    .sidebar {
      width: var(--sidebar-width);
      background: var(--sidebar-bg);
      background-image: linear-gradient(180deg, #0B1437 0%, #080F2A 100%);
      position: fixed;
      top: 0; left: 0; bottom: 0;
      display: flex;
      flex-direction: column;
      z-index: 100;
      box-shadow: 4px 0 24px rgba(0,0,0,0.05);
    }

    .sidebar-logo {
      padding: 32px 24px 24px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .logo-text {
      font-family: 'Outfit', sans-serif;
      font-size: 1.5rem;
      font-weight: 800;
      color: #fff;
      letter-spacing: -0.5px;
    }
    .logo-text span { color: #fff; opacity: 0.5; font-weight: 500; }

    .sidebar-divider {
      height: 1px;
      background: rgba(255, 255, 255, 0.1);
      margin: 0 24px 16px;
    }

    .sidebar-nav {
      flex: 1;
      padding: 0 16px;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 12px 16px;
      border-radius: 12px;
      color: #A3AED0;
      text-decoration: none;
      font-size: 0.95rem;
      font-weight: 500;
      transition: all 0.2s ease;
    }

    .nav-item:hover {
      color: #fff;
      background: rgba(255, 255, 255, 0.05);
    }

    .nav-item.active {
      color: #fff;
      background: var(--primary);
      box-shadow: 0px 4px 16px rgba(67, 24, 255, 0.3);
      font-weight: 600;
    }

    .nav-item i { font-size: 1.1rem; }

    .sidebar-footer {
      padding: 24px 20px;
      background: rgba(0,0,0,0.15);
    }

    .user-profile {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 16px;
    }

    .avatar {
      width: 40px; height: 40px;
      border-radius: 12px;
      background: linear-gradient(135deg, #4318FF, #868CFF);
      color: #fff;
      display: flex; align-items: center; justify-content: center;
      font-family: 'Outfit', sans-serif;
      font-weight: 700;
      font-size: 1.1rem;
      box-shadow: 0 4px 12px rgba(67, 24, 255, 0.3);
    }

    .user-info .name {
      color: #fff;
      font-family: 'Outfit', sans-serif;
      font-weight: 600;
      font-size: 0.95rem;
    }
    .user-info .role {
      color: #A3AED0;
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      font-weight: 600;
      margin-top: 2px;
    }

    .btn-logout {
      display: flex; align-items: center; justify-content: center; gap: 8px;
      width: 100%; padding: 10px;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.05);
      color: #fff;
      font-weight: 500; font-size: 0.85rem;
      text-decoration: none;
      transition: all 0.2s;
    }
    .btn-logout:hover {
      background: var(--danger);
      box-shadow: 0 4px 12px rgba(238, 93, 80, 0.3);
    }

    /* --- MAIN CONTENT --- */
    .main {
      margin-left: var(--sidebar-width);
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .topbar {
      padding: 24px 32px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: rgba(244, 247, 254, 0.8);
      backdrop-filter: blur(12px);
      position: sticky; top: 0; z-index: 50;
    }

    .breadcrumb {
      font-size: 0.85rem;
      color: var(--text-muted);
      font-weight: 500;
      margin-bottom: 4px;
    }
    .page-title {
      font-family: 'Outfit', sans-serif;
      font-size: 1.75rem;
      font-weight: 700;
      color: var(--text-main);
      letter-spacing: -0.5px;
    }

    .content { padding: 8px 32px 40px; }

    /* --- STATS GRID --- */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      margin-bottom: 32px;
    }

    .stat-card {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      padding: 24px;
      display: flex;
      align-items: center;
      gap: 16px;
      box-shadow: var(--shadow-card);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 24px 50px rgba(112, 144, 176, 0.18);
    }

    .stat-icon {
      width: 56px; height: 56px;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.5rem;
    }
    .icon-blue { background: rgba(67, 24, 255, 0.08); color: var(--primary); }
    .icon-orange { background: rgba(255, 181, 71, 0.1); color: var(--warning); }
    .icon-green { background: rgba(1, 181, 116, 0.1); color: var(--success); }
    .icon-red { background: rgba(238, 93, 80, 0.1); color: var(--danger); }

    .stat-details .label {
      font-size: 0.85rem;
      color: var(--text-muted);
      font-weight: 500;
      margin-bottom: 4px;
    }
    .stat-details .value {
      font-family: 'Outfit', sans-serif;
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--text-main);
      line-height: 1.1;
    }

    /* --- SECTION HEADERS --- */
    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-bottom: 20px;
    }
    .section-title {
      font-family: 'Outfit', sans-serif;
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--text-main);
    }

    .btn-primary {
      background: var(--primary);
      color: #fff;
      padding: 10px 20px;
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.85rem;
      text-decoration: none;
      display: inline-flex; align-items: center; gap: 8px;
      transition: all 0.2s;
      box-shadow: 0 4px 12px rgba(67, 24, 255, 0.2);
    }
    .btn-primary:hover { background: var(--primary-hover); transform: translateY(-1px); }

    /* --- TABLES --- */
    .table-wrapper {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-card);
      padding: 24px;
      margin-bottom: 32px;
      overflow-x: auto;
    }

    .table-wrapper .card-title {
      font-family: 'Outfit', sans-serif;
      font-size: 1.15rem;
      font-weight: 700;
      margin-bottom: 4px;
    }
    .table-wrapper .card-subtitle {
      font-size: 0.85rem;
      color: var(--text-muted);
      margin-bottom: 24px;
    }

    table { width: 100%; border-collapse: collapse; }
    
    th {
      text-align: left;
      padding: 0 16px 12px;
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 1px;
      border-bottom: 1px solid #E9EDF7;
    }

    td {
      padding: 16px;
      font-size: 0.9rem;
      font-weight: 500;
      color: var(--text-main);
      border-bottom: 1px solid #F4F7FE;
      vertical-align: middle;
    }
    
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: rgba(244, 247, 254, 0.5); }

    .td-name { font-weight: 600; }

    /* --- BADGES & BUTTONS --- */
    .badge {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 6px 12px; border-radius: 8px;
      font-size: 0.75rem; font-weight: 700;
    }
    .badge-pending { background: rgba(255, 181, 71, 0.1); color: #E89B1F; }
    .badge-approved { background: rgba(1, 181, 116, 0.1); color: var(--success); }
    .badge-rejected { background: rgba(238, 93, 80, 0.1); color: var(--danger); }

    .action-btns {
      display: flex; gap: 8px;
    }
    .btn-action {
      width: 32px; height: 32px;
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      text-decoration: none; transition: all 0.2s;
      font-size: 0.9rem;
    }
    .btn-approve { background: rgba(1, 181, 116, 0.1); color: var(--success); }
    .btn-approve:hover { background: var(--success); color: #fff; }
    
    .btn-reject { background: rgba(238, 93, 80, 0.1); color: var(--danger); }
    .btn-reject:hover { background: var(--danger); color: #fff; }
    
    .btn-edit { background: rgba(67, 24, 255, 0.1); color: var(--primary); }
    .btn-edit:hover { background: var(--primary); color: #fff; }
    
    .btn-delete { background: rgba(238, 93, 80, 0.1); color: var(--danger); }
    .btn-delete:hover { background: var(--danger); color: #fff; }

    .empty-state {
      text-align: center;
      padding: 40px 0;
      color: var(--text-muted);
      font-weight: 500;
    }

  </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-text">Jajan<span>Map</span></div>
  </div>
  
  <div class="sidebar-divider"></div>

  <nav class="sidebar-nav">
    <a href="<?= base_url('admin') ?>" class="nav-item active">
      <i class="bi bi-grid-1x2-fill"></i> Dashboard
    </a>
    <a href="<?= base_url('/') ?>" class="nav-item">
      <i class="bi bi-compass"></i> Lihat Peta
    </a>
    <a href="<?= base_url('tambah-kuliner') ?>" class="nav-item">
      <i class="bi bi-shop"></i> Tambah Kuliner
    </a>
    <a href="#" class="nav-item">
      <i class="bi bi-tags"></i> Kategori & Tag
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="user-profile">
      <div class="avatar"><?= strtoupper(substr(session()->get('nama'), 0, 1)) ?></div>
      <div class="user-info">
        <div class="name"><?= session()->get('nama') ?></div>
        <div class="role">Administrator</div>
      </div>
    </div>
    <a href="<?= base_url('logout') ?>" class="btn-logout">
      <i class="bi bi-box-arrow-right"></i> Keluar
    </a>
  </div>
</aside>

<!-- MAIN CONTENT -->
<div class="main">

  <div class="topbar">
    <div>
      <div class="breadcrumb">Admin / Dashboard</div>
      <div class="page-title">Overview</div>
    </div>
  </div>

  <div class="content">

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')) : ?>
      <div style="background: rgba(1, 181, 116, 0.1); color: var(--success); padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; font-weight: 600; display: flex; align-items: center; gap: 12px; border: 1px solid rgba(1, 181, 116, 0.2);">
        <i class="bi bi-check-circle-fill" style="font-size: 1.2rem;"></i>
        <?= session()->getFlashdata('success') ?>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
      <div style="background: rgba(238, 93, 80, 0.1); color: var(--danger); padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; font-weight: 600; display: flex; align-items: center; gap: 12px; border: 1px solid rgba(238, 93, 80, 0.2);">
        <i class="bi bi-exclamation-triangle-fill" style="font-size: 1.2rem;"></i>
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <!-- Stats -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon icon-blue"><i class="bi bi-shop-window"></i></div>
        <div class="stat-details">
          <div class="label">Total Kuliner</div>
          <div class="value"><?= $total_approved ?></div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon icon-orange"><i class="bi bi-hourglass-split"></i></div>
        <div class="stat-details">
          <div class="label">Menunggu Review</div>
          <div class="value"><?= $total_pending ?></div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon icon-green"><i class="bi bi-bookmark-star"></i></div>
        <div class="stat-details">
          <div class="label">Total Kategori</div>
          <div class="value"><?= $total_kategori ?></div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon icon-red"><i class="bi bi-tags-fill"></i></div>
        <div class="stat-details">
          <div class="label">Total Tag</div>
          <div class="value"><?= $total_tag ?></div>
        </div>
      </div>
    </div>

    <!-- Menunggu Moderasi -->
    <div class="table-wrapper">
      <div class="card-title">Menunggu Moderasi</div>
      <div class="card-subtitle">Tempat kuliner yang butuh persetujuan admin</div>
      
      <table>
        <thead>
          <tr>
            <th>Nama Tempat</th>
            <th>Kategori</th>
            <th>Disubmit Oleh</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($pending_kuliner)): ?>
            <?php foreach ($pending_kuliner as $k): ?>
            <tr>
              <td class="td-name"><?= esc($k['nama']) ?></td>
              <td><?= esc($k['nama_kategori'] ?? '-') ?></td>
              <td><?= esc($k['user_nama'] ?? '-') ?></td>
              <td><span class="badge badge-pending"><i class="bi bi-circle-fill" style="font-size:0.5rem"></i> Pending</span></td>
              <td>
                <div class="action-btns">
                  <a href="<?= base_url('approve-kuliner/' . $k['id']) ?>" class="btn-action btn-approve" title="Approve" onclick="return confirm('Approve tempat ini?')"><i class="bi bi-check-lg"></i></a>
                  <a href="<?= base_url('hapus-kuliner/' . $k['id']) ?>" class="btn-action btn-reject" title="Reject" onclick="return confirm('Tolak dan hapus tempat ini?')"><i class="bi bi-x-lg"></i></a>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5">
                <div class="empty-state">
                  <i class="bi bi-check2-circle" style="font-size: 2rem; color: var(--success); margin-bottom: 8px; display: block"></i>
                  Tidak ada kuliner yang menunggu moderasi
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Semua Kuliner -->
    <div class="section-header">
      <div class="section-title">Semua Kuliner</div>
      <a href="<?= base_url('tambah-kuliner') ?>" class="btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Baru
      </a>
    </div>

    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Nama Tempat</th>
            <th>Kategori</th>
            <th>Disubmit Oleh</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($semua_kuliner)): ?>
            <?php foreach ($semua_kuliner as $k): ?>
            <tr>
              <td class="td-name"><?= esc($k['nama']) ?></td>
              <td><?= esc($k['nama_kategori'] ?? '-') ?></td>
              <td><?= esc($k['user_nama'] ?? '-') ?></td>
              <td>
                <?php if ($k['status'] === 'approved'): ?>
                  <span class="badge badge-approved"><i class="bi bi-check2"></i> Approved</span>
                <?php elseif ($k['status'] === 'pending'): ?>
                  <span class="badge badge-pending"><i class="bi bi-hourglass"></i> Pending</span>
                <?php else: ?>
                  <span class="badge badge-rejected"><i class="bi bi-x-lg"></i> Rejected</span>
                <?php endif; ?>
              </td>
              <td>
                <div class="action-btns">
                  <a href="<?= base_url('edit-kuliner/' . $k['id']) ?>" class="btn-action btn-edit" title="Edit"><i class="bi bi-pencil-square"></i></a>
                  <a href="<?= base_url('hapus-kuliner/' . $k['id']) ?>" class="btn-action btn-delete" onclick="return confirm('Yakin menghapus <?= esc($k['nama']) ?>?')" title="Hapus"><i class="bi bi-trash"></i></a>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5">
                <div class="empty-state">Belum ada data kuliner</div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Moderasi Review -->
    <div class="section-header" style="margin-top: 40px;">
      <div class="section-title">Moderasi Review User</div>
    </div>

    <div class="table-wrapper">
      <div class="card-subtitle" style="margin-bottom: 24px;">Hapus review yang mengandung unsur SARA, spam, atau tidak relevan.</div>
      <table>
        <thead>
          <tr>
            <th>Pemberi Review</th>
            <th>Tempat Kuliner</th>
            <th>Rating & Komentar</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <!-- DUMMY DATA REVIEW UNTUK ADIT -->
          <tr>
            <td class="td-name">Budi Santoso</td>
            <td>Nasi Goreng Babat Pak Karmin</td>
            <td>
              <div style="color: #FFB547; font-size: 0.8rem; margin-bottom: 4px;">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <div style="font-size: 0.85rem; color: var(--text-muted);">Tempatnya bersih, makanannya enak banget porsinya gede! Recommended buat mahasiswa.</div>
            </td>
            <td>
              <div class="action-btns">
                <a href="#" class="btn-action btn-delete" onclick="return confirm('Hapus review ini?')" title="Hapus Review"><i class="bi bi-trash"></i></a>
              </div>
            </td>
          </tr>
          <tr>
            <td class="td-name">Anonim Spam</td>
            <td>Mie Ayam Tumini</td>
            <td>
              <div style="color: #FFB547; font-size: 0.8rem; margin-bottom: 4px;">
                <i class="bi bi-star-fill"></i><i class="bi bi-star"></i><i class="bi bi-star"></i><i class="bi bi-star"></i><i class="bi bi-star"></i>
              </div>
              <div style="font-size: 0.85rem; color: var(--text-muted);">Jelek banget pelayanannya kasirnya judes wooo</div>
            </td>
            <td>
              <div class="action-btns">
                <a href="#" class="btn-action btn-delete" onclick="return confirm('Hapus review ini?')" title="Hapus Review"><i class="bi bi-trash"></i></a>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</div>

</body>
</html>
