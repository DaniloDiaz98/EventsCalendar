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

    $email = $_POST["email"];
    $password = $_POST["password"];

    

    $query = "UPDATE usuarios SET password = '$password' WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "success";
    } else {        
        echo "error: " . mysqli_error($conn); // Imprimir mensaje de error de la base de datos
       
    }

    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}

?>