<?php
date_default_timezone_set('Asia/Jakarta');
include 'db.php';

$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? 'newest';

$sql = "SELECT * FROM files WHERE file_name LIKE ?";
switch ($sort) {
  case 'oldest': $sql .= " ORDER BY uploaded_at ASC"; break;
  case 'az': $sql .= " ORDER BY file_name ASC"; break;
  case 'za': $sql .= " ORDER BY file_name DESC"; break;
  default: $sql .= " ORDER BY uploaded_at DESC";
}

$stmt = $conn->prepare($sql);
$like = "%$search%";
$stmt->bind_param("s", $like);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $fileUrl = htmlspecialchars($row['file_url']);
    $fileName = htmlspecialchars($row['file_name']);
    echo "
      <div class='file-card'>
        <a href='viewer.php?file=" . urlencode($fileUrl) . "' class='file-name'>$fileName</a>
        <div style='font-size:14px;color:#666;text-align:right;white-space:nowrap;'>
          " . date('d M Y, H:i', strtotime($row['uploaded_at'])) . "
        </div>
      </div>
    ";
  }
} else {
  echo "<p style='text-align:center;'>Tidak ada file PDF yang cocok.</p>";
}
?>
