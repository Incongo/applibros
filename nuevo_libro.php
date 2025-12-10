<?php
session_start();

// Si no está logueado, redirigir
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";
require_once __DIR__ . "/includes/functions.php";

$usuario_id = $_SESSION['usuario_id'];

// Función para guardar imagen
function guardarImagen($campo, $carpeta = 'uploads')
{
    if (empty($_FILES[$campo]['name']))
        return '';

    if (!is_dir($carpeta))
        mkdir($carpeta, 0777, true);

    $ext = strtolower(pathinfo($_FILES[$campo]['name'], PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($ext, $permitidas))
        return '';

    $nombre = uniqid('img_', true) . '.' . $ext;
    $destino = $carpeta . '/' . $nombre;

    if (move_uploaded_file($_FILES[$campo]['tmp_name'], $destino)) {
        return $destino;
    }

    return '';
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo = trim($_POST['titulo']);
    $sinopsis = trim($_POST['sinopsis']);
    $autor = trim($_POST['autor']);
    $imagen = guardarImagen('imagen');

    if ($titulo !== '' && $sinopsis !== '' && $autor !== '') {

        $conn = conectarBaseDatos();

        $sql = "INSERT INTO libro (titulo, sinopsis, autor, usuario_id, imagen)
        VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssis", $titulo, $sinopsis, $autor, $usuario_id, $imagen);
        $stmt->execute();
    }

    header("Location: bienvenido.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nuevo libro</title>
    <link rel="stylesheet" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="form-container">
            <div class="card form-card">
                <h1>Añadir libro</h1>
                <form method="post" enctype="multipart/form-data">

                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" required>

                    <label for="autor">Autor:</label>
                    <input type="text" id="autor" name="autor" required>

                    <label for="sinopsis">Sinopsis:</label>
                    <textarea id="sinopsis" name="sinopsis" required></textarea>

                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" name="imagen" accept=".jpg,.jpeg,.png,.gif,.webp">

                    <button type="submit">Añadir</button>
                </form>

                <p style="text-align:center; margin-top:10px;">
                    <a href="bienvenido.php">Volver</a>
                </p>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>