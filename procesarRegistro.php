<?php
session_start();

// Mostrar errores de PHP en la página web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de utilidades para la conexión y otras funciones
require_once __DIR__.'/config.php';

$formEnviando = isset($_POST["registro"]);
if (! $formEnviando) {
    header('Location: registro.php');
    exit();
}

$erroresFormulario = [];

$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (empty($nombre) || mb_strlen($nombre) < 3) {
    $erroresFormulario['nombre'] = 'El nombre debe tener al menos 3 caracteres.';
}

$apellido = filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (empty($apellido) || mb_strlen($apellido) < 3) {
    $erroresFormulario['apellido'] = 'El apellido debe tener al menos 3 caracteres.';
}

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erroresFormulario['email'] = 'Introduce una dirección de correo electrónico válida.';
}

$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (empty($password) || mb_strlen($password) < 5) {
    $erroresFormulario['password'] = 'La contraseña debe tener al menos 5 caracteres.';
}

$password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (empty($password2) || $password != $password2) {
    $erroresFormulario['password2'] = 'Las contraseñas deben coincidir.';
}

if (count($erroresFormulario) == 0) {
    $conn = conexionBD();

    // Verificar si el correo ya está registrado como usuario
    $query = sprintf("SELECT * FROM Usuarios WHERE Email = '%s'",
        $conn->real_escape_string($email)
    );
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $erroresFormulario['email'] = 'Este correo electrónico ya está registrado. Por favor, utiliza otro.';
    } else {
        // Insertar el nuevo usuario en la tabla Usuarios
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = sprintf("INSERT INTO Usuarios (Nombre, Email, HashContraseña) VALUES ('%s', '%s', '%s')",
            $conn->real_escape_string($nombre . ' ' . $apellido),
            $conn->real_escape_string($email),
            $conn->real_escape_string($hashedPassword)
        );

        if ($conn->query($query)) {
            $_SESSION["login"] = true;
            $_SESSION["nombre"] = $nombre . ' ' . $apellido;
            $_SESSION["id"] = $conn->insert_id;
            $_SESSION["email"] = $email;
            header('Location: clases.php'); 
            exit();
        } else {
            $erroresFormulario[] = 'Error al registrar al usuario.';
        }
    }
}

// Si hay errores, muestra el formulario de registro con los errores
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registro</title>
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
            if (isset($_SESSION['login']) && ($_SESSION['login'] === true)) {
                return " {$_SESSION['nombre']} <a href='logout.php' class='salir'>(salir)</a>";   
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
                        <?= generarError('nombre', $erroresFormulario) ?>
                    </div>
                    <div>
                        <label for="apellido">Apellido:</label>
                        <input id="apellido" type="text" name="apellido" />
                        <?= generarError('apellido', $erroresFormulario) ?>
                    </div>
                    <div>
                        <label for="email">Email:</label>
                        <input id="email" type="email" name="email" />
                        <?= generarError('email', $erroresFormulario) ?>
                    </div>
                    <div>
                        <label for="password">Password:</label>
                        <input id="password" type="password" name="password" />
                        <?= generarError('password', $erroresFormulario) ?>
                    </div>
                    <div>
                        <label for="password2">Reintroduce el password:</label>
                        <input id="password2" type="password" name="password2" />
                        <?= generarError('password2', $erroresFormulario) ?>
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
