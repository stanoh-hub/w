<?php
session_start();
require 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, name, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $hashed_password);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            echo "<script>alert('Login successful!'); window.location.href='dashboard.html';</script>";
            exit();
        } else {
            echo "<script>alert('Invalid credentials!'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href='login.html';</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>
