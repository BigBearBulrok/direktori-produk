// assets/js/script.js

// 1. Fungsi Konfirmasi Hapus (Untuk Admin Dashboard)
function confirmDelete() {
    return confirm("Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.");
}

// 2. Fungsi Cetak Otomatis (Jika di halaman print)
function autoPrint() {
    window.print();
}

// 3. Simple Alert (Opsional)
document.addEventListener("DOMContentLoaded", function() {
    console.log("Aplikasi Direktori Produk Siap!");
});