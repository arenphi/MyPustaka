<?php
session_start();
include '../koneksi.php';

// Cek apakah yang akses adalah admin
if (!isset($_SESSION['user_data']) || $_SESSION['user_data']['level'] != 'Admin') {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Ambil nama file foto sebelum data dihapus
    $data = mysqli_query($conn, "SELECT foto_cover FROM buku WHERE id_buku = '$id'");
    $buku = mysqli_fetch_assoc($data);
    $foto = $buku['foto_cover'];

    // 2. Hapus file fisik dari folder jika ada
    if ($foto != "" && file_exists("../assets/img/cover/" . $foto)) {
        unlink("../assets/img/cover/" . $foto);
    }

    // 3. Hapus data dari database
    $query = mysqli_query($conn, "DELETE FROM buku WHERE id_buku = '$id'");

    if ($query) {
        echo "<script>
                alert('Buku berhasil dihapus!');
                window.location.href='../index.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus buku!');
                window.location.href='../index.php';
              </script>";
    }
} else {
    header("Location: ../index.php");
}
?>