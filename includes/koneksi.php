<?php
$host = "localhost"; // Ganti dengan host dari hosting Anda
$user = "root"; // Username database hosting
$pass = ""; // Password database hosting
$db   = "mypustaka"; // Nama database

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$base_url = "http://localhost/mypustaka/";
?>