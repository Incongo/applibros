<?php
include 'header.php';
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];
if (!isset($_SESSION['libros'][$usuario]))
    $_SESSION['libros'][$usuario] = [];
$libros = &$_SESSION['libros'][$usuario];

$index = (int) ($_GET['index'] ?? -1);
if (!isset($libros[$index])) {
    header("Location: bienvenido.php");
    exit();
}

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $libros[$index]['titulo'] = trim($_POST['titulo']);
    $libros[$index]['sinopsis'] = trim($_POST['sinopsis']);

    $nueva = guardarImagen('imagen');
    if ($nueva !== '') {
        $libros[$index]['imagen'] = $nueva;
    }
    header("Location: bienvenido.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar libro</title>
    <link rel="stylesheet" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <main>
        <div class="form-container">
            <div class="card form-card">
                <h1>Editar libro</h1>
                <form method="post" enctype="multipart/form-data">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo"
                        value="<?php echo htmlspecialchars($libros[$index]['titulo']); ?>" required>

                    <label for="sinopsis">Sinopsis:</label>
                    <textarea id="sinopsis" name="sinopsis"
                        required><?php echo htmlspecialchars($libros[$index]['sinopsis']); ?></textarea>

                    <?php if (!empty($libros[$index]['imagen']) && file_exists($libros[$index]['imagen'])): ?>
                        <p>Imagen actual:</p>
                        <img src="<?php echo htmlspecialchars($libros[$index]['imagen']); ?>" class="img-libro"
                            alt="Portada">
                    <?php endif; ?>

                    <label for="imagen">Nueva imagen (opcional):</label>
                    <input type="file" id="imagen" name="imagen" accept=".jpg,.jpeg,.png,.gif,.webp">

                    <button type="submit">Guardar cambios</button>
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