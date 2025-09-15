<?php 

include "koneksi.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "DELETE FROM siswa WHERE id = '$id'";
    $query = mysqli_query($conn, $sql);

    if($conn->query($sql) === TRUE){
        echo "Data berhasil di hapus";
        echo "<br>";
        echo "<a href='index.php'>kembali</a>";
    }
    else{
        echo "data gagal dihapus";
    }
}




?>