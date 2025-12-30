<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Direktori Produk'; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <nav class="public-navbar">
        <div class="container nav-flex">
            <?php if(isset($is_detail_page) && $is_detail_page == true): ?>
                <a href="index.php" class="nav-logo" style="font-size: 16px; font-weight: 600; color: #555;">
                    <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Kembali ke Direktori
                </a>
            <?php else: ?>
                <a href="index.php" class="nav-logo">
                    <i class="fas fa-cube"></i> DirektoriProduk
                </a>
            <?php endif; ?>
        </div>
    </nav>