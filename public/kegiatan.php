<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'templates/header.php'; 
?>

    <header class="page-header">
        <div class="container">
            <h1 class="gradient-text">Agenda Kegiatan Masjid</h1>
            <p>Ikuti berbagai kegiatan bermanfaat yang diselenggarakan di Masjid Khairul Bai.</p>
        </div>
    </header>

    <main class="page-content">
        <div class="container">
            <div class="kegiatan-grid">
                <?php
                $query_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan ORDER BY id");
                
                if (!$query_kegiatan) {
                    echo "Error dalam query: " . mysqli_error($koneksi);
                } elseif (mysqli_num_rows($query_kegiatan) > 0) {
                    while ($kegiatan = mysqli_fetch_assoc($query_kegiatan)) {
                ?>
                
                <div class="kegiatan-card animated-element">
                    <div class="card-content">
                        <h3><?php echo htmlspecialchars($kegiatan['nama_kegiatan']); ?></h3>
                        <p><strong>Jadwal:</strong> <?php echo htmlspecialchars($kegiatan['hari']); ?>, <?php echo htmlspecialchars($kegiatan['waktu']); ?></p>
                        <p><strong>Tempat:</strong> <?php echo htmlspecialchars($kegiatan['tempat']); ?></p>
                        <p style="color: var(--dark-text);"><?php echo nl2br(htmlspecialchars($kegiatan['deskripsi'])); ?></p>
                    </div>
                </div>

                <?php 
                    }
                } else {
                ?>
                    <p style="text-align: center; width: 100%;">Belum ada jadwal kegiatan yang ditambahkan. Silakan tambahkan melalui Panel Admin.</p>
                <?php } ?>
            </div>
        </div>
    </main>

<?php include 'templates/footer.php'; ?>