<?php

include '../db/dbconnect.php';

$nama_lengkap = $_POST['nama_lengkap'];
$username = $_POST['username'];
$password = $_POST['password'];
$telp = $_POST['telp'];

mysqli_query($conn, "INSERT INTO tb_masyarakat VALUES('', '$nama_lengkap', '$username', '$password', '$telp')");

header("location:login.php?info=daftar");