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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 650,
                events: 'fetchEvents.php',

                selectable: true,
                select: async function (start, end, allDay) {
                    const { value: formValues } = await Swal.fire({
                        title: 'Add Event',
                        confirmButtonText: 'Submit',
                        showCloseButton: true,
                        showCancelButton: true,
                        html:
                            '<input id="swalEvtTitle" class="swal2-input" placeholder="Enter title">' +
                            '<textarea id="swalEvtDesc" class="swal2-input" placeholder="Enter description"></textarea>' +
                            '<input id="swalEvtURL" class="swal2-input" placeholder="Enter URL">',
                        focusConfirm: false,
                        preConfirm: () => {
                            return [
                                document.getElementById('swalEvtTitle').value,
                                document.getElementById('swalEvtDesc').value,
                                document.getElementById('swalEvtURL').value
                            ]
                        }
                    });

                    if (formValues) {
                        // Add event
                        fetch("eventHandler.php", {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({ request_type: 'addEvent', start: start.startStr, end: start.endStr, event_data: formValues }),
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status == 1) {
                                    Swal.fire('Event added successfully!', '', 'success');
                                } else {
                                    Swal.fire(data.error, '', 'error');
                                }

                                // Refetch events from all sources and rerender
                                calendar.refetchEvents();
                            })
                            .catch(console.error);
                    }
                },

                eventClick: function (info) {
                    info.jsEvent.preventDefault();

                    // change the border color
                    info.el.style.borderColor = 'red';

                    Swal.fire({
                        title: info.event.title,
                        icon: 'info',
                        html: '<p>' + info.event.extendedProps.description + '</p><a href="' + info.event.url + '">Visit event page</a>',
                        showCloseButton: true,
                        showCancelButton: true,
                        showDenyButton: true,
                        cancelButtonText: 'Close',
                        confirmButtonText: 'Delete',
                        denyButtonText: 'Edit',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Delete event
                            fetch("eventHandler.php", {
                                method: "POST",
                                headers: { "Content-Type": "application/json" },
                                body: JSON.stringify({ request_type: 'deleteEvent', event_id: info.event.id }),
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status == 1) {
                                        Swal.fire('Event deleted successfully!', '', 'success');
                                    } else {
                                        Swal.fire(data.error, '', 'error');
                                    }

                                    // Refetch events from all sources and rerender
                                    calendar.refetchEvents();
                                })
                                .catch(console.error);
                        } else if (result.isDenied) {
                            // Edit and update event
                            Swal.fire({
                                title: 'Edit Event',
                                html:
                                    '<input id="swalEvtTitle_edit" class="swal2-input" placeholder="Enter title" value="' + info.event.title + '">' +
                                    '<textarea id="swalEvtDesc_edit" class="swal2-input" placeholder="Enter description">' + info.event.extendedProps.description + '</textarea>' +
                                    '<input id="swalEvtURL_edit" class="swal2-input" placeholder="Enter URL" value="' + info.event.url + '">',
                                focusConfirm: false,
                                confirmButtonText: 'Submit',
                                preConfirm: () => {
                                    return [
                                        document.getElementById('swalEvtTitle_edit').value,
                                        document.getElementById('swalEvtDesc_edit').value,
                                        document.getElementById('swalEvtURL_edit').value
                                    ]
                                }
                            }).then((result) => {
                                if (result.value) {
                                    // Edit event
                                    fetch("eventHandler.php", {
                                        method: "POST",
                                        headers: { "Content-Type": "application/json" },
                                        body: JSON.stringify({ request_type: 'editEvent', start: info.event.startStr, end: info.event.endStr, event_id: info.event.id, event_data: result.value })
                                    })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.status == 1) {
                                                Swal.fire('Event updated successfully!', '', 'success');
                                            } else {
                                                Swal.fire(data.error, '', 'error');
                                            }

                                            // Refetch events from all sources and rerender
                                            calendar.refetchEvents();
                                        })
                                        .catch(console.error);
                                }
                            });
                        } else {
                            Swal.close();
                        }
                    });
                }
            });

            calendar.render();
        });
    </script>

    <div class="reg-cont">


        <div id="calendar"></div>





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