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
  <link rel="stylesheet" href="css/stylelogin.css">
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
