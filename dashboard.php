<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}
include 'db.php';

// Inisialisasi pesan popup
$popup = '';
$popup_type = 'info';

// Hapus file
if (isset($_GET['delete'])) {
  $fileToDelete = $_GET['delete'];
  $stmt = $conn->prepare("DELETE FROM files WHERE file_url = ?");
  $stmt->bind_param("s", $fileToDelete);
  $stmt->execute();
  $targetPath = "uploads/" . basename($fileToDelete);
  if (file_exists($targetPath)) unlink($targetPath);
  // Redirect dengan pesan sukses dan tetap di tab hapus
  header("Location: dashboard.php?section=hapus&msg=" . urlencode("File berhasil dihapus.") . "&type=success");
  exit();
}

// Upload file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
  if ($_FILES['pdf_file']['type'] === "application/pdf") {
    $filename = basename($_FILES['pdf_file']['name']);
    $target = "uploads/" . $filename;
    if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $target)) {
      $stmt = $conn->prepare("INSERT INTO files (file_name, file_url) VALUES (?, ?)");
      $stmt->bind_param("ss", $filename, $filename);
      $stmt->execute();
      header("Location: dashboard.php?section=upload&msg=" . urlencode("Upload sukses.") . "&type=success");
      exit();
    } else {
      $popup = "❌ Gagal upload file.";
      $popup_type = "error";
    }
  } else {
    $popup = "❌ File harus berformat PDF.";
    $popup_type = "error";
  }
}

// Ambil pesan dari URL jika ada
if (isset($_GET['msg'])) {
  $popup = $_GET['msg'];
  $popup_type = $_GET['type'] ?? 'info';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="styledashboard.css">
</head>
<body>

  <div class="sidebar">
    <h3>Admin Panel</h3>
    <a onclick="showSection('upload')">Upload File</a>
    <a onclick="showSection('hapus')">Hapus File</a>
    <a href="logout.php">Logout</a>
  </div>

  <div class="main">
    <div id="upload" class="section">
      <h2>Upload PDF</h2>
      <form id="upload-form" method="post" enctype="multipart/form-data" novalidate>
        <div id="drop-area">
          <p id="drop-text">Drag & Drop file PDF di sini<br>atau klik untuk pilih file</p>
          <input type="file" name="pdf_file" id="fileElem" accept="application/pdf" required>
        </div>
        <button type="submit" id="upload-btn" disabled>Upload</button>
      </form>
    </div>

    <div id="hapus" class="section">
      <h2>Daftar File</h2>
      <?php
        $result = $conn->query("SELECT * FROM files ORDER BY uploaded_at DESC");
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<div class='file-item'>
              <a class='file-name' href='uploads/" . htmlspecialchars($row['file_url']) . "' target='_blank'>" . htmlspecialchars($row['file_name']) . "</a>
              <a href='dashboard.php?delete=" . urlencode($row['file_url']) . "' class='delete-link'>
                <button class='delete-btn' type='button'>Hapus</button>
              </a>
            </div>";
          }
        } else {
          echo "<p>Tidak ada file.</p>";
        }
      ?>
    </div>
  </div>

  <div id="popup-message"></div>

  <!-- Modal Konfirmasi Hapus Modern -->
  <div id="confirmModal" class="modal" style="display:none; position: fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); justify-content:center; align-items:center; z-index:9999;">
    <div style="background:#fff; padding:20px; border-radius:8px; max-width:320px; width:90%; text-align:center; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
      <p>Yakin ingin menghapus file ini?</p>
      <div style="margin-top:20px; display:flex; justify-content:space-around;">
        <button id="confirmDelete" style="padding:8px 20px; border:none; background:#e74c3c; color:#fff; border-radius:6px; cursor:pointer;">Hapus</button>
        <button id="cancelDelete" style="padding:8px 20px; border:none; background:#bdc3c7; color:#fff; border-radius:6px; cursor:pointer;">Batal</button>
      </div>
    </div>
  </div>

  <script>
    // Tampilkan section sesuai parameter URL
    function showSection(id) {
      document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active'));
      document.getElementById(id).classList.add('active');
      // Update URL parameter tanpa reload halaman
      const url = new URL(window.location);
      url.searchParams.set('section', id);
      url.searchParams.delete('msg');
      url.searchParams.delete('type');
      window.history.replaceState({}, '', url);
    }

    // Cek section dari URL dan tampilkan
    const urlParams = new URLSearchParams(window.location.search);
    const section = urlParams.get('section') || 'upload';
    showSection(section);

    // Drag & drop dan file input handling
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('fileElem');
    const dropText = document.getElementById('drop-text');
    const uploadBtn = document.getElementById('upload-btn');

    dropArea.addEventListener('dragenter', (e) => {
      e.preventDefault();
      dropArea.classList.add('dragover');
    });
    dropArea.addEventListener('dragover', (e) => {
      e.preventDefault();
      dropArea.classList.add('dragover');
    });
    dropArea.addEventListener('dragleave', (e) => {
      e.preventDefault();
      dropArea.classList.remove('dragover');
    });
    dropArea.addEventListener('drop', (e) => {
      e.preventDefault();
      dropArea.classList.remove('dragover');
      if (e.dataTransfer.files.length) {
        const file = e.dataTransfer.files[0];
        if(file.type !== 'application/pdf') {
          alert('File harus berformat PDF!');
          fileInput.value = "";
          dropText.textContent = "Drag & Drop file PDF di sini\natau klik untuk pilih file";
          uploadBtn.disabled = true;
          return;
        }
        fileInput.files = e.dataTransfer.files;
        dropText.textContent = "File terpilih: " + file.name;
        uploadBtn.disabled = false;
      }
    });

    fileInput.addEventListener('change', () => {
      if(fileInput.files.length > 0) {
        const file = fileInput.files[0];
        if(file.type !== 'application/pdf') {
          alert('File harus berformat PDF!');
          fileInput.value = "";
          dropText.textContent = "Drag & Drop file PDF di sini\natau klik untuk pilih file";
          uploadBtn.disabled = true;
          return;
        }
        dropText.textContent = "File terpilih: " + file.name;
        uploadBtn.disabled = false;
      } else {
        dropText.textContent = "Drag & Drop file PDF di sini\natau klik untuk pilih file";
        uploadBtn.disabled = true;
      }
    });

    // Popup message handling
    const popup = document.getElementById('popup-message');
    function showPopup(message, type = 'info') {
      popup.textContent = message;
      popup.className = '';
      popup.classList.add('show', type);
      setTimeout(() => {
        popup.classList.remove('show');
      }, 4000);
    }

    <?php if (!empty($popup)): ?>
      showPopup(<?= json_encode($popup) ?>, <?= json_encode($popup_type) ?>);
    <?php endif; ?>

    // Popup konfirmasi hapus modern non-blocking
    let deleteLink = null;

    document.querySelectorAll('.delete-link').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        deleteLink = this.href;
        document.getElementById('confirmModal').style.display = 'flex';
      });
    });

    document.getElementById('cancelDelete').addEventListener('click', () => {
      document.getElementById('confirmModal').style.display = 'none';
      deleteLink = null;
    });

    document.getElementById('confirmDelete').addEventListener('click', () => {
      if(deleteLink) {
        window.location.href = deleteLink;
      }
    });
  </script>

</body>
</html>
