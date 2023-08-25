<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "eventscalendar";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("No hay conexión a la BD " . mysqli_connect_error());
}

if (isset($_POST['validar'])) {
    $usuario = $_GET['usuario'];
    $tokenIngresado = $_POST['token'];

    $query = "SELECT token FROM usuarios WHERE usuario = '$usuario'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $tokenAlmacenado = $row['token'];

        if ($tokenIngresado === $tokenAlmacenado) {
            header("Location: mainOrg.php?usuario=" . urlencode($usuario));
            exit();
        } else {
            $error = "El token ingresado no es válido.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Token</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/logo.ico">
</head>

<body>
    <div id="contenedor">
        <div id="contenedorcentrado">
            <div id="form">
                <h1 class="title">Validar Token</h1>
                <?php if (isset($error)) { ?>
                    <p style="color: red;">
                        <?php echo $error; ?>
                    </p>
                <?php } ?>
                <br>
                <form method="post">
                    
                    <div class="inputContainer">
                        <input class="input" type="password" placeholder="a" name="token" required>
                        <label class="label">Token</label>
                    </div>
                    <input class="btn" type="submit" name="validar" value="Validar">
                </form>
            </div>
            <div id="derecho">
            <div class="logo-container">
                    <img class="logo" src="img/logo.png" alt="Logo de la página">
                </div>
                <hr>
                <div class="titulo">
                    <p class="welcome-text">
                    Por favor, ingrese el token que ha sido enviado a su correo electrónico.</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>