<?php
session_start();
include "koneksi.php";

// cek login
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// cek role pelanggan
if ($_SESSION["user"]["role"] != "pelanggan") {
    echo "Akses ditolak!";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Pelanggan</title>
    <style>
  body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f0f2f5;
    margin: 0; padding: 20px;
    color: #333;
  }
  .container {
    max-width: 1000px;
    margin: auto;
  }
  .header {
    background: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  /* Sistem Grid untuk bagi 2 kolom */
  .main-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
  }
  .card {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
  }
  h2, h3 { margin-top: 0; color: #2c3e50; }
  
  /* Styling Form */
  input, select {
    width: 100%;
    padding: 10px;
    margin: 5px 0 15px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
    display: block;
  }
  button {
    width: 100%;
    padding: 12px;
    background: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
  }
  button:hover { background: #218838; }

  /* Styling History List */
  .history-item {
    border-bottom: 1px dashed #ddd;
    padding: 10px 0;
  }
  .history-item:last-child { border-bottom: none; }
  .badge {
    background: #e9ecef;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
  }
  .btn-logout {
    color: #dc3545;
    text-decoration: none;
    font-weight: bold;
  }
</style>
</head>
<body>
<div class="container">
    <div class="header">
<h2>Dashboard Pelanggan</h2>
<p>Selamat datang - <?= $_SESSION["user"]["username"] ?> ( <?= $_SESSION[
     "user"
 ]["role"] ?> ) </p>
<a href="logout.php" class="btn-logout">Keluar (Logout)</a>
    </div>
<div class="main-grid">
    <div class="card">
<h3>➕ Form Pemesanan</h3>

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

    <button type="submit" name="pesan">Pesan</button>
</form>
    
<?php if (isset($_POST["pesan"])) {
    $product = $_POST["product"];
    $jumlah = $_POST["jumlah"];
    $hp = $_POST["hp"];
    $id_user = $_SESSION["user"]["id_user"];

    $query = "INSERT INTO orders (product_name, jumlah, no_hp, id_user)
              VALUES ('$product', '$jumlah', '$hp', '$id_user')";
    $koneksi->query($query);
    echo "<p id='notif-pesanan' style='color: green; font-weight: bold;'>Pesanan berhasil dibuat!</p>";
} ?>
</div>
<div class="card">
<h3>History Pesanan</h3>
<div style="max-height: 400px; overflow-y: auto;">
<?php
$id_user = $_SESSION["user"]["id_user"];
$result = $koneksi->query(
    "SELECT orders.*, tb_login.username, tb_login.role 
        FROM orders 
        JOIN tb_login ON orders.id_user = tb_login.id_user
        WHERE orders.id_user='" .
        $_SESSION["user"]["id_user"] .
        "' 
        ORDER BY orders.id DESC",
);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "
        <div class='history-item' style='margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;'>
            <div style='font-weight: bold; color: #2c3e50;'>📦 Produk: {$row["product_name"]}</div>
            <div style='font-size: 14px; color: #666;'>
                🔢 Jumlah: <span class='badge'>{$row["jumlah"]}</span> | 
                📞 HP: {$row["no_hp"]}
            </div>
        </div>
        ";
    }
} else {
    echo "<div style='text-align: center; color: #999; padding: 20px;'>Belum ada pesanan terbaru.</div>";
}
?>
</div>
</div>
</div>
<script>
      window.onload = function() {
        const notif = document.getElementById('notif-pesanan');
        if (notif) {
          setTimeout(function() {
            notif.style.display = 'none';
          }, 3000); // 3 detik
        }
      };
      notif.style.transition = 'opacity 1s'; // Efek halus 1 detik
notif.style.opacity = '0'; // Menjadi transparan
setTimeout(() => { notif.style.display = 'none'; }, 1000); // Benar-benar hapus setelah pudar
    </script>
</body>
</html>