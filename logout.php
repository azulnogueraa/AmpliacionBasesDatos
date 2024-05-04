<?php
//Inicio del procesamiento
session_start();

//Doble seguridad: unset + destroy
unset($_SESSION['login']);
unset($_SESSION['nombre']);
unset($_SESSION['email']);

session_destroy();
?>
<!DOCTYPE html>
<html lang = "es">
<head>
	<meta charset="UTF-8">
	<title>Logout</title>
    <link rel="icon" href="img/logo.jpg" type="image/png">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
    <body>
        <!-- topbar -->
        <div class="topbar">
            <div class="topbar-name">
                <a class="topbar-name">gymOrg</a>
            </div>
            <!-- topbar items -->
            <div>
                <a href="index.php" class="topbar-item">Inicio</a>
                <a href="registro.php" class="topbar-item">Registro</a>
                <a href="login.php" class="topbar-item">Log In</a>
                <a href="clases.php" class="topbar-item">Clases</a>
            </div>

            <?php
            // Función para mostrar el saludo dependiendo del estado de sesión del usuario
            function mostrarSaludo() {
                if (isset($_SESSION['login']) && ($_SESSION['login'] === true)) {
                    return "Bienvenido, {$_SESSION['nombre']} <a href='logout.php' class='salir'>(salir)</a>";   
                } else {
                    return "Usuario desconocido.";
                }
            }
            ?>
            <!-- Mostrar el saludo -->
            <div class="saludo"><?= mostrarSaludo(); ?></div>
        </div>

        <div id="contenedor_logout">
            <main>
                <article>
                    <h1>Hasta pronto!</h1>
                </article>
            </main>
        </div>
    </body>
</html>
