<?php 
// koneksi database
include "../db/dbconnect.php";

// menangkap data id yang di kirim dari url
$id_petugas = $_GET['id_petugas'];

// menghapus data dari database
mysqli_query($conn,"delete from tb_petugas where id_petugas='$id_petugas'");

// mengalihkan halaman kembali ke index.php
header("location:petugas.php?info=hapus");

?>