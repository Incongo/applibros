<?php
session_start();

if (isset($_SESSION['libros']) || isset($_SESSION['miembros'])) {
    // Creamos un array con todo lo que queremos persistir
    $datos = [
        "miembros" => $_SESSION['miembros'] ?? [],
        "libros" => $_SESSION['libros'] ?? []
    ];

    $json = json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents("datos.json", $json);

    // Redirigir de vuelta con mensaje
    header("Location: index.php?msg=guardado");
    exit();
} else {
    header("Location: index.php?msg=sin_datos");
    exit();
}
