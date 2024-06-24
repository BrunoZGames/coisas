<?php
require_once 'auth.php';

if (!isAuthenticated($conn)) {
    
    echo "<script>alert('Access denied. Please log in.');</script>";
    header("Location: ../login.php");
    exit();
}
?>
