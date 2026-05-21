<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            background-color: #f8f9fa; 
            font-family: 'Outfit', sans-serif;
            color: #333;
        }
        .glass-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 100%; 
            max-width: 400px;
            padding: 40px;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #d1d5db;
            background: #fff;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
            border-color: #007bff;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            transition: background-color 0.2s;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .back-link {
            display: inline-block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }
        .back-link:hover { color: #0056b3; }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="glass-card">
        <div>
            <h2 class="text-center mb-4" style="font-weight: 700; color: #4a4a4a;">Login</h2>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success text-center">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger text-center">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('loginProcess') ?>" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Masukkan email...">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan password...">
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3">Masuk</button>
                <div class="text-center">
                    <p class="mb-2">Belum punya akun? <a href="<?= base_url('register') ?>" class="text-decoration-none" style="font-weight: 600; color: #007bff;">Daftar di sini</a></p>
                    <a href="<?= base_url('/') ?>" class="back-link">← Kembali ke Map</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>