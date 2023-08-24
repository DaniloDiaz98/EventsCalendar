<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 20px;
        }
        .evento-card {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ccc;
        }
        .evento-thumbnail {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Panel de Administrador</h1>
            <a href="login.html" class="btn btn-danger">Salir</a>
        </div>
        
        <?php
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "eventscalendar";

        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        if (isset($_POST['aprobar'])) {
            $idEvento = $_POST['aprobar'];
            $updateQuery = "UPDATE eventos SET status = 2 WHERE id_eve = $idEvento";
            mysqli_query($conn, $updateQuery);
        }

        if (isset($_POST['eliminar'])) {
            $idEventoEliminar = $_POST['eliminar'];
            $deleteQuery = "DELETE FROM eventos WHERE id_eve = $idEventoEliminar";
            mysqli_query($conn, $deleteQuery);
        }

        function obtenerNombreCreador($conn, $idOrg) {
            // Aquí realizas la consulta a la base de datos para obtener el nombre del creador
            // Supongamos que tienes una tabla llamada 'usuarios' con columnas 'id' y 'nombre'
            
            $query = "SELECT nombre FROM usuarios WHERE id = $idOrg";
            $result = mysqli_query($conn, $query);
            
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                return $row['nombre'];
            }
            
            return "Nombre de Creador Desconocido"; // O algún otro valor predeterminado
        }

        $query = "SELECT * FROM eventos WHERE status = 1";
        $result = mysqli_query($conn, $query);

        while ($evento = mysqli_fetch_assoc($result)) {
            echo '<div class="evento-card">';
            echo '<h2>' . $evento['titulo'] . '</h2>';
            echo '<p><strong>Categoría:</strong> ' . $evento['categoria'] . '</p>';
            echo '<p><strong>Fecha:</strong> ' . $evento['fecha'] . '</p>';
            echo '<p><strong>Ciudad:</strong> ' . $evento['ciudad'] . '</p>';
            echo '<p><strong>Lugar:</strong> ' . $evento['lugar'] . '</p>';
            echo '<p><strong>Descripción:</strong> ' . $evento['descripcion'] . '</p>';
            echo '<p><strong>Creado por:</strong> ' . obtenerNombreCreador($conn, $evento['id_org']) . '</p>';
            echo '<img src="' . $evento['imagen1'] . '" alt="Imagen 1" class="evento-thumbnail">';
            echo '<img src="' . $evento['imagen2'] . '" alt="Imagen 2" class="evento-thumbnail">';
            

            echo '<form method="post">';
            echo '<input type="hidden" name="aprobar" value="' . $evento['id_eve'] . '">';
            echo '<div class="mt-3">';
            echo '<button type="submit" class="btn btn-success mr-2">Aprobar</button>';
            echo '</div>';
            echo '</form>';
            
            echo '<form method="post">';
            echo '<input type="hidden" name="eliminar" value="' . $evento['id_eve'] . '">';
            echo '<div class="mt-3">';
            echo '<button type="submit" class="btn btn-danger mr-2">Eliminar</button>';
            echo '</div>';
            echo '</form>';
            
            echo '</div>';
        }

        mysqli_close($conn);
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>