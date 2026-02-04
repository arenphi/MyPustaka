<?php
session_start();
include '../koneksi.php';

// Proteksi: Hanya Admin yang boleh masuk
if (!isset($_SESSION['user_data']) || $_SESSION['user_data']['level'] != 'Admin') {
    header("Location: ../login.php");
    exit;
}

// LOGIKA HAPUS BUKU
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM buku WHERE id_buku = '$id'");
    header("Location: kelola_buku.php?pesan=terhapus");
}

// LOGIKA TAMBAH BUKU
if (isset($_POST['tambah'])) {
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $stok = $_POST['stok'];
    
    mysqli_query($conn, "INSERT INTO buku (judul, pengarang, stok) VALUES ('$judul', '$pengarang', '$stok')");
    header("Location: kelola_buku.php?pesan=tersimpan");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --warna-admin: #2c3e50; }
        body { background-color: #f8f9fa; padding-bottom: 80px; }
        .header-admin { background-color: var(--warna-admin); color: white; }
    </style>
</head>
<body>

    <div class="header-admin p-3 shadow-sm mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Manajemen Buku</h5>
            <a href="../dashboard.php" class="text-white text-decoration-none"><i class="bi bi-x-lg"></i></a>
        </div>
    </div>

    <div class="container">
        <div class="card border-0 shadow-sm mb-4 p-3" style="border-radius: 12px;">
            <h6 class="fw-bold mb-3">Tambah Buku Baru</h6>
            <form method="POST">
                <input type="text" name="judul" class="form-control mb-2" placeholder="Judul Buku" required>
                <input type="text" name="pengarang" class="form-control mb-2" placeholder="Pengarang">
                <input type="number" name="stok" class="form-control mb-3" placeholder="Jumlah Stok" required>
                <button type="submit" name="tambah" class="btn btn-dark w-100">Simpan Koleksi</button>
            </form>
        </div>

        <h6 class="fw-bold mb-3">Daftar Koleksi</h6>
        <div class="table-responsive">
            <table class="table table-white bg-white shadow-sm rounded overflow-hidden" style="font-size: 13px;">
                <thead class="table-dark">
                    <tr>
                        <th>Judul</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conn, "SELECT * FROM buku ORDER BY id_buku DESC");
                    while($b = mysqli_fetch_assoc($query)):
                    ?>
                    <tr>
                        <td class="align-middle fw-bold"><?= $b['judul'] ?></td>
                        <td class="align-middle text-center"><?= $b['stok'] ?></td>
                        <td class="align-middle text-center">
                            <a href="kelola_buku.php?hapus=<?= $b['id_buku'] ?>" 
                               class="btn btn-outline-danger btn-sm" 
                               onclick="return confirm('Hapus buku ini?')">
                               <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>