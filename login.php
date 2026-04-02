
<?php
session_start();
include "koneksi.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
  .login-container {
    background: #ffffff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 25px rgba(0,0,0,0.15);
    width: 100%;
    max-width: 400px;
    height: 50vh; /* Tinggi 50% dari layar */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
  }
  h2 { color: #333; margin-bottom: 20px; }
  form { width: 100%; }
  input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
  }
  button {
    width: 100%;
    padding: 12px;
    background-color: #007bff; /* Warna biru untuk Login */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    transition: background 0.3s;
  }
  button:hover { background-color: #0056b3; }
  p { margin-top: 15px; font-size: 14px; color: #666; }
  a { color: #28a745; text-decoration: none; }
  a:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="login-container">
<h2> 🔐 Form Login</h2>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    
    <input type="password" name="password" placeholder="Password" required><br><br>
    
    <button type="submit" name="login">Login</button>
</form>
<p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
</div>
<?php if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = md5($_POST["password"]);

    $query = "SELECT * FROM tb_login WHERE username='$username' AND password='$password'";
    $result = $koneksi->query($query);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // simpan session
        $_SESSION["user"] = $data;

        // cek role
        if ($data["role"] == "admin") {
            header("Location: dashboard_admin.php");
        } else {
            header("Location: dashboard_pelanggan.php");
        }
    } else {
        echo "Login gagal! Username atau password salah.";
    }
} ?>

</body>
</html>