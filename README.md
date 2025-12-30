# Direktori Produk - Made in Indonesia

Aplikasi web sederhana untuk direktori produk lokal Indonesia dengan panel admin yang sudah dimodernisasi.

## Fitur Utama

### Frontend (Publik)
- **Halaman Utama**: Tampilan grid produk responsif dengan fitur pencarian real-time.
- **Hero Section Dinamis**: Judul, deskripsi, dan warna banner bisa diubah dari Admin.
- **Detail Produk**: Informasi lengkap, spesifikasi, dan galeri gambar.
- **Kontak Penjual**: Modal pop-up untuk melihat nomor WhatsApp penjual.
- **Cetak Laporan**: Fitur cetak detail produk yang rapi (CSS khusus print).
- **Navigasi Modular**: Menggunakan `header.php` dan `footer.php` terpisah.

### Backend (Admin Panel)
- **Dashboard**: Ringkasan daftar produk dengan tabel data.
- **CRUD Produk**: Tambah, Edit, dan Hapus produk dengan upload gambar.
- **Pengaturan Hero**: Fitur khusus untuk mengubah teks dan warna banner halaman depan.
- **Sidebar Terpusat**: Navigasi admin yang modular (`sidebar_admin.php`) dengan indikator menu aktif.
- **Keamanan**: Login session, proteksi file, dan validasi input.

## Teknologi

- **Backend**: PHP 7+ (Native)
- **Database**: MySQL / MariaDB
- **Frontend**: HTML5, CSS3 (Custom Style + FontAwesome), JavaScript
- **Styling**: Single CSS file (`style.css`) dengan variabel root dan media queries untuk responsivitas & print.

## Struktur Folder

Struktur folder telah dirapikan menggunakan folder `includes/` untuk file parsial.

```
   direktori-produk/
   ├── index.php              # Halaman utama (Front-end)
   ├── product_detail.php     # Halaman detail produk
   ├── logout.php             # Script logout
   ├── table.sql              # Schema database (tabel products & hero_settings)
   ├── includes/              # [BARU] Folder komponen halaman (Modular)
   │   ├── header.php         # Navbar & Head HTML
   │   ├── footer.php         # Footer & Script HTML
   │   └── sidebar_admin.php  # Sidebar menu admin (shareable)
   ├── admin/
   │   ├── login.php          # Halaman login admin
   │   ├── dashboard.php      # Halaman utama admin
   │   ├── product_add.php    # Form tambah produk
   │   ├── product_edit.php   # Form edit produk
   │   ├── product_delete.php # Script hapus produk
   │   └── hero_settings.php  # [BARU] Pengaturan tampilan banner depan
   ├── assets/
   │   ├── css/
   │   │   └── style.css      # Styling utama (termasuk style print)
   │   └── images/            # Folder penyimpanan upload gambar
   ├── config/
   │   └── database.php       # Koneksi database
   └── pdf/
      └── print_product.php  # Template khusus cetak/simpan PDF 
```

## Instalasi

### 1. Setup Database:
- Buat database baru bernama `db_made_in_indonesia`.
- Import file `table.sql` ke database tersebut (Pastikan tabel `hero_settings` ikut terbuat).

### 2. Konfigurasi Koneksi:
- Buka `config/database.php`.
- Sesuaikan `hostname`, `username`, `password`, dan `database` sesuai server lokal Anda.

### 3. Upload & Permission:
- Pindahkan folder project ke `htdocs` (XAMPP) atau `www` (Laragon).
- **Penting**: Pastikan folder `assets/images/` memiliki izin tulis (write permission) agar upload gambar berhasil.

### 4. Menyalakan Aplikasi:
- Buka terminal di vscode atau cmd (cmd: cd direktori-produk)
- Run `composer install` untuk menginstal dependensi.
- Run `php -S localhost:8000` untuk menjalankan aplikasi publik.

### 5. Akses Aplikasi:
- **Publik**: http://localhost:8000
- **Admin**: http://localhost:8000admin
- **Akun Default**: Username: `admin`, Password: `admin123`

## Penggunaan

### Mengelola Tampilan (Hero Settings)
1. Login ke Admin Panel.
2. Klik menu **"Ganti Hero"** di sidebar.
3. Ubah Judul, Deskripsi, Warna Background, dan Warna Teks sesuai keinginan.
4. Simpan, dan lihat perubahannya di halaman depan (`index.php`).

### Mencetak Laporan
1. Buka halaman detail produk di sisi publik.
2. Klik tombol ikon **Printer** atau **Simpan PDF**.
3. Halaman khusus cetak akan terbuka.
4. Tampilan
5. Tampilan akan otomatis menyesuaikan kertas A4 (tanpa tombol/navigasi).

## Keamanan

### Aplikasi ini menerapkan standar keamanan dasar:
- **Prepared Statements**: Mencegah SQL Injection pada semua query database.
- **htmlspecialchars()**: Mencegah serangan XSS (Cross-Site Scripting) pada output data.
- **Session Check**: Mencegah akses langsung ke halaman admin tanpa login.
- **Validasi File**: Memastikan hanya file gambar (JPG/PNG) yang bisa diupload.

### Troubleshooting
- **Error `failed to open stream` pada Sidebar**: Pastikan file `sidebar_admin.php` berada di folder `includes/` (sejajar dengan `header.php`), bukan di dalam `admin/includes/`.
- **Gambar tidak muncul saat Print**: Pastikan opsi "Background graphics" dicentang pada dialog print browser jika gambar/warna background hilang.

## Lisensi
Aplikasi ini dibuat untuk tujuan edukasi, portofolio, dan pengembangan lebih lanjut.