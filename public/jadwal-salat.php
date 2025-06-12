<?php include 'templates/header.php'; ?>

    <header class="page-header">
        <div class="container">
            <h1>Jadwal Salat Harian</h1>
            <p>Jadwal diperbarui secara otomatis berdasarkan lokasi Anda (membutuhkan izin lokasi).</p>
        </div>
    </header>

    <main class="page-content">
        <div class="container">
            <h2 id="lokasi" style="text-align: center;">Memuat lokasi...</h2>
            <div class="jadwal-salat-grid">
                <div class="jadwal-item"><h3>Subuh</h3><p id="subuh">--:--</p></div>
                <div class="jadwal-item"><h3>Dzuhur</h3><p id="dzuhur">--:--</p></div>
                <div class="jadwal-item"><h3>Ashar</h3><p id="ashar">--:--</p></div>
                <div class="jadwal-item"><h3>Maghrib</h3><p id="maghrib">--:--</p></div>
                <div class="jadwal-item"><h3>Isya</h3><p id="isya">--:--</p></div>
            </div>
            <p class="api-info">Jadwal salat disediakan oleh Aladhan.com Prayer Times API.</p>
        </div>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lokasi default jika user tidak memberikan izin
        const defaultLatitude = -7.3297; // Tasikmalaya
        const defaultLongitude = 108.2167; // Tasikmalaya
        const lokasiElement = document.getElementById('lokasi');

        function fetchPrayerTimes(latitude, longitude) {
            const today = new Date();
            const year = today.getFullYear();
            const month = today.getMonth() + 1;
            const apiURL = `https://api.aladhan.com/v1/calendar/${year}/${month}?latitude=${latitude}&longitude=${longitude}&method=2`;

            fetch(apiURL)
                .then(response => response.json())
                .then(data => {
                    // Cari jadwal untuk hari ini
                    const dayOfMonth = today.getDate() - 1; // Array index is 0-based
                    const timings = data.data[dayOfMonth].timings;
                    
                    document.getElementById('subuh').textContent = timings.Fajr;
                    document.getElementById('dzuhur').textContent = timings.Dhuhr;
                    document.getElementById('ashar').textContent = timings.Asr;
                    document.getElementById('maghrib').textContent = timings.Maghrib;
                    document.getElementById('isya').textContent = timings.Isha;
                    
                    // Update lokasi
                    lokasiElement.textContent = `Jadwal untuk: ${data.data[0].meta.timezone}`;
                })
                .catch(error => {
                    console.error('Error fetching prayer times:', error);
                    lokasiElement.textContent = "Gagal memuat jadwal. Menggunakan data default.";
                });
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                fetchPrayerTimes(position.coords.latitude, position.coords.longitude);
            }, () => {
                // User menolak, gunakan lokasi default
                lokasiElement.textContent = "Gagal mendapatkan lokasi. Menampilkan jadwal untuk Tasikmalaya.";
                fetchPrayerTimes(defaultLatitude, defaultLongitude);
            });
        } else {
            // Browser tidak mendukung geolocation
            lokasiElement.textContent = "Browser tidak mendukung geolokasi. Menampilkan jadwal untuk Tasikmalaya.";
            fetchPrayerTimes(defaultLatitude, defaultLongitude);
        }
    });
    </script>

<?php include 'templates/footer.php'; ?>