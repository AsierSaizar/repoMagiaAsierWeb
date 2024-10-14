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
            <div class="div_lista">
                <div class="div-izena">
                    <?=$row['izena']; ?> 
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>
</center>