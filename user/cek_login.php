<?php
session_start();

include '../db/dbconnect.php';

$username = $_POST['username'];
$password = $_POST['password'];

$data = mysqli_query($conn, "SELECT * FROM tb_masyarakat WHERE username='$username' AND password='$password'");

$cek = mysqli_num_rows($data);

if ($cek > 0) {
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $_SESSION['status'] = "login";
    header("location:index.php");
} else {
    header("location:login.php?info=gagal");
}