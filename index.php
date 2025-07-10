<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Daftar PDF</title>
  <style>
    /* Reset & base */
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f6f8;
      color: #333;
    }

    /* Navbar */
    nav {
      position: sticky;
      top: 0;
      background: white;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      padding: 10px 20px;
      display: flex;
      justify-content: flex-end;
      align-items: center;
      z-index: 1000;
    }
    nav a.admin-login {
      background-color: #0a64ff;
      color: white;
      text-decoration: none;
      padding: 8px 16px;
      border-radius: 20px;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }
    nav a.admin-login:hover {
      background-color: #004ecc;
    }

    /* Container for content */
    .container {
      max-width: 960px;
      margin: 30px auto;
      padding: 0 20px;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
      font-weight: 700;
      color: #0a64ff;
    }

    /* File card */
    .file-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgb(0 0 0 / 0.05);
      padding: 20px 25px;
      margin-bottom: 15px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: box-shadow 0.3s ease;
    }
    .file-card:hover {
      box-shadow: 0 8px 20px rgb(0 0 0 / 0.1);
    }

    .file-name {
      font-weight: 600;
      font-size: 16px;
      color: #0a64ff;
      text-decoration: none;
      overflow-wrap: break-word;
      max-width: 80%;
    }
    .file-name:hover {
      text-decoration: underline;
    }

  </style>
</head>
<body>
  <nav>
    <a href="login.php" class="admin-login">Admin Login</a>
  </nav>
  <div class="container">
    <h1>Daftar PDF</h1>
    <?php
      date_default_timezone_set('Asia/Jakarta');
      include 'db.php';
      $result = $conn->query("SELECT * FROM files ORDER BY uploaded_at DESC");
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $fileUrl = htmlspecialchars($row['file_url']);
          $fileName = htmlspecialchars($row['file_name']);
          echo "
            <div class='file-card'>
              <a href='viewer.php?file=" . urlencode($fileUrl) . "' target='' class='file-name'>$fileName</a>
              <div style='font-size: 14px; color: #666; text-align: right; white-space: nowrap;'>
                " . date('d M Y, H:i', strtotime($row['uploaded_at'])) . "
              </div>
            </div>
          ";
        }
      } else {
        echo "<p>Tidak ada file PDF yang diunggah.</p>";
      }
    ?>
  </div>
</body>
</html>
