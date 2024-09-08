<link rel="stylesheet" href="jokuaSortu.css">

<?php

require_once ("../../required/head.php");
$usuario = $_SESSION["usuario"];

$editatu = false;

if (isset($_GET["jokua"])) {
    $idJuego = $_GET["jokua"];
    $editatu = true;

    require_once (APP_DIR . "/src/required/functions.php");
    $conn = connection();
    $usuario = $_SESSION["usuario"];
    $sql = "SELECT * FROM juegos WHERE idjuegos = $idJuego;";
    $result = $conn->query($sql);
    $rowJuego = $result->fetch_assoc();

}
if (isset($_GET["categoria"])) {
    $categoriaBaseSortzeko = $_GET["categoria"];
}
?>
<br>
<center>
    <h1><?= ($editatu) ? "Editar Juego ($idJuego)" : "Añadir Juego" ?></h1>
</center><br><br>
<center>
    <div class="containerAñadirJuego">
        <b>


            <!-- IZENAAAAAAAAAAAA //////////////////-->


            <div class="form-group">
                <label for="juegosName">Nombre del juego:</label>
                <?php
                if ($editatu) {
                    $value = $rowJuego['juegosName'];
                    ?>
                    <input id="idJuego" type="hidden" value="<?= $idJuego ?>">
                    <?php

                } else {
                    $value = "";
                }
                ?>
                <input type="text" id="juegosName" class="form-control" name="juegosName" maxlength="45"
                    value="<?= ($editatu) ? "$value" : ""; ?>">
            </div>





            <!-- DESCRIPCION //////////////////-->


            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <?php
                if ($editatu) {
                    $value = $rowJuego['descripcion'];
                } else {
                    $value = "";
                }
                ?>
                <textarea class="textarea-resizable form-control" name="pasos" oninput="autoResizeTextarea(this)"><?= htmlspecialchars(($editatu) ? "$value" : ""); ?>
</textarea>
            </div>



            <!-- CATEGORIA //////////////////-->


            <div class="form-group">
                <label for="categoria">Categoria:</label><br>
                <select class="form-control CatOpt" name="categoria" id="categoria">
                    <?php
                    // Suponiendo que esta es tu variable
                    $categoria = isset($rowJuego['categoria']) ? $rowJuego['categoria'] : null;

                    if (!isset($categoria) && isset($_GET["categoria"])) {
                        $categoriaBaseSortzeko = $_GET["categoria"];
                        switch ($categoriaBaseSortzeko) {
                            case 'Cartomagia':
                                $categoria = 1;
                                break;
                            case 'Numismagia':
                                $categoria = 2;
                                break;
                            case 'Cuerdas':
                                $categoria = 3;
                                break;
                            case 'Mentalismo':
                                $categoria = 4;
                                break;
                            default:
                                $categoria = null;
                        }
                    }
                    ?>

                    <option class="CatOpt" value="1" <?= ($categoria == 1) ? "selected" : ""; ?>>Cartomagia
                    </option>
                    <option class="CatOpt" value="2" <?= ($categoria == 2) ? "selected" : ""; ?>>Numismagia
                    </option>
                    <option class="CatOpt" value="3" <?= ($categoria == 3) ? "selected" : ""; ?>>Cuerdas
                    </option>
                    <option class="CatOpt" value="4" <?= ($categoria == 4) ? "selected" : ""; ?>>Mentalismo
                    </option>
                </select>
            </div>



            <!-- SUBCATEGORIA //////////////////-->



            <?php
            require_once (APP_DIR . "/src/required/functions.php");
            $conn = connection();
            $usuario = $_SESSION["usuario"];
            $sql = "SELECT DISTINCT subcategoria FROM juegos;";
            $result = $conn->query($sql);
            ?>
            <div class="form-group">
                <label for="subcategoria">Subcategoria:</label>
                <select id="subcategoria" class="form-control" name="subcategoria" style="width: 100%;">

                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $selected = "";
                            if ($editatu) {
                                if ($rowJuego['subcategoria'] == $row['subcategoria']) {
                                    $selected = "selected";
                                }
                            }

                            ?>
                            <option value="<?= $row['subcategoria'] ?>" <?= $selected ?>><?= $row['subcategoria'] ?></option>
                            <?php
                        }
                    }
                    ?>

                </select>
            </div>

            <!-- PASOSSS //////////////////-->

            <div class="form-group">
                <label for="pasos">Pasos:</label>
                <?php
                if ($editatu) {
                    $value = $rowJuego['pasos'];
                } else {
                    $value = "";
                }
                ?>
                <textarea class="textarea-resizable form-control" name="pasos" oninput="autoResizeTextarea(this)"><?= htmlspecialchars(($editatu) ? "$value" : ""); ?>
</textarea>
            </div>
            




            <!-- NOTAAAAAAAS //////////////////-->
            <div class="form-group">
                <label for="notas">Notas:</label>
                <?php
                if ($editatu) {
                    $value = $rowJuego['notas'];
                } else {
                    $value = "";
                }
                ?>
                <textarea class="textarea-resizable form-control" name="pasos" oninput="autoResizeTextarea(this)"><?= htmlspecialchars(($editatu) ? "$value" : ""); ?>
</textarea>
            </div>





            <!-- DEMOSTRACIOOOOON //////////////////-->
            <div class="form-group">
                <label for="demostracion">Demonstración (Link):</label>
                <?php
                if ($editatu) {
                    $value = $rowJuego['demostracion'];
                } else {
                    $value = "";
                }
                ?>
                <input type="text" id="demostracion" class="form-control" name="demostracion"
                    value="<?= ($editatu) ? "$value" : ""; ?>">
            </div>





            <!-- EXOPLICACIONN //////////////////-->
            <div class="form-group">
                <label for="explicacion">Explicación (Link):</label>
                <?php
                if ($editatu) {
                    $value = $rowJuego['explicacion'];
                } else {
                    $value = "";
                }
                ?>
                <input type="text" id="explicacion" class="form-control" name="explicacion"
                    value="<?= ($editatu) ? "$value" : ""; ?>">
            </div>





            <!-- USUARIOOOOOOOOK //////////////////-->
            <div class="form-group">
                <label for="usuarioAukeratu">Usuario con acceso:</label>
                <?php
                if ($editatu) {
                    $asier = ($rowJuego['Asier'] == 1) ? "checked" : "";
                    $benat = ($rowJuego['Benat'] == 1) ? "checked" : "";
                } else {
                    if ($usuario == "Asier") {
                        $asier = "checked";
                        $benat = "";
                    } else {
                        $benat = "checked";
                        $asier = "";
                    }
                }
                ?>
                <form>
                    <label for="opcion1">
                        <input type="checkbox" id="opcion1Usuario" name="opcion1Usuario" value="opcion1Usuario"
                            <?= $asier ?>>
                        Asier
                    </label><br>

                    <label for="opcion2">
                        <input type="checkbox" id="opcion2Usuario" name="opcion2Usuario" value="opcion2Usuario"
                            <?= $benat ?>>
                        Beñat
                    </label>
                </form>
            </div>


            <?php
            if ($editatu) {
                ?>
                <button id="submit-button" class="btnSubmitEdit">Editar juego</button>
                <button id="borrarJuego" class="btnSubmitDelete"><i class="fas fa-trash"></i></button>
                <?php
            } else {
                ?>
                <button id="submit-button" class="btnSubmitInsert">Añadir juego</button>
                <?php
            }
            ?>
            <!-- BOTOIAAAAAAAAA //////////////////-->

        </b>
    </div>
</center>
<br><br><br>
<script>
    $(document).ready(function () {
        $('#subcategoria').select2({
            tags: true,
            placeholder: 'Selecciona o escribe una nueva opción',
            allowClear: true
        });
    });
    
    // Función para ajustar la altura del textarea automáticamente
    function autoResizeTextarea(el) {
        el.style.height = 'auto'; // Restablecer la altura
        el.style.height = (el.scrollHeight) + 'px'; // Ajustar la altura según el contenido
        console.log('Altura ajustada a:', el.scrollHeight); // Para verificar la ejecución
    }

    // Aplicar la función a todos los textareas con la clase 'textarea-resizable'
    document.addEventListener('DOMContentLoaded', function() {
        const textareas = document.querySelectorAll('.textarea-resizable');
        
        // Ajustar la altura al cargar la página
        textareas.forEach(textarea => {
            autoResizeTextarea(textarea);
        });

        // También asegurarse de que la altura cambie cuando el usuario escriba
        textareas.forEach(textarea => {
            textarea.addEventListener('input', function() {
                autoResizeTextarea(textarea);
            });
        });
    });
</script>
<?php

require_once ("../../required/footer.php");
?>