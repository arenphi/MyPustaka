<?php
include 'includes/koneksi.php';

$message = "";
$status = "";

if (isset($_POST['register'])) {
    // Sanitasi input sesuai standar keamanan RPL
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; 
    
    // Hash password agar data anggota aman di database 
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Cek ketersediaan email di tabel anggota
    $cek_email = mysqli_query($conn, "SELECT email FROM anggota WHERE email = '$email'");
    
    if (mysqli_num_rows($cek_email) > 0) {
        $message = "Email sudah terdaftar sebagai anggota!";
        $status  = "error";
    } else {
        // Menambahkan anggota baru dengan level default 'User' 
        $query = "INSERT INTO anggota (nama_lengkap, email, password, level) 
                  VALUES ('$nama', '$email', '$password_hash', 'User')";
        
        if (mysqli_query($conn, $query)) {
            $message = "Pendaftaran Berhasil! Silakan Login.";
            $status  = "success";
        } else {
            $message = "Gagal mendaftar: " . mysqli_error($conn);
            $status  = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login_style.css">
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
    <title>Daftar</title>
</head>
<body>
    <div class="login__container">
        <form action="" method="POST" class="login__form">
            <div style="text-align: center; margin-bottom: 1rem;">
                <i class="bi bi-book-half" style="font-size: 4rem; color: var(--warna-tema);"></i> 
                <h3 class="app__name">MyPustaka</h3>
            </div>
            
            <h4 class="login__title text-center text-md-start">Daftar</h4>

            <?php if($message): ?>
                <p class="login__error" style="color: <?= $status == 'success' ? '#27ae60' : '#e74c3c' ?>; text-align: center; font-size: 0.8rem; margin-bottom: 1rem;">
                    <?= $message ?>
                </p>
            <?php endif; ?>

            <div class="login__group">
                <input type="text" name="nama" class="login__input" placeholder="Nama Lengkap" required>
            </div>

            <div class="login__group">
                <input type="email" name="email" class="login__input" placeholder="Alamat Email" required>
            </div>

            <div class="login__group" style="position: relative;">
                <input type="password" name="password" id="reg-pass" class="login__input" placeholder="Buat Kata Sandi" required>
                <i class="ri-eye-off-line login__eye" id="reg-eye" style="position: absolute; right: 15px; top: 38%; cursor: pointer; color: #775CA7;"></i>
            </div>

            <div class="login__check">
                <div class="login__check-group">
                    <input type="checkbox" class="login__check-input" id="reg-check" required>
                    <label for="reg-check" class="login__check-label">Saya setuju dengan Syarat & Ketentuan</label>
                </div>
            </div>

            <button type="submit" name="register" class="login__button">Daftar Sekarang</button>

            <p class="login__signup">
                Sudah punya akun? <a href="login">Masuk</a>
            </p>
        </form>
    </div>

    <script>
        /* Logic Toggle Password View */
        const showHiddenPass = (regPass, regEye) =>{
           const input = document.getElementById(regPass),
                 iconEye = document.getElementById(regEye)

           iconEye.addEventListener('click', () =>{
               if(input.type === 'password'){
                   input.type = 'text'
                   iconEye.classList.add('ri-eye-line')
                   iconEye.classList.remove('ri-eye-off-line')
               } else {
                   input.type = 'password'
                   iconEye.classList.remove('ri-eye-line')
                   iconEye.classList.add('ri-eye-off-line')
               }
           })
        }
        showHiddenPass('reg-pass','reg-eye')
    </script>
</body>
</html>