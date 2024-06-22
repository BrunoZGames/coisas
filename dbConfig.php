<?php
// Database connection settings
$servername = "localhost";
$dbname = "fujimoto_barbershop";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}