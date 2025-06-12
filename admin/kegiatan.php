<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../core/config.php';
require_once 'templates/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kegiatan = mysqli_real_escape_string($koneksi, $_POST['nama_kegiatan']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $hari = mysqli_real_escape_string($koneksi, $_POST['hari']);
    $waktu = mysqli_real_escape_string($koneksi, $_POST['waktu']);
    $tempat = mysqli_real_escape_string($koneksi, $_POST['tempat']);

    if (isset($_POST['tambah'])) {
        $query = "INSERT INTO kegiatan (nama_kegiatan, deskripsi, hari, waktu, tempat) VALUES ('$nama_kegiatan', '$deskripsi', '$hari', '$waktu', '$tempat')";
        mysqli_query($koneksi, $query);
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $query = "UPDATE kegiatan SET nama_kegiatan='$nama_kegiatan', deskripsi='$deskripsi', hari='$hari', waktu='$waktu', tempat='$tempat' WHERE id=$id";
        mysqli_query($koneksi, $query);
    }
    header('Location: kegiatan.php');
    exit;
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM kegiatan WHERE id=$id");
    header('Location: kegiatan.php');
    exit;
}
?>

<div class="main-content">
    <h1>Manajemen Kegiatan</h1>
    <?php if (isset($_GET['action'])): ?>
        <?php
        $is_edit = $_GET['action'] == 'edit';
        $data = null;
        if ($is_edit) {
            $id = $_GET['id'];
            $result = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE id=$id");
            $data = mysqli_fetch_assoc($result);
        }
        ?>
        <div class="card">
            <h2><?php echo $is_edit ? 'Edit' : 'Tambah'; ?> Kegiatan</h2>
            <form action="kegiatan.php" method="POST">
                <?php if ($is_edit): ?>
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                <?php endif; ?>
                <div class="form-group">
                    <label>Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($data['nama_kegiatan']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"><?php echo $is_edit ? htmlspecialchars($data['deskripsi']) : ''; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Hari</label>
                    <input type="text" name="hari" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($data['hari']) : ''; ?>" required placeholder="Contoh: Setiap Hari, Jumat Pagi">
                </div>
                <div class="form-group">
                    <label>Waktu</label>
                    <input type="text" name="waktu" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($data['waktu']) : ''; ?>" required placeholder="Contoh: Ba'da Maghrib, 08:00 - 09:30 WIB">
                </div>
                <div class="form-group">
                    <label>Tempat</label>
                    <input type="text" name="tempat" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($data['tempat']) : ''; ?>" required>
                </div>
                <button type="submit" name="<?php echo $is_edit ? 'edit' : 'tambah'; ?>" class="btn-add"><?php echo $is_edit ? 'Simpan Perubahan' : 'Tambah Kegiatan'; ?></button>
                <a href="kegiatan.php" class="btn-delete" style="background-color: #6c757d;">Batal</a>
            </form>
        </div>
    <?php else: ?>
        <a href="?action=tambah" class="btn-add">Tambah Kegiatan Baru</a>
        <div class="card">
            <h2>Daftar Kegiatan</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Hari</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($koneksi, "SELECT * FROM kegiatan ORDER BY id DESC");
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)):
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row['nama_kegiatan']); ?></td>
                        <td><?php echo htmlspecialchars($row['hari']); ?></td>
                        <td><?php echo htmlspecialchars($row['waktu']); ?></td>
                        <td>
                            <a href="?action=edit&id=<?php echo $row['id']; ?>" class="action-btn btn-edit">Edit</a>
                            <a href="?hapus=<?php echo $row['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?php require_once 'templates/footer.php'; ?>