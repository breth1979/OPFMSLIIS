<?php
include 'db_connect.php';
$result = $conn->query("SELECT * FROM files ORDER BY uploaded_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Uploaded Files</title>
  <style>
    table { border-collapse: collapse; width: 60%; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
  </style>
</head>
<body>
  <h2>Uploaded Files</h2>
  <a href="upload_form.html">⬅ Back to Upload</a>
  <table>
    <tr>
      <th>ID</th>
      <th>Filename</th>
      <th>Date Uploaded</th>
      <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      
      <td><?= htmlspecialchars($row['filename']) ?></td>
      <td><?= htmlspecialchars($row['uploaded_at']) ?></td>
      <td>
        <a href="<?= htmlspecialchars($row['filepath']) ?>" target="_blank">View</a> |
        <a href="<?= htmlspecialchars($row['filepath']) ?>" download>Download</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
