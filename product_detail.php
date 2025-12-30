<?php
session_start();
include 'config/database.php';

//1. Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

//2. Fetch Product Data
$id = (int)$_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
$product = mysqli_fetch_assoc($query);

if (!$product) {
    header("Location: index.php");
    exit;
}

$page_title = $product['name'] . " - Detail";
$is_detail_page = true; 
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Detail</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <main class="container">
        
        <div class="detail-layout">
            
            <div class="detail-left">
                <img src="assets/images/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>

            <div class="detail-right">
                
                <div class="detail-header">
                    <div style="margin-bottom: 10px;">
                        <span class="badge badge-blue"><?php echo htmlspecialchars($product['category']); ?></span>
                        <span class="badge badge-yellow">
                            <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($product['origin']); ?>
                        </span>
                    </div>
                    
                    <h1 class="detail-title-main"><?php echo htmlspecialchars($product['name']); ?></h1>
                    <div class="detail-price-main">
                        Rp <?php echo number_format($product['price'], 0, ',', '.'); ?>
                    </div>
                </div>

                <div class="detail-body">
                    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                </div>

                <?php if(!empty($product['specifications'])): ?>
                <div class="detail-specs-box">
                    <h4><i class="fas fa-clipboard-list"></i> Spesifikasi Produk:</h4>
                    <p><?php echo nl2br(htmlspecialchars($product['specifications'])); ?></p>
                </div>
                <?php endif; ?>

                <div class="detail-actions">
                    <button onclick="showContact('<?php echo htmlspecialchars($product['seller_phone']); ?>')" class="btn btn-primary">
                        <i class="fas fa-phone-alt"></i> Hubungi Penjual
                    </button>
                    
                    <a href="pdf/print_product.php?id=<?php echo $product['id']; ?>" target="_blank" class="btn btn-secondary" title="Download PDF">
                        <i class="fas fa-print"></i>
                    </a>
                </div>

            </div>
        </div>

        <h3 style="margin-bottom: 25px; font-weight: 700; color: #333;">Produk Lainnya</h3>
        <div class="product-grid">
            <?php
            $query_other = mysqli_query($conn, "SELECT * FROM products WHERE id != '$id' ORDER BY RAND() LIMIT 4");
            while($other = mysqli_fetch_assoc($query_other)):
            ?>
            <a href="product_detail.php?id=<?php echo $other['id']; ?>" class="product-card">
                <div class="product-img-wrapper" style="height: 160px;">
                    <img src="assets/images/<?php echo $other['image']; ?>" alt="<?php echo htmlspecialchars($other['name']); ?>">
                    <div class="badge-location" style="font-size: 10px; padding: 2px 8px;"><?php echo htmlspecialchars($other['origin']); ?></div>
                </div>
                <div class="product-info" style="padding: 15px;">
                    <h4 style="font-size: 15px; margin-bottom: 5px; font-weight: 700;">
                        <?php echo htmlspecialchars($other['name']); ?>
                    </h4>
                    <div style="font-weight: bold; color: var(--primary); font-size: 14px;">
                        Rp <?php echo number_format($other['price'], 0, ',', '.'); ?>
                    </div>
                </div>
            </a>
            <?php endwhile; ?>
        </div>

    </main>

    <footer>
        <div class="container">
            &copy; <?php echo date('Y'); ?> Direktori Produk Lokal.
        </div>
    </footer>

    <div id="contactModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-icon">
                <i class="fas fa-address-book"></i>
            </div>
            <h3 class="modal-title">Kontak Penjual</h3>
            <p style="color: #666; font-size: 14px;">Silakan hubungi nomor di bawah ini:</p>
            
            <div class="phone-display" id="phoneNumberArea">
                ...
            </div>

            <button onclick="closeModal()" class="btn btn-primary">Tutup</button>
        </div>
    </div>

    <script>
        function showContact(phoneNumber) {
            var formattedNumber = "+" + phoneNumber;
            document.getElementById('phoneNumberArea').innerText = formattedNumber;
            document.getElementById('contactModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('contactModal').style.display = 'none';
        }

        window.onclick = function(event) {
            var modal = document.getElementById('contactModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <?php include 'includes/footer.php'; ?>

</body>
</html>