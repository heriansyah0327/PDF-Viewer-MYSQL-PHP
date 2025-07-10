<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  include 'db.php';
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->bind_result($db_password);

  if ($stmt->fetch()) {
    if ($password === $db_password) {
      $_SESSION['admin'] = true;
      header("Location: dashboard.php");
      exit();
    } else {
      $error = "Password salah";
    }
  } else {
    $error = "Username tidak ditemukan";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login Admin</title>
  <style>
    /* Reset default margin/padding */
    * {
      box-sizing: border-box;
    }
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f0f2f5;
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-container {
      position: relative;
      background: white;
      padding: 60px 40px 30px 40px; /* tambah padding-top jadi 60px */
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      width: 320px;
      text-align: center;
    }
    h2 {
      margin-bottom: 25px;
      color: #333;
    }
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px 15px;
      margin: 10px 0 20px 0;
      border: 1px solid #ccc;
      border-radius: 20px;
      font-size: 16px;
      transition: border-color 0.3s;
    }
    input[type="text"]:focus,
    input[type="password"]:focus {
      outline: none;
      border-color: #007bff;
      box-shadow: 0 0 5px rgba(0,123,255,0.5);
    }
    button {
      width: 100%;
      padding: 12px;
      background-color: #007bff;
      border: none;
      border-radius: 20px;
      color: white;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    button:hover {
      background-color: #0056b3;
    }
    .error-msg {
      color: #e74c3c;
      margin-bottom: 15px;
      font-weight: 600;
    }
  a.back-button {
    position: absolute;
    top: 20px;
    left: 20px;
    display: flex;
    align-items: center;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    cursor: pointer;
    padding: 6px 10px;
    background-color: #007bff;  /* biru */
    border-radius: 20px;
    transition: background-color 0.3s;
    user-select: none;
    z-index: 10;
  }
  a.back-button:hover {
    background-color: #0056b3; /* biru lebih gelap */
    text-decoration: none;
  }
  a.back-button::before {
    content: "";
    display: inline-block;
    margin-right: 8px;
    border: solid white;
    border-width: 0 3px 3px 0;
    padding: 3px;
    transform: rotate(135deg);
    -webkit-transform: rotate(135deg);
  }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Login Admin</h2>
    <?php if (!empty($error)) : ?>
      <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="post" autocomplete="off">
      <input name="username" placeholder="Username" type="text" required autofocus />
      <input name="password" type="password" placeholder="Password" required />
      <button type="submit">Login</button>
    </form>
    <a href="index.php" class="back-button" aria-label="Back to Home">Kembali</a>

  </div>
</body>
</html>
