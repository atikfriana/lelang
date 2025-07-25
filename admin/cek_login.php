<?php
session_start();

include '../db/dbconnect.php';

$username = $_POST['username'];
$password = $_POST['password'];

$login = mysqli_query($conn, "SELECT * FROM tb_petugas WHERE username='$username' AND password='$password'");

$cek = mysqli_num_rows($login);

if ($cek > 0) {

    // Data login
    $data = mysqli_fetch_assoc($login);

    if ($data['id_level'] == "1") {
        $_SESSION['id_petugas'] = $id_petugas;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['id_level'] = "1";
        header("location:index.php");
    } elseif($data['id_level'] == "2") {
        $_SESSION['id_petugas'] = $id_petugas;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['id_level'] = "2";
        header("location:../petugas/index.php");
    }
} else {
    header("location:login.php?info=gagal");
}
