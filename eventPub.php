<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Publicados</title>
    <link rel="icon" href="img/logo.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Incluye tus enlaces CSS adicionales aquí -->
    <style>
        body {
            background-color: #dfeffb;
        }

        .navbar {
            margin-bottom: 20px;
        }

        .container {
            width: 100%;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);


        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <nav style="height: 92px" class="navbar navbar-expand-lg navbar-light bg-primary">

        <a class="navbar-brand text-white" href="#">Events Calendar - Administrador</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="mainAdm.php" class="btn btn-light ml-2">Eventos a Revisar</a>
                </li>
                <li class="nav-item">
                    <a href="login.html" class="btn btn-light ml-2">Salir</a>
                </li>
            </ul>
        </div>

    </nav>
    <h1 align="center">Eventos Publicados</h1>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>Ciudad</th>
                        <th>Lugar</th>
                        <th>Creador</th>
                        <th>Imagen 1</th>
                        <th>Imagen 2</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $dbhost = "localhost";
                    $dbuser = "root";
                    $dbpass = "";
                    $dbname = "eventscalendar";

                    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

                    if (!$conn) {
                        die("Error de conexión: " . mysqli_connect_error());
                    }
                    if (isset($_POST['eliminar'])) {
                        $idEventoEliminar = $_POST['eliminar'];
                        $deleteQuery = "DELETE FROM eventos WHERE id_eve = $idEventoEliminar";
                        mysqli_query($conn, $deleteQuery);
                    }

                    $query = "SELECT * FROM eventos WHERE status = 2"; // Suponiendo que '2' es el estado para eventos publicados
                    $result = mysqli_query($conn, $query);


                    while ($evento = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $evento['titulo'] . '</td>';
                        echo '<td>' . $evento['descripcion'] . '</td>';
                        echo '<td>' . $evento['fecha'] . '</td>';
                        echo '<td>' . $evento['ciudad'] . '</td>';
                        echo '<td>' . $evento['lugar'] . '</td>';
                        echo '<td>' . obtenerNombreCreador($conn, $evento['id_org']) . '</td>';
                        echo '<td><img src="' . $evento['imagen1'] . '" alt="Imagen 1"></td>';
                        echo '<td><img src="' . $evento['imagen2'] . '" alt="Imagen 2"></td>';
                        echo '<td>';
                        echo '<form method="post">';
                        echo '<input type="hidden" name="eliminar" value="' . $evento['id_eve'] . '">';
                        echo '<button type="submit" class="btn btn-danger">Eliminar</button>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    }

                    mysqli_close($conn);

                    function obtenerNombreCreador($conn, $idOrg)
                    {
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
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Incluye tus enlaces de script adicionales aquí -->
</body>

</html>