<link rel="stylesheet" href="lista_joku.css">
<?php

require_once("../../required/head.php");

$usuario = $_SESSION["usuario"];

require_once(APP_DIR . "/src/required/functions.php");
require_once("functionsLista.php");

$listaId = isset($_GET["lista"]) ? $_GET["lista"] : 0;
$usuario = $_SESSION["usuario"];

$conn = connection();
$titulo = obtenerTituloLista($conn, $usuario, $listaId);

?>
<br>
<center>
    <h1><?= $titulo ?></h1><br>
    <br>

    <div class="container_Listak">
        <?php
        $sql = "SELECT j.* 
            FROM diarioMagico.lista_jokua lj
            JOIN diarioMagico.juegos j ON lj.id_jokua = j.idjuegos
            WHERE lj.id_lista = $listaId and $usuario =1;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $gameNumber = 0;
            while ($row = $result->fetch_assoc()) {
                $juego = $row["juegosName"];
                $idJuego = $row["idjuegos"];
                $gameNumber++;
                ?>
                <center>
                    <a href='<?= HREF_VIEWS_DIR ?>/juego/juego.php?juego=<?= $idJuego ?>' class='juegosDiv marco1 '
                        data-number="<?= $gameNumber ?>">
                        <b>
                            <div class="trucosName"><?= $juego ?></div>
                            <div class="trucosSubCat"><?= $row["subcategoria"] ?></div>
                        </b>

                    </a>
                    <div class="buttons">
                        <button class="delete-button_Lista" id="<?= $row['idjuegos'] ?>">
                            <i class="fas fa-trash-alt"></i>
                        </button>

                        <a id="<?= $row['idjuegos'] ?>" class="iconButton editButton"
                            href="<?= HREF_SRC_DIR ?>/views/jokuaSortu/jokuaSortu.php?jokua=<?= $row['idjuegos'] ?>"
                            title="List">
                            <i class="fas fa-edit"></i>
                        </a>

                    </div>
                </center>
                <?php
            }
        }
        ?>
    </div>
</center>