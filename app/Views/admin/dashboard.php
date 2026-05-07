<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css"/>
  <style>
    :root {
      --bg: #f7f5f2;
      --sidebar: #0f0e0d;
      --sidebar-w: 240px;
      --accent: #f5a623;
      --accent2: #e8523a;
      --text: #1a1917;
      --muted: #7a7672;
      --card: #ffffff;
      --border: #e8e4df;
      --green: #2d9e6b;
      --blue: #2e6be8;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      color: var(--text);
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      width: var(--sidebar-w);
      background: var(--sidebar);
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      z-index: 100;
    }

    .sidebar-logo {
      padding: 24px 20px 20px;
      border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .logo-text {
      font-family: 'Syne', sans-serif;
      font-size: 1.3rem;
      font-weight: 800;
      color: #fff;
    }

    .logo-text span { color: var(--accent); }

    .logo-sub {
      font-size: 0.68rem;
      color: rgba(255,255,255,0.35);
      margin-top: 2px;
      letter-spacing: 0.5px;
    }

    .sidebar-nav {
      flex: 1;
      padding: 16px 12px;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .nav-label {
      font-size: 0.63rem;
      color: rgba(255,255,255,0.25);
      text-transform: uppercase;
      letter-spacing: 1.5px;
      padding: 12px 8px 6px;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 12px;
      border-radius: 8px;
      color: rgba(255,255,255,0.55);
      text-decoration: none;
      font-size: 0.875rem;
      font-weight: 500;
      transition: all 0.15s;
    }

    .nav-item:hover { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.9); }
    .nav-item.active { background: var(--accent); color: #000; font-weight: 600; }
    .nav-item i { font-size: 1rem; width: 18px; text-align: center; }

    .sidebar-footer {
      padding: 16px 12px;
      border-top: 1px solid rgba(255,255,255,0.08);
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 12px;
      border-radius: 8px;
      margin-bottom: 8px;
    }

    .avatar {
      width: 34px; height: 34px;
      border-radius: 50%;
      background: var(--accent);
      display: flex; align-items: center; justify-content: center;
      font-family: 'Syne', sans-serif;
      font-weight: 800; font-size: 0.8rem; color: #000;
      flex-shrink: 0;
    }

    .user-name { font-size: 0.82rem; font-weight: 600; color: #fff; line-height: 1.2; }
    .user-role { font-size: 0.68rem; color: var(--accent); font-weight: 500; }

    .btn-logout {
      display: flex; align-items: center; gap: 8px;
      width: 100%; padding: 9px 12px; border-radius: 8px;
      background: rgba(232,82,58,0.12); border: 1px solid rgba(232,82,58,0.2);
      color: #e8523a; font-family: 'DM Sans', sans-serif;
      font-size: 0.82rem; font-weight: 500; cursor: pointer;
      text-decoration: none; transition: all 0.15s;
    }

    .btn-logout:hover { background: rgba(232,82,58,0.2); color: #e8523a; }

    .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; }

    .topbar {
      background: var(--card); border-bottom: 1px solid var(--border);
      padding: 16px 28px; display: flex; align-items: center;
      justify-content: space-between; position: sticky; top: 0; z-index: 50;
    }

    .page-title { font-family: 'Syne', sans-serif; font-size: 1.1rem; font-weight: 700; }
    .breadcrumb { font-size: 0.75rem; color: var(--muted); margin-top: 2px; }
    .topbar-right { display: flex; align-items: center; gap: 10px; }
    .greeting { font-size: 0.82rem; color: var(--muted); }
    .greeting strong { color: var(--text); }

    .content { padding: 28px; flex: 1; }

    .stats-grid {
      display: grid; grid-template-columns: repeat(4, 1fr);
      gap: 16px; margin-bottom: 28px;
    }

    .stat-card {
      background: var(--card); border: 1px solid var(--border);
      border-radius: 12px; padding: 20px;
      display: flex; align-items: flex-start; justify-content: space-between;
      transition: transform 0.15s, box-shadow 0.15s;
    }

    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.06); }
    .stat-label { font-size: 0.75rem; color: var(--muted); margin-bottom: 6px; }
    .stat-value { font-family: 'Syne', sans-serif; font-size: 2rem; font-weight: 800; line-height: 1; }
    .stat-sub { font-size: 0.72rem; color: var(--muted); margin-top: 4px; }

    .stat-icon {
      width: 40px; height: 40px; border-radius: 10px;
      display: flex; align-items: center; justify-content: center; font-size: 1.1rem;
    }

    .icon-orange { background: rgba(245,166,35,0.12); color: var(--accent); }
    .icon-red    { background: rgba(232,82,58,0.12);  color: var(--accent2); }
    .icon-green  { background: rgba(45,158,107,0.12); color: var(--green); }
    .icon-blue   { background: rgba(46,107,232,0.12); color: var(--blue); }

    .section-title { font-family: 'Syne', sans-serif; font-size: 0.95rem; font-weight: 700; margin-bottom: 14px; }

    .actions-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 28px; }

    .action-card {
      background: var(--card); border: 1px solid var(--border); border-radius: 12px;
      padding: 18px; display: flex; align-items: center; gap: 14px;
      text-decoration: none; color: var(--text); transition: all 0.15s;
    }

    .action-card:hover {
      border-color: var(--accent); box-shadow: 0 4px 16px rgba(245,166,35,0.12);
      transform: translateY(-1px); color: var(--text);
    }

    .action-icon {
      width: 44px; height: 44px; border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.2rem; flex-shrink: 0;
    }

    .action-name { font-weight: 600; font-size: 0.875rem; }
    .action-desc { font-size: 0.72rem; color: var(--muted); margin-top: 2px; }
    .action-arrow { margin-left: auto; color: var(--muted); font-size: 0.9rem; }

    .table-card { background: var(--card); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }

    .table-header {
      padding: 16px 20px; border-bottom: 1px solid var(--border);
      display: flex; align-items: center; justify-content: space-between;
    }

    .table-title { font-weight: 600; font-size: 0.9rem; }
    .table-sub { font-size: 0.72rem; color: var(--muted); }

    table { width: 100%; border-collapse: collapse; }
    th {
      padding: 10px 20px; text-align: left; font-size: 0.72rem; font-weight: 600;
      color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px;
      background: #faf9f7; border-bottom: 1px solid var(--border);
    }
    td { padding: 13px 20px; font-size: 0.84rem; border-bottom: 1px solid var(--border); }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #faf9f7; }

    .badge {
      display: inline-flex; align-items: center; gap: 4px;
      padding: 3px 10px; border-radius: 999px; font-size: 0.7rem; font-weight: 600;
    }
    .badge-pending  { background: rgba(245,166,35,0.12); color: #b37700; }
    .badge-approved { background: rgba(45,158,107,0.12); color: var(--green); }
    .badge-rejected { background: rgba(232,82,58,0.12);  color: var(--accent2); }

    .btn-sm {
      padding: 5px 12px; border-radius: 6px; font-size: 0.75rem;
      font-weight: 600; border: none; cursor: pointer;
      text-decoration: none; transition: all 0.15s; display: inline-block;
    }
    .btn-approve { background: rgba(45,158,107,0.12); color: var(--green); }
    .btn-approve:hover { background: var(--green); color: #fff; }
    .btn-reject { background: rgba(232,82,58,0.1); color: var(--accent2); }
    .btn-reject:hover { background: var(--accent2); color: #fff; }
    .btn-edit { background: rgba(46,107,232,0.1); color: var(--blue); }
    .btn-edit:hover { background: var(--blue); color: #fff; }
    .btn-delete { background: rgba(232,82,58,0.1); color: var(--accent2); }
    .btn-delete:hover { background: var(--accent2); color: #fff; }
    .empty-row td { text-align:center; color:var(--muted); padding:32px; }

    .empty-row td { text-align: center; color: var(--muted); padding: 32px; }
  </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-text">Panel <span>Admin</span></div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-label">Menu Utama</div>
    <a href="<?= base_url('admin') ?>" class="nav-item active">
      <i class="bi bi-grid-fill"></i> Dashboard
    </a>
    <a href="<?= base_url('/') ?>" class="nav-item">
      <i class="bi bi-map"></i> Lihat Peta
    </a>
    <a href="<?= base_url('tambah-kuliner') ?>" class="nav-item">
      <i class="bi bi-shop"></i> Kuliner
    </a>
    <a href="#" class="nav-item">
      <i class="bi bi-tag-fill"></i> Kategori
    </a>
    <a href="#" class="nav-item">
      <i class="bi bi-bookmark-fill"></i> Tag
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="user-info">
      <div class="avatar"><?= strtoupper(substr(session()->get('nama'), 0, 1)) ?></div>
      <div>
        <div class="user-name"><?= session()->get('nama') ?></div>
        <div class="user-role"><?= ucfirst(session()->get('role')) ?></div>
      </div>
    </div>
    <a href="<?= base_url('logout') ?>" class="btn-logout">
      <i class="bi bi-box-arrow-left"></i> Keluar
    </a>
  </div>
</aside>

<!-- MAIN CONTENT -->
<div class="main">

  <!-- Topbar -->
  <div class="topbar">
    <div>
      <div class="page-title">Dashboard</div>
      <div class="breadcrumb">Selamat datang kembali 👋</div>
    </div>
    <div class="topbar-right">
      <div class="greeting">Halo, <strong><?= session()->get('nama') ?></strong></div>
    </div>
  </div>

  <!-- Content -->
  <div class="content">

    <!-- Stats -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-info">
          <div class="stat-label">Total Kuliner</div>
          <div class="stat-value"><?= $total_approved ?></div>
          <div class="stat-sub">Sudah approved</div>
        </div>
        <div class="stat-icon icon-orange"><i class="bi bi-shop"></i></div>
      </div>
      <div class="stat-card">
        <div class="stat-info">
          <div class="stat-label">Menunggu Review</div>
          <div class="stat-value"><?= $total_pending ?></div>
          <div class="stat-sub">Perlu dimoderasi</div>
        </div>
        <div class="stat-icon icon-red"><i class="bi bi-clock-history"></i></div>
      </div>
      <div class="stat-card">
        <div class="stat-info">
          <div class="stat-label">Kategori</div>
          <div class="stat-value"><?= $total_kategori ?></div>
          <div class="stat-sub">Jenis tempat makan</div>
        </div>
        <div class="stat-icon icon-green"><i class="bi bi-tag"></i></div>
      </div>
      <div class="stat-card">
        <div class="stat-info">
          <div class="stat-label">Tag</div>
          <div class="stat-value"><?= $total_tag ?></div>
          <div class="stat-sub">Label tersedia</div>
        </div>
        <div class="stat-icon icon-blue"><i class="bi bi-bookmark"></i></div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="section-title">Aksi Cepat</div>
    <div class="actions-grid">
      <a href="<?= base_url('tambah-kuliner') ?>" class="action-card">
        <div class="action-icon icon-orange"><i class="bi bi-plus-circle-fill"></i></div>
        <div>
          <div class="action-name">Tambah Tempat</div>
          <div class="action-desc">Tambah kuliner baru ke database</div>
        </div>
        <i class="bi bi-chevron-right action-arrow"></i>
      </a>
      <a href="#" class="action-card">
        <div class="action-icon icon-green"><i class="bi bi-tag-fill"></i></div>
        <div>
          <div class="action-name">Tambah Kategori</div>
          <div class="action-desc">Buat kategori tempat makan baru</div>
        </div>
        <i class="bi bi-chevron-right action-arrow"></i>
      </a>
      <a href="#" class="action-card">
        <div class="action-icon icon-blue"><i class="bi bi-bookmark-fill"></i></div>
        <div>
          <div class="action-name">Tambah Tag</div>
          <div class="action-desc">Buat tag / label baru</div>
        </div>
        <i class="bi bi-chevron-right action-arrow"></i>
      </a>
    </div>

    <!-- Semua Kuliner Table -->
    <div class="section-title" style="margin-top:0">Semua Kuliner</div>
    <div class="table-card" style="margin-bottom:28px">
      <div class="table-header">
        <div>
          <div class="table-title">Daftar Lengkap Tempat Kuliner</div>
          <div class="table-sub">Kelola semua data kuliner di sini</div>
        </div>
      </div>
      <table>
        <thead>
          <tr>
            <th>Nama Tempat</th>
            <th>Kategori</th>
            <th>Disubmit oleh</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($semua_kuliner)): ?>
            <?php foreach ($semua_kuliner as $k): ?>
            <tr>
              <td><?= esc($k['nama']) ?></td>
              <td><?= esc($k['nama_kategori'] ?? '-') ?></td>
              <td><?= esc($k['user_nama'] ?? '-') ?></td>
              <td>
                <?php if ($k['status'] === 'approved'): ?>
                  <span class="badge badge-approved"><i class="bi bi-check-circle"></i> Approved</span>
                <?php elseif ($k['status'] === 'pending'): ?>
                  <span class="badge badge-pending"><i class="bi bi-clock"></i> Pending</span>
                <?php else: ?>
                  <span class="badge badge-rejected"><i class="bi bi-x-circle"></i> Rejected</span>
                <?php endif; ?>
              </td>
              <td style="display:flex;gap:6px;">
                <a href="#" class="btn-sm btn-edit">✎ Edit</a>
                <a href="#" class="btn-sm btn-delete" onclick="return confirm('Yakin hapus?')">✕ Hapus</a>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr class="empty-row"><td colspan="5">Belum ada data kuliner</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pending Table -->
    <div class="section-title">Menunggu Moderasi</div>
    <div class="table-card">
      <div class="table-header">
        <div>
          <div class="table-title">Kuliner Pending</div>
          <div class="table-sub">Butuh persetujuan sebelum tampil di publik</div>
        </div>
      </div>
      <table>
        <thead>
          <tr>
            <th>Nama Tempat</th>
            <th>Kategori</th>
            <th>Disubmit oleh</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($pending_kuliner)): ?>
            <?php foreach ($pending_kuliner as $k): ?>
            <tr>
              <td><?= esc($k['nama']) ?></td>
              <td><?= esc($k['nama_kategori'] ?? '-') ?></td>
              <td><?= esc($k['user_nama'] ?? '-') ?></td>
              <td><span class="badge badge-pending"><i class="bi bi-clock"></i> Pending</span></td>
              <td style="display:flex;gap:6px;">
                <a href="#" class="btn-sm btn-approve">✓ Approve</a>
                <a href="#" class="btn-sm btn-reject">✕ Reject</a>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr class="empty-row">
              <td colspan="5">🎉 Tidak ada kuliner yang menunggu moderasi</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

</body>
</html>
