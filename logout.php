<?php
session_start();
session_destroy(); // Hapus semua sesi
header("Location: admin/login.php"); // Kembalikan ke halaman login
?>