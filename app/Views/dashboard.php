<style>
    body { font-family: sans-serif; padding: 20px; background: #f4f4f4; }
    .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
    th { background: #007bff; color: white; }
    .btn { padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 14px; }
    .btn-add { background: #28a745; color: white; margin-bottom: 10px; display: inline-block; }
</style>

<div class="container">
    <h2>Halo, <?= $nama_user ?>!</h2>
    <p>Role: <strong><?= $role_user ?></strong> | <a href="/logout">Logout</a></p>
    <hr>
    
    <h3>Daftar Kuliner Semarang</h3>
    <a href="/tambah-kuliner" class="btn btn-add">+ Tambah Tempat</a>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tempat</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($tempat_kuliner as $k) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $k['nama'] ?></td>
                <td><?= $k['alamat'] ?></td>
                <td><?= $k['status'] ?></td>
                <td>
                    <a href="#">Edit</a> | <a href="#">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>