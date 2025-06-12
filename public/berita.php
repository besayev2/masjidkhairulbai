<?php include 'templates/header.php'; ?>

    <header class="page-header">
        <div class="container">
            <h1 class="gradient-text">Berita & Informasi</h1>
            <p>Simak kabar terbaru seputar kegiatan dan informasi dari Masjid Khairul Bai.</p>
        </div>
    </header>

    <main class="page-content">
        <div class="container">
            <div class="berita-grid">
                <?php
                // Ambil semua berita dari database, urutkan dari yang terbaru
                $query_berita = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY tanggal_publikasi DESC");
                if (mysqli_num_rows($query_berita) > 0):
                    while ($berita = mysqli_fetch_assoc($query_berita)):
                ?>
                <div class="berita-card animated-element">
                    <a href="detail-berita.php?id=<?php echo $berita['id']; ?>">
                        <img src="../uploads/<?php echo htmlspecialchars($berita['gambar']); ?>" alt="<?php echo htmlspecialchars($berita['judul']); ?>">
                    </a>
                    <div class="berita-content">
                        <p class="berita-meta"><?php echo date('d F Y', strtotime($berita['tanggal_publikasi'])); ?></p>
                        <h3><a href="detail-berita.php?id=<?php echo $berita['id']; ?>"><?php echo htmlspecialchars($berita['judul']); ?></a></h3>
                        <p><?php echo potong_teks(htmlspecialchars($berita['konten']), 120); ?></p>
                        <a href="detail-berita.php?id=<?php echo $berita['id']; ?>" class="read-more">Baca Selengkapnya →</a>
                    </div>
                </div>
                <?php 
                    endwhile;
                else:
                ?>
                    <p>Belum ada berita yang dipublikasikan.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

<?php include 'templates/footer.php'; ?>