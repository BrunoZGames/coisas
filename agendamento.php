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

        <link href="https://cdn.syncfusion.com/ej2/26.1.35/ej2-base/styles/material.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.syncfusion.com/ej2/26.1.35/ej2-buttons/styles/material.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.syncfusion.com/ej2/26.1.35/ej2-calendars/styles/material.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.syncfusion.com/ej2/26.1.35/ej2-dropdowns/styles/material.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.syncfusion.com/ej2/26.1.35/ej2-inputs/styles/material.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.syncfusion.com/ej2/26.1.35/ej2-splitbuttons/styles/material.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.syncfusion.com/ej2/26.1.35/ej2-lists/styles/material.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.syncfusion.com/ej2/26.1.35/ej2-popups/styles/material.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.syncfusion.com/ej2/26.1.35/ej2-navigations/styles/material.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.syncfusion.com/ej2/26.1.35/ej2-schedule/styles/material.css" rel="stylesheet" type="text/css"/>
        
		<script src="https://cdn.syncfusion.com/ej2/26.1.35/dist/ej2.min.js" type="text/javascript"></script>
        <script>
           
        </script>

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
 

    <div class="reg-cont">


    <?php
  // initialize scheduler
  echo '
  <div id="Schedule"></div>
  <script>
  ej.base.registerLicense("ORg4AjUWIQA/Gnt2U1hhQlJBfVhdX2dWfFN0QXNYfVRzcl9GZkwxOX1dQl9nSXhRckRgWH9dc3NWQ2g=");
  var dataManager = new ej.data.DataManager({
	url: "http://localhost/server.php",
	crudUrl: "http://localhost/server.php",
	adaptor: new ej.data.UrlAdaptor(),
	crossDomain: true
});
    var scheduleObj = new ej.schedule.Schedule({
		height: "650px",
        views: [{ option: "Month", showWeekNumber: true, readonly: false  }, "TimelineDay", "TimelineWeek"],
        allowDragAndDrop: true,
        eventSettings: { dataSource: dataManager },
        group: {
            resources: ["MeetingRoom"]
        },
        resources: [{
                field: "RoomID", title: "Room Type",
                name: "MeetingRoom", allowMultiple: true,
                dataSource: [
                    { text: "HairCut", id: 1, color: "#ea7a57", capacity: 1, type: "HairCut" },
                ],
                textField: "text", idField: "id", colorField: "color"
            }],
    });
    scheduleObj.appendTo("#Schedule");
  </script>
  ';
?>





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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/fullcalendar-6.1.14/dist/index.global.js" defer></script>
</body>

</html>