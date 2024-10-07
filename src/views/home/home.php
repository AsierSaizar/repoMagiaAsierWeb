<link rel="stylesheet" href="home.css">
<?php

require_once("../../required/head.php");
require_once("../../required/carrusel.php");

$usuario = $_SESSION["usuario"];
?>
<br>
<center>
    <h1>Categorias</h1>
</center><br><br>

<div class="containerCategorias">
    <?php
    require_once(APP_DIR . "/src/required/functions.php");

    $conn = connection();
    $sql = "SELECT * 
        FROM diarioMagico.categorias
        ORDER BY 
            CASE idcategorias
                WHEN 1 THEN 1
                WHEN 2 THEN 2
                WHEN 4 THEN 3
                WHEN 3 THEN 4
            END;";
    $result = $conn->query($sql);
    ?>
    <center>
        <div class="todosJuegos">
            <a class="TodosLosJuegos" href="<?= HREF_SRC_DIR ?>/views/categoria/categoria.php?categoria=10">
                <div class=" marco2 categoriaIconos ">
                    <h3 class="categoriasNameH3">Todos Los Juegos</h3>
                </div>

            </a>
            <a class="TodosLosJuegos" href="<?= HREF_SRC_DIR ?>/views/listak/listak.php">
                <div class=" marco2 categoriaIconos ">
                    <h3 class="categoriasNameH3">Listas</h3>
                </div>

            </a>
        </div>
        <br><br>
        <div class="categorias">
            <?php

            $sqlCont = "SELECT 
    SUM(CASE WHEN categoria = 1 THEN 1 ELSE 0 END) AS Cartomagia,
    SUM(CASE WHEN categoria = 2 THEN 1 ELSE 0 END) AS Numismagia,
    SUM(CASE WHEN categoria = 3 THEN 1 ELSE 0 END) AS Cuerdas,
    SUM(CASE WHEN categoria = 4 THEN 1 ELSE 0 END) AS Mentalismo,

    (SELECT COUNT(*) FROM diarioMagico.juegos WHERE $usuario = 1 AND idjuegos IN (
		SELECT idJokua 
		FROM diarioMagico.faboritok 
		WHERE $usuario = 1)) AS total_faboritok,
        
    (SELECT COUNT(*) FROM diarioMagico.juegos WHERE $usuario = 1 AND idjuegos IN (
        SELECT idJokua 
        FROM diarioMagico.listangordeta 
        WHERE $usuario = 1
    )) AS total_listangordeta
    FROM diarioMagico.juegos
    WHERE $usuario = 1;";

            $resultCont = $conn->query($sqlCont);
            $resultCont->num_rows;
            $rowCont = $resultCont->fetch_assoc();
            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
                    $gameKopNumber = $rowCont[$row["categoriasName"]];
                    ?>
                    <div class="categoriaDiv">
                        <a class="linkCategorias cont"
                            href="<?= HREF_SRC_DIR ?>/views/categoria/categoria.php?categoria=<?= $row["categoriasName"] ?>"
                            data-number="<?= $gameKopNumber ?>">
                            <img class="imagenCategoria marco1" src="../../../public/<?= $row["imagenName"] ?>">

                            <h3 class="categoriasNameH3"><?= $row["categoriasName"] ?></h3>
                        </a>

                    </div>
                    <?php
                }

            } else {
                echo "Ez dago irizpide hauek betetzen dituet produkturik.";
            } ?>


            <div class="categoriaDiv">
                <a class="linkCategorias cont" href="<?= HREF_SRC_DIR ?>/views/gordeta/gordeta.php?gordeta=1"
                    data-number="<?= $rowCont["total_faboritok"] ?>">
                    <div class="imagenCategoria marco1 categoriaIconos Star"><i class="fas fa-star"></i></div>
                    <h3 class="categoriasNameH3">Favoritos <i class="fas fa-star"></i></h3>
                </a>

            </div>
            <div class="categoriaDiv">
                <a class="linkCategorias cont" href="<?= HREF_SRC_DIR ?>/views/gordeta/gordeta.php?gordeta=2"
                    data-number="<?= $rowCont["total_listangordeta"] ?>">
                    <div class="imagenCategoria marco1 categoriaIconos List"><i class="fas fa-list"></i></div>
                    <h3 class="categoriasNameH3">Lista de Guardados <i class="fas fa-list"></i></h3>
                </a>

            </div>
        </div>
        <br><br>

    </center>
    <?php

    $conn->close();
    ?>

</div>

</body>

<?php

require_once("../../required/footer.php");
?>