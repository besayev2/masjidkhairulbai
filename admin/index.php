<?php
session_start();
require_once '../core/config.php';

// Cek jika sudah login, redirect ke dashboard
if (isset($_SESSION['admin_login'])) {
    // Ambil data untuk statistik
    $jumlah_berita = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM berita"))['total'];
    $jumlah_kegiatan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM kegiatan"))['total'];
    $jumlah_galeri = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM galeri"))['total'];
    
    // Tampilkan halaman Dashboard
    include 'templates/header.php';
    ?>
    <div class="main-content">
        <h1>Dashboard</h1>
        <div class="card">
            <h2>Selamat Datang, <?php echo $_SESSION['admin_nama']; ?>!</h2>
            <p>Ini adalah halaman panel admin untuk mengelola konten website Masjid Khairul Bai.</p>
        </div>

        <div class="card">
            <h2>Statistik Konten</h2>
            <p><strong>Total Berita:</strong> <?php echo $jumlah_berita; ?> artikel</p>
            <p><strong>Total Kegiatan:</strong> <?php echo $jumlah_kegiatan; ?> agenda</p>
            <p><strong>Total Foto Galeri:</strong> <?php echo $jumlah_galeri; ?> foto</p>
        </div>
    </div>
    <?php
    include 'templates/footer.php';
    exit; // Hentikan script agar form login tidak ditampilkan
}

// Tampilkan halaman Login jika belum login
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Masjid Khairul Bai</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>Admin Panel</h1>
            <p>Masjid Khairul Bai</p>
            <hr style="border-color: #333; margin: 15px 0;">
            
            <?php 
            if(isset($_SESSION['error_message'])){
                echo '<div class="error-msg">'.$_SESSION['error_message'].'</div>';
                unset($_SESSION['error_message']);
            }
            ?>

            <form action="auth.php" method="POST">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" name="login" class="btn-login">Login</button>
            </form>
        </div>
    </div>
</body>
</html>