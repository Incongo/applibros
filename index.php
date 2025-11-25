<?php
session_start();



// Recoger todos los libros de todos los usuarios
$librosGlobales = [];
if (isset($_SESSION['libros'])) {
    foreach ($_SESSION['libros'] as $usuario => $lista) {
        foreach ($lista as $libro) {
            $librosGlobales[] = ["usuario" => $usuario] + $libro;
        }
    }
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
                <?php foreach ($librosGlobales as $i => $libro): ?>
                    <div class="card">
                        <?php if (!empty($libro["imagen"]) && file_exists($libro["imagen"])): ?>
                            <img src="<?php echo htmlspecialchars($libro["imagen"]); ?>" alt="Portada">
                        <?php else: ?>
                            <img src="img/default.jpg" alt="Sin imagen">
                        <?php endif; ?>
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($libro["titulo"]); ?></h3>
                            <p><?php echo nl2br(htmlspecialchars($libro["sinopsis"] ?? "")); ?></p>
                            <small>Por: <?php echo htmlspecialchars($libro["usuario"]); ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div style="text-align:center; margin:20px;">
            <form action="guardar_json.php" method="post" style="display:inline;">
                <button type="submit">💾 Guardar datos</button>
            </form>
            <form action="cargar_json.php" method="post" style="display:inline;">
                <button type="submit">📂 Cargar datos</button>
            </form>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <p style="text-align:center; color:green;">
                <?php
                switch ($_GET['msg']) {
                    case 'guardado':
                        echo "Datos guardados correctamente.";
                        break;
                    case 'cargado':
                        echo "Datos cargados correctamente.";
                        break;
                    case 'sin_datos':
                        echo "No había datos de sesión para guardar.";
                        break;
                    case 'error_json':
                        echo "Error al leer el archivo JSON.";
                        break;
                    case 'no_archivo':
                        echo "No existe el archivo de datos.";
                        break;
                }
                ?>
            </p>
        <?php endif; ?>

    </main>

    <?php include 'footer.php'; ?>
</body>

</html>