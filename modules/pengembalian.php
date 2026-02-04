<?php
include '../includes/koneksi.php';
if (isset($_POST['proses_kembali'])) {
    $id_t = $_POST['id_transaksi'];
    $id_b = $_POST['id_buku'];
    
    // Ambil data denda (Logika: Rp 2.000 / hari telat)
    $q = mysqli_query($conn, "SELECT tgl_kembali_seharusnya FROM transaksi WHERE id_transaksi='$id_t'");
    $t = mysqli_fetch_assoc($q);
    $diff = strtotime(date("Y-m-d")) - strtotime($t['tgl_kembali_seharusnya']);
    $hari = max(0, floor($diff / (60 * 60 * 24)));
    $denda = $hari * 2000;

    // Update Transaksi & Kembalikan Stok
    mysqli_query($conn, "UPDATE transaksi SET tgl_dikembalikan=CURDATE(), denda='$denda', status='Dikembalikan' WHERE id_transaksi='$id_t'");
    mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id_buku='$id_b'");
    header("Location: ../laporan/riwayat.php");
}
?>