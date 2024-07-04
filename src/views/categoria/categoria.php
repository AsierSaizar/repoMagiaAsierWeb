<link rel="stylesheet" href="categoria.css">
<?php

require_once ("../../required/head.php");

//CATEGORIAK MANEJATZEKO ETA EZ KENTZEKO FILTROAKIN ///////////
$categoriaSESSION = isset($_SESSION["categoria"]) ? $_SESSION["categoria"] : "Cartomagia";
$categoria = isset($_GET["categoria"]) ? $_GET["categoria"] : $categoriaSESSION;
$_SESSION["categoria"] = $categoria;
?>
<br>
<center>
    <h1><?= $categoria ?></h1><br>
    <form method="get">
        <select name="subcatFiltro" id="subcatFiltro">
            <?php
            require_once (APP_DIR . "/src/required/functions.php");
            $conn = connection();
            $usuario = $_SESSION["usuario"];
            if (isset($_GET["subcatFiltro"])) {
                $subcatFiltro = $_GET["subcatFiltro"];
            } else {
                $subcatFiltro = "todos";
            }
            $sql = "SELECT DISTINCT subcategoria FROM juegos WHERE categoria = (SELECT idcategorias FROM categorias WHERE categoriasName = '$categoria') and $usuario = 1;";
            $result = $conn->query($sql);
            ?>
            <option value="todos">Todos</option>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <option value="<?= $row['subcategoria'] ?>"><?= $row['subcategoria'] ?></option>
                    <?php
                }
            } else {
                echo "Ez dago irizpide hauek betetzen dituet produkturik.";
            }
            ?>
        </select>
        <button type="submit" class="search-buttonFiltro">
            <i class='fa-solid fa-filter'></i>
        </button>
    </form>
</center><br>

<div class="containerJuegos">
    <?php

    $conn = connection();
    $usuario = $_SESSION["usuario"];
    if ($subcatFiltro == "todos") {
        $sql = "SELECT j.* FROM juegos j JOIN categorias c ON j.categoria = c.idcategorias WHERE c.categoriasName = '$categoria' and $usuario = 1;";
    } else {
        $sql = "SELECT j.* FROM juegos j JOIN categorias c ON j.categoria = c.idcategorias WHERE c.categoriasName = '$categoria' and subcategoria='$subcatFiltro' and $usuario = 1 ;";
    }


    $result = $conn->query($sql);


    //Faboritotakok koloreztatzen
    $sqlfab = "SELECT idJokua FROM faboritok Where $usuario = 1;";
    $resultFab = $conn->query($sqlfab);

    // Almacenar los IDs de juegos favoritos en un array
    $faboritos = [];
    if ($resultFab->num_rows > 0) {
        while ($rowFab = $resultFab->fetch_assoc()) {
            $faboritos[] = $rowFab["idJokua"];
        }
    }

    //Listakok koloreztatzen
    $sqllist = "SELECT idJokua FROM listanGordeta Where $usuario = 1;";
    $resultlist = $conn->query($sqllist);

    // Almacenar los IDs de juegos favoritos en un array
    $listakokGord = [];
    if ($resultlist->num_rows > 0) {
        while ($rowlist = $resultlist->fetch_assoc()) {
            $listakokGord[] = $rowlist["idJokua"];
        }
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $juego = $row["juegosName"];
            $idJuego = $row["idjuegos"];
            $fabBauka = in_array($idJuego, $faboritos) ? "starButtonBtnFab" : "starButtonBtn";
            $ListBauka = in_array($idJuego, $listakokGord) ? "listButtonBtnList" : "listButtonBtn";
            ?>
            <center>
                <a href='<?= HREF_VIEWS_DIR ?>/juego/juego.php?juego=<?= $idJuego ?>' class='juegosDiv marco1 <?= $juego ?>'>
                    <b>
                        <div class="trucosName"><?= $juego ?></div>
                        <div class="trucosSubCat"><?= $row["subcategoria"] ?></div>
                    </b>
                </a>
                <div class="buttons">
                    <button id="<?= $row['idjuegos'] ?>" class="iconButton starButton <?= $fabBauka ?>" title="Star">
                        <i class="fas fa-star"></i>
                    </button>
                    <button id="<?= $row['idjuegos'] ?>" class="iconButton listButton <?= $ListBauka ?>" title="List">
                        <i class="fas fa-list"></i>
                    </button>
                    <a id="<?= $row['idjuegos'] ?>" class="iconButton editButton"
                        href="<?= HREF_SRC_DIR ?>/views/jokuaSortu/jokuaSortu.php?jokua=<?= $row['idjuegos'] ?>" title="List">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            </center>
            <?php
        }
    }
    ?>
    <a href="<?= HREF_VIEWS_DIR ?>/jokuaSortu/jokuaSortu.php?categoria=<?=$categoria?>" class="crearNuevoJuego">
        +
    </a>
    <?php
    $conn->close();
    ?>
</div>

<br><br>
<?php

require_once ("../../required/footer.php");
?>