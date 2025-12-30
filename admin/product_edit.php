<?php
session_start();
include '../config/database.php';

// Cek Login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit;
}

// Ambil ID dari URL
$id = (int)$_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
$data  = mysqli_fetch_assoc($query);

// Jika data tidak ada, kembalikan ke dashboard
if (!$data) {
    header("Location: dashboard.php");
    exit;
}

// Proses Update Data
if (isset($_POST['update'])) {
    $name     = trim($_POST['name']);
    $category = trim($_POST['category']);
    $origin   = trim($_POST['origin']);
    $price    = (int)$_POST['price'];
    $desc     = trim($_POST['description']);
    $specs    = trim($_POST['specifications']);
    $old_img  = $_POST['old_image'];

    if (empty($name) || empty($category) || empty($origin) || $price <= 0 || empty($desc)) {
        echo "<script>alert('Mohon lengkapi semua data wajib!');</script>";
    } else {
        // Logika Ganti Gambar
        $img_db = $old_img; // Default pakai gambar lama
        
        if (!empty($_FILES['image']['name'])) {
            $allowed = ['png', 'jpg', 'jpeg'];
            $filename = $_FILES['image']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                $new_name = rand() . '_' . $filename;
                
                // Upload gambar baru
                if (move_uploaded_file($_FILES['image']['tmp_name'], '../assets/images/' . $new_name)) {
                    $img_db = $new_name;
                    
                    // Hapus gambar lama jika bukan default
                    if ($old_img != 'default.jpg' && file_exists('../assets/images/' . $old_img)) {
                        unlink('../assets/images/' . $old_img);
                    }
                }
            } else {
                echo "<script>alert('Format gambar harus JPG atau PNG!');</script>";
            }
        }

        // Update Database
        $stmt = mysqli_prepare($conn, "UPDATE products SET name=?, category=?, price=?, origin=?, description=?, specifications=?, image=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssissssi", $name, $category, $price, $origin, $desc, $specs, $img_db, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: dashboard.php?msg=sukses_edit");
            exit;
        } else {
            echo "<script>alert('Gagal mengupdate data.');</script>";
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
    <title>Edit Produk - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="admin-wrapper">
    
    <?php 
    $active_menu = 'dashboard'; 
    include '../includes/sidebar_admin.php'; 
    ?>

    <main class="admin-content">
        <div class="container" style="max-width: 800px; margin: 0 auto;">
            
            <h2 style="margin-bottom: 20px; font-weight: 700;">Edit Produk</h2>

            <div class="card" style="background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); border: 1px solid #f0f0f0;">
                
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="old_image" value="<?php echo $data['image']; ?>">
                    
                    <div style="margin-bottom: 15px;">
                        <label>Nama Produk</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($data['name']); ?>" required>
                    </div>

                    <div style="display: flex; gap: 20px; margin-bottom: 15px;">
                        <div style="flex:1">
                            <label>Kategori</label>
                            <select name="category" required>
                                <option value="Fashion" <?php if($data['category']=='Fashion') echo 'selected'; ?>>Fashion</option>
                                <option value="Kuliner" <?php if($data['category']=='Kuliner') echo 'selected'; ?>>Kuliner</option>
                                <option value="Kerajinan" <?php if($data['category']=='Kerajinan') echo 'selected'; ?>>Kerajinan</option>
                                <option value="Elektronik" <?php if($data['category']=='Elektronik') echo 'selected'; ?>>Elektronik</option>
                                <option value="Lainnya" <?php if($data['category']=='Lainnya') echo 'selected'; ?>>Lainnya</option>
                            </select>
                        </div>
                        <div style="flex:1">
                            <label>Asal Daerah</label>
                            <input type="text" name="origin" value="<?php echo htmlspecialchars($data['origin']); ?>" required>
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label>Harga (Rp)</label>
                        <input type="number" name="price" value="<?php echo $data['price']; ?>" required>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label>Deskripsi Singkat</label>
                        <textarea name="description" rows="3" required><?php echo htmlspecialchars($data['description']); ?></textarea>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label>Spesifikasi (Opsional)</label>
                        <textarea name="specifications" rows="3"><?php echo htmlspecialchars($data['specifications']); ?></textarea>
                    </div>

                    <div style="margin-bottom: 25px;">
                        <label>Foto Produk</label>
                        <div style="display: flex; gap: 15px; align-items: flex-start;">
                            <img src="../assets/images/<?php echo $data['image']; ?>" 
                                 style="width: 80px; height: 80px; object-fit: cover; border-radius: 6px; border: 1px solid #ccc;">
                            
                            <div style="flex: 1;">
                                <input type="file" name="image" accept=".jpg, .jpeg, .png" 
                                       style="padding: 10px; background: #f9f9f9; width: 100%; border-radius: 6px; border: 1px dashed #ccc;">
                                <small style="color: #888; display: block; margin-top: 5px;">Biarkan kosong jika tidak ingin mengganti gambar saat ini.</small>
                            </div>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" name="update" class="btn btn-primary" style="padding: 10px 25px;">
                            <i class="fas fa-save"></i> Simpan Perubahan
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