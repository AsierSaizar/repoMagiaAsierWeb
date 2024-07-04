<link rel="stylesheet" href="juego.css">
<?php

require_once ("../../required/head.php");

require_once (APP_DIR . "/src/required/functions.php");
$conn = connection();

$idJuego = isset($_GET["juego"]) ? $_GET["juego"] : "1";

$sql = "SELECT * FROM juegos WHERE idjuegos = $idJuego;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc()
        //JOKUAN DATOK JARTZEN HASTEA DAO HEMEN
        ?>
    <br>

    <center>
        <h1><?= $row["juegosName"] ?></h1>
        <br><br>
    </center>
    <div class="containerJuego">
        <?php

        if (!empty($row["descripcion"])) {
            ?>
            <div class="descripcionJuegoDiv">
                <h2 class="descripcionJuegoh2 tituloApartado">Descripcion del juego:</h2>
                <div class="descripcionJuego"><?= $row["descripcion"] ?></div>
            </div><br><br>
            <?php
        }

        if (!empty($row["pasos"])) {
            ?>
            <div class="pasosJuegoDiv">
                <h2 class="pasosJuegoh2 tituloApartado">Pasos del juego:</h2>
                <div class="pasosJuego"><?= $row["pasos"] ?></div>
            </div><br><br>
            <?php
        }


        if (!empty($row["notas"])) {
            ?>
            <div class="notasJuegoDiv">
                <h2 class="notasJuegoh2 tituloApartado">Notas del juego:</h2>
                <div class="notasJuego"><?= $row["notas"] ?></div>
            </div><br><br>
            <?php
        }



        if (!empty($row["demostracion"])) {
            ?>
            <div class="demoJuegoDiv">
                <h2 class="demoJuegoh2 tituloApartado">Demostracion del juego:</h2>
                <iframe class="demoJuego video" src="<?= $row["demostracion"] ?>" width="840" height="480"
                    allow="autoplay; fullscreen" allowfullscreen></iframe>
            </div><br><br>
            <?php
        }


        if (!empty($row["explicacion"])) {
            ?>
            <div class="expliJuegoDiv">
                <h2 class="expliJuegoh2 tituloApartado">Explicacion del juego:</h2>
                <iframe class="expliJuego video" src="<?= $row["explicacion"] ?>" width="840" height="480"
                    allow="autoplay; fullscreen" allowfullscreen></iframe>
            </div>
            <?php
        }
        ?>
    </div>


    <?php
} else {
    echo "Ez dago irizpide hauek betetzen dituet produkturik.";
}


?>

<br><br><br>





<?php

require_once ("../../required/footer.php");
?>