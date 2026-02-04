<?php
session_start();
include '../includes/koneksi.php';

$id_transaksi = $_GET['id'];
$tgl_dikembalikan = date('Y-m-d');

// 1. Ambil ID Buku dari transaksi ini
$transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id_buku FROM transaksi WHERE id_transaksi = '$id_transaksi'"));
$id_buku = $transaksi['id_buku'];

// 2. Update status transaksi menjadi 'Dikembalikan'
$update_status = mysqli_query($conn, "UPDATE transaksi SET 
                                      tgl_dikembalikan = '$tgl_dikembalikan', 
                                      status = 'Dikembalikan' 
                                      WHERE id_transaksi = '$id_transaksi'");

if ($update_status) {
    // 3. Tambahkan kembali stok buku
    mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id_buku = '$id_buku'");
    
    echo "<script>alert('Buku telah dikembalikan. Stok diperbarui!'); window.location='daftar_pinjam.php';</script>";
}
?>