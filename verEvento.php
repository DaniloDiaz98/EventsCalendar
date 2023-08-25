<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Evento</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="img/logo.ico">
    <style>
        body {
            background-color: #dfeffb;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .evento-details {
            display: flex;
            justify-content: space-between;
        }

        .evento-info {
            flex: 1;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-right: 20px;
        }

        .evento-imagenes {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .evento-title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .evento-categoria {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .evento-info strong {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .evento-descripcion {
            font-size: 16px;
            line-height: 1.6;
        }

        .evento-thumbnail {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <nav style="height: 92px" class="navbar navbar-expand-lg navbar-light bg-primary">
        <a class="navbar-brand" style="color: white">Events Calendar</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="login.html" class="btn btn-light ml-2">Iniciar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?php
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "eventscalendar";

        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        if (isset($_GET['id'])) {
            $eventoId = $_GET['id'];

            $query = "SELECT * FROM eventos WHERE id_eve = $eventoId";
            $result = mysqli_query($conn, $query);
            $evento = mysqli_fetch_assoc($result);

            if ($evento) {
                echo '<h1 class="evento-title">' . $evento['titulo'] . '</h1>';
                echo '<div class="evento-details">';

                // Div para información del evento
                echo '<div class="evento-info">';
                echo '<p class="evento-categoria"><strong>Categoría:</strong>' . $evento['categoria'] . '</p>';
                echo '<p><strong>Fecha:</strong> ' . $evento['fecha'] . '</p>';
                echo '<p><strong>Ciudad:</strong> ' . $evento['ciudad'] . '</p>';
                echo '<p><strong>Lugar:</strong> ' . $evento['lugar'] . '</p>';
                echo '<p class="evento-descripcion"><strong>Descripción:</strong>' . $evento['descripcion'] . '</p>';
                echo '</div>';

                // Div para imágenes del evento (a la derecha)
                echo '<div class="evento-imagenes">';
                echo '<img src="' . $evento['imagen1'] . '" alt="Imagen 1" class="evento-thumbnail">';
                echo '<img src="' . $evento['imagen2'] . '" alt="Imagen 2" class="evento-thumbnail">';
                echo '</div>';

                echo '</div>';
                // Obtener y mostrar los comentarios del evento
                if ($evento) {
                    $queryComentarios = "SELECT c.*, u.nombre, u.foto_perfil FROM comentario c
                             INNER JOIN usuarios u ON c.id_or = u.id
                             WHERE c.id_eve = $eventoId";
                    $resultComentarios = mysqli_query($conn, $queryComentarios);

                    if ($resultComentarios && mysqli_num_rows($resultComentarios) > 0) {
                        echo '<div class="container mt-5">';
                        echo '<h2 class="mb-4">Comentarios</h2>';

                        while ($comentario = mysqli_fetch_assoc($resultComentarios)) {
                            echo '<div class="card mb-3 shadow-sm" style="border-radius: 20px;">'; // Ajusta el valor de border-radius según tu preferencia
                            echo '<div class="card-body d-flex align-items-start">';
                            echo '<img src="' . $comentario['foto_perfil'] . '" alt="Foto de Perfil" width="60" height="60" class="rounded-circle mr-3">';
                            echo '<div>';
                            echo '<h5 class="card-title font-weight-bold mb-1">' . $comentario['nombre'] . '</h5>';
                            echo '<p class="card-text">' . $comentario['comentario'] . '</p>';
                            echo '<p class="card-text text-muted">' . $comentario['fecha'] . '</p>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }

                        echo '</div>';                        
                    }
                } else {
                    echo '<p>Evento no encontrado.</p>';
                }
            } else {
                echo '<p>ID de evento no especificado.</p>';
            }
        }
        mysqli_close($conn);
        ?>
        <?php include 'footer.php'; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>