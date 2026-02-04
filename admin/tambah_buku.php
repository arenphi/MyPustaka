<?php
session_start();
include '../koneksi.php';
include '../includes/header.php';

// Proteksi Admin (Opsional, pastikan session level ada)
if (!isset($_SESSION['user_data']) || $_SESSION['user_data']['level'] !== 'Admin') {
    // header("Location: ../login.php");
}
?>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="fw-bold text-center" style="color: #775CA7;">Tambah Koleksi Buku</h5>
                </div>
                <div class="card-body p-4">
                    <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Cover Buku</label>
                            <input type="file" name="foto_cover" class="form-control" accept="image/*" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Buku</label>
                            <input type="text" name="judul" class="form-control" placeholder="Judul Buku" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Penulis / Pengarang</label>
                                <input type="text" name="pengarang" class="form-control" placeholder="Nama Penulis" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Penerbit</label>
                                <input type="text" name="penerbit" class="form-control" placeholder="Nama Penerbit" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" class="form-control" placeholder="Tahun" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Jumlah Stok</label>
                                <input type="number" name="stok" class="form-control" placeholder="Contoh: 10" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" name="btn_simpan" class="btn text-white py-2" style="background-color: #775CA7; border-radius: 10px;">
                                Simpan Buku
                            </button>
                            <a href="kelola_buku.php" class="btn btn-light py-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>