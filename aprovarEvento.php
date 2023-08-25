<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "eventscalendar";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_eve"])) {
    $idEvento = $_POST["id_eve"];

    // Actualizar el estado del evento a 2 (aprobado)
    $updateQuery = "UPDATE eventos SET status = 2 WHERE id_eve = $idEvento";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Evento aprobado exitosamente.";
    } else {
        echo "Error al aprobar el evento: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
