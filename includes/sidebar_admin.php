<aside class="admin-sidebar">
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <i class="fas fa-cube" style="color: #007bff;"></i> AdminPanel
        </div>
    </div>
    
    <nav class="sidebar-menu">
        <a href="dashboard.php" class="menu-item <?php echo (isset($active_menu) && $active_menu == 'dashboard') ? 'active' : ''; ?>">
            <i class="fas fa-list"></i> Daftar Produk
        </a>
        
        <a href="product_add.php" class="menu-item <?php echo (isset($active_menu) && $active_menu == 'product_add') ? 'active' : ''; ?>">
            <i class="fas fa-plus-circle"></i> Tambah Produk
        </a>
        
        <a href="hero_settings.php" class="menu-item <?php echo (isset($active_menu) && $active_menu == 'hero') ? 'active' : ''; ?>">
            <i class="fas fa-image"></i> Ganti Hero
        </a>
        
        <a href="../index.php" target="_blank" class="menu-item">
            <i class="fas fa-external-link-alt"></i> Lihat Website
        </a>
    </nav>

    <div class="sidebar-footer">
        <div style="font-size: 12px; color: #999; margin-bottom: 5px;">Login sebagai:</div>
        <div style="font-weight: bold; margin-bottom: 10px;">
            <?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?>
        </div>
        <a href="../logout.php" class="btn" style="background-color: #dc3545; color: #fff; width: 100%; display: flex; justify-content: center; align-items: center; text-decoration: none; box-shadow: 0 4px 6px rgba(220, 53, 69, 0.2);">
            <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> Keluar
        </a>
    </div>
</aside>