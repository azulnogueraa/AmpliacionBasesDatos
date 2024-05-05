<?php
session_start();

// Mostrar errores de PHP en la página web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de utilidades para la conexión y otras funciones
require_once __DIR__.'/config.php';

if (isset($_GET['id'])) {
    $_SESSION['clase_id'] = $_GET['id'];
}

$erroresFormulario = [];

// Verificar si se envió el formulario de inscripción
$formEnviado = isset($_POST["inscribir"]);

if ($formEnviado) {
    // Validar y filtrar los datos del formulario
    $HorarioID = filter_input(INPUT_POST, 'Horario_ID', FILTER_VALIDATE_INT);

    // Verificar si se seleccionó un horario válido
    if (!$HorarioID) {
        $erroresFormulario['Horario_ID'] = 'Por favor, selecciona un horario válido.';
    }

    // Procesar la inscripción si no hay errores en el formulario
    if (count($erroresFormulario) === 0) {
        $conn = conexionBD();

        // Obtener el ID de usuario desde la sesión
        $UserID = $_SESSION['id'];

        // Verificar si el usuario ya está inscrito en este horario
        $query = "SELECT * FROM Inscripciones WHERE UserID = ? AND HorarioID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $UserID, $HorarioID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // El usuario ya está inscrito en este horario
            $erroresFormulario['general'] = 'Ya estás inscrito en esta clase para este horario.';
        } else {
            // Insertar la inscripción del usuario en la tabla de Inscripciones
            $queryInsert = "INSERT INTO Inscripciones (UserID, HorarioID) VALUES (?, ?)";
            $stmtInsert = $conn->prepare($queryInsert);
            $stmtInsert->bind_param('ii', $UserID, $HorarioID);

            if ($stmtInsert->execute()) {
                // Inscripción exitosa
                $_SESSION['exitoMensaje'] = 'Te has inscrito correctamente en la clase.';
    
                header('Location: perfil.php');
                exit();
            } else {
                $erroresFormulario['general'] = 'Error al inscribirse en la clase. Por favor, inténtalo de nuevo.';
            }

            $stmtInsert->close();
        }

        $stmt->close();
        $conn->close();
    }
}

$ClaseID = $_SESSION['clase_id'];

// Obtener los horarios disponibles para la clase seleccionada desde la base de datos
$conn = conexionBD();
$query = "SELECT HorarioID, Fecha, HoraInicio FROM HorariosClases WHERE ClaseID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $ClaseID);
$stmt->execute();
$result = $stmt->get_result();

$horariosDisponibles = [];
while ($row = $result->fetch_assoc()) {
    $horariosDisponibles[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Inscribirse en Clase</title>
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
        // Mostrar el nombre del usuario si está logueado
        if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
            echo '<div class="saludo">' . $_SESSION['nombre'] . ' (<a href="logout.php" class="salir">Salir</a>)</div>';
        }
        ?>
    </div>
    <main>
        <article>
            <h1>Inscribirse en Clase</h1>
            <?php if (!empty($_SESSION['exitoMensaje'])) : ?>
                <div class="exito">
                    <?= $_SESSION['exitoMensaje'] ?>
                </div>
                <?php unset($_SESSION['exitoMensaje']); ?>
            <?php endif; ?>
            <?php if (!empty($erroresFormulario)) : ?>
                <div class="errores">
                    <ul>
                        <?php foreach ($erroresFormulario as $error) : ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form action="inscribirClase.php" method="POST">
                <fieldset>
                    <div class="legenda">
                        <legend>Selecciona un Horario</legend>
                    </div>
                    <?php foreach ($horariosDisponibles as $horario) : ?>
                        <div>
                            <label>
                                <input type="radio" name="Horario_ID" value="<?= $horario['HorarioID'] ?>" required>
                                <?= date('d/m/Y', strtotime($horario['Fecha'])) ?> - <?= date('H:i', strtotime($horario['HoraInicio'])) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                    <div class="boton">
                        <button type="submit" name="inscribir">Inscribirse</button>
                    </div>
                </fieldset>
            </form>
        </article>
    </main>
</body>
</html>