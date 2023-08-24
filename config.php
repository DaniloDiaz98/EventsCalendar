<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "eventscalendar";


$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    echo ("No hay conexión a la BD " . mysqli_connect_error());
}


$nombre = $_POST["nombre"];
$usuario = $_POST["usuario"];
$cedula = $_POST["cedula"];
$password = $_POST["pass"];
$email = $_POST["email"];
$telefono = $_POST["telefono"];
$id_cargo = 2;
$foto_perfil = "1.png";
// Después de insertar los datos en la base de datos
$token = uniqid();
// Almacena el token en la base de datos junto con los datos del usuario
$query = "INSERT INTO usuarios (nombre, usuario, cedula, password, email, telefono, foto_perfil, id_cargo, token) values ('$nombre', '$usuario', '$cedula', '$password', '$email', '$telefono', '$foto_perfil', '$id_cargo', '$token')";
$ejecutar = mysqli_query($conn, $query);
header("Location: mainOrg.php?usuario=" . urlencode($usuario));  



?>