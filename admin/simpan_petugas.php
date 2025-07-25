<?php 
// koneksi database
include "../db/dbconnect.php";

// menangkap data yang di kirim dari form
$nama_petugas = $_POST['nama_petugas'];
$username = $_POST['username'];
$password = $_POST['password'];
$id_level = $_POST['id_level'];

// menginput data ke database
mysqli_query($conn,"insert into tb_petugas values('','$nama_petugas','$username','$password','$id_level')");

// mengalihkan halaman kembali ke index.php
header("location:petugas.php?info=simpan");

?>