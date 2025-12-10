<?php
session_start();

$nombre  = trim($_POST['nombre'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($nombre !== "" && $password !== "") {

    require_once "config.php";
    require_once __DIR__ . "/includes/functions.php";

    $conn = conectarBaseDatos();

    // Buscar usuario por nombre
    $sql = "SELECT usuario_id, nombre, password, email 
            FROM usuario 
            WHERE nombre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($password, $usuario["password"])) {

            // Guardar datos en sesión
            $_SESSION["usuario_id"] = $usuario["usuario_id"];
            $_SESSION["usuario_nombre"] = $usuario["nombre"];
            $_SESSION["usuario_email"] = $usuario["email"];

            $_SESSION["msg"] = "Bienvenido, " . $usuario["nombre"];
            header("Location: bienvenido.php");
            exit();
        } else {
            $_SESSION["msg"] = "Contraseña incorrecta";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION["msg"] = "El usuario no existe";
        header("Location: login.php");
        exit();
    }
} else {
    $_SESSION["msg"] = "Debe completar todos los campos";
    header("Location: login.php");
    exit();
}
