<footer>

    <p>&copy; <?php echo date("Y"); ?> Don Libro — Tu biblioteca digital.</p>

    <p>
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <a href="bienvenido.php" style="color:#fff; margin-right:15px;">Mis libros</a>
            <a href="logout.php" style="color:#fff;">Cerrar sesión</a>
        <?php else: ?>
            <a href="login.php" style="color:#fff; margin-right:15px;">Login</a>
            <a href="registro.php" style="color:#fff;">Registro</a>
        <?php endif; ?>
    </p>

</footer>