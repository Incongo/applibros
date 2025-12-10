<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_nombre'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require_once "config.php";
require_once __DIR__ . "/includes/functions.php";

$conn = conectarBaseDatos();

/* ---------------------------------------------------------
   1. ESTADÍSTICAS
--------------------------------------------------------- */

// Total de usuarios
$totalUsuarios = $conn->query("SELECT COUNT(*) AS total FROM usuario")->fetch_assoc()['total'];

// Total de libros
$totalLibros = $conn->query("SELECT COUNT(*) AS total FROM libro")->fetch_assoc()['total'];

// Libros por usuario
$sql = "
    SELECT 
        usuario.usuario_id,
        usuario.nombre AS usuario_nombre,
        libro.libro_id,
        libro.titulo,
        libro.imagen
    FROM usuario
    LEFT JOIN libro ON usuario.usuario_id = libro.usuario_id
    ORDER BY usuario.usuario_id, libro.libro_id DESC
";

$resultado = $conn->query($sql);

$usuarios = [];

while ($fila = $resultado->fetch_assoc()) {
    $id = $fila['usuario_id'];

    if (!isset($usuarios[$id])) {
        $usuarios[$id] = [
            'nombre' => $fila['usuario_nombre'],
            'libros' => []
        ];
    }

    if (!empty($fila['libro_id'])) {
        $usuarios[$id]['libros'][] = [
            'id' => $fila['libro_id'],
            'titulo' => $fila['titulo'],
            'imagen' => $fila['imagen']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de administración</title>
    <link rel="stylesheet" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <br><br>
        <h1>Panel de administración</h1>
        <br>

        <!-- Estadísticas -->
        <div style="text-align:center; margin-bottom:30px;">
            <h2>📊 Estadísticas generales</h2>
            <p><strong>Total de usuarios:</strong> <?php echo $totalUsuarios; ?></p>
            <p><strong>Total de libros:</strong> <?php echo $totalLibros; ?></p>
        </div>

        <h2 style="text-align:center;">👥 Usuarios y sus libros</h2>
        <br>

        <?php if (empty($usuarios)): ?>
            <p>No hay usuarios registrados.</p>
        <?php else: ?>
            <div class="galeria">
                <?php foreach ($usuarios as $usuario_id => $usuario): ?>
                    <div class="card">
                        <div class="card-content">
                            <h3>👤 <?php echo htmlspecialchars($usuario['nombre']); ?></h3>

                            <!-- Botón eliminar usuario -->
                            <?php if ($usuario['nombre'] !== 'admin'): ?>
                                <p>
                                    <a href="eliminar_usuario.php?id=<?php echo $usuario_id; ?>"
                                        onclick="return confirm('¿Seguro que quieres eliminar este usuario y todos sus libros?');"
                                        style="color:red; font-weight:bold;">
                                        Eliminar usuario
                                    </a>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($usuario['libros'])): ?>
                                <ul>
                                    <?php foreach ($usuario['libros'] as $libro): ?>
                                        <li>
                                            <strong><?php echo htmlspecialchars($libro['titulo']); ?></strong><br><br>

                                            <?php if (!empty($libro['imagen']) && file_exists($libro['imagen'])): ?>
                                                <img src="<?php echo htmlspecialchars($libro['imagen']); ?>" class="img-libro" alt="Portada">
                                            <?php else: ?>
                                                <img src="img/default.jpg" class="img-libro" alt="Sin imagen">
                                            <?php endif; ?>

                                            <!-- Botón eliminar libro -->
                                            <p>
                                                <a href="eliminar_libro.php?id=<?php echo $libro['id']; ?>"
                                                    onclick="return confirm('¿Eliminar este libro?');"
                                                    style="color:red;">
                                                    Eliminar libro
                                                </a>
                                            </p>
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