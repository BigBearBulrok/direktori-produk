<?php
// 1. Hubungkan ke database
include '../config/database.php';

// 2. Cek ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../index.php"); 
    exit;
}

$id = (int)$_GET['id'];

// 3. Ambil data
$stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$query = mysqli_stmt_get_result($stmt);
$data  = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data produk tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Produk - <?php echo htmlspecialchars($data['name']); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body style="background: #eef1f5;"> <div class="print-actions">
        <a href="../product_detail.php?id=<?php echo $id; ?>" class="btn btn-secondary" style="text-decoration: none;">
            &laquo; Kembali
        </a>
        <button onclick="window.print()" class="btn btn-primary">
            Cetak / Simpan PDF
        </button>
    </div>

    <div class="report-container">
        
        <div class="report-header">
            <h1>Direktori Produk Lokal</h1>
            <p>Laporan Detail</p>
        </div>

        <div class="report-img">
            <img src="../assets/images/<?php echo $data['image']; ?>" alt="Foto Produk">
        </div>

        <table class="report-table">
            <tr>
                <th>Nama Produk</th>
                <td><?php echo htmlspecialchars($data['name']); ?></td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td><?php echo htmlspecialchars($data['category']); ?></td>
            </tr>
            <tr>
                <th>Asal Daerah</th>
                <td><?php echo htmlspecialchars($data['origin']); ?></td>
            </tr>
            <tr>
                <th>Kontak Penjual</th>
                <td><?php echo htmlspecialchars($data['seller_phone']); ?></td>
            </tr>
            <tr>
                <th>Harga</th>
                <td style="font-weight: bold;">Rp <?php echo number_format($data['price'], 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td><?php echo nl2br(htmlspecialchars($data['description'])); ?></td>
            </tr>
            <tr>
                <th>Spesifikasi</th>
                <td><?php echo nl2br(htmlspecialchars($data['specifications'])); ?></td>
            </tr>
        </table>

        <div class="report-footer">
            <div class="signature-box">
                <p>Dicetak pada: <?php echo date("d/m/Y"); ?></p>
                
                <div class="signature-line">
                    ( Admin Direktori )
                </div>
            </div>
        </div>

    </div>
</body>
</html>