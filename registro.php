<?php
//Inicio del procesamiento
session_start();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Registro</title>
        <link rel="icon" href="img/logo.jpg" type="image/png">
        <link rel="stylesheet" href="css/login_registro.css">
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
                <a href="login.php" class="topbar-item">Log In</a>
                <a href="registro.php" class="topbar-item">Registro</a>
                <?php
                // Verificar si el usuario no está autenticado
                if (isset($_SESSION["login"]) || $_SESSION["login"] == true) {
                    echo "<a href='clases.php' class='topbar-item'>Clases</a>";
                }
                ?>
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

    
        <main>
            <article>
                <h1>Registro de usuario</h1>
                <form action="procesarRegistro.php" method="POST">
                <fieldset>
                    <div class="legenda">
                        <legend>Datos para el registro</legend>
                    </div>
                    <div>
                        <label for="nombre">Nombre:</label>
                        <input id="nombre" type="text" name="nombre" />
                    </div>
                    <div>
                        <label for="apellido">Apellido:</label>
                        <input id="apellido" type="text" name="apellido" />
                    </div>
                    <div>
                        <label for="email">Email:</label>
                        <input id="email" type="email" name="email" />
                    </div>
                    <div>
                        <label for="password">Contraseña:</label>
                        <input id="password" type="password" name="password" />
                    </div>
                    <div>
                        <label for="password2">Reintroduce contraseña:</label>
                        <input id="password2" type="password" name="password2" />
                    </div>
                    <div class="boton">
                        <button type="submit" name="registro">Registrar</button>
                    </div>
                </fieldset>
                </form>
            </article>
        </main>

    </body>

</html>