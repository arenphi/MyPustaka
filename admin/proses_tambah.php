<?php
include '../koneksi.php';

if (isset($_POST['btn_simpan'])) {
    $judul     = mysqli_real_escape_string($conn, $_POST['judul']);
    $pengarang = mysqli_real_escape_string($conn, $_POST['pengarang']);
    $penerbit  = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun     = $_POST['tahun_terbit'];
    $stok      = $_POST['stok'];

    $nama_foto = time() . '_' . $_FILES['foto_cover']['name'];
    
    if (move_uploaded_file($_FILES['foto_cover']['tmp_name'], "../assets/img/cover/" . $nama_foto)) {
        $query = "INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, stok, foto_cover) 
                  VALUES ('$judul', '$pengarang', '$penerbit', '$tahun', '$stok', '$nama_foto')";
        mysqli_query($conn, $query);
        echo "<script>alert('Buku ditambahkan!'); window.location='../index.php';</script>";
    }
}
?>