<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Redirigir al inicio de sesión si el usuario no ha iniciado sesión
    exit();
}

// Aquí puedes obtener los detalles del usuario de $_SESSION['usuario']
$nombre = $_SESSION['usuario']['nombre'];
$email = $_SESSION['usuario']['email'];
// y otros campos que necesites mostrar

// Resto del código HTML
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perfil de Usuario</title>
</head>
<body >
    <h1>Bienvenido, <?php echo $nombre; ?>!</h1>
    <p>Tu dirección de correo electrónico es: <?php echo $email; ?></p>
    <!-- Puedes mostrar más información del usuario aquí -->

    <a href="logout.php">Cerrar sesión</a>
    <!-- Enlace para cerrar sesión, debe apuntar a un script que cierre la sesión y redirija al inicio de sesión -->
</body>
</html>
