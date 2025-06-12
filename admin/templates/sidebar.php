<div class="sidebar">
    <h2>Masjid Khairul Bai</h2>
    <nav class="sidebar-menu">
        <ul>
            <li><a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Dashboard</a></li>
            <li><a href="kegiatan.php" class="<?php echo ($current_page == 'kegiatan.php') ? 'active' : ''; ?>">Kegiatan</a></li>
            <li><a href="berita.php" class="<?php echo ($current_page == 'berita.php') ? 'active' : ''; ?>">Berita</a></li>
            <li><a href="galeri.php" class="<?php echo ($current_page == 'galeri.php') ? 'active' : ''; ?>">Galeri</a></li>
            <li><a href="user.php" class="<?php echo ($current_page == 'user.php') ? 'active' : ''; ?>">Manajemen Admin</a></li>
            <li class="logout"><a href="auth.php?logout=true">Logout</a></li>
        </ul>
    </nav>
</div>