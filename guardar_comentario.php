<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "eventscalendar";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventoId = $_POST["evento_id"];
    $usuarioId = $_POST["usuario_id"];
    $comentario = $_POST["comentario"];
    $fecha = date("Y-m-d H:i:s");

    $query = "INSERT INTO comentario (id_eve,id_or, comentario, fecha) VALUES ('$eventoId', '$usuarioId', '$comentario', '$fecha')";

    if (mysqli_query($conn, $query)) {
        echo "Comentario almacenado exitosamente.";
    } else {
        echo "Error al almacenar el comentario: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
