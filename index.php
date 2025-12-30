<?php
session_start();
include 'config/database.php';

// 1. Ambil Pengaturan Hero
$query_hero = mysqli_query($conn, "SELECT * FROM hero_settings LIMIT 1");
$hero = mysqli_fetch_assoc($query_hero);

$hero_title = $hero['title'] ?? 'Direktori Produk Unggulan';
$hero_desc  = $hero['subtitle'] ?? 'Temukan produk lokal berkualitas terbaik di sini.';
$hero_bg    = $hero['background_color'] ?? '#007bff';
$hero_text  = $hero['text_color'] ?? '#ffffff';

// 2. Logika Search
$where_clause = "";
$search_keyword = "";

if (isset($_GET['search'])) {
    $search_keyword = mysqli_real_escape_string($conn, $_GET['search']);
    if (!empty($search_keyword)) {
        $where_clause = "WHERE (name LIKE '%$search_keyword%' OR description LIKE '%$search_keyword%')";
    }
}

// 3. Query Produk
$query_products = mysqli_query($conn, "SELECT * FROM products $where_clause ORDER BY id DESC");

$page_title = $hero_title;
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($hero_title); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <header class="hero-section" style="background-color: <?php echo $hero_bg; ?>; color: <?php echo $hero_text; ?>;">
        <div class="container hero-content">
            <h1><?php echo htmlspecialchars($hero_title); ?></h1>
            <p><?php echo htmlspecialchars($hero_desc); ?></p>
        </div>
    </header>

    <main class="container">
        
        <div class="search-wrapper">
            <form action="" method="GET" class="search-box">
                <input type="text" name="search" placeholder="Cari nama produk..." value="<?php echo htmlspecialchars($search_keyword); ?>">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>
            </form>
        </div>

        <div class="product-grid">
            <?php if(mysqli_num_rows($query_products) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($query_products)): ?>
                    
                    <a href="product_detail.php?id=<?php echo $row['id']; ?>" class="product-card">
                        
                        <div class="product-img-wrapper">
                            <img src="assets/images/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                            <div class="badge-location">
                                <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['origin']); ?>
                            </div>
                        </div>
                        
                        <div class="product-info">
                            <div class="product-cat"><?php echo htmlspecialchars($row['category']); ?></div>
                            <h3 class="product-title"><?php echo htmlspecialchars($row['name']); ?></h3>
                            <div class="product-price">Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></div>
                            <p class="product-desc"><?php echo htmlspecialchars($row['description']); ?></p>
                        </div>

                    </a>

                <?php endwhile; ?>
            <?php else: ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 80px 20px; color: #888;">
                    <i class="fas fa-box-open" style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;"></i>
                    <p>Tidak ada produk yang ditemukan.</p>
                    <a href="index.php" class="btn btn-secondary" style="margin-top: 10px;">Reset Pencarian</a>
                </div>
            <?php endif; ?>
        </div>

    </main>

    <?php include 'includes/footer.php'; ?>

</body>
</html>