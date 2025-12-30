<?php
session_start();
include '../config/database.php';

//1. Cek Login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit;
}

//2. Proses Simpan
if (isset($_POST['simpan'])) {
    $name     = trim($_POST['name']);
    $category = trim($_POST['category']);
    $origin   = trim($_POST['origin']);
    $price    = (int)$_POST['price'];
    $phone    = trim($_POST['seller_phone']);
    $desc     = trim($_POST['description']);
    $specs    = trim($_POST['specifications']);

    if (empty($name) || empty($category) || empty($origin) || $price <= 0 || empty($desc) || empty($phone)) {
        echo "<script>alert('Harap lengkapi semua data wajib!');</script>";
    } else {
        $img_db = 'default.jpg';
        if (!empty($_FILES['image']['name'])) {
            $allowed = ['png', 'jpg', 'jpeg'];
            $filename = $_FILES['image']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed)) {
                $new_name = rand() . '_' . $filename;
                if (move_uploaded_file($_FILES['image']['tmp_name'], '../assets/images/' . $new_name)) {
                    $img_db = $new_name;
                }
            } else {
                echo "<script>alert('Format gambar harus JPG atau PNG!');</script>";
            }
        }

        $stmt = mysqli_prepare($conn, "INSERT INTO products (name, category, price, origin, seller_phone, description, specifications, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssisssss", $name, $category, $price, $origin, $phone, $desc, $specs, $img_db);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: dashboard.php?msg=sukses_tambah");
            exit;
        } else {
            echo "<script>alert('Gagal menyimpan data ke database.');</script>";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="admin-wrapper">
    <?php 
    $active_menu = 'product_add'; 
    include '../includes/sidebar_admin.php'; 
    ?>

    <main class="admin-content">
        <div class="container" style="max-width: 800px; margin: 0 auto;">
            
            <h2 style="margin-bottom: 20px; font-weight: 700;">Tambah Produk Baru</h2>

            <div class="card" style="background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); border: 1px solid #f0f0f0;">
                <form action="" method="POST" enctype="multipart/form-data">
                    
                    <div style="margin-bottom: 15px;">
                        <label>Nama Produk</label>
                        <input type="text" name="name" required placeholder="Contoh: Batik Tulis">
                    </div>

                    <div style="display: flex; gap: 20px; margin-bottom: 15px;">
                        <div style="flex:1">
                            <label>Kategori</label>
                            <select name="category" required>
                                <option value="">- Pilih Kategori -</option>
                                <option value="Fashion">Fashion</option>
                                <option value="Kuliner">Kuliner</option>
                                <option value="Kerajinan">Kerajinan</option>
                                <option value="Elektronik">Elektronik</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div style="flex:1">
                            <label>Asal Daerah</label>
                            <input type="text" name="origin" required placeholder="Contoh: Yogyakarta">
                        </div>
                    </div>

                    <div style="display: flex; gap: 20px; margin-bottom: 15px;">
                        <div style="flex:1">
                            <label>Harga (Rp)</label>
                            <input type="number" name="price" required placeholder="Contoh: 150000">
                        </div>
                        <div style="flex:1">
                            <label>No. HP Penjual</label>
                            <input type="number" name="seller_phone" required placeholder="Contoh: 62812345678">
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label>Deskripsi Singkat</label>
                        <textarea name="description" rows="3" required placeholder="Deskripsi produk..."></textarea>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label>Spesifikasi (Opsional)</label>
                        <textarea name="specifications" rows="3" placeholder="Bahan, Ukuran, Berat, dll..."></textarea>
                    </div>

                    <div style="margin-bottom: 25px;">
                        <label>Foto Produk</label>
                        <input type="file" name="image" required accept=".jpg, .jpeg, .png" style="background: #f9f9f9; border: 1px dashed #ccc; padding: 10px; width: 100%; border-radius: 6px;">
                        <small style="color: #888; display: block; margin-top: 5px;">Format: JPG/PNG, Maks 2MB.</small>
                    </div>
                    
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" name="simpan" class="btn btn-primary" style="padding: 10px 25px;">
                            <i class="fas fa-save"></i> Simpan Produk
                        </button>
                        <a href="dashboard.php" class="btn btn-secondary" style="padding: 10px 25px;">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </main>
</div>

</body>
</html>