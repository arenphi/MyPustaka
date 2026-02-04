<?php
// Aktifkan pelaporan error agar tidak blank putih jika terjadi kesalahan
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Jalur koneksi: keluar satu folder (..) lalu masuk ke includes/koneksi.php
require_once '../includes/koneksi.php';

if (isset($_POST['btn_konfirmasi'])) {
    // Pastikan session user ada
    if (!isset($_SESSION['user_data']['id_anggota'])) {
        die("Error: Sesi login tidak ditemukan. Silakan login kembali.");
    }

    $id_buku     = mysqli_real_escape_string($conn, $_POST['id_buku']);
    $id_anggota  = $_SESSION['user_data']['id_anggota'];
    $tgl_pinjam  = mysqli_real_escape_string($conn, $_POST['tgl_pinjam']);
    $tgl_kembali = mysqli_real_escape_string($conn, $_POST['tgl_kembali']);

    // 1. Cek ketersediaan stok terakhir
    $cek = mysqli_query($conn, "SELECT stok FROM buku WHERE id_buku = '$id_buku'");
    
    if (!$cek) {
        die("Error Query Stok: " . mysqli_error($conn));
    }

    $data = mysqli_fetch_assoc($cek);

    if ($data && $data['stok'] > 0) {
        // 2. Input data ke tabel transaksi
        // Pastikan nama kolom di database Anda (id_buku, id_anggota, tgl_pinjam, tgl_kembali_seharusnya, status) sudah sesuai
        $query_pinjam = "INSERT INTO transaksi (id_buku, id_anggota, tgl_pinjam, tgl_kembali_seharusnya, status) 
                         VALUES ('$id_buku', '$id_anggota', '$tgl_pinjam', '$tgl_kembali', 'Dipinjam')";
        
        if (mysqli_query($conn, $query_pinjam)) {
            // 3. Kurangi stok buku di tabel buku
            mysqli_query($conn, "UPDATE buku SET stok = stok - 1 WHERE id_buku = '$id_buku'");
            
            echo "<script>alert('Peminjaman Berhasil!'); window.location='../index';</script>";
        } else {
            // Jika gagal, tampilkan error spesifik database
            die("Error Simpan Transaksi: " . mysqli_error($conn));
        }
    } else {
        echo "<script>alert('Maaf, stok buku sudah habis!'); window.location='../index';</script>";
    }
} else {
    // Jika file diakses langsung tanpa lewat form
    header("Location: ../index");
    exit();
}
?>