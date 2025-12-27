<?php
// 1. Connect to database
$conn = new mysqli("localhost", "root", "", "test");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Get form data
$username = $_POST['username'];
$email = $_POST['email'];
$userpassword = $_POST['userpassword'];
$fullname = $_POST['fullname']; // optional

// 3. Hash the password before storing
$hashedPassword = password_hash($userpassword, PASSWORD_DEFAULT);

// 4. Insert into database
$stmt = $conn->prepare("INSERT INTO users (username, email, userpassword, fullname) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $email, $hashedPassword, $fullname);

if ($stmt->execute()) {
   
    echo "✅ Registration successful!";
     header("refresh:1; url=main.php"); // Replace with your target page
    
    // header("Location: login.html"); // Optional redirect
} else {
    echo "❌ Error: " . $stmt->error;
     header("refresh:1; url=main.php"); // Replace with your target page
}

$stmt->close();
$conn->close();
?>
