<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tempat Kuliner</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
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
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Edit Tempat Kuliner</h2>
        <?php if (session()->getFlashdata('error')) : ?>
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            <?= session()->getFlashdata('error') ?>
        </div>
        <?php endif; ?>
        
        <form action="/update-kuliner/<?= $kuliner['id'] ?>" method="post">
            <?= csrf_field(); ?>
            
            <div class="form-group">
                <label>Nama Tempat</label>
                <input type="text" name="nama" class="form-control" value="<?= esc($kuliner['nama']) ?>" required>
            </div>

            <div class="form-group">
                <label>Kategori Kuliner</label>
                <select name="kategori_id" class="form-control" required>
                    <?php foreach ($kategori as $k) : ?>
                        <option value="<?= $k['id'] ?>" <?= $kuliner['kategori_id'] == $k['id'] ? 'selected' : '' ?>><?= esc($k['nama_kategori']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="alamat" rows="3" class="form-control" required><?= esc($kuliner['alamat']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="3" class="form-control"><?= esc($kuliner['deskripsi']) ?></textarea>
            </div>

            <div class="row">
                <div class="col form-group">
                    <label>Latitude (Lat) Peta</label>
                    <input type="text" name="lat" class="form-control" value="<?= esc($kuliner['lat']) ?>">
                </div>
                <div class="col form-group">
                    <label>Longitude (Lon) Peta</label>
                    <input type="text" name="lon" class="form-control" value="<?= esc($kuliner['lon']) ?>">
                </div>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn-save">Update Data</button>
                <?php $kembali = session()->get('role') === 'admin' ? '/admin' : '/dashboard'; ?>
                <a href="<?= $kembali ?>" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>

</body>
</html>
