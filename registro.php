<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    include 'header.php';
    ?>
    <main>
        <div class="form-container">
            <div class="card form-card">
                <h1>Registro de Usuario</h1>
                <form action="procesar_registro.php" method="post">

                    <label for="nombre">Nombre de Usuario:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre de usuario" required>

                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" placeholder="Contraseña" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>


                    <button type="submit">Registrarse</button>
                </form>
                <?php 
                session_start();
                if (isset($_SESSION['msg'])) {
                    $msg = $_SESSION['msg'];
                    echo "<p> $msg </p>";
                }
                ?>
                <p style="text-align:center; margin-top:10px;">
                    ¿Ya tienes cuenta? <a href="login.php">Iniciar sesión</a>
                </p>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>