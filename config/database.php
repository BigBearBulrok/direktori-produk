<?php
$host     = "localhost";
$username = "root";       // Default XAMPP username
$password = "";           // Default XAMPP password (kosong)
$database = "db_made_in_indonesia";

// Membuat koneksi ke MySQL
$conn = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}
?>