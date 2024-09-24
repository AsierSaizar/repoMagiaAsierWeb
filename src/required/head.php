<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    require_once("define.php");
    session_start();
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DiarioMagico</title>
    <link rel="icon" type="image/png" href="../../../public/logoRepertorio.png">

    <!-- CARRUSEL DE FOTOS //////////////////-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- SIDE BARRANTZAT DA HAUUU //////////////////-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- IKONONTZAKO DA //////////////////-->
    <script src="https://kit.fontawesome.com/7f605dc8fe.js" crossorigin="anonymous"></script>



    <!-- J-QUERY //////////////////-->

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="<?= HREF_SRC_DIR ?>/required/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- HEADERREKO CSS-a //////////////////-->
    <link rel="stylesheet" href="<?= HREF_SRC_DIR ?>/css/header.css">

</head>

<body>
    <header class="header">
        <div class="header-left">
            <!-- SIDE BARRANTZAT DA HAUUU //////////////////-->
            <div>
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvassrcolling" aria-controls="offcanvassrcolling">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
            <?php
            require_once(APP_DIR . "/src/required/sideBar.php");
            ?>

            <!-- SIDE BARRANTZAT DA HAUUU //////////////////-->

            <div class="tagline">
                <span> El Diario Magico</span>
            </div>
            <div class="logo">
                <a href="<?= HREF_VIEWS_DIR ?>/home/home.php">
                    <img src='../../../public/logoRepertorio.png' width="50px">
                </a>
            </div>

            <div class="buscador">
                <i class="fa-solid fa-magnifying-glass" id="icono-buscar"></i>
                <input type="text" id="search-input" placeholder="Buscar..." class="search-field">
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const iconoBuscar = document.getElementById("icono-buscar");
                const campoBuscar = document.getElementById("search-input");
                const botonSiguiente = document.getElementById("next-button");
                let currentIndex = -1; // Índice de la coincidencia actual
                let allMatches = []; // Lista de todos los elementos resaltados

                // Mostrar el campo de búsqueda cuando se hace clic en la lupa
                iconoBuscar.addEventListener("click", function () {
                    campoBuscar.classList.toggle("active"); // Alternar clase para mostrar/ocultar el campo
                    campoBuscar.focus(); // Poner el foco en el campo de búsqueda al mostrarlo
                });

                // Escuchar los cambios en el campo de búsqueda
                campoBuscar.addEventListener("input", function () {
                    const searchTerm = campoBuscar.value;
                    if (searchTerm) {
                        resaltarCoincidencias(searchTerm);
                        currentIndex = -1; // Reiniciar el índice cuando cambie la búsqueda
                        botonSiguiente.style.display = "inline-block"; // Mostrar el botón "Siguiente"
                    } else {
                        quitarResaltados(); // Limpiar los resaltados si no hay texto
                        botonSiguiente.style.display = "none"; // Ocultar el botón "Siguiente" si no hay búsqueda
                    }
                });

                // Ejecutar la búsqueda al presionar "Enter"
                campoBuscar.addEventListener("keydown", function (event) {
                    if (event.key === "Enter") { // Si se presiona la tecla Enter
                        event.preventDefault(); // Evitar que el formulario se envíe si es el caso
                        if (allMatches.length > 0) {
                            currentIndex++;
                            if (currentIndex >= allMatches.length) {
                                currentIndex = 0; // Volver al principio si se llega al final
                            }
                            moverACoincidencia(currentIndex);
                        }
                    }
                });

                // Al hacer clic en "Siguiente", se mueve a la siguiente coincidencia
                botonSiguiente.addEventListener("click", function () {
                    if (allMatches.length > 0) {
                        currentIndex++;
                        if (currentIndex >= allMatches.length) {
                            currentIndex = 0; // Volver al principio si se llega al final
                        }
                        moverACoincidencia(currentIndex);
                    }
                });

                // Función para quitar los resaltados anteriores
                function quitarResaltados() {
                    const resaltados = document.querySelectorAll('.highlightt');
                    resaltados.forEach(function (span) {
                        span.outerHTML = span.innerHTML; // Quitar el <span> y devolver el texto original
                    });
                    allMatches = []; // Limpiar la lista de coincidencias
                }

                // Función para resaltar todas las coincidencias en el texto
                function resaltarCoincidencias(term) {
                    quitarResaltados(); // Limpiar los resaltados previos

                    // Crear expresión regular para buscar el término (sin distinción de mayúsculas/minúsculas)
                    const regex = new RegExp(`(${term})`, 'gi');

                    // Recorrer todo el contenido del documento y resaltar
                    const elementos = document.querySelectorAll("body *:not(script):not(style):not(.search-field)");
                    elementos.forEach(function (el) {
                        if (el.children.length === 0) { // Solo elementos que no tienen hijos (texto puro)
                            el.innerHTML = el.innerHTML.replace(regex, '<span class="highlightt">$1</span>');
                        }
                    });

                    // Actualizar la lista de coincidencias
                    allMatches = document.querySelectorAll('.highlightt');
                }

                // Función para moverse a la coincidencia actual
                function moverACoincidencia(index) {
                    allMatches.forEach(function (match, i) {
                        match.classList.remove('current-highlightt'); // Quitar el resaltado actual
                        if (i === index) {
                            match.classList.add('current-highlightt'); // Resaltar la coincidencia actual
                            match.scrollIntoView({ behavior: 'smooth', block: 'center' }); // Desplazarse a la coincidencia
                        }
                    });
                }
            });

        </script>

        <!-- USUARIOA KONTROLA //////////////////-->
        <?php

        $usuario = "";
        if (isset($_GET["usuario"])) {
            $usuario = isset($_GET["usuario"]) ? $_GET["usuario"] : "Asier";
        }


        if (!isset($_SESSION["usuario"])) { //Sesioan usuarioa ez badago
            //Defektuzko usuarioa sortu
            $_SESSION["usuario"] = "Asier";
        }

        if ($usuario == "Asier" || $usuario == "Benat") {
            $_SESSION["usuario"] = $usuario;
        }


        if ($_SESSION["usuario"] == "Asier") {
            $ClasSubAsier = "clasSub";
            $ClasSubBenat = "";
        } else if ($_SESSION["usuario"] == "Benat") {
            $ClasSubBenat = "clasSub";
            $ClasSubAsier = "";
        }

        ?>

        <div class="usuarioNameDiv">
            <a href="../home/home.php?usuario=Asier" class="usuarioNameAsier usuarioName <?= $ClasSubAsier ?>">Asier</a>
            <a href="../home/home.php?usuario=Benat" class="usuarioNameBenat usuarioName <?= $ClasSubBenat ?>">Benat</a>
        </div>




    </header>