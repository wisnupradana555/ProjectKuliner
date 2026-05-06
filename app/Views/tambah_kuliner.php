<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Tempat Kuliner</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 20px; }
        .container { background: white; padding: 20px; max-width: 600px; margin: auto; border-radius: 8px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], textarea { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn { padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; color: white; text-decoration: none;}
        .btn-simpan { background: #28a745; }
        .btn-batal { background: #dc3545; }
    </style>
</head>
<body>

<div class="container">
    <h2>Tambah Tempat Kuliner</h2>
    <hr>
    
    <!-- Form ini akan mengirim data ke URL /simpan-kuliner pakai metode POST -->
    <form action="/simpan-kuliner" method="post">
        
        <div class="form-group">
            <label>Nama Tempat:</label>
            <input type="text" name="nama" required placeholder="Contoh: Mie Gacoan Tembalang">
        </div>

        <div class="form-group">
            <label>Alamat:</label>
            <textarea name="alamat" rows="3" required placeholder="Masukkan alamat lengkap"></textarea>
        </div>

        <div class="form-group">
            <label>Deskripsi Singkat:</label>
            <textarea name="deskripsi" rows="3" required placeholder="Contoh: Enak, murah, dan tempatnya luas"></textarea>
        </div>

        <!-- Lat & Lon diketik manual dulu, nanti bisa kita upgrade pakai Maps -->
        <div class="form-group">
            <label>Latitude (Opsional):</label>
            <input type="text" name="lat" placeholder="Contoh: -7.051...">
        </div>

        <div class="form-group">
            <label>Longitude (Opsional):</label>
            <input type="text" name="lon" placeholder="Contoh: 110.435...">
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-simpan">Simpan Data</button>
            <a href="/dashboard" class="btn btn-batal">Batal</a>
        </div>

    </form>
</div>

</body>
</html>