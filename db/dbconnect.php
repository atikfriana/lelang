<?php


$conn = mysqli_connect("localhost", "root", "", "sistem_lelang");
if (mysqli_connect_errno()) {
    echo 'Koneksi Database Gagal : ' . mysqli_connect_error();
}
