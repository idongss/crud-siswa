<?php
session_start();
include "koneksi.php";

$result = $conn->query("SELECT * FROM siswa");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
</head>
<style>
    body{
        padding: 20px;
         }

    table{
        border-collapse: collapse;
        width: 50px;
        margin: 0 auto;
    }
    th,td{
        border: 1px solid black;
        padding: 8px 12px;
        text-align: center;
    }
    th{
        background-color: #eee;
    }
   .btn-tambah {
    display: inline-block;
    padding: 10px 20px;
    background: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
}
.btn-tambah:hover {
    background: #45a049;
}

</style>

<body>
    <div class="container">
        <table border="4">
            <tr bgcolor="silver">
                <td>Nama</td>
                <td>Foto</td>
                <td>Kelas</td>
                <td>Jurusan</td>
                <td>Email</td>
                <td>Nomor Hp</td>
                <td>Aksi</td>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['nama'] ?></td>
                    <td> <img src="uploads/<?= $row['foto'] ?>" width="70px" height="70px"></td>
                    <td><?= $row['kelas'] ?></td>
                    <td><?= $row['jurusan'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['nohp'] ?></td>

                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>">edit</a>
                        <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin mau hapus?')">hapus</a>
                    </td>
                </tr>
            <?php } ?>

        </table>

      <div style="text-align:center; margin-top:15px;">
    <a href="tambah.php" class="btn-tambah">Tambah Data</a>
</div>

    </div>
</body>

</html>