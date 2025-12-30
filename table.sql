-- 1. Hapus database lama jika ada (Reset Total)
DROP DATABASE IF EXISTS db_made_in_indonesia;

-- 2. Buat Database Baru
CREATE DATABASE db_made_in_indonesia;
USE db_made_in_indonesia;

-- 3. Tabel Admin
CREATE TABLE admin (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Akun Admin (Username: admin, Password: admin123)
INSERT INTO admin (username, password) VALUES 
('admin', '$2y$10$cDNXxq9geLZK3qxJQmfeweJRTwk16Oyy6/5dwTbwhKFG83nJOVs/q');

-- 4. Tabel Produk (UPDATE: Ada kolom seller_phone)
CREATE TABLE products (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    price DECIMAL(10, 0) NOT NULL,
    origin VARCHAR(50) NOT NULL,
    seller_phone VARCHAR(20) NOT NULL,  -- KOLOM BARU: Nomor HP Penjual
    description TEXT,
    specifications TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. Data Dummy (UPDATE: Sudah termasuk nomor HP)
INSERT INTO products (name, category, price, origin, seller_phone, description, specifications, image) VALUES 
(
    'Kemeja Batik Tulis Solo', 
    'Fashion', 
    450000, 
    'Surakarta (Solo)',
    '6281234567890', -- Nomor HP Penjual Batik
    'Kemeja batik tulis asli dengan motif parang klasik. Dibuat oleh pengrajin lokal Solo menggunakan bahan katun primisima yang nyaman dan dingin.', 
    'Bahan: Katun Primisima\nTeknik: Tulis Manual\nUkuran: L (Slim Fit)\nWarna: Coklat Emas', 
    'batik_solo.jpg'
),
(
    'Kopi Gayo Arabika Premium', 
    'Kuliner', 
    85000, 
    'Aceh Tengah', 
    '6289876543210', -- Nomor HP Penjual Kopi
    'Biji kopi pilihan dari dataran tinggi Gayo, Aceh. Memiliki aroma yang kuat dengan tingkat keasaman yang seimbang. Cocok untuk manual brew.', 
    'Berat Bersih: 250 gram\nRoasting: Medium Dark\nNotes: Caramel, Fruity, Spicy', 
    'kopi_gayo.jpg'
),
(
    'Tas Anyaman Rotan Bulat', 
    'Kerajinan', 
    125000, 
    'Bali', 
    '6285554443332', -- Nomor HP Penjual Tas
    'Tas selempang kekinian berbentuk bulat yang terbuat dari bahan rotan alami. Dilengkapi dengan kain batik di bagian dalam dan tali kulit sintetis.', 
    'Diameter: 20 cm\nBahan: Rotan & Kulit Sintetis\nPenutup: Kancing Klip', 
    'tas_rotan.jpg'
),
(
    'Polytron Speaker Bluetooth', 
    'Elektronik', 
    750000, 
    'Kudus', 
    '6281112223334', -- Nomor HP Toko Elektronik
    'Speaker aktif portable buatan lokal dengan kualitas suara bass yang nendang. Tahan air dan baterai tahan lama hingga 12 jam pemakaian.', 
    'Model: Muze\nKonektivitas: Bluetooth 5.0, AUX\nBaterai: 3000 mAh\nFitur: Water Resistant', 
    'speaker_polytron.jpg'
),
(
    'Tenun Ikat Sumba', 
    'Fashion', 
    1200000, 
    'Sumba Timur', 
    '6287778889990', -- Nomor HP Pengrajin Tenun
    'Kain tenun ikat asli dengan pewarna alam. Memiliki motif hewan yang melambangkan status sosial dan kearifan lokal masyarakat Sumba.', 
    'Ukuran: 240 x 60 cm\nPewarna: Akar Mengkudu (Merah), Nila (Biru)\nWaktu Pembuatan: 3 Bulan', 
    'tenun_sumba.jpg'
);

-- 6. Tabel Hero Settings
CREATE TABLE hero_settings (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subtitle TEXT,
    background_color VARCHAR(20) DEFAULT '#667eea',
    text_color VARCHAR(20) DEFAULT '#fff',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert Default Hero Settings
INSERT INTO hero_settings (title, subtitle) VALUES 
('Selamat Datang di Direktori Produk', 'Temukan produk berkualitas Made in Indonesia dari berbagai daerah');