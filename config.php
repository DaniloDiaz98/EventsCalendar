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

$token=$_POST["pass"];

$destino = $_POST["email"];
$asunto = 'Token';

$cuerpo = '
    <html>
        <head>
            <title>Token De Verificacion</title>
        </head>
        <body>
            <h1>EventsCalendar</h1>
            <h1>Token de Verificación:</h1>
            <p>' . $password . '</p>
        </body>
    </html>
';

// para envio en formato HTML
$headers= "MIME-Version: 1.0\r\n";
$headers.= "Content-type: text/html; charset=utf-8\r\n";
// direccion del remitente
$headers.= "FROM: EVENTS CALENDAR<$email>\r\n";

//ruta del mensaje desde origen a destino
$headers.="Return-patch: $destino\r\n";

mail($destino,$asunto,$cuerpo,$headers);
echo"Email enviado correctamente";




$query = "INSERT INTO usuarios (nombre,usuario,cedula,password,email,telefono,foto_perfil,id_cargo,token)   values('$nombre','$usuario','$cedula','$password','$email','$telefono','$foto_perfil','$id_cargo','$token')";
$ejecutar = mysqli_query($conn, $query);
header("Location: mainOrg.php?usuario=" . urlencode($usuario));



?>