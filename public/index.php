<?php include 'templates/header.php'; ?>

    <section class="hero">
        <div class="hero-content">
            <h1>Selamat Datang di Masjid Khairul Bai</h1>
            <p>Pusat ibadah dan kegiatan keislaman yang modern dan menenangkan.</p>
        </div>
    </section>

    <main class="page-content">
        <div class="container">
            <section class="text-center" style="margin-bottom: 50px;">
                <h2>Memakmurkan Rumah Allah</h2>
                <p style="max-width: 800px; margin: auto;">Masjid Khairul Bai berkomitmen menjadi pusat peradaban Islam di lingkungan sekitar, menyediakan sarana ibadah yang nyaman serta program-program dakwah dan sosial yang bermanfaat bagi umat.</p>
            </section>
            
            <section>
                <h2>Berita & Artikel Terbaru</h2>
                <div class="berita-grid">
                    <?php
                    $query_berita = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY tanggal_publikasi DESC LIMIT 3");
                    while ($berita = mysqli_fetch_assoc($query_berita)):
                    ?>
                    <div class="berita-card">
                        <img src="../uploads/<?php echo $berita['gambar']; ?>" alt="<?php echo $berita['judul']; ?>">
                        <div class="berita-content">
                            <p class="berita-meta"><?php echo date('d M Y', strtotime($berita['tanggal_publikasi'])); ?></p>
                            <h3><a href="detail-berita.php?id=<?php echo $berita['id']; ?>"><?php echo $berita['judul']; ?></a></h3>
                            <p><?php echo potong_teks($berita['konten'], 100); ?></p>
                            <a href="detail-berita.php?id=<?php echo $berita['id']; ?>">Baca Selengkapnya &rarr;</a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>
        </div>
    </main>

<?php include 'templates/footer.php'; ?>