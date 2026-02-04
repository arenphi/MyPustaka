<?php
// Cek status login
$is_login = isset($_SESSION['user_data']);
$user = $is_login ? $_SESSION['user_data'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPustaka</title>

    <link rel="icon" type="image/svg+xml" 
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23775CA7'><path d='M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z'/></svg>">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>

<header class="header">
    <nav class="nav container">
        <a href="<?= $base_url ?>index.php" class="nav__logo">
            <i class="bi bi-book-half"></i> 
            <span class="appname">MyPustaka</span>
        </a>

        <div class="nav__menu" id="nav-menu">
            <ul class="nav__list">
                <li><a href="<?= $base_url ?>index.php" class="nav__link active">Beranda</a></li>
                
                <?php if($is_login): ?>
                    <li class="dropdown__item">
                        <div class="nav__link">
                            Laporan <i class="bi bi-chevron-down dropdown__arrow"></i>
                        </div>
                        <ul class="dropdown__menu">
                            <li><a href="<?= $base_url ?>laporan/resi.php" class="dropdown__link"><i class="bi bi-ticket-perforated"></i> Resi</a></li>
                            <li><a href="<?= $base_url ?>laporan/riwayat.php" class="dropdown__link"><i class="bi bi-clock-history"></i> Riwayat</a></li>
                        </ul>
                    </li>

        <div class="nav__search">
            <form action="<?= $base_url ?>modules/buku.php" method="GET">
                <input type="text" name="cari" placeholder="Cari buku..." class="search__input">
                <button type="submit" class="search__button">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

                    <li>
                        <a href="<?= $base_url ?>profile.php" class="nav__link nav__profile">
                        </a>

                    </li>

                   <li class="dropdown__item">
                        <div class="nav__link">
                            <i class="bi bi-person-circle"></i> <span><?= explode(' ', $user['nama_lengkap'])[0] ?></span>
                            <i class="bi bi-chevron-down dropdown__arrow"></i>
                        </div>
                        <ul class="dropdown__menu">
                            <li><a href="<?= $base_url ?>profil.php" class="dropdown__link"><i class="bi bi-person"></i> Profil</a></li>
                            <li><a href="<?= $base_url ?>logout.php" class="dropdown__link text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                        </ul>
                    </li>

                <?php else: ?>
                    <li><a href="<?= $base_url ?>login.php" class="nav__link login-btn"><i class="bi bi-person"></i> Login</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="nav__toggle" id="nav-toggle">
            <i class="bi bi-list nav__burger"></i>
        </div>
    </nav>
</header>