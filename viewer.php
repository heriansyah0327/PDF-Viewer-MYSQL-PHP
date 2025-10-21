<?php
if (!isset($_GET['file'])) {
  die("No file specified.");
}

$fileName = basename($_GET['file']);
$file = 'uploads/' . $fileName;

// Pastikan file ada dan valid
if (!file_exists($file) || mime_content_type($file) !== 'application/pdf') {
  die("Invalid file.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PDF Viewer - <?php echo htmlspecialchars($fileName); ?></title>
  <style>
    body, html {
      height: 100%;
      margin: 0;
      padding: 0;
      background: #f4f4f4;
      display: flex;
      flex-direction: column;
      font-family: Arial, sans-serif;
    }
    header {
      background: #222;
      color: #fff;
      padding: 6px 20px;
      font-size: 16px;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      position: relative;
      height: 40px;
    }
    a.back-button {
      position: absolute;
      left: 20px;
      display: flex;
      align-items: center;
      color: #fff;
      text-decoration: none;
      font-size: 14px;
      cursor: pointer;
      padding: 6px 10px;
      background-color: #444;
      border-radius: 20px;
      transition: background-color 0.3s;
      user-select: none;
    }
    a.back-button:hover {
      background-color: #666;
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
    }
    .title {
      width: 100%;
      text-align: center;
      font-weight: bold;
      font-size: 16px;
      user-select: none;
    }
    embed {
      flex-grow: 1;
      border: none;
      width: 100%;
      height: 100%;
      display: block;
    }
    #download-message {
      display: none;
      padding: 20px;
      text-align: center;
      background: #f0f0f0;
      flex-grow: 1;
      font-size: 18px;
    }
    #download-message a {
      display: inline-block;
      margin-top: 15px;
      padding: 10px 20px;
      background-color: #0a64ff;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 600;
      transition: background-color 0.3s;
    }
    #download-message a:hover {
      background-color: #094cbf;
    }
  </style>
</head>
<body>
  <header>
    <a class="back-button" href="index.php">Back</a>
    <div class="title">Viewing: <?php echo htmlspecialchars($fileName); ?></div>
  </header>

  <embed id="pdfEmbed" src="<?php echo htmlspecialchars($file); ?>" type="application/pdf"></embed>

  <div id="download-message">
    PDF ini sulit ditampilkan di perangkat Anda.<br />
    <a href="<?php echo htmlspecialchars($file); ?>" target="_blank" rel="noopener noreferrer">Klik untuk membaca</a>
  </div>

  <script>
    function isMobile() {
      return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }

    if (isMobile()) {
      document.getElementById('pdfEmbed').style.display = 'none';
      document.getElementById('download-message').style.display = 'flex';
      document.getElementById('download-message').style.flexDirection = 'column';
      document.getElementById('download-message').style.justifyContent = 'center';
    }
  </script>
</body>
</html>
