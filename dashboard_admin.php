<?php
session_start();
include "koneksi.php";

// CEK LOGIN
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// CEK ROLE ADMIN
if ($_SESSION["user"]["role"] != "admin") {
    echo "Akses ditolak!";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f8f9fa;
    margin: 0; padding: 20px;
    color: #333;
  }
  .container { max-width: 1100px; margin: auto; }
  
  /* Header Panel Admin */
  .admin-header {
    background: #2c3e50;
    color: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  }

  /* Layout 2 Kolom */
  .content-wrapper {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 25px;
  }

  .card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.05);
  }

  /* Form Styling */
  h3 { border-bottom: 2px solid #eee; padding-bottom: 10px; margin-top: 0; }
  input, select {
    width: 100%; padding: 10px; margin: 10px 0 20px 0;
    border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;
  }
  .btn-submit {
    width: 100%; padding: 12px; background: #3498db;
    color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;
  }
  .btn-submit:hover { background: #2980b9; }

  /* Table Styling */
  table {
    width: 100%; border-collapse: collapse; margin-top: 10px;
    background: white; overflow: hidden; border-radius: 8px;
  }
  th { background: #34495e; color: white; padding: 12px; text-align: left; }
  td { padding: 12px; border-bottom: 1px solid #eee; font-size: 14px; }
  tr:hover { background: #f1f4f6; }

  /* Link Action */
  .btn-edit { color: #f39c12; text-decoration: none; font-weight: bold; }
  .btn-delete { color: #e74c3c; text-decoration: none; font-weight: bold; }
  .logout-link { color: #ecf0f1; text-decoration: none; font-weight: bold; padding: 8px 15px; border: 1px solid #ecf0f1; border-radius: 5px; }
  .logout-link:hover { background: #ecf0f1; color: #2c3e50; }
</style>
</head>
<body>
<div class="container">
    <div class="admin-header">
        <div>
            <h1>Dashboard Admin</h1>
            <p>Selamat datang, <?= $_SESSION["user"][
                "username"
            ] ?> (<?= $_SESSION["user"]["role"] ?>)</p>
        </div>
        <a href="logout.php" class="logout-link">Logout</a> 
    </div>
<!-- FORM TAMBAH DATA -->
 <div class="content-wrapper">
        <div class="card">
<h3> ➕ Tambah Pesanan</h3>

<form method="POST">
    
    <!-- SELECT PRODUK -->
    <label>Nama Produk:</label><br>
    <select name="product" required>
        <option value="">-- Pilih Produk --</option>
        <option value="Itik / Bebek">Itik / Bebek</option>
        <option value="Usus Bebek">Usus Bebek</option>
        <option value="Jeroan Bebek">Jeroan Bebek</option>
    </select><br>

    <label>Jumlah:</label><br>
    <input type="number" name="jumlah" required><br>

    <label>No HP:</label><br>
    <input type="text" name="hp" required><br>

    <button type="submit" name="pesan" class="btn-submit">Pesan</button>
</form>

<?php // SIMPAN DATA

if (isset($_POST["pesan"])) {
    $product = $_POST["product"];
    $jumlah = $_POST["jumlah"];
    $hp = $_POST["hp"];
    $id_user = $_SESSION["user"]["id_user"];

    $query = "INSERT INTO orders (product_name, jumlah, no_hp, id_user)
              VALUES ('$product', '$jumlah', '$hp', '$id_user')";

    if ($koneksi->query($query)) {
        echo "Pesanan berhasil ditambahkan!";
    } else {
        echo "Error: " . $koneksi->error;
    }
} ?>
</div>
<!-- TAMPILKAN DATA -->
 <div class="card">
<h3> 📊 Data Seluruh Pesanan</h3>
<div style="overflow-x: auto;">
<table border="1" cellpadding="10">
<tr>
    <th>Username</th>
    <th>Role</th>   
    <th>Produk</th>
    <th>Jumlah</th>
    <th>No HP</th>
    <th>Aksi</th>
</tr>

<?php
$result = $koneksi->query("SELECT orders.*, tb_login.username, tb_login.role 
FROM tb_login 
JOIN orders ON tb_login.id_user = orders.id_user");

while ($row = $result->fetch_assoc()) {
    echo "
    <tr>
        <td>{$row["username"]}</td>
        <td>{$row["role"]}</td>
        <td>{$row["product_name"]}</td>
        <td>{$row["jumlah"]}</td>
        <td>{$row["no_hp"]}</td>
        <td>
            <a href='edit_dashAdmin.php?id={$row["id"]}' class='btn-edit'>Edit</a> | 
            <a href='delete_dashAdmin.php?id={$row["id"]}' class='btn-delete' onclick=\"return confirm('Yakin hapus?')\">Hapus</a>
        </td>
    </tr>
    ";
}
?>

</table>
</div>
</div>
</div>
    </div>

</body>
</html>