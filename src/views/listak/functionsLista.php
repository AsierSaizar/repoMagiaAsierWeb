<?php


function obtenerTituloLista($conn, $usuario, $listaId)
{
    // Verificar si listaId no es 0
    if ($listaId != 0) {
        // Consulta para obtener el título de la lista
        $sql = "SELECT * FROM diarioMagico.lista WHERE $usuario = 1 AND id = $listaId;";
        $result = $conn->query($sql);

        // Si se encuentran resultados, devolver el título
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row['izena'];
            }
        } else {
            return "Permision denied for user " . $usuario;
        }
    } else {
        return "Permision denied for user " . $usuario;
    }
}


