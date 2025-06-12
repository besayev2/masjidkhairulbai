<?php
session_start();
require_once '../core/config.php';
require_once 'templates/header.php';

$upload_dir = '../uploads/';

// Logika untuk proses data (Tambah, Edit)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $konten = $_POST['konten'];
    $user_id = $_SESSION['admin_id'];
    $gambar_lama = $_POST['gambar_lama'] ?? null;
    $gambar_nama = $gambar_lama;

    // Logika upload gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        // Hapus gambar lama jika ada
        if ($gambar_lama && file_exists($upload_dir . $gambar_lama)) {
            unlink($upload_dir . $gambar_lama);
        }
        $gambar_nama = time() . '_' . basename($_FILES["gambar"]["name"]);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_dir . $gambar_nama);
    }

    if (isset($_POST['tambah'])) {
        $query = "INSERT INTO berita (judul, konten, gambar, user_id) VALUES ('$judul', '$konten', '$gambar_nama', $user_id)";
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $query = "UPDATE berita SET judul='$judul', konten='$konten', gambar='$gambar_nama' WHERE id=$id";
    }
    mysqli_query($koneksi, $query);
    header('Location: berita.php');
    exit;
}

// Logika Hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    // Ambil nama file gambar untuk dihapus
    $res = mysqli_query($koneksi, "SELECT gambar FROM berita WHERE id=$id");
    if($data = mysqli_fetch_assoc($res)){
        if($data['gambar'] && file_exists($upload_dir . $data['gambar'])){
            unlink($upload_dir . $data['gambar']);
        }
    }
    mysqli_query($koneksi, "DELETE FROM berita WHERE id=$id");
    header('Location: berita.php');
    exit;
}
?>

<div class="main-content">
    <h1>Manajemen Berita</h1>

    <?php if (isset($_GET['action'])): ?>
        <?php
        $is_edit = $_GET['action'] == 'edit';
        $data = null;
        if ($is_edit) {
            $id = $_GET['id'];
            $result = mysqli_query($koneksi, "SELECT * FROM berita WHERE id=$id");
            $data = mysqli_fetch_assoc($result);
        }
        ?>
        <div class="card">
            <h2><?php echo $is_edit ? 'Edit' : 'Tambah'; ?> Berita</h2>
            <form action="berita.php" method="POST" enctype="multipart/form-data">
                <?php if ($is_edit): ?>
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                    <input type="hidden" name="gambar_lama" value="<?php echo $data['gambar']; ?>">
                <?php endif; ?>
                <div class="form-group">
                    <label>Judul Berita</label>
                    <input type="text" name="judul" class="form-control" value="<?php echo $is_edit ? $data['judul'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Konten</label>
                    <textarea name="konten" class="form-control"><?php echo $is_edit ? $data['konten'] : ''; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Gambar Unggulan</label>
                    <input type="file" name="gambar" class="form-control">
                    <?php if ($is_edit && $data['gambar']): ?>
                        <p style="margin-top:10px;">Gambar saat ini: <img src="<?php echo $upload_dir . $data['gambar']; ?>" width="100"></p>
                    <?php endif; ?>
                </div>
                <button type="submit" name="<?php echo $is_edit ? 'edit' : 'tambah'; ?>" class="btn-add"><?php echo $is_edit ? 'Simpan Perubahan' : 'Terbitkan Berita'; ?></button>
                <a href="berita.php" class="btn-delete">Batal</a>
            </form>
        </div>
    <?php else: ?>
        <a href="?action=tambah" class="btn-add">Tulis Berita Baru</a>
        <div class="card">
            <h2>Daftar Berita</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Tanggal Publikasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id DESC");
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)):
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['judul']; ?></td>
                        <td><?php echo date('d M Y, H:i', strtotime($row['tanggal_publikasi'])); ?></td>
                        <td>
                            <a href="?action=edit&id=<?php echo $row['id']; ?>" class="action-btn btn-edit">Edit</a>
                            <a href="?hapus=<?php echo $row['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Yakin ingin menghapus berita ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'templates/footer.php'; ?>