<?php
require_once 'auth.php';

if (!isAuthenticated($conn)) {
    echo "Access denied. Please log in.";
    exit();
}
?>
