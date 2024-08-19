<link rel="stylesheet" href="juego.css">
<?php

require_once("../../required/head.php");

require_once(APP_DIR . "/src/required/functions.php");
$conn = connection();
$usuario = $_SESSION["usuario"];
$idJuego = isset($_GET["juego"]) ? $_GET["juego"] : "1";


$sqlCat = "SELECT categoriasName FROM categorias WHERE idcategorias=(SELECT categoria FROM juegos WHERE idjuegos=2);";
$resultCat = $conn->query($sqlCat);
$rowCat = $resultCat->fetch_assoc();


$sql = "SELECT * FROM juegos WHERE idjuegos = $idJuego order by subcategoria;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
        //JOKUAN DATOK JARTZEN HASTEA DAO HEMEN
        $sql2 = "SELECT 
        posicion
        FROM (
        SELECT 
        idjuegos,
        ROW_NUMBER() OVER (ORDER BY subcategoria) as posicion
        FROM 
        juegos
        WHERE 
        categoria = (SELECT categoria FROM juegos WHERE idjuegos = $idJuego) 
        AND $usuario = 1
        ORDER BY 
        subcategoria
        ) AS subconsulta
        WHERE idjuegos = $idJuego;
        ";
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();


        $sql3 = "SELECT COUNT(*) as CANTIDAD
        FROM juegos
        WHERE categoria = (SELECT categoria FROM juegos WHERE idjuegos = $idJuego) 
        AND $usuario = 1;";
        $result3 = $conn->query($sql3);
        $row3 = $result3->fetch_assoc()
        
        ?>
    <br>
    <center><a class="categoriaNameLink" href="<?= HREF_VIEWS_DIR ?>/categoria/categoria.php?categoria=<?= $rowCat["categoriasName"] ?>"><?= $rowCat["categoriasName"] ?> (<?= $row2["posicion"] ?>/<?=$row3['CANTIDAD']?>)</a><br></center>
    <br><div class="tituloJokua">
        <?php
        $sql1 = "WITH juegos_ordenados AS (
                SELECT 
                    idjuegos,
                    ROW_NUMBER() OVER (ORDER BY subcategoria) AS rn
                FROM juegos
                WHERE categoria = (SELECT categoria FROM juegos WHERE idjuegos = $idJuego)
                  AND $usuario = 1
            ),
            posicion_actual AS (
                SELECT rn 
                FROM juegos_ordenados 
                WHERE idjuegos = $idJuego
            )
            SELECT 
                (SELECT idjuegos FROM juegos_ordenados WHERE rn = (SELECT rn - 1 FROM posicion_actual)) AS idjuego_anterior,
                (SELECT idjuegos FROM juegos_ordenados WHERE rn = (SELECT rn + 1 FROM posicion_actual)) AS idjuego_posterior;";

        $result1 = $conn->query($sql1);
        $idjuegosArray = array(); // Inicializa un array vacío
        if ($result1->num_rows > 0) {
            while ($row1 = $result1->fetch_assoc()) {
                $idjuegoAnterior = $row1['idjuego_anterior'];
                $idjuegoPosterior = $row1['idjuego_posterior'];
            }
        }

        if (empty($idjuegoAnterior)) {
            ?>
            <div></div>
            <?php
        } else {
            ?>
            <a href="<?= HREF_VIEWS_DIR ?>/juego/juego.php?juego=<?= $idjuegoAnterior ?>">
                <i class="fa-solid fa-chevron-left fletxak"></i>
            </a>
            <?php
        }


        
        ?>

        <h1 class=""><?= $row["juegosName"] ?></h1>

        <?php
        if (empty($idjuegoPosterior)) {
            ?>
            <div></div>
            <?php
        } else {
            ?>
            <a href="<?= HREF_VIEWS_DIR ?>/juego/juego.php?juego=<?= $idjuegoPosterior ?>">
                <i class="fa-solid fa-chevron-right fletxak"></i>
            </a>
            <?php
        } ?>


    </div><br><br>
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

require_once("../../required/footer.php");
?>