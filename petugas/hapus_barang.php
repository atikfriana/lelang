<?php 
// koneksi database
include '../db/dbconnect.php';

// menangkap data id yang di kirim dari url
$id_barang = $_GET['id_barang'];


// menghapus data dari database
mysqli_query($conn,"delete from tb_barang where id_barang='$id_barang'");

// mengalihkan halaman kembali ke index.php
header("location:barang.php?info=hapus");

?>