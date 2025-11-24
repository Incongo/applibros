<?php
session_start();

// Elimina solo la variable del usuario actual
unset($_SESSION["usuario"]);

// Redirige al login
header("Location: index.php");
exit();
?>