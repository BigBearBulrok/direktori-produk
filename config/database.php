<?php
$host     = "localhost";
$username = "root";       // Default username
$password = "";           // Default password
$database = "db_made_in_indonesia";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}
?>