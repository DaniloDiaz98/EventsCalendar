<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="icon" href="img/logo.ico">
    <!-- Agrega el enlace a Bootstrap CDN aquí -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        .form-label {
            font-weight: bold;
        }

        .back-btn a {
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Editar Perfil</h1>
        <?php
        require 'vendor/autoload.php';
        $nombreActual = "";
        if (isset($_GET["usuario"])) {
            $usuario = $_GET["usuario"];
            // Configura tus credenciales y detalles de Firebase Storage aquí
            $storage = new \Google\Cloud\Storage\StorageClient([
                'projectId' => 'eventcalendar-7e0dc',
                'keyFilePath' => 'eventcalendar-7e0dc-firebase-adminsdk-zbn98-45a95464ad.json'
            ]);
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $dbhost = "localhost";
                $dbuser = "root";
                $dbpass = "";
                $dbname = "eventscalendar";

                $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

                if (!$conn) {
                    echo ("<p class='error'>No hay conexión a la BD " . mysqli_connect_error() . "</p>");
                }

                // Recupera los datos del formulario
                $nombreNuevo = $_POST["nombre"];
                $emailNuevo = $_POST["email"];
                $telefonoNuevo = $_POST["telefono"];

                // Actualiza los datos en la base de datos
                $query = "UPDATE usuarios SET nombre='$nombreNuevo', email='$emailNuevo', telefono='$telefonoNuevo' WHERE usuario='$usuario'";
                if (mysqli_query($conn, $query)) {
                    echo "<p class='success'>Los datos se han actualizado correctamente.</p>";
                } else {
                    echo "<p class='error'>Error al actualizar los datos en la base de datos.</p>";
                }
                $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

                if (!$conn) {
                    echo ("<p class='error'>No hay conexión a la BD " . mysqli_connect_error() . "</p>");
                }
                $query = "SELECT nombre, email, telefono FROM usuarios WHERE usuario='$usuario'";
                $result = mysqli_query($conn, $query);
                if ($result && mysqli_num_rows($result) > 0) {
                    $userData = mysqli_fetch_assoc($result);
                    $nombreActual = $userData["nombre"];
                }
                // Actualiza la foto de perfil si se proporciona
                if (!empty($_FILES["nuevaFoto"]["tmp_name"])) {
                    $nombreFoto = $_FILES["nuevaFoto"]["name"];
                    $rutaTemporal = $_FILES["nuevaFoto"]["tmp_name"];
                
                    
                
                    $bucketName = 'eventcalendar-7e0dc.appspot.com'; // Reemplaza con el nombre de tu bucket de Firebase Storage

                   
                    $object = $storage->bucket($bucketName)->upload(
                        file_get_contents($rutaTemporal),
                        [
                            'name' => 'Fotos de Perfil/' . $nombreFoto // Agrega la carpeta en el nombre del archivo
                        ]
                    );
                    
                    $urlImagenPerfil = $object->signedUrl(new \DateTime('tomorrow'));
                
                    $updateFotoQuery = "UPDATE usuarios SET foto_perfil='$urlImagenPerfil' WHERE usuario='$usuario'";
                    if (mysqli_query($conn, $updateFotoQuery)) {
                        echo "<p class='success'>La foto de perfil se ha actualizado correctamente.</p>";
                    } else {
                        echo "<p class='error'>Error al actualizar la foto de perfil en la base de datos.</p>";
                    }
                }

                mysqli_close($conn);
            } else {
                // Establecer conexión a la base de datos y realizar consulta para obtener datos del usuario
                $dbhost = "localhost";
                $dbuser = "root";
                $dbpass = "";
                $dbname = "eventscalendar";

                $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

                if (!$conn) {
                    echo ("<p class='error'>No hay conexión a la BD " . mysqli_connect_error() . "</p>");
                }
                $query = "SELECT nombre, email, telefono FROM usuarios WHERE usuario='$usuario'";
                $result = mysqli_query($conn, $query);
                if ($result && mysqli_num_rows($result) > 0) {
                    $userData = mysqli_fetch_assoc($result);
                    $nombreActual = $userData["nombre"];
                }

                mysqli_close($conn);
            }
        } else {
            echo "<p class='error'>Usuario no especificado</p>";
        }
        ?>
        <form action="editarPer.php?usuario=<?php echo urlencode($usuario); ?>" method="post"
            enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control"
                    value="<?php echo htmlspecialchars($nombreActual); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control"
                    value="<?php echo htmlspecialchars($userData["email"]); ?>" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" class="form-control"
                    value="<?php echo htmlspecialchars($userData["telefono"]); ?>" required>
            </div>
            <div class="mb-3">
                <label for="nuevaFoto" class="form-label">Cambiar Foto de Perfil:</label>
                <input type="file" id="nuevaFoto" name="nuevaFoto" accept="image/*" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Datos</button>
        </form>
        <div class="back-btn mt-3">
            <a href="mainOrg.php?usuario=<?php echo urlencode($usuario); ?>">Volver al Dashboard</a>
        </div>
    </div>
    <!-- Agrega el script de Bootstrap si es necesario -->
</body>

</html>