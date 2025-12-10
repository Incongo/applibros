<?php
session_start();

$nombre  = trim($_POST['nombre'] ?? '');
$password = trim($_POST['password'] ?? '');
$email    = trim($_POST['email'] ?? '');

if ($nombre !== "" && $password !== "" && $email !== "") {

    require_once "config.php";
    require_once __DIR__ . "/includes/functions.php";

    // Conectar a la base de datos
    $conn = conectarBaseDatos();

    // Encriptar contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    try {
        // Insertar usuario
        $sql = "INSERT INTO usuario (nombre, password, email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $passwordHash, $email);

        if ($stmt->execute()) {
            $_SESSION["msg"] = "Usuario creado correctamente";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION["msg"] = "Error creando al usuario";
            header("Location: registro.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION["msg"] = "Error creando al usuario " . $e->getMessage();
        header("Location: registro.php");
        exit();
    }
} else {
    $_SESSION["msg"] = "Necesario cubrir todos los campos";
    header("Location: registro.php");
    exit();
}
