<?php
require 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.location.href='register.html';</script>";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $hashed_password);
    
    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Please login.'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Registration failed! Try again.'); window.location.href='register.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
