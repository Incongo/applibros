<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";
require_once __DIR__ . "/includes/functions.php";

$usuario_id = $_SESSION['usuario_id'];
$libro_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($libro_id <= 0) {
    header("Location: bienvenido.php");
    exit();
}

$conn = conectarBaseDatos();

// 1. Comprobar que el libro pertenece al usuario
$sql = "SELECT imagen FROM libro WHERE libro_id = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $libro_id, $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    // Intento de borrar libro ajeno o inexistente
    header("Location: bienvenido.php");
    exit();
}

$libro = $resultado->fetch_assoc();

// 2. Borrar la imagen si existe
if (!empty($libro['imagen']) && file_exists($libro['imagen'])) {
    unlink($libro['imagen']);
}

// 3. Borrar el libro de la base de datos
$sql = "DELETE FROM libro WHERE libro_id = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $libro_id, $usuario_id);
$stmt->execute();

header("Location: bienvenido.php");
exit();
