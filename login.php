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
            <a href="clases.php" class="topbar-item">Clases</a>
        </div>

    </div>


    <main>
        <article>
            <h1>Log In</h1>
            <form method="post" action="procesarLogin.php" name="signin-form">
            <fieldset>
                <div class="legenda">
                    <legend>Datos para reingresar</legend>
                </div>
                <div class="form-element">
                    <label for="nombreUsuario">Email:</label>
                    <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
                </div>
                <div class="form-element">
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" required />
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