<?php
session_start();
include '../config/database.php';

// Cek Login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit;
}

// Ambil Data Hero
$query = mysqli_query($conn, "SELECT * FROM hero_settings LIMIT 1");
$hero = mysqli_fetch_assoc($query);

// Proses Update
if (isset($_POST['update_hero'])) {
    $title    = mysqli_real_escape_string($conn, $_POST['title']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    $bg_color = mysqli_real_escape_string($conn, $_POST['background_color']);
    $txt_color= mysqli_real_escape_string($conn, $_POST['text_color']);

    $update = mysqli_query($conn, "UPDATE hero_settings SET title='$title', subtitle='$subtitle', background_color='$bg_color', text_color='$txt_color' WHERE id=".$hero['id']);

    if ($update) {
        $msg_sukses = "Tampilan Hero berhasil diperbarui!";
        // Refresh data
        $hero['title'] = $title;
        $hero['subtitle'] = $subtitle;
        $hero['background_color'] = $bg_color;
        $hero['text_color'] = $txt_color;
    } else {
        $msg_error = "Gagal update database.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Hero - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="admin-wrapper">
    
    <?php 
    $active_menu = 'hero'; 
    include '../includes/sidebar_admin.php'; 
    ?>

    <main class="admin-content">
        <div class="container" style="max-width: 800px; margin: 0 auto;">
            
            <h2 style="margin-bottom: 20px; font-weight: 700;">Pengaturan Tampilan</h2>

            <?php if(isset($msg_sukses)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $msg_sukses; ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 18px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                    Edit Hero Section (Banner)
                </h3>

                <form action="" method="POST">
                    
                    <div style="margin-bottom: 15px;">
                        <label>Judul Utama</label>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($hero['title']); ?>" required>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label>Subjudul / Deskripsi</label>
                        <textarea name="subtitle" rows="3" required><?php echo htmlspecialchars($hero['subtitle']); ?></textarea>
                    </div>

                    <div style="display: flex; gap: 30px; margin-bottom: 30px;">
                        <div>
                            <label>Warna Background</label>
                            <input type="color" name="background_color" value="<?php echo $hero['background_color']; ?>" style="width: 60px; height: 40px; cursor: pointer; padding: 0; border: none;">
                        </div>
                        
                        <div>
                            <label>Warna Teks</label>
                            <input type="color" name="text_color" value="<?php echo $hero['text_color']; ?>" style="width: 60px; height: 40px; cursor: pointer; padding: 0; border: none;">
                        </div>
                    </div>

                    <div style="margin-bottom: 25px;">
                        <label>Pratinjau (Preview):</label>
                        <div style="padding: 40px; text-align: center; border-radius: 8px; border: 1px dashed #ccc; 
                                    background-color: <?php echo $hero['background_color']; ?>; color: <?php echo $hero['text_color']; ?>;">
                            <h2 style="margin: 0; font-size: 28px;"><?php echo htmlspecialchars($hero['title']); ?></h2>
                            <p style="margin-top: 10px; font-size: 16px;"><?php echo htmlspecialchars($hero['subtitle']); ?></p>
                        </div>
                    </div>

                    <button type="submit" name="update_hero" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>

                </form>
            </div>
        </div>
    </main>
</div>

</body>
</html>