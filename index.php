<?php
// Ejemplo de datos de libros
$libros = [
    [
        "titulo" => "El Quijote",
        "imagen" => "imagenes/quijote.jpg",
    ],
    [
        "titulo" => "Clean Code",
        "imagen" => "imagenes/cleancode.jpg",
    ],
    [
        "titulo" => "Harry Potter",
        "imagen" => "imagenes/harrypotter.jpg",
    ]
];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tus Libros</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Don Libro</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="catalogo.php">Catálogo</a></li>
        </ul>
    </nav>
    <main>
        <a href="login.php">Login</a>
        <a href="registro.php">Registrarse</a>

        <h2>Bienvenido a Don Libro</h2>
        catalogo de libros
        <p>Explora nuestra amplia selección de libros y encuentra tu próxima lectura favorita.</p>

        <h2 style="text-align:center;">📚 Nuestros libros 📚</h2>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($libros as $libro): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($libro["titulo"]); ?></td>
                        <td>
                            <img src="<?php echo htmlspecialchars($libro["imagen"]); ?>"
                                alt="Portada de <?php echo htmlspecialchars($libro["titulo"]); ?>" class="img-libro">
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <img src="img/libros.jpg" alt="Imagen de libros">



    </main>
</body>

</html>