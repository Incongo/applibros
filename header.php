<header>

    <div>
        <a href="index.php" style="color:#fff; text-decoration:none; font-weight:bold; font-size:20px;">
            📚 Don Libro
        </a>
    </div>

    <div>
        <a href="index.php" style="color:#fff; margin-right:15px;">Inicio</a>

        <?php if (isset($_SESSION['usuario_id'])): ?>
            <div style="position:relative; display:inline-block;">
                <span style="cursor:pointer;">
                    <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?> ⌄
                </span>

                <div id="dropdown"
                    style="text-align:center; width:240%; display:none; position:absolute; right:0;
                            background:#333; padding:10px; border-radius:4px;">

                    <a href="bienvenido.php" style="color:#fff; text-decoration:none; display:block; margin:5px 0;">
                        Mis libros
                    </a>

                    <a href="logout.php" style="color:#fff; text-decoration:none; display:block; margin:5px 0;">
                        Cerrar sesión
                    </a>

                    <?php if ($_SESSION['usuario_nombre'] === 'admin'): ?>
                        <a href="admin_panel.php"
                            style="color:#fff; text-decoration:none; display:block; margin:5px 0;">
                            Panel de control
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <script>
                const span = document.querySelector('header span');
                const dropdown = document.getElementById('dropdown');
                span.addEventListener('click', () => {
                    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                });
            </script>

        <?php else: ?>
            <a href="login.php" style="color:#fff; margin-right:15px;">Login</a>
            <a href="registro.php" style="color:#fff;">Registro</a>
        <?php endif; ?>
    </div>

</header>