
<?php include "koneksi.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
  .register-container {
    background: #ffffff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 310px;
    text-align: center;
  }
  h2 { color: #333; margin-bottom: 20px; }
  input, select {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box; /* Agar padding tidak merusak lebar */
  }
  button {
    width: 100%;
    padding: 12px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    transition: background 0.3s;
  }
  button:hover { background-color: #218838; }
  p { margin-top: 15px; font-size: 14px; color: #666; }
  a { color: #007bff; text-decoration: none; }
  a:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="register-container">
<h2> 📝 Form Register</h2>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    
    <input type="password" name="password" placeholder="Password" required><br><br>
    
    <input type="password" name="confirm" placeholder="Konfirmasi Password" required><br><br>
    
    <select name="role" required>
        <option value="">-- Pilih Role --</option>
        <option value="admin">Admin</option>
        <option value="pelanggan">Pelanggan</option>
    </select><br><br>
    
    <button type="submit" name="register">Register</button>
</form>
<p>Sudah punya akun? <a href="login.php">Login di sini</a></p>

<?php if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = md5($_POST["password"]);
    $confirm = md5($_POST["confirm"]);
    $role = $_POST["role"];

    if ($password != $confirm) {
        echo "Password tidak sama!";
    } else {
        $query = "INSERT INTO tb_login (username, password, role) 
                  VALUES ('$username', '$password', '$role')";

        if ($koneksi->query($query)) {
            echo "Register berhasil!";
        } else {
            echo "Error: " . $koneksi->error;
        }
    }
} ?>
</div>
</body>
</html>