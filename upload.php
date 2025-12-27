<?php
include 'db_connect.php'; // <-- your database connection (MySQLi or PDO)
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: main.php");
    exit();
}
echo "<script>
    alert('⛔ Access Level: " . $_SESSION['Level'] . "');
</script>";

if ($_SESSION['Level'] !== 'Administrator' && $_SESSION['Level'] !== 'Encoder') {
    echo "<script>
    alert('⛔ Access denied. Admin and Encoder only! ');
    window.location.href = 'main.php'; // or login.php
</script>";
exit();

}

// Folder for uploads
$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $id=$_POST['file'];
    $fileName = basename($file['name']);
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        // Save info to DB
        $stmt = $conn->prepare("INSERT INTO files (filename, filepath, id) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $fileName, $targetPath, $id);
        $stmt->execute();
        echo "<script>
        alert('✅ File uploaded successfully!');
        window.history.go(-2);
       
    </script>";
    exit;

       // echo "<p>✅ File uploaded successfully!</p>";
        // echo '<a href="file_list.php">View Uploaded Files</a>';
    } else {
        echo "❌ Upload failed.";
    }
}
?>

