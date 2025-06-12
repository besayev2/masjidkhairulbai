<footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Masjid Khairul Bai. All Rights Reserved. | <a href="#" id="login-trigger">Login Admin</a></p>
        </div>
    </footer>

    <div class="modal-overlay" id="login-modal">
        <div class="modal-content">
            <button class="modal-close" id="login-modal-close">&times;</button>
            <h3>Login Panel Admin</h3>
            <p>Silakan masukkan kredensial Anda.</p>
            
            <?php
            // Menampilkan pesan error jika login gagal dari halaman ini
            // session_start() sudah ada di header.php, jadi tidak perlu lagi
            if (isset($_SESSION['error_message'])):
            ?>
            <div class="error-msg">
                <?php 
                echo $_SESSION['error_message']; 
                unset($_SESSION['error_message']); // Hapus pesan setelah ditampilkan
                ?>
            </div>
            <?php endif; ?>

            <form action="../admin/auth.php" method="POST" class="modal-form">
                <input type="hidden" name="source" value="homepage">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" name="login" class="btn-modern">Login</button>
            </form>
        </div>
    </div>
    <script>
        // Script untuk Toggle Menu Hamburger (SUDAH ADA)
        const menuToggle = document.querySelector('.menu-toggle');
        const navMenu = document.querySelector('.nav-menu');

        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            menuToggle.classList.toggle('active');
        });

        // Script untuk Animasi Saat Scroll (SUDAH ADA)
        const animatedElements = document.querySelectorAll('.animated-element');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, { threshold: 0.1 });
        animatedElements.forEach(element => { observer.observe(element); });
        
        // =======================================================
        //          JAVASCRIPT BARU UNTUK MODAL LOGIN
        // =======================================================
        const loginTrigger = document.getElementById('login-trigger');
        const loginModal = document.getElementById('login-modal');
        const loginModalClose = document.getElementById('login-modal-close');

        // Fungsi untuk membuka modal
        function openLoginModal() {
            loginModal.classList.add('active');
        }

        // Fungsi untuk menutup modal
        function closeLoginModal() {
            loginModal.classList.remove('active');
        }

        // Event listener untuk tombol pemicu
        loginTrigger.addEventListener('click', (e) => {
            e.preventDefault(); // Mencegah link berpindah halaman
            openLoginModal();
        });

        // Event listener untuk tombol close (X)
        loginModalClose.addEventListener('click', closeLoginModal);

        // Event listener untuk menutup modal saat mengklik area gelap di luar
        loginModal.addEventListener('click', (e) => {
            if (e.target === loginModal) {
                closeLoginModal();
            }
        });

        // Cek jika ada parameter ?login_error=1 di URL, langsung buka modal
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('login_error')) {
            openLoginModal();
        }

    </script>
</body>
</html>