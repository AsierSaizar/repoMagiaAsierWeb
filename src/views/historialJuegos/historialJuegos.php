<link rel="stylesheet" href="historialJuegos.css">
<?php

require_once ("../../required/head.php");
$usuario = $_SESSION["usuario"];
?>
<br>
<center>
    <h1>Historial de Juegos borrados</h1>
</center><br><br>

<div class="containerJuegos">
    <?php
    require_once (APP_DIR . "/src/required/functions.php");

    $conn = connection();

    // Obtener los registros del historial
    $result = $conn->query("SELECT h.idjuegos, h.categoria, h.juegosName, deleted_at, c.categoriasName FROM historial_juegos h JOIN categorias c ON h.categoria = c.idcategorias WHERE $usuario=1;");
    ?>

    <table class="historial-table">
        <tr>
            <th>Id del Juego</th>
            <th>Categoría</th>
            <th>Nombre del Juego</th>
            <th>Fecha de Eliminación</th>
            <th>Acción</th>
            <th>Borrar del historial</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['idjuegos']; ?></td>
                <td><?= $row['categoriasName']; ?></td>
                <td><?= $row['juegosName']; ?></td>
                <td><?= $row['deleted_at']; ?></td>
                <td><button id="<?= $row['idjuegos']; ?>" type="submit" class="restore-button">Restaurar</button></td>
                <td><button id="<?= $row['idjuegos']; ?>" type="submit" class="deleteHis-button">Borrar</button></td>
            </tr>
        <?php endwhile; ?>
    </table>
    </body>

    </html>

    <?php
    $conn->close();
    ?>


</div>