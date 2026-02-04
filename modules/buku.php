<?php
include '../includes/koneksi.php';
if(isset($_POST['add'])){
    $j = $_POST['judul']; $p = $_POST['pengarang']; $s = $_POST['stok'];
    mysqli_query($conn, "INSERT INTO buku (judul, pengarang, stok) VALUES ('$j', '$p', '$s')");
}
?>
<body class="container p-3">
    <form method="POST">
        <input name="judul" placeholder="Judul" class="form-control mb-2" required>
        <input name="pengarang" placeholder="Pengarang" class="form-control mb-2">
        <input type="number" name="stok" placeholder="Stok" class="form-control mb-2" required>
        <button name="add" class="btn btn-primary w-100">Tambah Buku</button>
    </form>
    <table class="table mt-3">
        <tr><th>Judul</th><th>Stok</th></tr>
        <?php $q=mysqli_query($conn,"SELECT * FROM buku"); while($r=mysqli_fetch_assoc($q)){ echo "<tr><td>{$r['judul']}</td><td>{$r['stok']}</td></tr>"; } ?>
    </table>
</body>