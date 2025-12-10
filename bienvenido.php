<?php
session_start();

// Si no está logueado, redirigir
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";
require_once __DIR__ . "/includes/functions.php";

// Datos del usuario logueado
$usuario_id = $_SESSION['usuario_id'];
$usuario_nombre = $_SESSION['usuario_nombre'];

$conn = conectarBaseDatos();

// Obtener los libros del usuario
$sql = "SELECT libro_id, titulo, sinopsis, autor, imagen 
        FROM libro 
        WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();

$libros = [];
while ($fila = $resultado->fetch_assoc()) {
    $libros[] = $fila;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Biblioteca</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>Biblioteca de <?php echo htmlspecialchars($usuario_nombre); ?></h1>

        <h3>Tus libros:</h3>

        <?php if (empty($libros)): ?>
            <p style="text-align:center;">Todavía no tienes libros en tu biblioteca.</p>
        <?php else: ?>
            <div class="galeria">
                <?php foreach ($libros as $libro): ?>
                    <div class="card">


                        <?php if (!empty($libro['imagen']) && file_exists($libro['imagen'])): ?>
                            <img src="<?php echo htmlspecialchars($libro['imagen']); ?>" alt="Portada" class="img-libro">
                        <?php else: ?>
                            <img src="img/default.jpg" alt="Sin imagen" class="img-libro">
                        <?php endif; ?>

                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($libro['titulo']); ?></h3>
                            <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['autor']); ?></p>
                            <p><?php echo nl2br(htmlspecialchars($libro['sinopsis'])); ?></p>
                        </div>

                        <div class="acciones">
                            <a href="editar_libro.php?id=<?php echo $libro['libro_id']; ?>" title="Editar">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="eliminar_libro.php?id=<?php echo $libro['libro_id']; ?>" title="Eliminar"
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