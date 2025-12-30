<?php
session_start();
include '../config/database.php';

// 1. Cek Login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit;
}

// 2. Logika Pencarian
$search_keyword = "";
if (isset($_GET['search'])) {
    $search_keyword = mysqli_real_escape_string($conn, $_GET['search']);
    $query_str = "SELECT * FROM products WHERE name LIKE '%$search_keyword%' OR category LIKE '%$search_keyword%' ORDER BY id DESC";
} else {
    $query_str = "SELECT * FROM products ORDER BY id DESC";
}
$query = mysqli_query($conn, $query_str);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="admin-wrapper">
    
    <?php 
    $active_menu = 'dashboard'; // Penanda menu aktif
    include '../includes/sidebar_admin.php'; 
    ?>

    <main class="admin-content">
        
        <h2 style="margin-bottom: 20px; font-weight: 700;">Daftar Produk</h2>

        <?php if(isset($_GET['msg'])): ?>
            <div class="alert alert-success" style="padding: 15px; background: #d1e7dd; color: #0f5132; margin-bottom: 20px; border-radius: 8px;">
                <i class="fas fa-check-circle"></i>
                <?php 
                    if($_GET['msg'] == 'sukses_tambah') echo "Produk baru berhasil ditambahkan!";
                    elseif($_GET['msg'] == 'sukses_edit') echo "Data produk berhasil diperbarui!";
                    elseif($_GET['msg'] == 'sukses_hapus') echo "Produk berhasil dihapus!";
                ?>
            </div>
        <?php endif; ?>

        <div class="table-container"> <div class="table-header">
                <form action="" method="GET" class="search-box-admin">
                    <input type="text" name="search" placeholder="Cari nama atau kategori..." value="<?php echo htmlspecialchars($search_keyword); ?>" autocomplete="off">
                    
                    <button type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    
                    <?php if(!empty($search_keyword)): ?>
                        <a href="dashboard.php" class="reset-btn" title="Reset">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php endif; ?>
                </form>
                
                <a href="product_add.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Baru
                </a>
            </div>

            <div style="overflow-x: auto;">
                <table class="table-admin">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Foto</th>
                            <th width="25%">Info Produk</th>
                            <th width="15%">Kontak</th> <th width="15%">Kategori</th>
                            <th width="15%">Harga</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if(mysqli_num_rows($query) > 0): 
                            while($row = mysqli_fetch_assoc($query)): 
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>
                                <img src="../assets/images/<?php echo $row['image']; ?>" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #eee;">
                            </td>
                            <td>
                                <strong style="display: block; font-size: 15px; margin-bottom: 2px;"><?php echo htmlspecialchars($row['name']); ?></strong>
                                <small style="color: #888;"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['origin']); ?></small>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 5px; color: #555;">
                                    <i class="fas fa-phone-alt" style="color: #28a745; font-size: 13px;"></i>
                                    <span><?php echo htmlspecialchars($row['seller_phone']); ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="background: #eef2ff; color: #4f46e5;">
                                    <?php echo htmlspecialchars($row['category']); ?>
                                </span>
                            </td>
                            <td style="font-weight: bold;">
                                Rp <?php echo number_format($row['price'], 0, ',', '.'); ?>
                            </td>
                            <td>
                                <a href="product_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-info" style="padding: 6px 10px;" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="product_delete.php?id=<?php echo $row['id']; ?>" 
                                   class="btn btn-danger" 
                                   style="padding: 6px 10px;"
                                   onclick="return confirm('Yakin ingin menghapus produk ini?')"
                                   title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: #888;">
                                <i class="fas fa-box-open" style="font-size: 32px; margin-bottom: 10px;"></i><br>
                                Tidak ada data produk.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
        </div> </main>
</div>

</body>
</html>