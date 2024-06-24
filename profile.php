<?php
require_once './backend/middleware.php';
session_start();

if (!isset($_SESSION['user_info'])) {
    header("Location: login.html");
    exit();
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
                    <?php
                    if ($_SESSION['role'] == 2) {
                        echo '<a href="admin.php"><li>Painel de Controlo</li></a>';
                    }
                    ?>
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
            <h1 class="title">O teu Perfil</h1>

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

            <div class="profile-info">
                <p><strong>Nome:</strong>
                    <?= htmlspecialchars($user_info['name']) . " " . htmlspecialchars($user_info['lastname']) ?> </p>
                <p><strong>Nome de Usuario:</strong> <?php echo htmlspecialchars($user_info['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user_info['email']); ?></p>
                <p><strong>Telemóvel:</strong> <?php echo htmlspecialchars($user_info['phone']); ?></p>
            </div>

            <h2 class="title">Mudar Palavra-Passe</h2>
            <form action="backend/auth.php" method="post" class="change-password-form">
                <input type="hidden" name="action" value="change_password">
                <label for="current_password">Palavra-Passe Atual:</label>
                <input type="password" id="current_password" name="current_password" required>

                <label for="new_password">Nova Palavra-Passe:</label>
                <input type="password" id="new_password" name="new_password" required>

                <label for="confirm_password">Confirma a nova Palavra-Passe:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>

                <input type="submit" value="Change Password">
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