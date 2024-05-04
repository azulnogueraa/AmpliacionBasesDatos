<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>gymOrg</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pagina web que gestiona la organización de las clases de unn gimnasio">
    <link rel="icon" href="img/logo.jpg" type="image/png">
    <link rel="stylesheet" href="css/style.css">
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


    <div class="imagen-fondo">
    </div>

</body>

</html>