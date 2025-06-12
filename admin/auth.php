<?php
session_start();
require_once '../core/config.php';

// Proses Login
if (isset($_POST['login'])) {
    // Ambil info dari mana form di-submit
    $source_page = $_POST['source'] ?? 'admin_page';

    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $result = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            // Set session
            $_SESSION['admin_login'] = true;
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_nama'] = $row['nama_lengkap'];
            header("Location: index.php"); // Jika berhasil, selalu ke dashboard admin
            exit;
        }
    }
    
    // Jika sampai di sini, artinya login gagal
    $_SESSION['error_message'] = "Username atau password salah!";
    
    // Arahkan kembali sesuai halaman asal
    if ($source_page === 'homepage') {
        // Redirect kembali ke homepage dengan penanda error
        header("Location: ../public/index?login_error=1");
    } else {
        // Redirect kembali ke halaman login admin
        header("Location: index.php");
    }
    exit;
}

// Proses Logout
if (isset($_GET['logout'])) {
    session_start();
    $_SESSION = [];
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
?>