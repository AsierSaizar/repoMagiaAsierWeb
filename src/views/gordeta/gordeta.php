<link rel="stylesheet" href="gordeta.css">
<?php

require_once ("../../required/head.php");
//CATEGORIAK MANEJATZEKO ETA EZ KENTZEKO FILTROAKIN ///////////


$gordetaSESSION = isset($_SESSION["gordeta"]) ? $_SESSION["gordeta"] : 1;
$gordeta = isset($_GET["gordeta"]) ? $_GET["gordeta"] : $gordetaSESSION;
$_SESSION["gordeta"] = $gordeta;

$existe = true;
if ($gordeta == 1) {
    $title = "Favoritos";
    $tablaDB = "faboritok";
} else if ($gordeta == 2) {
    $title = "Lista de Guardados";
    $tablaDB = "listangordeta";
} else {
    $existe = false;
}
if ($existe) {

    ?>
    <br>
    <center>
        <h1><?= $title ?></h1>
        <form method="get">
            <select name="catFiltro" id="catFiltro">
                <?php
                require_once (APP_DIR . "/src/required/functions.php");
                $conn = connection();
                $usuario = $_SESSION["usuario"];
                if (isset($_GET["catFiltro"])) {
                    $catFiltro = $_GET["catFiltro"];
                } else {
                    $catFiltro = "todos";
                }

                $sql = "SELECT DISTINCT categorias.categoriasName AS categoria_nombre FROM juegos JOIN  categorias ON juegos.categoria = categorias.idcategorias WHERE 
            juegos.idjuegos IN (
                SELECT idJokua 
                FROM $tablaDB 
                WHERE $usuario = 1
            );";


                $result = $conn->query($sql);
                ?>
                <option value="todos">Todos</option>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <option value="<?= $row['categoria_nombre'] ?>"><?= $row['categoria_nombre'] ?></option>
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
    </center><br><br>

    <class="containerGordeta">
        <?php
        require_once (APP_DIR . "/src/required/functions.php");
        $conn = connection();
        $usuario = $_SESSION["usuario"];
        if ($catFiltro == "todos") {
            $sql = "SELECT juegos.*, categorias.categoriasName AS categoria_nombre FROM juegos JOIN  categorias ON juegos.categoria = categorias.idcategorias WHERE 
        juegos.idjuegos IN (
            SELECT idJokua 
            FROM $tablaDB 
            WHERE $usuario = 1
        ) and juegos.idjuegos IN (
            SELECT idjuegos 
            FROM juegos
            WHERE $usuario = 1
        );";
        } else {
            $sql = "SELECT juegos.*, categorias.categoriasName AS categoria_nombre FROM juegos JOIN  categorias ON juegos.categoria = categorias.idcategorias WHERE juegos.idjuegos IN (SELECT idJokua FROM $tablaDB WHERE $usuario = 1)and categoria in ( SELECT idcategorias FROM categorias WHERE categoriasName = '$catFiltro') and juegos.idjuegos IN (SELECT idjuegos FROM juegos WHERE $usuario = 1)";
        }

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            ?>
            <input id="gordetaMotaInput" type="hidden" value="<?= $tablaDB ?>"></input>

            <div class="table-container">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Nombre del juego</th>
                            <th>Categoría</th>
                            <th>Subcategoría</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><a
                                        href="<?= HREF_SRC_DIR ?>/views/juego/juego.php?juego=<?= $row['idjuegos'] ?>"><?= $row['juegosName'] ?></a>
                                </td>
                                <td><a
                                        href="<?= HREF_SRC_DIR ?>/views/categoria/categoria.php?categoria=<?= $row['categoria_nombre'] ?>"><?= $row['categoria_nombre'] ?></a>
                                </td>
                                <td><?= $row['subcategoria'] ?></td>
                                <td>
                                    <button class="delete-button" id="<?= $row['idjuegos'] ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
        } else {
            echo "Ez dago irizpide hauek betetzen dituet produkturik.";
        }
        ?>

        </div>
        <br><br>
        <?php

}
require_once ("../../required/footer.php");
?>