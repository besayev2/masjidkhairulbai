<?php
session_start();
require_once '../core/config.php';
require_once 'templates/header.php';

// Logika untuk proses data (Tambah, Edit, Hapus)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];

    if (isset($_POST['tambah'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query = "INSERT INTO users (nama_lengkap, username, password) VALUES ('$nama_lengkap', '$username', '$password')";
        mysqli_query($koneksi, $query);
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        // Cek apakah password diisi atau tidak
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $query = "UPDATE users SET nama_lengkap='$nama_lengkap', username='$username', password='$password' WHERE id=$id";
        } else {
            // Jika password kosong, jangan update password
            $query = "UPDATE users SET nama_lengkap='$nama_lengkap', username='$username' WHERE id=$id";
        }
        mysqli_query($koneksi, $query);
    }
    header('Location: user.php');
    exit;
}

// Logika Hapus (mencegah user menghapus diri sendiri)
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id != $_SESSION['admin_id']) { // User tidak bisa menghapus akunnya sendiri
        mysqli_query($koneksi, "DELETE FROM users WHERE id=$id");
    }
    header('Location: user.php');
    exit;
}
?>

<div class="main-content">
    <h1>Manajemen Admin</h1>

    <?php if (isset($_GET['action'])): ?>
        <?php
        $is_edit = $_GET['action'] == 'edit';
        $data = null;
        if ($is_edit) {
            $id = $_GET['id'];
            $result = mysqli_query($koneksi, "SELECT * FROM users WHERE id=$id");
            $data = mysqli_fetch_assoc($result);
        }
        ?>
        <div class="card">
            <h2><?php echo $is_edit ? 'Edit' : 'Tambah'; ?> Admin</h2>
            <form action="user.php" method="POST">
                <?php if ($is_edit): ?>
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                <?php endif; ?>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?php echo $is_edit ? $data['nama_lengkap'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $is_edit ? $data['username'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" <?php echo !$is_edit ? 'required' : ''; ?>>
                    <?php if ($is_edit): ?>
                        <small style="color: #aaa;">Kosongkan jika tidak ingin mengubah password.</small>
                    <?php endif; ?>
                </div>
                <button type="submit" name="<?php echo $is_edit ? 'edit' : 'tambah'; ?>" class="btn-add"><?php echo $is_edit ? 'Simpan Perubahan' : 'Tambah Admin'; ?></button>
                <a href="user.php" class="btn-delete">Batal</a>
            </form>
        </div>
    <?php else: ?>
        <a href="?action=tambah" class="btn-add">Tambah Admin Baru</a>
        <div class="card">
            <h2>Daftar Admin</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)):
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['nama_lengkap']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td>
                            <a href="?action=edit&id=<?php echo $row['id']; ?>" class="action-btn btn-edit">Edit</a>
                            <?php if ($row['id'] != $_SESSION['admin_id']): // Tombol hapus tidak muncul untuk user yg sedang login ?>
                            <a href="?hapus=<?php echo $row['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Yakin ingin menghapus admin ini?')">Hapus</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'templates/footer.php'; ?>