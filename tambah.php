<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama   = trim($_POST['nama'] ?? '');
  $kelas  = trim($_POST['kelas'] ?? '');
  $jurusan= trim($_POST['jurusan'] ?? '');
  $email  = trim($_POST['email'] ?? '');
  $nohp   = trim($_POST['nohp'] ?? '');

  // proses upload foto (opsional)
  $fotoName = null;
  if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $allowed = ['image/jpeg','image/png','image/gif','image/webp'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    if ($_FILES['foto']['size'] <= $maxSize && in_array($_FILES['foto']['type'], $allowed)) {
      $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
      $fotoName = time() . '_' . bin2hex(random_bytes(5)) . '.' . $ext;
      if (!is_dir('uploads')) mkdir('uploads', 0755, true);
      move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/' . $fotoName);
    } else {
      $fotoName = null; // bisa tambahkan error handling
    }
  }

  // insert ke DB
  $stmt = $conn->prepare("INSERT INTO siswa (nama, foto, kelas, jurusan, email, nohp) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssss", $nama, $fotoName, $kelas, $jurusan, $email, $nohp);
  $stmt->execute();
  $stmt->close();

  header('Location: index.php');
  exit;
}
?>
<!doctype html>
<html lang="id">
<head><meta charset="utf-8"><title>Tambah Siswa</title><link rel="stylesheet" href="style.css"></head>
<body>
  <h1>Tambah Siswa</h1>
  <form method="post" enctype="multipart/form-data">
    <label>Nama <input type="text" name="nama" required></label><br>
    <label>Foto <input type="file" name="foto" accept="image/*"></label><br>
    <label>Kelas <input type="text" name="kelas"></label><br>
    <label>Jurusan <input type="text" name="jurusan"></label><br>
    <label>Email <input type="email" name="email"></label><br>
    <label>No HP <input type="text" name="nohp"></label><br>
    <button type="submit">Simpan</button> <a href="index.php">Batal</a>
  </form>
</body>
</html>
