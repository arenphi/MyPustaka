<?php
session_start();
include '../includes/koneksi.php';
include '../includes/header.php';

if (!isset($_SESSION['user_data'])) { header("Location: ../login.php"); exit; }

$id_anggota = $_SESSION['user_data']['id_anggota'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style> :root { --warna-tema: #775CA7; } .bg-tema { background-color: var(--warna-tema); } </style>
</head>
<body class="bg-light p-3" style="padding-top: 80px !important;">
    <div class="container" style="max-width: 500px;">
        <h5 class="fw-bold mb-4">Pinjaman Saya</h5>
        
        <?php
        $sql = "SELECT t.*, b.judul, b.foto_cover 
                FROM transaksi t 
                JOIN buku b ON t.id_buku = b.id_buku 
                WHERE t.id_anggota = '$id_anggota' 
                ORDER BY t.status DESC";
        $q = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($q) == 0) {
            echo "<div class='text-center py-5'><i class='bi bi-emoji-smile fs-1 text-muted'></i><p class='text-muted'>Belum ada buku yang dipinjam.</p></div>";
        }

        while($r = mysqli_fetch_assoc($q)):
            // Hitung denda jika masih dipinjam
            $denda = 0;
            if($r['status'] == 'Dipinjam') {
                $deadline = new DateTime($r['tgl_kembali_seharusnya']);
                $today = new DateTime(date('Y-m-d'));
                if($today > $deadline) {
                    $denda = $today->diff($deadline)->days * 5000;
                }
            }
        ?>
        <div class="card mb-3 border-0 shadow-sm p-3" style="border-radius: 12px;">
            <div class="d-flex align-items-center">
                <img src="../assets/img/cover/<?= $r['foto_cover'] ?>" class="rounded" style="width: 60px; height: 80px; object-fit: cover;">
                <div class="ms-3 flex-grow-1">
                    <span class="badge <?= $r['status'] == 'Dipinjam' ? 'bg-warning text-dark' : 'bg-success' ?> mb-1" style="font-size: 10px;"><?= $r['status'] ?></span>
                    <h6 class="fw-bold mb-1" style="font-size: 14px;"><?= $r['judul'] ?></h6>
                    <small class="text-muted d-block" style="font-size: 11px;">Batas: <?= date('d M Y', strtotime($r['tgl_kembali_seharusnya'])) ?></small>
                    <?php if($denda > 0): ?>
                        <small class="text-danger fw-bold">Denda: Rp <?= number_format($denda, 0, ',', '.') ?></small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endwhile; ?>

        <a href="../index.php" class="btn btn-secondary w-100 mt-4 border-0" style="border-radius: 10px;">Kembali</a>
    </div>
</body>
</html>