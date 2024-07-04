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
                <input type="text" id="descripcion" class="form-control" name="descripcion"
                    value="<?= ($editatu) ? "$value" : ""; ?>">
            </div>



            <!-- CATEGORIA //////////////////-->


            <div class="form-group">
                <label for="categoria">Categoria:</label><br>
                <select class="form-control CatOpt" name="categoria" id="categoria">
                    <?php
                    // Suponiendo que esta es tu variable
                    $categoria = $rowJuego['categoria'];
                    ?>

                    <option class="CatOpt" value="1" <?php echo ($categoria == 1) ? "selected" : ""; ?>>Cartomagia
                    </option>
                    <option class="CatOpt" value="2" <?php echo ($categoria == 2) ? "selected" : ""; ?>>Numismagia
                    </option>
                    <option class="CatOpt" value="3" <?php echo ($categoria == 3) ? "selected" : ""; ?>>Cuerdas
                    </option>
                    <option class="CatOpt" value="4" <?php echo ($categoria == 4) ? "selected" : ""; ?>>Mentalismo
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
                <input type="text" id="pasos" class="form-control" name="pasos"
                    value="<?= ($editatu) ? "$value" : ""; ?>">
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
                <input type="text" id="notas" class="form-control" name="notas" maxlength="225"
                    value="<?= ($editatu) ? "$value" : ""; ?>">
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
                    $asier = "";
                    $benat = "";
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
</script>
<?php

require_once ("../../required/footer.php");
?>