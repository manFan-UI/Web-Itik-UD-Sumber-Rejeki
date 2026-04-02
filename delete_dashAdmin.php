<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// 2. CEK APAKAH YANG MENGHAPUS ADALAH ADMIN?
if ($_SESSION["user"]["role"] != "admin") {
    echo "<script>alert('Akses ditolak! Hanya Admin yang boleh menghapus.'); window.location='dashboard_pelanggan.php';</script>";
    exit();
}

// 3. JIKA LOLOS CEK, BARU JALANKAN PROSES HAPUS
$id = $_GET["id"];
$koneksi->query("DELETE FROM orders WHERE id='$id'");

// 4. BALIK KE DASHBOARD
header("Location: dashboard_admin.php");
exit();

?>
