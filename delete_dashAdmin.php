<?php
include "koneksi.php";

$id = $_GET["id"];

$koneksi->query("DELETE FROM orders WHERE id='$id'");

header("Location: dashboard_admin.php");
?>
