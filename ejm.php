<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <!-- Agrega el enlace a Bootstrap CDN aquí -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Editar Perfil</h1>
        <?php
        if (isset($_GET["usuario"])) {
            $usuario = $_GET["usuario"];

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $dbhost = "localhost";
                $dbuser = "root";
                $dbpass = "";
                $dbname = "eventscalendar";

                $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

                if (!$conn) {
                    echo ("<p class='error'>No hay conexión a la BD " . mysqli_connect_error() . "</p>");
                }

                $nuevaFoto = $_FILES["nuevaFoto"];
                $nombreFoto = $nuevaFoto["name"];
                $tipoFoto = $nuevaFoto["type"];
                $rutaTemporal = $nuevaFoto["tmp_name"];

                $rutaDestino = "img/" . $nombreFoto;

                // Verificar que sea una imagen válida
                $permitidos = array("image/jpeg", "image/png");
                if (in_array($tipoFoto, $permitidos)) {
                    // Mover la imagen al directorio de destino
                    if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                        // Actualizar la ruta de la foto de perfil en la base de datos
                        $query = "UPDATE usuarios SET foto_perfil='$nombreFoto' WHERE usuario='$usuario'";
                        if (mysqli_query($conn, $query)) {
                            echo "<p class='success'>La foto de perfil se ha actualizado correctamente.</p>";
                        } else {
                            echo "<p class='error'>Error al actualizar la foto de perfil en la base de datos.</p>";
                        }
                    } else {
                        echo "<p class='error'>Error al subir la imagen.</p>";
                    }
                } else {
                    echo "<p class='error'>Formato de imagen no válido. Solo se permiten archivos JPEG y PNG.</p>";
                }

                mysqli_close($conn);
            }
        } else {
            echo "<p class='error'>Usuario no especificado</p>";
        }
        ?>
<<<<<<< HEAD:cambiarFoto.php
        <form action="cambiarFoto.php?usuario=<?php echo urlencode($usuario); ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="nuevaFoto" required accept="image/*">
            <input type="submit" value="Subir Foto">
        </form>
        <div class="back-btn">
            <a href="mainOrg.php?usuario=<?php echo urlencode($usuario); ?>">Volver al dasboard Organizador</a>
=======
        
        <div class="back-btn mt-3">
            <a href="mainOrg.php?usuario=<?php echo urlencode($usuario); ?>">Volver al Dashboard</a>
>>>>>>> Publicacion-de-Eventos:ejm.php
        </div>
    </div>
    <!-- Agrega el script de Bootstrap si es necesario -->
</body>

</html>
