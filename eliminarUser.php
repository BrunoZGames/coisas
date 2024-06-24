<?php
require_once './backend/middleware.php';
require_once './backend/auth.php';
session_start();

if (!isAdmin($conn)) {
    echo "<script>alert('Access denied. Only Admins can access this page.');</script>";
    header("Location: logged.php");
    exit();
}


$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['success'] = "Usuario eliminado correctamente!";
} else {
    $_SESSION['error'] = "Erro a eliminar usuario: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: admin.php");
exit();