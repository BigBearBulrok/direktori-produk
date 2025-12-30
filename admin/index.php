<?php
// Redirect to admin login page
header("Location: /admin/login.php");
exit;

if (isset($_SESSION['status']) && $_SESSION['status'] == "login") {
    // Jika sudah login, langsung ke dashboard
    header("Location: dashboard.php");
    exit;
} else {
    // Jika belum, arahkan ke login
    header("Location: login.php");
    exit;
}
?>