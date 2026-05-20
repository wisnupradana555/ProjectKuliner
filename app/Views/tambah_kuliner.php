<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tempat Kuliner</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f4f4; padding: 40px 20px; color: #333; margin: 0; }
        .form-container { background: white; padding: 30px 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 600px; margin: 0 auto; }
        .form-container h2 { margin-top: 0; color: #007bff; border-bottom: 2px solid #f0f0f0; padding-bottom: 15px; margin-bottom: 25px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px; color: #555; }
        .form-control { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 14px; font-family: inherit; transition: border-color 0.3s ease; }
        .form-control:focus { border-color: #007bff; outline: none; box-shadow: 0 0 0 3px rgba(0,123,255,0.1); }
        .row { display: flex; gap: 15px; }
        .col { flex: 1; }
        .btn-group { margin-top: 30px; display: flex; gap: 15px; align-items: center; }
        .btn-save { background: #28a745; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer; font-size: 15px; font-weight: bold; transition: background 0.3s ease; }
        .btn-save:hover { background: #218838; }
        .btn-cancel { color: #dc3545; text-decoration: none; font-size: 15px; padding: 12px 25px; border-radius: 6px; border: 1px solid transparent; font-weight: bold; transition: background 0.3s ease; }
        .btn-cancel:hover { background: #f8d7da; border-color: #f5c6cb; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Tambah Tempat Kuliner</h2>
        
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
                    <option value="1">Makanan Berat</option>
                    <option value="2">Jajanan / Makanan Ringan</option>
                    <option value="3">Minuman / Kafe</option>
                    <option value="4">Oleh-Oleh</option>
                </select>
            </div>

            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="alamat" rows="3" class="form-control" placeholder="Tuliskan alamat lengkap jalan, RT/RW, dll..." required></textarea>
            </div>

            <div class="form-group">
                <label>Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="3" class="form-control" placeholder="Ceritakan ciri khas atau menu andalan dari tempat ini..."></textarea>
            </div>

            <div class="form-group">
                <label>Upload Foto Tempat (Opsional)</label>
                <input type="file" name="foto" class="form-control" accept="image/*" style="padding: 9px;">
                <small style="color: #888; font-size: 12px; margin-top: 5px; display: block;">Format: JPG, PNG. Maksimal 2MB.</small>
            </div>

            <div class="row">
                <div class="col form-group">
                    <label>Latitude (Lat) Peta</label>
                    <input type="text" name="lat" class="form-control" placeholder="Contoh: -6.966667">
                </div>
                <div class="col form-group">
                    <label>Longitude (Lon) Peta</label>
                    <input type="text" name="lon" class="form-control" placeholder="Contoh: 110.416664">
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-save">Simpan Data</button>
                <a href="/dashboard" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>

</body>
</html>