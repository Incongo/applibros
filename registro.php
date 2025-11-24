<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Registro de Usuario</h1>
    <form action="procesar_registro.php" method="post">
        <label for="username">Nombre de Usuario:</label>
        <input type="text" id="username" name="username" placeholder="Nombre de usuario" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" placeholder="Contraseña" required>

        <button type="submit">Registrarse</button>

    </form>

</body>

</html>