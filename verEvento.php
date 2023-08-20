<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Evento</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin: 20px;
        }
        .evento-thumbnail {
            max-width: 100%;
            max-height: 300px;
            object-fit: cover;
        }
    </style>
</head>
<body>
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
                echo '<h2>' . $evento['titulo'] . '</h2>';
                echo '<img src="' . $evento['imagen1'] . '" alt="Imagen 1" class="evento-thumbnail">';
                echo '<p><strong>Fecha:</strong> ' . $evento['fecha'] . '</p>';
                echo '<p><strong>Lugar:</strong> ' . $evento['lugar'] . '</p>';
                echo '<p>' . $evento['descripcion'] . '</p>';
                echo '<img src="' . $evento['imagen2'] . '" alt="Imagen 2" class="evento-thumbnail">';
            } else {
                echo '<p>Evento no encontrado.</p>';
            }
        } else {
            echo '<p>ID de evento no especificado.</p>';
        }

        mysqli_close($conn);
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
