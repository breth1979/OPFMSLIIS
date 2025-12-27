<?php
session_start();

// 1. Connect to the database
$conn = new mysqli("localhost", "root", "", "test");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Get submitted data
$username = $_POST['username'];
$userpassword = $_POST['userpassword'];

// 3. Prepare query
$stmt = $conn->prepare("SELECT id, userpassword, fullname, citymunicipality, Level FROM users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $username, $username);
$stmt->execute();
$result = $stmt->get_result();

// 4. Check if user exists
if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // 5. Verify password
    if (password_verify($userpassword, $row['userpassword'])) {
        $_SESSION['userid'] = $row['id'];
        $_SESSION['username'] = $username;
        $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['Level'] = $row['Level'];
              $_SESSION['citymunicipality'] = $row['citymunicipality'];
         // ← Add this


        header("refresh:1; url=main.php"); // Replace with your target page
    } else {
        echo "❌ Incorrect password.";
    }
} else {
    echo "❌ No user found with that username or email.";
}

$stmt->close();
$conn->close();
?>
