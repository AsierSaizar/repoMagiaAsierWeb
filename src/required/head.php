<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    require_once ("define.php");
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
            require_once (APP_DIR . "/src/required/sideBar.php");
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
        </div>

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