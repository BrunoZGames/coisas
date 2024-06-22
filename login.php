<?php
session_start();
if (isset($_SESSION['token'])) {
    header("Location: logged.php");
    exit;
}
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
                    <a href="index.html">
                        <li>Inicio</li>
                    </a>
                    <a href="register.php">
                        <li>Sign Up</li>
                    </a>
                </ul>
            </div>
        </nav>
    </header>



    <div class="reg-cont">
        <div class="register-container">
            <h1 class="title">Log In</h1>
            <form action="backend/auth.php" method="post" class="register-form">
                <input type="hidden" name="action" value="login">
                <label for="username">Nome de Usuario:</label><br>
                <input type="text" id="username" name="username" required><br>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br>
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
                <input type="submit" value="Log In">
                <p>Não tem uma conta? <a href="register.html">Registre-se</a></p>
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