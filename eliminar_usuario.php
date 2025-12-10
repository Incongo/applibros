<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_nombre'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require_once "config.php";
require_once __DIR__ . "/includes/functions.php";

$conn = conectarBaseDatos();

$usuario_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($usuario_id <= 0) {
    header("Location: admin_panel.php");
    exit();
}

// No permitir borrar al admin
$check = $conn->prepare("SELECT nombre FROM usuario WHERE usuario_id = ?");
$check->bind_param("i", $usuario_id);
$check->execute();
$res = $check->get_result()->fetch_assoc();

if ($res['nombre'] === 'admin') {
    header("Location: admin_panel.php");
    exit();
}

// Borrar imágenes de libros
$sql = "SELECT imagen FROM libro WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    if (!empty($row['imagen']) && file_exists($row['imagen'])) {
        unlink($row['imagen']);
    }
}

// Borrar libros
$conn->query("DELETE FROM libro WHERE usuario_id = $usuario_id");

// Borrar usuario
$conn->query("DELETE FROM usuario WHERE usuario_id = $usuario_id");

header("Location: admin_panel.php");
exit();
