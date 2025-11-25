<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];
if (!isset($_SESSION['libros'][$usuario])) {
    $_SESSION['libros'][$usuario] = [];
}
$libros = $_SESSION['libros'][$usuario];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Biblioteca</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>Biblioteca de <?php echo htmlspecialchars($usuario); ?></h1>

        <h3>Tus libros:</h3>

        <?php if (empty($libros)): ?>
            <p style="text-align:center;">Todavía no tienes libros en tu biblioteca.</p>
        <?php else: ?>
            <div class="galeria">
                <?php foreach ($libros as $i => $libro): ?>
                    <div class="card">
                        <?php if (!empty($libro['imagen']) && file_exists($libro['imagen'])): ?>
                            <img src="<?php echo htmlspecialchars($libro['imagen']); ?>" alt="Portada">
                        <?php else: ?>
                            <img src="img/default.jpg" alt="Sin imagen">
                        <?php endif; ?>
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($libro['titulo']); ?></h3>
                            <p><?php echo nl2br(htmlspecialchars($libro['sinopsis'])); ?></p>
                        </div>
                        <div class="acciones">
                            <a href="editar_libro.php?index=<?php echo $i; ?>" title="Editar">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="eliminar_libro.php?index=<?php echo $i; ?>" title="Eliminar"
                                onclick="return confirm('¿Seguro que quieres borrar este libro?');">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <p style="text-align:center; margin-top:20px;">
            <a href="nuevo_libro.php">➕ Añadir nuevo libro</a>
        </p>
        <p style="text-align:center;">
            <a href="logout.php">Cerrar sesión</a>
        </p>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>