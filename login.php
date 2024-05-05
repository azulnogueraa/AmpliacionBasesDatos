<?php
//Inicio del procesamiento
session_start();
?>
<!DOCTYPE html>
<html lang= "es">
    <head>
        <meta charset="utf-8">
        <title>Pagina Principal</title>
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
                return "{$_SESSION['nombre']} <a href='logout.php' class='salir'>(salir)</a>";   
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
            <h1>Log In</h1>
            <form method="post" action="procesarLogin.php" name="signin-form">
            <fieldset>
                <div class="legenda">
                    <legend>Datos para ingresar</legend>
                </div>
                <div class="form-element">
                    <label for="email">Email:</label>
                    <input type="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required />
                </div>
                <div class="form-element">
                    <label for="contrasena">Contraseña:</label>
                    <input type="contrasena" name="contrasena" required />
                </div>
                <div class="boton">
                    <button type="submit" name="login" value="login">Log In</button>
                </div>
            </fieldset>
            </form>
        </article>
    </main>
    
    </body>

</html>