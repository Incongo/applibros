<?php
session_start();
// Si ya está logueado, mándalo a bienvenido.php directamente
if (isset($_SESSION['usuario'])) {
    header("Location: bienvenido.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="login-container">
            <div class="card login-card">
                <h1>Iniciar Sesión</h1>
                <form action="procesar_login.php" method="post">
                    <label for="username">Usuario:</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit">Entrar</button>
                </form>
                <p>
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo "<span class='error-message'>" . $_SESSION["error"] . "</span>";
                    }
                    ?>
                </p>
                <p style="text-align:center; margin-top:10px;">
                    ¿No tienes cuenta? <a href="registro.php">Registrarse</a>
                </p>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>