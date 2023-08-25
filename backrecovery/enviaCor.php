<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Configuración del correo
    $destino = $_POST["email"];
    $asunto = 'Token';

    $token = "1998";  // Reemplaza esto con la generación real de tokens

    $cuerpo = '
        <html>
            <head>
                <title>Token De Verificacion</title>
            </head>
            <body>
                <h1>EventsCalendar</h1>
                <h1>Token de Verificación:</h1>
                <p>' . $token . '</p>
            </body>
        </html>
    ';

    // para envío en formato HTML
    $headers= "MIME-Version: 1.0\r\n";
    $headers.= "Content-type: text/html; charset=utf-8\r\n";
    $headers.= "FROM: EVENTS CALENDAR <noreply@example.com>\r\n";
    $headers.="Return-path: $destino\r\n";

    if (mail($destino, $asunto, $cuerpo, $headers)) {
        // Guardar el token en la base de datos
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "eventscalendar";

        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        if (!$conn) {
            echo "error";
            exit();
        }

        $email = $_POST["email"];

        $query = "UPDATE usuarios SET token = '$token' WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "success";
        } else {
            echo "error";
        }

        mysqli_close($conn);
    } else {
        echo "error";
    }
} else {
    echo "Invalid request method.";
}

// Función para generar un token aleatorio
function generateRandomToken() {
    // Implementa la generación real de tokens aquí
    return substr(md5(uniqid(rand(), true)), 0, 8);
}
?>
