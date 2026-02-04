<?php
session_start();
include 'includes/koneksi.php';
include 'includes/header.php';

// Cek status login
$is_login = isset($_SESSION['user_data']);
$user = $is_login ? $_SESSION['user_data'] : null;
$role = $is_login ? $user['level'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPustaka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        :root { --warna-tema: #775CA7; }
        body { background-color: #f0f2f5; padding-top: 75px; padding-bottom: 30px; }
        .bg-tema { background-color: var(--warna-tema) !important; }
        .card-menu { border: none; border-radius: 15px; transition: 0.2s; cursor: pointer; }
        
        .book-cover-wrapper {
            width: 100%; position: relative; padding-top: 140%; 
            overflow: hidden; background: linear-gradient(135deg, #775CA7, #4e3a75);
        }
        .book-cover-bg { position: absolute; top: 0; left: 0; bottom: 0; right: 0; display: flex; align-items: center; justify-content: center; }
        .book-img { width: 100%; height: 100%; object-fit: cover; }
        .book-author { font-size: 10px; color: var(--warna-tema); text-transform: uppercase; letter-spacing: 0.5px; }
        .book-title { font-size: 12px; height: 36px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; }
        
        /* Modal Custom Style */
        .modal-content { border-radius: 20px; border: none; }
        .preview-container { width: 100%; height: 250px; background: #eee; border-radius: 10px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 2px dashed #ccc; }
    </style>
</head>
<body>
    <div class="container mt-2">
        
        <?php if($is_login && $role == 'Admin'): ?>
    <div class="row g-2 mb-4">
        <div class="col-6">
            <div data-bs-toggle="modal" data-bs-target="#modalTambah" class="card card-menu p-3 text-center shadow-sm text-decoration-none text-dark bg-white">
                <i class="bi bi-plus-circle-fill fs-3 text-success mb-1"></i>
                <span class="fw-bold" style="font-size: 12px;">Tambah Buku</span>
            </div>
        </div>
        <div class="col-6">
            <a href="admin/daftar_pinjam.php" class="card card-menu p-3 text-center shadow-sm text-decoration-none text-dark bg-white">
                <i class="bi bi-people-fill fs-3 text-primary mb-1"></i>
                <span class="fw-bold" style="font-size: 12px;">Data Peminjam</span>
            </a>
        </div>
    </div>
<?php endif; ?>

<h6 class="fw-bold mb-3">Rekomendasi Buku</h6>
<div class="row g-3">
    <?php
    $query = mysqli_query($conn, "SELECT * FROM buku ORDER BY id_buku DESC");
    while($b = mysqli_fetch_assoc($query)):
    ?>
    <div class="col-6 col-md-3"> 
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; overflow: hidden; background: white;">
            <div class="book-cover-wrapper">
                <div class="book-cover-bg">
                    <?php if(!empty($b['foto_cover'])): ?>
                        <img src="assets/img/cover/<?= $b['foto_cover'] ?>" alt="Cover" class="book-img">
                    <?php else: ?>
                        <i class="bi bi-book fs-1 opacity-50 text-white"></i>
                    <?php endif; ?>
                </div>
            </div>
            <div class="p-2">
                <div class="book-author text-truncate"><?= $b['pengarang'] ?></div>
                <div class="book-title fw-bold text-dark mb-1"><?= $b['judul'] ?></div>
                
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <span class="text-muted" style="font-size: 10px;">Stok: <?= $b['stok'] ?></span>
                    
                    <?php if($role == 'Admin'): ?>
                    <div class="d-flex gap-1">
                        <button type="button" class="btn btn-warning btn-sm flex-fill text-white fw-bold" 
                                style="font-size: 10px; border-radius: 8px;"
                                data-bs-toggle="modal" data-bs-target="#modalEdit<?= $b['id_buku'] ?>">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <a href="admin/hapus_buku.php?id=<?= $b['id_buku'] ?>" 
                           class="btn btn-danger btn-sm flex-fill fw-bold" 
                           style="font-size: 10px; border-radius: 8px;" 
                           onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                            <i class="bi bi-trash"></i> Hapus
                        </a>
                    </div>

                    <?php else: ?>
                        <a href="<?= $is_login ? 'modules/transaksi.php?id='.$b['id_buku'] : 'login.php' ?>" 
                           class="btn btn-primary btn-sm px-3" 
                           style="background-color: var(--warna-tema); border:none; font-size: 10px; border-radius: 20px;">
                           Pinjam
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if($role == 'Admin'): ?>
    <div class="modal fade" id="modalEdit<?= $b['id_buku'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="fw-bold text-warning">Edit Data Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="admin/proses_edit.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="id_buku" value="<?= $b['id_buku'] ?>">
                        <input type="hidden" name="foto_lama" value="<?= $b['foto_cover'] ?>">
                        
                        <div class="row">
                            <div class="col-md-5 mb-3 text-center">
                                <label class="fw-bold small mb-2 d-block">Cover Saat Ini</label>
                                <div class="preview-container mb-2" style="height: 200px;">
                                    <img id="img-edit-preview<?= $b['id_buku'] ?>" src="assets/img/cover/<?= $b['foto_cover'] ?>" style="width:100%; height:100%; object-fit:cover;">
                                </div>
                                <input type="file" name="foto_cover" class="form-control form-control-sm" accept="image/*" onchange="previewEditImage(this, '<?= $b['id_buku'] ?>')">
                                <small class="text-muted" style="font-size: 9px;">*Kosongkan jika tidak ingin mengganti cover</small>
                            </div>
                            
                            <div class="col-md-7">
                                <div class="mb-2">
                                    <label class="small fw-bold">Judul Buku</label>
                                    <input type="text" name="judul" class="form-control" value="<?= $b['judul'] ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label class="small fw-bold">Penulis / Pengarang</label>
                                    <input type="text" name="pengarang" class="form-control" value="<?= $b['pengarang'] ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label class="small fw-bold">Penerbit</label>
                                    <input type="text" name="penerbit" class="form-control" value="<?= $b['penerbit'] ?>" required>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-2">
                                        <label class="small fw-bold">Tahun</label>
                                        <input type="number" name="tahun_terbit" class="form-control" value="<?= $b['tahun_terbit'] ?>" required>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label class="small fw-bold">Stok</label>
                                        <input type="number" name="stok" class="form-control" value="<?= $b['stok'] ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="btn_edit" class="btn btn-warning text-white px-4">Update Buku</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php endwhile; ?>
</div>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="fw-bold">Tambah Koleksi Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="admin/proses_tambah.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label class="fw-bold small mb-2">Cover Buku</label>
                                <div class="preview-container mb-2">
                                    <i class="bi bi-image fs-1 text-muted" id="icon-preview"></i>
                                    <img id="img-preview" src="" style="display:none; width:100%; height:100%; object-fit:cover;">
                                </div>
                                <input type="file" name="foto_cover" id="foto_cover" class="form-control form-control-sm" accept="image/*" required onchange="previewImage()">
                            </div>
                            
                            <div class="col-md-7">
                                <div class="mb-2">
                                    <label class="small fw-bold">Judul Buku</label>
                                    <input type="text" name="judul" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label class="small fw-bold">Penulis / Pengarang</label>
                                    <input type="text" name="pengarang" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label class="small fw-bold">Penerbit</label>
                                    <input type="text" name="penerbit" class="form-control" required>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-2">
                                        <label class="small fw-bold">Tahun</label>
                                        <input type="number" name="tahun_terbit" class="form-control" required>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label class="small fw-bold">Stok</label>
                                        <input type="number" name="stok" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="btn_simpan" class="btn text-white px-4" style="background-color: var(--warna-tema);">Simpan Buku</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi untuk Preview Gambar sebelum upload
        function previewImage() {
            const file = document.querySelector('#foto_cover').files[0];
            const preview = document.querySelector('#img-preview');
            const icon = document.querySelector('#icon-preview');
            
            const reader = new FileReader();
            reader.onloadend = function () {
                preview.src = reader.result;
                preview.style.display = 'block';
                icon.style.display = 'none';
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
    </script>
</body>
</html>