<?php
include 'koneksi.php';

if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $npm  = mysqli_real_escape_string($conn, $_POST['npm']);
    mysqli_query($conn, "INSERT INTO mahasiswa (nama, npm) VALUES ('$nama', '$npm')");
    header("Location: index.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id=$id");
    header("Location: index.php");
    exit;
}

$edit = false;
$row_edit = ['nama' => '', 'npm' => '', 'id' => ''];
if (isset($_GET['edit'])) {
    $edit = true;
    $id_edit = (int) $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id=$id_edit");
    $row_edit = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $id = (int) $_POST['id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $npm  = mysqli_real_escape_string($conn, $_POST['npm']);
    mysqli_query($conn, "UPDATE mahasiswa SET nama='$nama', npm='$npm' WHERE id=$id");
    header("Location: index.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM mahasiswa ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CRUD Mahasiswa - Pertemuan 11</title>
    <link rel="stylesheet" href="style.css?v=1">
</head>
<body>
    <h2>Data Mahasiswa</h2>
    
    <form action="" method="POST">
        <input type="hidden" name="id" value="<?= $row_edit['id']; ?>">
        <input type="text" name="nama" placeholder="Nama Mahasiswa" value="<?= $row_edit['nama']; ?>" required>
        <input type="text" name="npm" placeholder="NPM" value="<?= $row_edit['npm']; ?>" required>

        <?php if ($edit): ?>
            <button type="submit" name="update">Update Data</button>
            <a href="index.php" style="margin-left:10px; color:gray;">Batal</a>
        <?php else: ?>
            <button type="submit" name="tambah">Tambah Data</button>
        <?php endif; ?>
    </form>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>NPM</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($data)) : ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['npm']; ?></td>
                <td>
                    <a href="index.php?edit=<?= $row['id']; ?>">Edit</a> | 
                    <a href="index.php?hapus=<?= $row['id']; ?>" class="btn-hapus" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>