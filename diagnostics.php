<?php
session_start();
require 'config.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to perform diagnostics!'); window.location.href='login.html';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $vin = $_POST['vin'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $mileage = $_POST['mileage'];
    $issue = $_POST['issue'];
    
    $sql = "INSERT INTO diagnostics (user_id, vin, make, model, year, mileage, issue, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssiss", $user_id, $vin, $make, $model, $year, $mileage, $issue);
    
    if ($stmt->execute()) {
        echo "<script>alert('Diagnostics submitted successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to submit diagnostics!'); window.location.href='diagnostics.html';</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>
