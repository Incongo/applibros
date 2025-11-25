<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$librosPorUsuario = $_SESSION['libros'] ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de administración</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>Panel de administración</h1>
        <p>Aquí puedes ver todos los usuarios registrados y sus libros.</p>

        <?php if (empty($librosPorUsuario)): ?>
            <p>No hay usuarios ni libros registrados.</p>
        <?php else: ?>
            <div class="galeria">
                <?php foreach ($librosPorUsuario as $usuario => $listaLibros): ?>
                    <div class="card">
                        <div class="card-content">
                            <h3>👤 <?php echo htmlspecialchars($usuario); ?></h3>
                            <?php if (!empty($listaLibros)): ?>
                                <ul>
                                    <?php foreach ($listaLibros as $libro): ?>
                                        <li>
                                            <strong><?php echo htmlspecialchars($libro['titulo']); ?></strong><br>
                                            <?php echo htmlspecialchars($libro['sinopsis']); ?><br>
                                            <?php if (!empty($libro['imagen']) && file_exists($libro['imagen'])): ?>
                                                <img src="<?php echo htmlspecialchars($libro['imagen']); ?>" class="img-libro" alt="Portada">
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p>Este usuario no ha subido libros.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
