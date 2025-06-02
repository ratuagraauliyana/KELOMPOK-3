<?php
$conn = mysqli_connect("localhost", "root", "", "db_tiket");

if(!$conn){
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>