<?php
session_start();

$usuario = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($usuario !== "" && $password !== "") {
    // Recuperar lista de miembros
    $miembros = $_SESSION['miembros'] ?? [];

    // Comprobar si el usuario ya existe
    if (array_key_exists($usuario, $miembros)) {
        header("Location: registro.php?error=Usuario ya existe");
        exit();
    } else {
        // Guardar nuevo usuario
        $miembros[$usuario] = $password;
        $_SESSION['miembros'] = $miembros;

        // Redirigir al login
        header("Location: login.php?success=Usuario registrado");
        exit();
    }
} else {
    header("Location: registro.php?error=Por favor complete todos los campos");
    exit();
}