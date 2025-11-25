<?php
session_start();

if (file_exists("datos.json")) {
    $json = file_get_contents("datos.json");
    $datos = json_decode($json, true);

    if (is_array($datos)) {
        $_SESSION['miembros'] = $datos['miembros'] ?? [];
        $_SESSION['libros'] = $datos['libros'] ?? [];
        header("Location: index.php?msg=cargado");
        exit();
    } else {
        header("Location: index.php?msg=error_json");
        exit();
    }
} else {
    header("Location: index.php?msg=no_archivo");
    exit();
}
