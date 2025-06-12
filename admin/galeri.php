<?php
session_start();
require_once '../core/config.php';
require_once 'templates/header.php';

$upload_dir = '../uploads/';

// Logika untuk proses data (Tambah)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {
    $judul_foto = $_POST['judul_foto'];
    $nama_file = '';

    if (isset($_FILES['nama_file']) && $_FILES['nama_file']['error'] == 0) {
        $nama_file = time() . '_' . basename($_FILES["nama_file"]["name"]);
        if (move_uploaded_file($_FILES['nama_file']['tmp_name'], $upload_dir . $nama_file)) {
            $query = "INSERT INTO galeri (judul_foto, nama_file) VALUES ('$judul_foto', '$nama_file')";
            mysqli_query($koneksi, $query);
        }
    }
    header('Location: galeri.php');
    exit;
}

// Logika Hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    // Ambil nama file untuk dihapus dari folder uploads
    $res = mysqli_query($koneksi, "SELECT nama_file FROM galeri WHERE id=$id");
    if($data = mysqli_fetch_assoc($res)){
        if($data['nama_file'] && file_exists($upload_dir . $data['nama_file'])){
            unlink($upload_dir . $data['nama_file']); // Hapus file fisik
        }
    }
    mysqli_query($koneksi, "DELETE FROM galeri WHERE id=$id"); // Hapus data dari database
    header('Location: galeri.php');
    exit;
}
?>

<div class="main-content">
    <h1>Manajemen Galeri</h1>
    
    <div class="card">
        <h2>Upload Foto Baru</h2>
        <form action="galeri.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Judul Foto</label>
                <input type="text" name="judul_foto" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Pilih File Gambar</label>
                <input type="file" name="nama_file" class="form-control" required accept="image/*">
            </div>
            <button type="submit" name="tambah" class="btn-add">Upload Foto</button>
        </form>
    </div>

    <div class="card">
        <h2>Daftar Foto Galeri</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Preview</th>
                    <th>Judul Foto</th>
                    <th>Tanggal Upload</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($koneksi, "SELECT * FROM galeri ORDER BY id DESC");
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)):
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><img src="<?php echo $upload_dir . $row['nama_file']; ?>" width="100" alt="<?php echo $row['judul_foto']; ?>"></td>
                    <td><?php echo $row['judul_foto']; ?></td>
                    <td><?php echo date('d M Y, H:i', strtotime($row['tanggal_upload'])); ?></td>
                    <td>
                        <a href="?hapus=<?php echo $row['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Yakin ingin menghapus foto ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>