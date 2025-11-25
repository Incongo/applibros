<?php
session_start();

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username !== '' && $password !== '') {
    // Inicializar array de usuarios si no existe
    if (!isset($_SESSION['usuarios'])) {
        $_SESSION['usuarios'] = [];
    }

    // Validar usuario
    if (isset($_SESSION['miembros'][$username]) && $_SESSION['miembros'][$username] === $password) {
        $_SESSION['usuario'] = $username;
        header("Location: bienvenido.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
        $_SESSION["error"] = $error;
    }

} else {
    $error = "Debes rellenar todos los campos.";
    $_SESSION["error"] = $error;
}

header("Location: login.php");
exit();
?>