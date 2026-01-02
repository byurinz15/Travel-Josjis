<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_travel_booking"; // Pastikan nama database sama dengan yang di phpMyAdmin

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>
