<?php
// Fungsi untuk memotong teks agar tidak terlalu panjang (untuk preview berita)
function potong_teks($teks, $panjang) {
    if (strlen($teks) > $panjang) {
        $teks = substr($teks, 0, $panjang);
        $teks .= '...';
    }
    return $teks;
}
?>