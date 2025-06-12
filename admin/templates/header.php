<?php
// Proteksi halaman
if (!isset($_SESSION['admin_login'])) {
    header("Location: index.php");
    exit;
}
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Masjid Khairul Bai</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>