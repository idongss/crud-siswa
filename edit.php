<?php
require 'koneksi.php';

// Jika form disubmit (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id      = (int)$_POST['id'];   // ambil id dari hidden input!
    $nama    = $_POST['nama'];
    $kelas   = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $email   = $_POST['email'];
    $nohp    = $_POST['nohp'];

    // contoh update sederhana (tanpa upload foto)
    $stmt = $conn->prepare(
        "UPDATE siswa SET nama=?, kelas=?, jurusan=?, email=?, nohp=? WHERE id=?"
    );
    $stmt->bind_param('sssssi', $nama, $kelas, $jurusan, $email, $nohp, $id);
    $stmt->execute();

    echo "Data berhasil diupdate. <a href='index.php'>Kembali</a>";
    exit;
}

// ----- Jika GET: tampilkan data -----
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM siswa WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$data   = $result->fetch_assoc();

if (!$data) { die("Data tidak ditemukan."); }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Data siswa</title>
</head>
<body>
<h2>Edit Data siswa</h2>

<form action="edit.php" method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']); ?>">
    <input type="hidden" name="created_at" value="<?= htmlspecialchars($data['created_at']); ?>">

    <label>Nama:</label><br>
    <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" required><br><br>

    <label>Foto (ganti bila perlu):</label><br>
    <input type="file" name="foto"><br>
    <small>Foto sekarang:</small><br>
    <img src="uploads/<?= htmlspecialchars($data['foto']); ?>" width="100"><br><br>

    <label>Kelas:</label><br>
    <input type="text" name="kelas" value="<?= htmlspecialchars($data['kelas']); ?>" required><br><br>

    <label>Jurusan:</label><br>
    <input type="text" name="jurusan" value="<?= htmlspecialchars($data['jurusan']); ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($data['email']); ?>" required><br><br>

    <label>No HP:</label><br>
    <input type="text" name="nohp" value="<?= htmlspecialchars($data['nohp']); ?>" required><br><br>

    <button type="submit">Update</button>
</form>

</body>
</html>
