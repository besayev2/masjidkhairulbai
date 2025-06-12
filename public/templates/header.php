<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../core/config.php';
require_once '../core/functions.php'; 
// Menggunakan PHP_SELF untuk membaca nama file (e.g., kegiatan.php)
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masjid Khairul Bai - Pusat Kegiatan Islam</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <a href="index.php" class="logo">Masjid Khairul Bai</a>
            
            <nav class="nav-menu">
                <ul>
                    <li><a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Beranda</a></li>
                    <li><a href="jadwal-salat.php" class="<?php echo ($current_page == 'jadwal-salat.php') ? 'active' : ''; ?>">Jadwal Salat</a></li>
                    <li><a href="kegiatan.php" class="<?php echo ($current_page == 'kegiatan.php') ? 'active' : ''; ?>">Kegiatan</a></li>
                    <li><a href="berita.php" class="<?php echo ($current_page == 'berita.php') ? 'active' : ''; ?>">Berita</a></li>
                    <li><a href="galeri.php" class="<?php echo ($current_page == 'galeri.php') ? 'active' : ''; ?>">Galeri</a></li>
                    <li><a href="kontak.php" class="<?php echo ($current_page == 'kontak.php') ? 'active' : ''; ?>">Kontak</a></li>
                    
                

                </ul>
            </nav>

            <div class="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>