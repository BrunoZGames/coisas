<?php
function isAdmin($conn)
{
    if (!isset($_SESSION['token'])) {
        return false;
    }

    $token = $_SESSION['token'];

    // Prepare statement to fetch role_name from users and roles tables
    $stmt = $conn->prepare("SELECT r.role_name 
                            FROM users u 
                            JOIN role_type r ON u.role_id = r.role_id 
                            WHERE u.token = ?");
    $stmt->bind_param("s", $token);

    // Execute the query
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($role_name);

    // Fetch the result
    $stmt->fetch();

    // Close statement
    $stmt->close();

    // Check if role_name matches "Admin"
    return $role_name === "administrador";
}




session_start();

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

// console log with log

if (!isAdmin($conn)) {
    echo "<script>alert('Access denied. Only Admins can access this page.');</script>";
    header("Location: logged.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    echo "<script>console.log('post test');</script>";

    $id = $conn->real_escape_string($_POST['id']);
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $name =$conn->real_escape_string($_POST['name']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $role_id = $conn->real_escape_string($_POST['role_id']);
    
    $password = $conn->real_escape_string($_POST['password']);

    $update_user = $_SESSION['user_info']['user_id'];
    date_default_timezone_set('Europe/Lisbon');
    $updated_at = date('Y-m-d H:i:s');

    if (empty($username) || empty($email) || empty($name) || empty($lastname) || empty($role_id)) {
        $_SESSION['error'] = "Por favor, preencha todos os campos.";
        header("Location: editarUser.php?id=$id");
        exit();
    }

    if (empty($password)) {
        
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, name = ?, last_name = ?, phonenumber = ?, role_id = ?, update_user = ?, updated_at = ?  WHERE user_id = ?");
        $stmt->bind_param("sssssiisi", $username, $email, $name, $lastname, $phone, $role_id, $update_user, $updated_at, $id);
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET username = ?, password = ?, email = ?, name = ?, last_name = ?, phonenumber = ?, role_id = ?, update_user = ?, updated_at = ?  WHERE user_id = ?");
        $stmt->bind_param("ssssssiisi", $username, $password, $email, $name, $lastname, $phone, $role_id, $update_user, $updated_at, $id);
    }

    

    if ($stmt->execute()) {
        $_SESSION['success'] = "Usuario atualizado corretamente!";
    } else {
        $_SESSION['error'] = "Erro ao atualizar o usuario: " . $stmt->error;
    }

    $stmt->close();
    header("Location: admin.php");
    exit();
} else {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT user_id, username, email, name, last_name, phonenumber, role_id FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($id, $username, $email, $name, $lastname, $phone, $role_id);
    $stmt->fetch();
    $stmt->close();

}




$user_info = $_SESSION['user_info'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fujimoto Barbershop</title>
    <link rel="stylesheet" href="styles.css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto&display=swap">


    <style>

    </style>
</head>

<body class="body">

    <!--CABEÇALHO-->

    <header class="header">
        <nav class="nav">
            <a href="#" class="logo">
                <img src="./imagens/fujimoto99.png" alt="Fujimoto" width="60" height="60">
                <span class="logo-text">Fujimoto</span>
            </a>
            <div id="menuToggle">
                <input type="checkbox" />
                <span></span>
                <span></span>
                <span></span>
                <ul id="menu">
                    <a href="logged.php">
                        <li>Inicio</li>
                    </a>
                    <a href="backend/logout.php">
                        <li style="color: red;">Log Out</li>
                    </a>
                </ul>
            </div>
        </nav>
    </header>

    </script>
    <div class="reg-cont2">

    <div class="profile-container">
        <h1 class="title">Editar Usuario</h1>

        <?php
        if (isset($_SESSION['error'])) {
            echo "<div class='error'>{$_SESSION['error']}</div>";
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo "<div class='success'>{$_SESSION['success']}</div>";
            unset($_SESSION['success']);
        }
        ?>

        <form action="editarUser.php" method="POST" class="change-password-form">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            
            <label for="lastname">Apelidos:</label>
            <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>" required>
            
            <label for="phone">Telemóvel:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
            
            <label for="role_id">Role:</label>
            <select id="role_id" name="role_id" required>
                <option value="2" <?php if ($role_id == 2) echo 'selected'; ?>>Admin</option>
                <option value="1" <?php if ($role_id == 1) echo 'selected'; ?>>Usuario</option>
            </select>
            
            <input type="submit" value="Atualizar Usuario">
        </form>
    </div>




    </div>

    <!--RODAPÉ-->
    <footer class="black-background">
        <div class="page-inner-content footer-content">
            <div class="logo-footer">
                <h1 class="logo">Fujimoto Barbershop</h1>
                <p>O meu objetivo é oferecer produtos e cortes de
                    qualidade...</p>
            </div>
            <div class="links-footer">
                <h3>Links úteis</h3>
                <ul>
                    <li><a href="https://www.instagram.com/fujimotobarbershop/" target="_blank">Instagram</a></li>
                    <li><a href="https://www.x.com/" target="_blank">Twitter</a></li>
                    <li><a href="https://www.tiktok.com/" target="_blank">TikTok</a></li>
                    <li><a href="https://www.facebook.com/" target="_blank">Facebook</a></li>
                </ul>
            </div>
        </div>
        <hr class="page-inner-content" />
        <div class="page-inner-content copyright">
            <p>© 2024 - Rodrigo Pinto - Todos os Direitos Reservados</p>
        </div>
    </footer>
    <script defer src="scripts.js"></script>

</body>

</html>