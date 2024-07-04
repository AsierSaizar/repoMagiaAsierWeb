<?php
session_start();


if (isset($_POST["action"])) {
    switch ($_POST["action"]) {
        case "fabSartu": {
            $jokuaId = $_POST["jokuaId"];
            $usuario = $_SESSION["usuario"];


            require_once ("functions.php");

            $conn = connection();

            // Verifica si ya existe una fila con el mismo idJokua
            $resultado = $conn->query("SELECT * FROM faboritok WHERE idJokua = $jokuaId");

            if ($resultado->num_rows > 0) {
                // Si existe, actualiza la columna del usuario correspondiente
                $conn->query("UPDATE faboritok SET $usuario = 1 WHERE idJokua = $jokuaId");
            } else {
                // Si no existe, inserta una nueva fila con los valores
                $conn->query("INSERT INTO faboritok (idJokua, $usuario) VALUES ($jokuaId, 1)");
            }
            $conn->close();
            echo "Juego añadido a favoritos";
            break;
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////
        case "lstGorde": {
            $jokuaId = $_POST["jokuaId"];
            $usuario = $_SESSION["usuario"];


            require_once ("functions.php");

            $conn = connection();

            // Verifica si ya existe una fila con el mismo idJokua
            $resultado = $conn->query("SELECT * FROM listanGordeta WHERE idJokua = $jokuaId");

            if ($resultado->num_rows > 0) {
                // Si existe, actualiza la columna del usuario correspondiente
                $conn->query("UPDATE listanGordeta SET $usuario = 1 WHERE idJokua = $jokuaId");
            } else {
                // Si no existe, inserta una nueva fila con los valores
                $conn->query("INSERT INTO listanGordeta (idJokua, $usuario) VALUES ($jokuaId, 1)");
            }
            $conn->close();
            echo "Juego añadido a Lista de Guardados";
            break;
        }


        //////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////

        case "listatikKendu": {
            $jokuaId = $_POST["jokuaId"];
            $usuario = $_SESSION["usuario"];
            $mota = $_POST["mota"];

            require_once ("functions.php");

            $conn = connection();


            // Si existe, actualiza la columna del usuario correspondiente
            $conn->query("UPDATE $mota SET $usuario = 0 WHERE idJokua = $jokuaId");

            $conn->close();
            echo "Juego borrado de la lista";
            break;
        }
        case "añadirJuego": {
            $juegosName = $_POST["juegosName"];
            $descripcion = $_POST["descripcion"];
            $categoria = $_POST["categoria"];
            $subcategoria = $_POST["subcategoria"];
            $pasos = $_POST["pasos"];
            $notas = $_POST["notas"];
            $explicacion = $_POST["explicacion"];
            $demostracion = $_POST["demostracion"];
            $asierUsu = $_POST["asierUsu"];
            $benatUsu = $_POST["benatUsu"];



            require_once ("functions.php");

            $conn = connection();

            $sql = "INSERT INTO juegos (juegosName, descripcion, categoria, subcategoria, pasos, notas, explicacion, demostracion, Asier, Benat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


            $stmt = $conn->prepare($sql);


            $stmt->bind_param("ssssssssss", $juegosName, $descripcion, $categoria, $subcategoria, $pasos, $notas, $explicacion, $demostracion, $asierUsu, $benatUsu);


            if ($stmt->execute()) {
                echo "Nuevo registro creado exitosamente";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }


            $stmt->close();
            $conn->close();
            break;
        }
        case "editarJuego": {
            $jokuaId = $_POST["jokuaId"];
            $juegosName = $_POST["juegosName"];
            $descripcion = $_POST["descripcion"];
            $categoria = $_POST["categoria"];
            $subcategoria = $_POST["subcategoria"];
            $pasos = $_POST["pasos"];
            $notas = $_POST["notas"];
            $explicacion = $_POST["explicacion"];
            $demostracion = $_POST["demostracion"];
            $asierUsu = $_POST["asierUsu"];
            $benatUsu = $_POST["benatUsu"];



            require_once ("functions.php");

            $conn = connection();

            $sql = "UPDATE juegos 
            SET juegosName = ?, 
                descripcion = ?, 
                categoria = ?, 
                subcategoria = ?, 
                pasos = ?, 
                notas = ?, 
                explicacion = ?, 
                demostracion = ?, 
                Asier = ?, 
                Benat = ? 
            WHERE idjuegos = ?";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param("ssssssssssi", $juegosName, $descripcion, $categoria, $subcategoria, $pasos, $notas, $explicacion, $demostracion, $asierUsu, $benatUsu, $jokuaId);



            if ($stmt->execute()) {
                echo "Juego editado correctamente";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }


            $stmt->close();
            $conn->close();
            break;
        }

        case "borrarJuego": {
            $jokuaId = $_POST["jokuaId"];
            require_once ("functions.php");

            $conn = connection();

            // Primero, selecciona el registro que quieres eliminar
            $result = $conn->query("SELECT * FROM juegos WHERE idjuegos = $jokuaId");

            if ($result->num_rows > 0) {
                // Fetch the data
                $row = $result->fetch_assoc();

                // Inserta los datos en la tabla de historial
                $stmt = $conn->prepare("INSERT INTO historial_juegos (idjuegos, categoria, subcategoria, juegosName, descripcion, pasos, notas, demostracion, explicacion, Asier, Benat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param(
                    "iissssssssi",
                    $row['idjuegos'],
                    $row['categoria'],
                    $row['subcategoria'],
                    $row['juegosName'],
                    $row['descripcion'],
                    $row['pasos'],
                    $row['notas'],
                    $row['demostracion'],
                    $row['explicacion'],
                    $row['Asier'],
                    $row['Benat']
                );
                $stmt->execute();

                // Luego, elimina el registro de la tabla original
                $conn->query("DELETE FROM juegos WHERE idjuegos = $jokuaId");

                echo "Juego borrado exitosamente";
            } else {
                echo "Juego no encontrado";
            }

            $conn->close();
            break;
        }
        case "restaurarJuego": {
            $idjuegos = $_POST["jokuaId"];
            
            require_once ("functions.php");

            $conn = connection();

            // Obtener el registro del historial
            $result = $conn->query("SELECT * FROM historial_juegos WHERE idjuegos = $idjuegos");

            if ($result->num_rows > 0) {
                // Fetch the data
                $row = $result->fetch_assoc();

                // Inserta los datos en la tabla original
                $stmt = $conn->prepare("INSERT INTO juegos (idjuegos, categoria, subcategoria, juegosName, descripcion, pasos, notas, demostracion, explicacion, Asier, Benat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param(
                    "iissssssssi",
                    $row['idjuegos'],
                    $row['categoria'],
                    $row['subcategoria'],
                    $row['juegosName'],
                    $row['descripcion'],
                    $row['pasos'],
                    $row['notas'],
                    $row['demostracion'],
                    $row['explicacion'],
                    $row['Asier'],
                    $row['Benat']
                );
                $stmt->execute();

                // Elimina el registro de la tabla de historial
                $conn->query("DELETE FROM historial_juegos WHERE idjuegos = $idjuegos");
                echo "Juego restaurado con exito";
                exit();
            } else {
                echo "Juego no encontrado en el historial";
            }

            $conn->close();
        }
    }
} else {
    echo "Error: Invalid action.";
}