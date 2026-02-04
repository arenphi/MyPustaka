<?php
include '../koneksi.php';

if (isset($_POST['btn_edit'])) {
    $id_buku    = $_POST['id_buku'];
    $judul      = mysqli_real_escape_string($conn, $_POST['judul']);
    $pengarang  = mysqli_real_escape_string($conn, $_POST['pengarang']);
    $penerbit   = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun      = $_POST['tahun_terbit'];
    $stok       = $_POST['stok'];
    $foto_lama  = $_POST['foto_lama'];

    // Cek upload foto baru
    if ($_FILES['foto_cover']['name'] != "") {
        $foto_name = $_FILES['foto_cover']['name'];
        $nama_foto_baru = time() . '_' . $foto_name;
        
        if (move_uploaded_file($_FILES['foto_cover']['tmp_name'], "../assets/img/cover/" . $nama_foto_baru)) {
            if ($foto_lama != "" && file_exists("../assets/img/cover/" . $foto_lama)) {
                unlink("../assets/img/cover/" . $foto_lama);
            }
            $foto_final = $nama_foto_baru;
        }
    } else {
        $foto_final = $foto_lama;
    }

    $query = "UPDATE buku SET 
                judul = '$judul', pengarang = '$pengarang', penerbit = '$penerbit', 
                tahun_terbit = '$tahun', stok = '$stok', foto_cover = '$foto_final' 
              WHERE id_buku = '$id_buku'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Berhasil diupdate!'); window.location='../index.php';</script>";
    }
}
?>