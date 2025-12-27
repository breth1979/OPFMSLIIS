<?php
// insertuser.php

// Get POST data
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$username = $_POST['username'];
$userpassword = password_hash($_POST['userpassword'], PASSWORD_DEFAULT); // Always hash passwords!
$citymunicipality = $_POST['citymunicipality'];
$Level = $_POST['Level'];
$grantor = $_POST['grantor']; // Logged-in user

// Database connection
$conn = new mysqli('localhost', 'root', '', 'test');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute insert statement
$stmt = $conn->prepare("INSERT INTO users (fullname, email, username, userpassword, citymunicipality, Level, grantor) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $fullname, $email, $username, $userpassword, $citymunicipality, $Level, $grantor);
try {
    $stmt->execute();
    echo "<script>alert('User successfully added!'); window.location='userview.php';</script>";
} catch (mysqli_sql_exception $e) {

    // Error number 1062 = Duplicate entry
    if ($e->getCode() == 1062) {
        echo "<script>alert('Error: Username already exists. Please choose another username.'); 
              window.history.back();
              </script>";
    } else {
        echo "<script>alert('An error occurred: " . addslashes($e->getMessage()) . "'); 
              window.history.back();
              </script>";
    }
}

if ($stmt->execute()) {
    echo "<script>alert('User added successfully!'); window.location='userview.php';</script>";
} else {
    echo "<script>alert('Error: " . $stmt->error . "'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
