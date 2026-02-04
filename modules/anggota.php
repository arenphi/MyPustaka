<?php
include '../includes/koneksi.php';
$lang = $_GET['lang'] ?? 'ID';

if (isset($_POST['add_member'])) {
    $nama = $_POST['nama'];
    $telp = $_POST['telepon'];
    // Logika upload foto KTP dari Android WebView
    $foto = $_FILES['foto']['name'];
    move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/anggota/" . $foto);
    
    mysqli_query($conn, "INSERT INTO anggota (nama_lengkap, nomor_telepon, foto_ktp) VALUES ('$nama', '$telp', '$foto')");
    header("Location: anggota.php?lang=$lang");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-3">
    <h5><?= ($lang == 'ID' ? "Tambah Anggota Baru" : "Add New Member") ?></h5>
    <form method="POST" enctype="multipart/form-data" class="mb-4">
        <input type="text" name="nama" class="form-control mb-2" placeholder="Nama Lengkap" required>
        <input type="text" name="telepon" class="form-control mb-2" placeholder="No. Telepon">
        <input type="file" name="foto" class="form-control mb-2" accept="image/*">
        <button type="submit" name="add_member" class="btn btn-primary w-100">Simpan Anggota</button>
    </form>
    <a href="../index.php?lang=<?= $lang ?>" class="btn btn-secondary btn-sm">Kembali</a>
</body>
</html>