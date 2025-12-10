<?php
session_start();

require_once "config.php";
require_once __DIR__ . "/includes/functions.php";

$conn = conectarBaseDatos();

// Obtener todos los libros con el nombre del usuario dueño
$sql = "SELECT libro.libro_id, libro.titulo, libro.sinopsis, libro.autor, libro.imagen,
               usuario.nombre AS usuario_nombre
        FROM libro
        INNER JOIN usuario ON libro.usuario_id = usuario.usuario_id
        ORDER BY libro.libro_id DESC";

$resultado = $conn->query($sql);

$librosGlobales = [];
while ($fila = $resultado->fetch_assoc()) {
    $librosGlobales[] = $fila;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Don Libro</title>
    <link rel="stylesheet" href="./styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <br><br>
        <h2 class="h2index">📚 Nuestros libros 📚</h2>

        <p>Explora nuestra amplia selección de libros y encuentra tu próxima lectura favorita.</p>
        <br><br>

        <?php if (empty($librosGlobales)): ?>
            <p style="text-align:center;">Todavía no hay libros registrados.</p>
        <?php else: ?>
            <div class="galeria">
                <?php foreach ($librosGlobales as $libro): ?>
                    <div class="card">

                        <?php if (!empty($libro["imagen"]) && file_exists($libro["imagen"])): ?>
                            <img src="<?php echo htmlspecialchars($libro["imagen"]); ?>" alt="Portada" class="img-libro">
                        <?php else: ?>
                            <img src="img/default.jpg" alt="Sin imagen" class="img-libro">
                        <?php endif; ?>

                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($libro["titulo"]); ?></h3>
                            <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro["autor"]); ?></p>
                            <p><?php echo nl2br(htmlspecialchars($libro["sinopsis"])); ?></p>
                            <small>Subido por: <?php echo htmlspecialchars($libro["usuario_nombre"]); ?></small>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </main>

    <?php include 'footer.php'; ?>
</body>

</html>