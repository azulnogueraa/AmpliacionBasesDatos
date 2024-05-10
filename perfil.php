<?php
session_start();

require_once __DIR__.'/config.php';

// Mostrar errores de PHP en la página web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Obtener el ID de usuario desde la sesión
$UserID = $_SESSION['id'];

// Obtener las clases a las que el usuario está inscrito desde la base de datos
$conn = conexionBD();
$query = "SELECT Clases.Nombre AS NombreClase, HorariosClases.Fecha, HorariosClases.HoraInicio
          FROM Inscripciones
          INNER JOIN HorariosClases ON Inscripciones.HorarioID = HorariosClases.HorarioID
          INNER JOIN Clases ON HorariosClases.ClaseID = Clases.ClaseID
          WHERE Inscripciones.UserID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $UserID);
$stmt->execute();
$result = $stmt->get_result();

$clasesInscritas = [];
while ($row = $result->fetch_assoc()) {
    $clasesInscritas[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Perfil de Usuario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.jpg" type="image/png">
    <link rel="stylesheet" href="css/perfil.css">
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
            // Verificar si el usuario está autenticado
            if (isset($_SESSION["login"]) && $_SESSION["login"] == true) {
                echo "<a href='clases.php' class='topbar-item'>Clases</a>";
                echo "<a href='perfil.php' class='topbar-item'>Perfil</a>";
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
            <h1>Mis Clases</h1>
            <?php if (!empty($_SESSION['exitoMensaje'])) : ?>
                <div class="exito">
                    <?= $_SESSION['exitoMensaje'] ?>
                </div>
                <?php unset($_SESSION['exitoMensaje']); ?>
            <?php endif; ?>
            <div>
                <?php if (empty($clasesInscritas)) : ?>
                    <p>No estás inscrito en ninguna clase actualmente.</p>
                <?php else : ?>
                    <h2>Clases a las que está inscrito:</h2>
                    <ul>
                        <?php foreach ($clasesInscritas as $clase) : ?>
                            <li>
                                <?= $clase['NombreClase'] ?> - <?= date('d/m/Y', strtotime($clase['Fecha'])) ?> <?= date('H:i', strtotime($clase['HoraInicio'])) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </article>
    </main>
</body>
</html>
