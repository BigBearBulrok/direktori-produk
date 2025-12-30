<?php
session_start();
include '../config/database.php';

//1. Cek Login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit;
}

//2. Proses Hapus Produk
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $query_img = mysqli_query($conn, "SELECT image FROM products WHERE id = '$id'");
    $data_img = mysqli_fetch_assoc($query_img);

    if ($data_img) {
        $target_file = "../assets/images/" . $data_img['image'];
        if ($data_img['image'] != 'default.jpg' && file_exists($target_file)) {
            unlink($target_file);
        }

        $delete = mysqli_query($conn, "DELETE FROM products WHERE id = '$id'");

        if ($delete) {
            header("Location: dashboard.php?msg=sukses_hapus");
        } else {
            echo "<script>alert('Gagal menghapus data dari database.'); window.location='dashboard.php';</script>";
        }
    } else {
        header("Location: dashboard.php");
    }
} else {
    header("Location: dashboard.php");
}
?>