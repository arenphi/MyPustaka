<?php
session_start();
include '../includes/koneksi.php';
if (!isset($_SESSION['user_data'])) { header("Location: ../login.php"); exit; }

$id_user = $_SESSION['user_data']['id_anggota'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: #f0f2f5; padding-bottom: 80px; }
        .resi-card { border-radius: 12px; border-left: 5px solid #775CA7; }
    </style>
</head>
<body>
    <div class="p-3 bg-white shadow-sm mb-3">
        <h6 class="fw-bold mb-0 text-center">Resi Peminjaman</h6>
    </div>

    <div class="container">
        <?php
        $query = mysqli_query($conn, "SELECT t.*, b.judul FROM transaksi t 
                                     JOIN buku b ON t.id_buku = b.id_buku 
                                     WHERE t.id_anggota = '$id_user' 
                                     ORDER BY t.id_transaksi DESC");
        
        while($r = mysqli_fetch_assoc($query)):
        ?>
        <div class="card resi-card shadow-sm mb-3 p-3 border-0">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-light text-dark">ID #<?= $r['id_transaksi'] ?></span>
                <span class="badge <?= $r['status'] == 'Dipinjam' ? 'bg-warning' : 'bg-success' ?>"><?= $r['status'] ?></span>
            </div>
            <h6 class="fw-bold mb-1"><?= $r['judul'] ?></h6>
            <div class="row small text-muted">
                <div class="col-6">Pinjam: <?= date('d/m/y', strtotime($r['tgl_pinjam'])) ?></div>
                <div class="col-6 text-end text-danger">Batas: <?= date('d/m/y', strtotime($r['tgl_kembali_seharusnya'])) ?></div>
            </div>
            <?php if($r['denda'] > 0): ?>
                <div class="mt-2 p-2 bg-danger-subtle rounded text-danger fw-bold small">
                    Denda Terdeteksi: Rp <?= number_format($r['denda'], 0, ',', '.') ?>
                </div>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </div>

    <nav class="navbar fixed-bottom bg-white border-top p-2">
        <div class="container d-flex justify-content-around text-center">
            <a href="../index.php" class="text-decoration-none text-muted small"><i class="bi bi-house-door d-block fs-4"></i>Home</a>
            <a href="resi.php" class="text-decoration-none small" style="color:#775CA7;"><i class="bi bi-receipt d-block fs-4"></i>Resi</a>
            <a href="../logout.php" class="text-decoration-none text-danger small"><i class="bi bi-power d-block fs-4"></i>Out</a>
        </div>
    </nav>
</body>
</html>