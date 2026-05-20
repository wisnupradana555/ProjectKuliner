<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Kontributor | Panel Profesional</title>
  
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

    .nav-label {
      font-size: 0.7rem;
      color: rgba(255,255,255,0.3);
      text-transform: uppercase;
      letter-spacing: 1.5px;
      padding: 12px 16px 6px;
      font-weight: 600;
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

    .greeting {
      font-size: 0.9rem;
      color: var(--text-muted);
      font-weight: 500;
    }
    .greeting b { color: var(--text-main); font-family: 'Outfit', sans-serif; }

    .content { padding: 8px 32px 40px; }

    /* --- STATS GRID --- */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-bottom: 32px;
    }

    .stat-card {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      padding: 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: var(--shadow-card);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 24px 50px rgba(112, 144, 176, 0.18);
    }

    .stat-info .label {
      font-size: 0.85rem;
      color: var(--text-muted);
      font-weight: 600;
      margin-bottom: 4px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .stat-info .value {
      font-family: 'Outfit', sans-serif;
      font-size: 2.2rem;
      font-weight: 700;
      color: var(--text-main);
      line-height: 1.1;
      margin-bottom: 4px;
    }
    .stat-info .sub {
      font-size: 0.75rem;
      color: var(--text-muted);
      font-weight: 500;
    }

    .stat-icon {
      width: 64px; height: 64px;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.8rem;
    }
    .icon-blue { background: rgba(67, 24, 255, 0.08); color: var(--primary); }
    .icon-green { background: rgba(1, 181, 116, 0.1); color: var(--success); }
    .icon-orange { background: rgba(255, 181, 71, 0.1); color: var(--warning); }

    /* --- BUTTONS --- */
    .btn-primary {
      background: var(--primary);
      color: #fff;
      padding: 14px 28px;
      border-radius: 12px;
      font-family: 'Outfit', sans-serif;
      font-weight: 600;
      font-size: 1rem;
      text-decoration: none;
      display: inline-flex; align-items: center; gap: 10px;
      transition: all 0.2s;
      box-shadow: 0 8px 24px rgba(67, 24, 255, 0.25);
      margin-bottom: 32px;
    }
    .btn-primary:hover { 
      background: var(--primary-hover); 
      transform: translateY(-2px); 
      box-shadow: 0 12px 28px rgba(67, 24, 255, 0.35);
    }
    .btn-primary i { font-size: 1.2rem; }

    /* --- TABLES --- */
    .section-title {
      font-family: 'Outfit', sans-serif;
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--text-main);
      margin-bottom: 20px;
    }

    .table-wrapper {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-card);
      padding: 24px;
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
    .td-address { color: var(--text-muted); font-size: 0.85rem; }

    /* --- BADGES --- */
    .badge {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 6px 12px; border-radius: 8px;
      font-size: 0.75rem; font-weight: 700;
    }
    .badge-pending { background: rgba(255, 181, 71, 0.1); color: #E89B1F; }
    .badge-approved { background: rgba(1, 181, 116, 0.1); color: var(--success); }
    .badge-rejected { background: rgba(238, 93, 80, 0.1); color: var(--danger); }

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
    <div class="nav-label">Menu Kontributor</div>
    <a href="<?= base_url('dashboard') ?>" class="nav-item active">
      <i class="bi bi-grid-1x2-fill"></i> Dashboard
    </a>
    <a href="<?= base_url('tambah-kuliner') ?>" class="nav-item">
      <i class="bi bi-plus-square"></i> Tambah Tempat
    </a>
    <a href="<?= base_url('/') ?>" class="nav-item">
      <i class="bi bi-compass"></i> Lihat Peta
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="user-profile">
      <div class="avatar"><?= strtoupper(substr(session()->get('nama'), 0, 1)) ?></div>
      <div class="user-info">
        <div class="name"><?= session()->get('nama') ?></div>
        <div class="role">Kontributor</div>
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
      <div class="breadcrumb">Kontributor / Dashboard</div>
      <div class="page-title">Panel Kontributor</div>
    </div>
    <div class="greeting">Halo, <b><?= session()->get('nama') ?></b> 👋</div>
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
        <div class="stat-info">
          <div class="label">Total Submisi</div>
          <div class="value"><?= $total_submisi ?></div>
          <div class="sub">Semua tempat yang kamu tambahkan</div>
        </div>
        <div class="stat-icon icon-blue"><i class="bi bi-shop-window"></i></div>
      </div>
      <div class="stat-card">
        <div class="stat-info">
          <div class="label">Disetujui</div>
          <div class="value"><?= $total_approved ?></div>
          <div class="sub">Tampil di peta publik</div>
        </div>
        <div class="stat-icon icon-green"><i class="bi bi-check-circle-fill"></i></div>
      </div>
      <div class="stat-card">
        <div class="stat-info">
          <div class="label">Menunggu Review</div>
          <div class="value"><?= $total_pending ?></div>
          <div class="sub">Belum dimoderasi oleh admin</div>
        </div>
        <div class="stat-icon icon-orange"><i class="bi bi-hourglass-split"></i></div>
      </div>
    </div>

    <!-- Tombol Tambah Utama -->
    <a href="<?= base_url('tambah-kuliner') ?>" class="btn-primary">
      <i class="bi bi-plus-lg"></i> Kontribusi Tempat Kuliner Baru
    </a>

    <!-- Tabel Submisi -->
    <div class="section-title">Riwayat Kontribusi Kamu</div>
    <div class="table-wrapper">
      <div class="card-title">Daftar Tempat</div>
      <div class="card-subtitle">Pantau status persetujuan dari tempat-tempat yang sudah kamu masukkan.</div>
      
      <table>
        <thead>
          <tr>
            <th>Nama Tempat</th>
            <th>Kategori</th>
            <th>Alamat</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($kuliner_saya)): ?>
            <?php foreach ($kuliner_saya as $k): ?>
            <tr>
              <td class="td-name"><?= esc($k['nama']) ?></td>
              <td><?= esc($k['nama_kategori'] ?? '-') ?></td>
              <td class="td-address"><?= esc($k['alamat']) ?></td>
              <td>
                <?php if ($k['status'] === 'approved'): ?>
                  <span class="badge badge-approved"><i class="bi bi-check2"></i> Approved</span>
                <?php elseif ($k['status'] === 'pending'): ?>
                  <span class="badge badge-pending"><i class="bi bi-circle-fill" style="font-size:0.5rem"></i> Pending</span>
                <?php else: ?>
                  <span class="badge badge-rejected"><i class="bi bi-x-lg"></i> Rejected</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4">
                <div class="empty-state">
                  <i class="bi bi-journal-x" style="font-size: 2rem; color: #A3AED0; margin-bottom: 8px; display: block"></i>
                  Kamu belum menambahkan tempat kuliner apapun.
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

</body>
</html>
