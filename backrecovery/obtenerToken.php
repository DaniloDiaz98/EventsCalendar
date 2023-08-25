<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "eventscalendar";

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$conn) {
        echo "error";
        exit();
    }

    $email = $_POST["email"]; // Asegúrate de que estés recibiendo el email correctamente

    $query = "SELECT token FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo $row["token"];
    } else {
        echo "error";
    }

    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}

?>
