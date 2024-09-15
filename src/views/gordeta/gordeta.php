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
        <br>
        <div class="modoVista">
            <input type="hidden">
            <input type="radio" id="list-view" name="view" checked>
            <label for="list-view"><i class="fa-solid fa-list"></i></label>

            <input type="radio" id="box-view" name="view">
            <label for="box-view"><i class="fa-solid fa-boxes-stacked"></i></label>
        </div>
        <script>
            $(document).ready(function () {
                // Function to toggle visibility based on the selected view
                function toggleView() {
                    if ($('#list-view').is(':checked')) {
                        $('.containerGordetaLista').show();
                        $('.containerGordetaBox').hide();
                    } else if ($('#box-view').is(':checked')) {
                        $('.containerGordetaLista').hide();
                        $('.containerGordetaBox').show();
                    }
                }

                // Initially call toggleView to set the correct visibility on page load
                toggleView();

                // Add event listener to the radio buttons to toggle view on change
                $('.modoVista input[type="radio"]').on('change', function () {
                    toggleView();
                    localStorage.setItem('selectedView', this.id); // Save selected view in localStorage
                });

                // Check if there's a saved value in localStorage
                const savedView = localStorage.getItem('selectedView');
                if (savedView) {
                    $('#' + savedView).prop('checked', true);
                } else {
                    // Default to list view if nothing is saved
                    $('#list-view').prop('checked', true);
                }

                // Trigger the toggle function after setting the correct checked state
                toggleView();
            });



        </script>
    </center>

    <!-- containerGordeta LIST -->
    <div class="containerGordetaLista">
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
        ) Order BY categoria_nombre, subcategoria;";
        } else {
            $sql = "SELECT juegos.*, categorias.categoriasName AS categoria_nombre FROM juegos JOIN  categorias ON juegos.categoria = categorias.idcategorias WHERE juegos.idjuegos IN (SELECT idJokua FROM $tablaDB WHERE $usuario = 1)and categoria in ( SELECT idcategorias FROM categorias WHERE categoriasName = '$catFiltro') and juegos.idjuegos IN (SELECT idjuegos FROM juegos WHERE $usuario = 1)Order BY subcategoria";
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
    <!-- containerGordeta BOX -->
    <div class="containerGordetaBox">
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
        )Order BY categoria_nombre, subcategoria;";
        } else {
            $sql = "SELECT juegos.*, categorias.categoriasName AS categoria_nombre FROM juegos JOIN  categorias ON juegos.categoria = categorias.idcategorias WHERE juegos.idjuegos IN (SELECT idJokua FROM $tablaDB WHERE $usuario = 1)and categoria in ( SELECT idcategorias FROM categorias WHERE categoriasName = '$catFiltro') and juegos.idjuegos IN (SELECT idjuegos FROM juegos WHERE $usuario = 1)Order BY subcategoria";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $juego = $row["juegosName"];
                $idJuego = $row["idjuegos"];
                ?>
                <center>
                    <a href='<?= HREF_VIEWS_DIR ?>/juego/juego.php?juego=<?= $idJuego ?>' class='juegosDiv marco1'>
                        <b>
                            <div class="trucosName"><?= $juego ?></div>
                            <div class="trucosSubCat"><?= $row["subcategoria"] ?></div>
                        </b>

                    </a>
                    <div class="buttons">
                        <button class="delete-button" id="<?= $row['idjuegos'] ?>">
                            <i class="fas fa-trash-alt"></i>
                        </button>

                    </div>
                </center>
                <?php
            }
        }

        ?>

    </div>
    <br><br>
    <?php

}
require_once ("../../required/footer.php");
?>