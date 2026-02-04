<?php
session_start();
include '../includes/koneksi.php';
if (!isset($_SESSION['user_data'])) { header("Location: index.php"); exit; }
$user = $_SESSION['user_data'];
$role = $user['level'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPustaka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --warna-tema: #775CA7; }
        body { background-color: #f0f2f5; padding-top: 65px; padding-bottom: 80px; }
        .bg-tema { background-color: var(--warna-tema) !important; }
        .footer-nav { background: white; border-top: 1px solid #dee2e6; height: 70px; }
        .nav-link-custom { color: #6c757d; font-size: 11px; text-decoration: none; }
        .nav-link-custom.active { color: var(--warna-tema); font-weight: bold; }
        .dropdown-item { font-size: 14px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark bg-tema fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="dashboard.php">MyPustaka</a>
            
            <div class="dropdown">
                <button class="btn btn-link text-white p-0 me-2" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-file-earmark-text fs-4"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li><h6 class="dropdown-header">Laporan</h6></li>
                    <li><a class="dropdown-item" href="laporan/resi.php"><i class="bi bi-ticket-perforated me-2"></i> Resi Pinjam</a></li>
                    <li><a class="dropdown-item" href="laporan/riwayat.php"><i class="bi bi-clock-history me-2"></i> Riwayat Selesai</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
        <div class="card p-3 mb-4 shadow-sm border-0" style="border-radius: 15px;">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['nama_lengkap']) ?>&background=775CA7&color=fff" class="rounded-circle shadow-sm" width="50">
                    <div class="ms-3">
                        <h6 class="mb-0 fw-bold"><?= $user['nama_lengkap'] ?></h6>
                        <small class="text-muted"><?= $role ?></small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row g-3">
            <div class="col-6">
                <a href="modules/buku.php" class="card p-4 text-center border-0 shadow-sm text-decoration-none text-dark">
                    <i class="bi bi-book fs-1 text-primary mb-2"></i>
                    <span>Katalog</span>
                </a>
            </div>
            <?php if($role == 'Admin'): ?>
            <div class="col-6">
                <a href="admin/kelola_buku.php" class="card p-4 text-center border-0 shadow-sm text-decoration-none text-dark">
                    <i class="bi bi-gear fs-1 text-danger mb-2"></i>
                    <span>Kelola Buku</span>
                </a>
            </div>
            <?php else: ?>
            <div class="col-6">
                <a href="modules/transaksi.php" class="card p-4 text-center border-0 shadow-sm text-decoration-none text-dark">
                    <i class="bi bi-cart-plus fs-1 text-success mb-2"></i>
                    <span>Pinjam</span>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <nav class="navbar fixed-bottom footer-nav p-0 shadow">
        <div class="container d-flex justify-content-around align-items-center text-center">
            <a href="dashboard.php" class="nav-link-custom active">
                <i class="bi bi-house-door fs-4 d-block"></i> Beranda
            </a>
            <a href="profile.php" class="nav-link-custom">
                <i class="bi bi-person-circle fs-4 d-block"></i> Profil
            </a>
            <a href="logout.php" class="nav-link-custom text-danger" onclick="return confirm('Keluar dari aplikasi?')">
                <i class="bi bi-box-arrow-right fs-4 d-block"></i> Logout
            </a>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>