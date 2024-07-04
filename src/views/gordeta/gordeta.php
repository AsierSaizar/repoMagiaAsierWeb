<link rel="stylesheet" href="gordeta.css">
<?php

require_once ("../../required/head.php");

$gordeta = isset($_GET["gordeta"]) ? $_GET["gordeta"] : 1;
$existe = true;
if ($gordeta == 1) {
    $title = "Favoritos";
    $tablaDB = "faboritok";
} else if ($gordeta == 2) {
    $title = "Lista de Guardados";
    $tablaDB = "listanGordeta";
} else {
    $existe = false;
}
if ($existe) {

    ?>
    <br>
    <center>
        <h1><?= $title ?></h1>
    </center><br><br>

    <class="containerGordeta">
        <?php
        require_once (APP_DIR . "/src/required/functions.php");
        $conn = connection();
        $usuario = $_SESSION["usuario"];

        $sql = "SELECT juegos.*, categorias.categoriasName AS categoria_nombre FROM juegos JOIN  categorias ON juegos.categoria = categorias.idcategorias WHERE 
        juegos.idjuegos IN (
            SELECT idJokua 
            FROM $tablaDB 
            WHERE $usuario = 1
        );
        ";

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