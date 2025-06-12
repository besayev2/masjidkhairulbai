<?php
// Atur zona waktu
date_default_timezone_set('Asia/Jakarta');

// Detail koneksi database
$db_host = 'localhost';
$db_user = 'root'; // Sesuaikan dengan username database Anda
$db_pass = '';     // Sesuaikan dengan password database Anda
$db_name = 'db_masjid_khairul_bai';

// Membuat koneksi ke database
$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// URL dasar website (untuk link absolut)
define('BASE_URL', 'http://localhost/masjid-khairul-bai/');
?>