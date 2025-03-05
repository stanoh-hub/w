<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to access this page!'); window.location.href='login.html';</script>";
    exit();
}
?>
