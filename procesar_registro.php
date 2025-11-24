<?php
session_start();

$usuario = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($usuario !== "" && $password !== "") {
    $miembros = $_SEESION['miembros'] ?? [];
    //buscar si el usuario ya existe

    if (array_key_exists($usuario, $miembros)) {
        // Usuario ya existe
        header("Location: registro.php?error=Usuario ya existe");
        exit();
    } else {
        // Agregar nuevo usuario
        $miembros[] = [$usuario => $password];
        header("Location: login.php");
        exit();
    }


} else {
    header("Location: registro.php?error=Por favor complete todos los campos");
    exit();
}
?>