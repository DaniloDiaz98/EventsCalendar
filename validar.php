<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "eventscalendar";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    echo ("No hay conexión a la BD " . mysqli_connect_error());
}

$usuario = $_POST["usuario"];
$password = $_POST["pass"];

$query = "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$password'";
$ejecutar = mysqli_query($conn, $query);

// Comprobación adicional para depurar
if (!$ejecutar) {
    echo ("Error en la consulta: " . mysqli_error($conn));
}

if (mysqli_num_rows($ejecutar) > 0) {
    $filas = mysqli_fetch_array($ejecutar);

    if ($filas['id_cargo'] == 1) { // Administrador       
        header("Location: mainAdm.php?usuario=" . urlencode($usuario));     
    } else if ($filas['id_cargo'] == 2) { // Organizador
        header("Location: mainOrg.php?usuario=" . urlencode($usuario));      
        exit;
    } else {
        echo "<script> alert('Usuario No Encontrado');window.location= 'login.html' </script>";
    }
} else {
    echo "<script> alert('Usuario No Encontrado');window.location= 'login.html' </script>";
}

mysqli_free_result($ejecutar);
mysqli_close($conn);
?>



?>