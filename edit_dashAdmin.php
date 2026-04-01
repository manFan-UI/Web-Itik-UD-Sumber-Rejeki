<?php
include "koneksi.php";

$id = $_GET["id"];
$data = $koneksi->query("SELECT * FROM orders WHERE id='$id'")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
    <style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f7f6;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
  }
  .edit-container {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
  }
  h2 { 
    color: #2c3e50; 
    margin-top: 0; 
    text-align: center;
    border-bottom: 2px solid #3498db;
    padding-bottom: 10px;
  }
  label {
    display: block;
    margin-top: 15px;
    font-weight: bold;
    color: #555;
    font-size: 14px;
  }
  input, select {
    width: 100%;
    padding: 12px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-sizing: border-box;
  }
  .btn-group {
    margin-top: 25px;
    display: flex;
    gap: 10px;
  }
  button {
    flex: 2;
    padding: 12px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
  }
  button:hover { background-color: #2980b9; }
  .btn-back {
    flex: 1;
    background-color: #95a5a6;
    text-decoration: none;
    color: white;
    text-align: center;
    padding: 12px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: bold;
  }
  .btn-back:hover { background-color: #7f8c8d; }
</style>
</head>
<body>
<div class="edit-container">
    <h2>📝 Edit Pesanan</h2>

<form method="POST">
    <select name="product">
        <option <?= $data["product_name"] == "Itik / Bebek"
            ? "selected"
            : "" ?>>Itik / Bebek</option>
        <option <?= $data["product_name"] == "Usus Bebek"
            ? "selected"
            : "" ?>>Usus Bebek</option>
        <option <?= $data["product_name"] == "Jeroan Bebek"
            ? "selected"
            : "" ?>>Jeroan Bebek</option>
    </select><br><br>
    <input type="number" name="jumlah" value="<?= $data["jumlah"] ?>"><br><br>
    <input type="text" name="hp" value="<?= $data["no_hp"] ?>"><br><br>

    <div class="btn-group">
            <a href="dashboard_admin.php" class="btn-back">Batal</a>
            <button type="submit" name="update">Simpan Perubahan</button>
        </div>
</form>

<?php if (isset($_POST["update"])) {
    $koneksi->query("UPDATE orders SET 
        product_name='$_POST[product]',
        jumlah='$_POST[jumlah]',
        no_hp='$_POST[hp]'
        WHERE id='$id'
    ");

    header("Location: dashboard_admin.php");
} ?>

</body>
</html>