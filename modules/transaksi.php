<?php
session_start();
include '../includes/koneksi.php';
include '../includes/header.php';

if (!isset($_SESSION['user_data'])) {
    header("Location: ../login.php");
    exit;
}

$id_buku = $_GET['id'];
$id_user = $_SESSION['user_data']['id_anggota']; // Mengambil ID dari session anggota

// Ambil data buku
$query_buku = mysqli_query($conn, "SELECT * FROM buku WHERE id_buku = '$id_buku'");
$b = mysqli_fetch_assoc($query_buku);

// Logika Tanggal
$tgl_pinjam = date('Y-m-d');
$tgl_kembali_seharusnya = date('Y-m-d', strtotime('+7 days', strtotime($tgl_pinjam)));

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 text-center">Konfirmasi Peminjaman</h5>
                    <table class="table table-borderless small">
                        <tr>
                            <td>Judul Buku</td>
                            <td class="fw-bold">: <?= $b['judul'] ?></td>
                        </tr>
                        <tr>
                            <td>Peminjam</td>
                            <td class="fw-bold">: <?= $_SESSION['user_data']['nama_lengkap'] ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Pinjam</td>
                            <td class="fw-bold">: <?= date('d M Y', strtotime($tgl_pinjam)) ?></td>
                        </tr>
                        <tr>
                            <td>Batas Kembali</td>
                            <td class="fw-bold text-danger">: <?= date('d M Y', strtotime($tgl_kembali_seharusnya)) ?></td>
                        </tr>
                    </table>

                    <div class="alert alert-warning" style="font-size: 11px;">
                        <i class="bi bi-exclamation-triangle"></i> 
                        Keterlambatan akan dikenakan denda <b>Rp5.000/hari</b>.
                    </div>

                    <form action="proses_pinjam" method="POST">
                        <input type="hidden" name="id_buku" value="<?= $id_buku ?>">
                        <input type="hidden" name="tgl_pinjam" value="<?= $tgl_pinjam ?>">
                        <input type="hidden" name="tgl_kembali" value="<?= $tgl_kembali_seharusnya ?>">
                        
                        <div class="d-grid gap-2">
                            <button type="submit" name="btn_konfirmasi" class="btn btn-primary text-white py-2" style="background-color: #775CA7; border:none;">
                                Konfirmasi Pinjam
                            </button>
                            <a href="../index.php" class="btn btn-light py-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>