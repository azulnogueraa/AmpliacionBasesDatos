<?php
session_start();

// Mostrar errores de PHP en la página web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de utilidades para la conexión y otras funciones
require_once __DIR__.'/config.php';

$erroresFormulario = [];

// Verificar si se envió el formulario de inicio de sesión
$formEnviado = isset($_POST["login"]);

if ($formEnviado) {
    // Validar y filtrar los datos del formulario
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $contrasena = filter_input(INPUT_POST, 'contrasena', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Validar email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erroresFormulario['email'] = 'Introduce una dirección de correo electrónico válida.';
    }

    // Validar contraseña
    if (empty($contrasena)) {
        $erroresFormulario['contrasena'] = 'Introduce tu contraseña.';
    }

    // Procesar inicio de sesión si no hay errores en el formulario
    if (count($erroresFormulario) === 0) {
        $conn = conexionBD();

        // Buscar usuario por email
        $query = "SELECT * FROM Usuarios WHERE Email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();

            // Verificar la contraseña utilizando password_verify
            if (password_verify($contrasena, $usuario['HashContraseña'])) {
                // Inicio de sesión exitoso, establecer variables de sesión
                $_SESSION["login"] = true;
                $_SESSION["nombre"] = $usuario['Nombre'];
                $_SESSION["id"] = $usuario['UserID'];
                $_SESSION["email"] = $email;

                // Redirigir al usuario a la página de clases después del inicio de sesión
                header('Location: clases.php');
                exit();
            } else {
                $erroresFormulario['email'] = 'Las credenciales de inicio de sesión son incorrectas.';
            }
        } else {
            $erroresFormulario['email'] = 'No se encontró ningún usuario con este correo electrónico.';
        }

        $stmt->close();
        $conn->close();
    }
}

// Si llegamos aquí, significa que hubo errores en el formulario o no se envió el formulario
// Mostrar el formulario de inicio de sesión con los errores
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Iniciar Sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <a href="registro.php" class="topbar-item">Registro</a>
            <a href="login.php" class="topbar-item">Log In</a>
            <?php
            // Verificar si el usuario está autenticado
            if (isset($_SESSION["login"]) && $_SESSION["login"] == true) {
                echo "<a href='clases.php' class='topbar-item'>Clases</a>";
                echo "<a href='perfil.php' class='topbar-item'>Perfil</a>";
            }
            ?>
        </div>
        <?php
        // Función para mostrar el saludo dependiendo del estado de sesión del usuario
        function mostrarSaludo() {
            if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
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
            <h1>Iniciar Sesión</h1>
            <form action="procesarLogin.php" method="POST">
                <fieldset>
                    <div class="legenda">
                        <legend>Introduce tus credenciales</legend>
                    </div>
                    <div>
                        <label for="email">Email:</label>
                        <input id="email" type="email" name="email" />
                        <?= isset($erroresFormulario['email']) ? '<span class="error">' . $erroresFormulario['email'] . '</span>' : '' ?>
                    </div>
                    <div>
                        <label for="contrasena">Contraseña:</label>
                        <input id="contrasena" type="password" name="contrasena" />
                        <?= isset($erroresFormulario['contrasena']) ? '<span class="error">' . $erroresFormulario['contrasena'] . '</span>' : '' ?>
                    </div>
                    <div class="boton">
                        <button type="submit" name="login">Iniciar Sesión</button>
                    </div>
                </fieldset>
            </form>
        </article>
    </main>
</body>
</html>
