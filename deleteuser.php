<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: main.php");
    exit();
}

// Check if ID is provided
if (!isset($_GET['id'])) {
    echo "No user ID specified!";
    exit();
}

$id = $_GET['id'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'test'); // change 'test' to your DB name
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute delete query
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('User deleted successfully!'); window.location='userview.php';</script>";
} else {
    echo "<script>alert('Error deleting user!'); window.location='userview.php';</script>";
}

$stmt->close();
$conn->close();
?>
