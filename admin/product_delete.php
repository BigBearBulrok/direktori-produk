<?php
session_start();
include '../config/database.php';

// Cek Login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit;
}

// Cek parameter ID
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // 1. Ambil data gambar lama untuk dihapus
    $query_img = mysqli_query($conn, "SELECT image FROM products WHERE id = '$id'");
    $data_img = mysqli_fetch_assoc($query_img);

    if ($data_img) {
        // Hapus file fisik gambar jika ada dan bukan gambar default
        $target_file = "../assets/images/" . $data_img['image'];
        if ($data_img['image'] != 'default.jpg' && file_exists($target_file)) {
            unlink($target_file);
        }

        // 2. Hapus data dari database
        $delete = mysqli_query($conn, "DELETE FROM products WHERE id = '$id'");

        if ($delete) {
            header("Location: dashboard.php?msg=sukses_hapus");
        } else {
            echo "<script>alert('Gagal menghapus data dari database.'); window.location='dashboard.php';</script>";
        }
    } else {
        // Data tidak ditemukan
        header("Location: dashboard.php");
    }
} else {
    header("Location: dashboard.php");
}
?>