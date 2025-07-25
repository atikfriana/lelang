<?php 
// koneksi database
include '../db/dbconnect.php';

// menangkap data yang di kirim dari form
$id_barang = $_POST['id_barang'];
$tgl_lelang = date('Y-m-d');
$id_petugas = $_POST['id_petugas'];

// menginput data ke database
mysqli_query($conn,"insert into tb_lelang values('','$id_barang','$tgl_lelang','','','$id_petugas','')");

// mengalihkan halaman kembali ke index.php
header("location:aktivasi.php?info=simpan");

?>