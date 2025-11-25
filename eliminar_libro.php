<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];
if (!isset($_SESSION['libros'][$usuario]))
    $_SESSION['libros'][$usuario] = [];
$libros = &$_SESSION['libros'][$usuario];

$index = (int) ($_GET['index'] ?? -1);
if (isset($libros[$index])) {
    unset($libros[$index]);
    $libros = array_values($libros);
}
header("Location: bienvenido.php");
exit();
