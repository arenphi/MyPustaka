<?php
session_start();
include '../includes/koneksi.php';
include '../includes/header.php';


// Proteksi Admin
if (!isset($_SESSION['user_data']) || $_SESSION['user_data']['level'] != 'Admin') { 
    header("Location: ../login.php"); 
    exit; 
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Peminjaman - MyPustaka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
    body { background-color: #f8f9fa; }
    /* Jarak agar konten tidak tertutup navbar fixed */
    .container-admin { margin-top: 80px; padding-bottom: 50px; }
    .card-transaksi { border-radius: 12px; transition: 0.3s; border: none; }
    .badge-status { font-size: 10px; padding: 5px 10px; border-radius: 20px; }
    .bg-tema { background-color: #775CA7; color: white; }
</style>

<div class="container container-admin" style="max-width: 600px;">
    <div class="text-center mb-4">
        <h5 class="fw-bold">Manajemen Peminjaman</h5>
        <p class="text-muted small">Daftar buku yang sedang aktif dipinjam</p>
    </div>
    
    <?php
    $sql = "SELECT t.*, a.nama_lengkap, b.judul 
            FROM transaksi t 
            JOIN anggota a ON t.id_anggota = a.id_anggota 
            JOIN buku b ON t.id_buku = b.id_buku 
            WHERE t.status = 'Dipinjam'
            ORDER BY t.tgl_kembali_seharusnya ASC";
    $q = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($q) == 0) {
        echo "
        <div class='text-center py-5'>
            <i class='bi bi-inbox fs-1 text-muted'></i>
            <p class='text-muted'>Tidak ada peminjaman aktif saat ini.</p>
        </div>";
    }

    while($r = mysqli_fetch_assoc($q)):
        // LOGIKA HITUNG DENDA OTOMATIS
        $tgl_deadline = new DateTime($r['tgl_kembali_seharusnya']);
        $tgl_sekarang = new DateTime(date('Y-m-d'));
        $denda_berjalan = 0;
        $selisih = 0;

        if ($tgl_sekarang > $tgl_deadline) {
            $selisih = $tgl_sekarang->diff($tgl_deadline)->days;
            $denda_berjalan = $selisih * 5000; 
        }
    ?>
    <div class="card mb-3 shadow-sm p-3 card-transaksi">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <span class="fw-bold d-block mb-1" style="font-size: 14px;"><?= $r['nama_lengkap'] ?></span>
                <span class="text-primary small fw-bold"><i class="bi bi-book me-1"></i> <?= $r['judul'] ?></span>
            </div>
            <span class="badge bg-warning text-dark badge-status"><?= $r['status'] ?></span>
        </div>
        
        <hr class="my-2 opacity-25">
        
        <div class="row text-muted" style="font-size: 11px;">
            <div class="col-6">
                Tgl Pinjam: <br> <b><?= date('d M Y', strtotime($r['tgl_pinjam'])) ?></b>
            </div>
            <div class="col-6 text-end">
                Jatuh Tempo: <br> <b class="<?= ($denda_berjalan > 0) ? 'text-danger' : '' ?>"><?= date('d M Y', strtotime($r['tgl_kembali_seharusnya'])) ?></b>
            </div>
        </div>

        <?php if($denda_berjalan > 0): ?>
            <div class="alert alert-danger py-1 px-2 mt-2 mb-2 border-0 d-flex justify-content-between align-items-center" style="font-size: 12px;">
                <span><i class="bi bi-exclamation-circle me-1"></i> Terlambat <?= $selisih ?> Hari</span>
                <span class="fw-bold">Denda: Rp <?= number_format($denda_berjalan, 0, ',', '.') ?></span>
            </div>
        <?php endif; ?>

        <div class="mt-2">
            <a href="proses_kembali.php?id=<?= $r['id_transaksi'] ?>&denda=<?= $denda_berjalan ?>" 
               class="btn btn-success btn-sm w-100 fw-bold py-2" 
               style="border-radius: 8px;"
               onclick="return confirm('Konfirmasi pengembalian buku?')">
               <i class="bi bi-check2-circle me-1"></i> Selesaikan Pinjaman
            </a>
        </div>
    </div>
    <?php endwhile; ?>

    <div class="text-center mt-4">
        <a href="../index.php" class="btn btn-light btn-sm text-muted">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>