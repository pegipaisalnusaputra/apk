<?php
// Detail koneksi database
$host = 'localhost';
$user = 'root'; // Ganti jika username berbeda
$pass = ''; // Ganti jika ada password
$dbname = 'db_client';

// Buat koneksi ke database
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>
