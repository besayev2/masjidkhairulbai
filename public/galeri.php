<?php include 'templates/header.php'; ?>

    <header class="page-header">
        <div class="container">
            <h1>Galeri Kegiatan</h1>
            <p>Dokumentasi momen-momen berharga dari berbagai kegiatan di Masjid Khairul Bai.</p>
        </div>
    </header>

    <main class="page-content">
        <div class="container">
            <div class="galeri-grid">
                <?php
                $query_galeri = mysqli_query($koneksi, "SELECT * FROM galeri ORDER BY id DESC");
                if (mysqli_num_rows($query_galeri) > 0):
                    while ($foto = mysqli_fetch_assoc($query_galeri)):
                ?>
                <div class="galeri-item">
                    <img src="../uploads/<?php echo $foto['nama_file']; ?>" alt="<?php echo $foto['judul_foto']; ?>">
                    <div class="overlay">
                        <h3><?php echo $foto['judul_foto']; ?></h3>
                    </div>
                </div>
                <?php 
                    endwhile;
                else:
                ?>
                    <p>Belum ada foto di dalam galeri.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

<?php include 'templates/footer.php'; ?>