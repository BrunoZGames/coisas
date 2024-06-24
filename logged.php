<?php
require_once './backend/middleware.php';

echo "This is a protected page. Only logged-in users can see this.";


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

            <div class="nav-username">
                <a href="profile.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                        class="size-4">
                        <path fill-rule="evenodd"
                            d="M15 8A7 7 0 1 1 1 8a7 7 0 0 1 14 0Zm-5-2a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM8 9c-1.825 0-3.422.977-4.295 2.437A5.49 5.49 0 0 0 8 13.5a5.49 5.49 0 0 0 4.294-2.063A4.997 4.997 0 0 0 8 9Z"
                            clip-rule="evenodd" />
                    </svg>

                    <?= $_SESSION['user_info']['name'] . ' ' . $_SESSION['user_info']['lastname'] ?></a>
            </div>
            <div id="menuToggle">
                <input type="checkbox" />
                <span></span>
                <span></span>
                <span></span>
                <ul id="menu">
                    <a href="#inicio">
                        <li>Inicio</li>
                    </a>
                    <a href="#aboutme">
                        <li>Sobre Mim</li>
                    </a>
                    <a href="#contact">
                        <li>Contato</li>
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


    <span id="inicio" class="anchor"></span>

    <!--FOTO PAGINA INICIAL-->
    <div class="banner">
        <img src="imagens/inicio.jpg" alt="Fujimoto Barbershop" height="800px" width="100%">

    </div>

    <span id="aboutme" class="anchor"></span>
    <!--PAGINA SOBRE A BARBEARIA-->
    <div class="content">
        <div class="about-me-container">
            <!-- Left Video Column -->
            <div class="video-column">
                <div class="video-container">
                    <video src="./imagens/vid1.mp4" loop autoplay muted></video>
                </div>
            </div>

            <!-- Middle Text Column -->
            <div class="text-column">
                <h2 class="about-me-heading">SOBRE MIM!</h2>
                <p class="about-me-text">O meu nome é Daniel Ferreira, tenho 18 anos e sou natural de Tarouca, na bela
                    região de Viseu. Recentemente, tive a alegria de concluir o curso de Barbeiro Profissional na
                    reconhecida escola "DoItBetter" em Coimbra. Esta conquista representa um marco importante na minha
                    vida
                    e estou extremamente entusiasmado com as oportunidades que esta área oferece. Tenho observado um
                    crescimento significativo da profissão de barbeiro, especialmente entre os jovens, o que me deixa
                    ainda
                    mais motivado.</p>
                <p class="about-me-text">Atualmente, estou a aplicar na prática todos os conhecimentos e habilidades que
                    adquiri durante o curso. Para isso, montei o meu próprio negócio, onde ofereço serviços de cortes de
                    cabelo e barba diretamente no conforto do meu quarto. Esta experiência tem sido incrivelmente
                    valiosa,
                    permitindo-me evoluir como profissional, ganhar experiência prática e também apoiar os meus futuros
                    objetivos e ambições na área.</p>
                <p class="about-me-text">Se alguém estiver à procura de um corte de cabelo ou de barba personalizado,
                    estou
                    aqui para ajudar! Tenho plena confiança nas minhas técnicas e competências, que abrangem uma vasta
                    gama
                    de estilos de cortes masculinos. Para mim, é extremamente gratificante poder trabalhar numa área que
                    amo
                    e ver a satisfação dos meus clientes ao saírem com um visual renovado.</p>
                <p class="about-me-text">A todos os interessados, fica o convite: venham experimentar os meus serviços e
                    deixem-me cuidar do vosso visual com dedicação e profissionalismo.</p>
                <p class="about-me-text">Um abraço,</p>
                <p class="about-me-text">Daniel Ferreira</p>
            </div>

            <!-- Right Video Column -->
            <div class="video-column">
                <div class="video-container">
                    <video src="./imagens/vid2.mp4" loop autoplay muted></video>
                </div>
            </div>
        </div>

        <!--INSTAGRAM FEED-->
        <div class="instagram-feed">
            <iframe src="https://snapwidget.com/embed/1068456" class="snapwidget-widget" allowtransparency="true"
                frameborder="0" scrolling="no" style="border:none; overflow:hidden;  width:765px; height:510px"
                title="Posts from Instagram"></iframe>
        </div>

        <span id="contact" class="anchor"></span>
    </div>
    <!--CONTACT SECTION-->
    <section class="contact-section">
        <div class="container-loc">
            <div class="map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d937.540305448903!2d-7.760836230337422!3d41.03545310980924!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd3b55005ab29431%3A0x48655faaa129c17c!2sFujimoto%20Barbershop!5e1!3m2!1spt-PT!2ses!4v1716940230462!5m2!1spt-PT!2ses"
                    width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
                    tabindex="0"></iframe>
            </div>
            <div class="contact-info">
                <h2>Informação de Contato</h2>
                <p><strong>Address:</strong> 123 Main Street, Anytown, USA</p>
                <p><strong>Phone:</strong> (123) 456-7890</p>
                <p><strong>Email:</strong> contact@example.com</p>
            </div>
        </div>
    </section>

    <!--APPOINTMENT SECTION-->

    <section class="appointment-section">
        <div class="appointment-container">
            <h1>Agendamento</h1>
            <br>
            <a href="agendamento.php"><button class="agendamento-button">Fazer um Agendamento</button></a>
        </div>
    </section>

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