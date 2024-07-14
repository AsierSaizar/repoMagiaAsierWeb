<link rel="stylesheet" href="mnemonica.css">
<?php

require_once ("../../required/head.php");

$usuario = $_SESSION["usuario"];
?><br>
<center>
    <h1>Mnemonica de Juan Tamariz<i class="fa-solid fa-hat-wizard"></i><br></h1>
</center><br><br>

<h2 class="h2Ord">Ordenacion:</h2>
<div class="containerMnemonica">
    
    <?php
    require_once (APP_DIR . "/src/required/functions.php");

    $conn = connection();

    $sql = "SELECT * FROM diarioMagico.mnemonica order by cardPosition;";

    $result = $conn->query($sql);
    ?>
    <div class="mnemonica">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
                <div class="cartaBakoitza">
                    <span class="spanCardPosition"><?= $row['cardPosition'] ?></span>
                    <img class="cartaImg" src="../../../public/cards/<?= $row['valor'].$row['palo'] ?>.png">
                </div>
            <?php
        }
    } else {
        echo "Ez dago irizpide hauek betetzen dituet produkturik.";
    }
    ?>
    </div>
</div>