<link rel="stylesheet" href="listak.css">
<?php

require_once("../../required/head.php");

$usuario = $_SESSION["usuario"];

require_once(APP_DIR . "/src/required/functions.php");

?>
<br>
<center>
    <h1>Listak</h1><br>
    <br>


    <div class="container_Listak">
        <?php
        $conn = connection();
        $sql = "SELECT * FROM diarioMagico.lista WHERE $usuario = 1;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <a href="<?= HREF_SRC_DIR ?>/views/listak/lista_joku.php?lista=<?= $row['id'] ?> " class="div_lista">
                    <div class="div-izena">
                        <?= $row['izena'] ?>
                    </div>
                </a>
                <?php
            }
        }
        ?>

        <button class="crearNuevaLista">
            <i class="fa-solid fa-plus"></i>
        </button>
        <div id="myModal" class="modal">
            <div class="modal_content">
                <span class="close">&times;</span>
                <h2>Crear Nueva Lista</h2>
                
                <label class="listName">Nombre de la lista:</label>
                <input type="text" id="listName"><br>
                <input type="checkbox" id="opcion1Usuario" name="opcion1Usuario" value="opcion1Usuario">Asier <br>
                <input type="checkbox" id="opcion2Usuario" name="opcion2Usuario" value="opcion2Usuario">Beñat <br>
                    
                
                <button id="crearListaBtn"><h3>Crear Lista</h3></button>
                
            </div>
        </div>
        
        <script src="listaJs.js"></script>
    </div>
</center>