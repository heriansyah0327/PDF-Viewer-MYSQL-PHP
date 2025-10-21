<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Daftar PDF</title>
  <link rel="stylesheet" href="css/styleindex.css">
</head>
<body>
  <nav>
    <div class="nav-left">📄 Daftar PDF</div>
    <a href="login.php" class="admin-login">Admin Login</a>
  </nav>

  <div class="container">
    <div class="filter-bar">
      <input type="text" id="searchInput" placeholder="Cari nama file...">
      <select id="sortSelect">
        <option value="newest">Tanggal: Terbaru</option>
        <option value="oldest">Tanggal: Terlama</option>
        <option value="az">Nama: A-Z</option>
        <option value="za">Nama: Z-A</option>
      </select>
    </div>

    <div id="fileList">
    </div>
  </div>

  <script>
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const fileList = document.getElementById('fileList');

    function loadFiles() {
      const search = searchInput.value;
      const sort = sortSelect.value;
      fetch(`fetch_files.php?search=${encodeURIComponent(search)}&sort=${sort}`)
        .then(res => res.text())
        .then(html => fileList.innerHTML = html)
        .catch(err => console.error('Error:', err));
    }

    loadFiles();

    searchInput.addEventListener('input', loadFiles);
    sortSelect.addEventListener('change', loadFiles);
  </script>
</body>
</html>
