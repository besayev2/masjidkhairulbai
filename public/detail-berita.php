<?php 
// Memasukkan file header, koneksi, dan fungsi
include 'templates/header.php'; 

// Mengambil ID dari URL dengan aman, memastikan itu adalah angka
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Hanya jalankan query jika ID valid (lebih dari 0)
if ($id > 0) {
    // Mengambil data berita dan juga nama penulis dari tabel 'users' menggunakan JOIN
    $query = mysqli_query($koneksi, "SELECT berita.*, users.nama_lengkap FROM berita JOIN users ON berita.user_id = users.id WHERE berita.id=$id");
    $berita = mysqli_fetch_assoc($query);
} else {
    $berita = null;
}

// Jika data berita dengan ID tersebut tidak ditemukan di database, tampilkan pesan error
if (!$berita):
?>
    <header class="page-header">
        <div class="container">
            <h1 class="gradient-text">Berita Tidak Ditemukan</h1>
            <p>Maaf, berita yang Anda cari tidak ada atau mungkin telah dihapus.</p>
            <a href="berita.php" style="display:inline-block; margin-top: 20px; font-weight: 500;">← Kembali ke Daftar Berita</a>
        </div>
    </header>

<?php else: // Namun, jika berita ditemukan, tampilkan kontennya di bawah ini ?>

    <header class="page-header" style="padding-bottom: 20px;">
        <div class="container">
            <h1 class="gradient-text"><?php echo htmlspecialchars($berita['judul']); ?></h1>
            <p class="berita-meta">
                Dipublikasikan pada <?php echo date('d F Y', strtotime($berita['tanggal_publikasi'])); ?> oleh <?php echo htmlspecialchars($berita['nama_lengkap']); ?>
            </p>
        </div>
    </header>

    <main class="page-content" style="padding-top: 20px;">
        <div class="container" style="max-width: 800px;">
            <img src="../uploads/<?php echo htmlspecialchars($berita['gambar']); ?>" alt="<?php echo htmlspecialchars($berita['judul']); ?>" class="berita-detail-img" style="width:100%; height:auto; border-radius:8px; margin-bottom: 30px;">
            
            <article style="font-size: 1.1em; line-height: 1.8;">
                <?php echo nl2br(htmlspecialchars($berita['konten'])); // nl2br berfungsi agar baris baru (enter) tetap tampil di HTML ?>
            </article>

            <a href="berita.php" style="display:inline-block; margin-top: 40px; font-weight: 500;">← Kembali ke Daftar Berita</a>
        </div>
    </main>

<?php 
endif; // Akhir dari pengecekan `if (!$berita)`

// Memasukkan file footer
include 'templates/footer.php'; 
?>