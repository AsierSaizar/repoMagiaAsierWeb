<link rel="stylesheet" href="home.css">
<?php

require_once ("../../required/head.php");
require_once ("../../required/carrusel.php");
?>
<br>
<center>
    <h1>Categorias</h1>
</center><br><br>

<div class="containerCategorias">
    <?php
    require_once (APP_DIR . "/src/required/functions.php");

    $conn = connection();
    $sql = "SELECT * FROM categorias;";
    $result = $conn->query($sql);
    ?>
    <center>
        <div class="categorias">
            <?php
            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="categoriaDiv">
                        <a class="linkCategorias"
                            href="<?= HREF_SRC_DIR ?>/views/categoria/categoria.php?categoria=<?= $row["categoriasName"] ?>">
                            <img class="imagenCategoria marco1" src="../../../public/<?= $row["imagenName"] ?>">

                            <h3 class="categoriasNameH3"><?= $row["categoriasName"] ?></h3>
                        </a>

                    </div>
                    <?php
                }

            } else {
                echo "Ez dago irizpide hauek betetzen dituet produkturik.";
            } ?>
        </div>
<br><br>

    </center>
    <?php

    $conn->close();
    ?>

</div>

</body>

<?php

require_once ("../../required/footer.php");
?>