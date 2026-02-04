<?php
session_start();
include 'includes/koneksi.php'; // Sesuaikan path koneksi Anda

// Jika sudah login, tendang ke beranda
if (isset($_SESSION['user_data'])) {
    header("Location: index");
    exit;
}

$error = "";

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Query ke tabel anggota (sesuai struktur DB Pustaka Anda)
    $query = "SELECT * FROM anggota WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Verifikasi password hash (Standar RPL)
        if (password_verify($password, $row['password'])) {
            // Simpan data penting ke session
            $_SESSION['user_data'] = [
                'id_anggota' => $row['id_anggota'],
                'nama_lengkap' => $row['nama_lengkap'],
                'level' => $row['level'], // Admin atau User
                'alamat' => $row['alamat']
            ];
            
            header("Location: index");
            exit;
        } else {
            $error = "Kata sandi yang Anda masukkan salah.";
        }
    } else {
        $error = "Akun tidak ditemukan. Silakan daftar terlebih dahulu.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --warna-tema: #775CA7; }
        body { background-color: var(--warna-tema); height: 100vh; display: flex; align-items: center; justify-content: center; font-family: sans-serif; }
        .login__container { background: white; width: 100%; max-width: 420px; padding: 2.5rem; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.2); }
        .app__logo { width: 60px; margin-bottom: 0.5rem; }
        .app__name { color: var(--warna-tema); font-weight: 800; letter-spacing: 1px; }
        .login__title { font-weight: 700; margin: 1.5rem 0; color: #333; }
        .login__input { width: 100%; padding: 12px 15px; border-radius: 30px; border: 1px solid #ddd; outline: none; transition: 0.3s; margin-bottom: 1rem; }
        .login__input:focus { border-color: var(--warna-tema); }
        .login__button { width: 100%; padding: 12px; border-radius: 10px; border: none; background: var(--warna-tema); color: white; font-weight: 600; margin: 1rem 0; transition: 0.3s; }
        .login__button:hover { background: #5e468d; }
        .login__check { display: flex; justify-content: space-between; font-size: 0.85rem; color: #666; margin-bottom: 1rem; }
        .login__signup { text-align: center; font-size: 0.9rem; color: #444; margin-top: 1rem; }
        .login__signup a { color: var(--warna-tema); text-decoration: none; font-weight: 600; }
        .ri-eye-off-line { cursor: pointer; color: var(--warna-tema); position: absolute; right: 20px; top: 12px; }
    </style>
    <title>Masuk MyPustaka</title>
</head>
<body>
    <div class="login__container">
        <form action="" method="POST">
            <div class="text-center">
                <i class="bi bi-book-half" style="font-size: 4rem; color: var(--warna-tema);"></i> 
                <h3 class="app__name">MyPustaka</h3>
            </div>
            
            <h4 class="login__title text-center text-md-start">Masuk</h4>

            <?php if($error): ?>
                <div class="alert alert-danger py-2" style="font-size: 0.8rem; border-radius: 10px;">
                    <i class="ri-error-warning-line"></i> <?= $error; ?>
                </div>
            <?php endif; ?>

            <input type="email" name="email" class="login__input" placeholder="Email" required>

            <div style="position: relative;">
                <input type="password" name="password" id="login-pass" class="login__input" placeholder="Kata Sandi" required>
                <i class="ri-eye-off-line" id="login-eye"></i>
            </div>

            <div class="login__check">
                <div>
                    <input type="checkbox" id="login-check">
                    <label for="login-check">Tetap masuk</label>
                </div>
                <a href="#" style="text-decoration:none; color: var(--warna-tema);">Lupa Sandi?</a>
            </div>

            <button type="submit" name="login" class="login__button">Masuk</button>

            <div class="login__signup">
                Belum punya akun? <a href="register">Daftar Akun</a>
            </div>
            <div class="login__signup mt-2">
                <a href="index" class="text-secondary small">
                    <i class="ri-arrow-left-line"></i> Kembali ke Beranda
                </a>
            </div>
        </form>
    </div>

    <script>
        /* Logic Toggle Password View */
        const showHiddenPass = (loginPass, loginEye) =>{
           const input = document.getElementById(loginPass),
                 iconEye = document.getElementById(loginEye)

           iconEye.addEventListener('click', () =>{
               if(input.type === 'password'){
                   input.type = 'text'
                   iconEye.classList.add('ri-eye-line')
                   iconEye.classList.remove('ri-eye-off-line')
               } else{
                   input.type = 'password'
                   iconEye.classList.remove('ri-eye-line')
                   iconEye.classList.add('ri-eye-off-line')
               }
           })
        }
        showHiddenPass('login-pass','login-eye')
    </script>
</body>
</html>