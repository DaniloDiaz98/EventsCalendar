<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Aprobados</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 20px;
        }

        .evento-card {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }

        .evento-thumbnail {
            max-width: 239px;
            max-height: 135px;
            object-fit: cover;
        }

        .eventos-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 20px;
            /* Añadido para espacio entre botón y eventos */
        }

        .iniciar-sesion {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="iniciar-sesion">
            <a href="login.html" class="btn btn-primary">Iniciar Sesión</a>
        </div>

        <div>
            <label for="orden">Ordenar por:</label>
            <select id="orden" onchange="cambiarOrden();">
                <option value="titulo">Título</option>
                <option value="fecha">Fecha</option>
            </select>
        </div>

        <div class="eventos-row">
            <?php
            $dbhost = "localhost";
            $dbuser = "root";
            $dbpass = "";
            $dbname = "eventscalendar";

            $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

            if (!$conn) {
                die("Error de conexión: " . mysqli_connect_error());
            }

            $query = "SELECT * FROM eventos WHERE status = 2";

            $orden = "titulo"; // Orden por defecto (título)
            if (isset($_GET['orden'])) {
                if ($_GET['orden'] === 'fecha') {
                    $orden = "fecha";
                }
            }

            $query .= " ORDER BY " . $orden;
            $result = mysqli_query($conn, $query);

            while ($evento = mysqli_fetch_assoc($result)) {
                echo '<div class="evento-card">';
                echo '<h2>' . $evento['titulo'] . '</h2>';
                echo '<img src="' . $evento['imagen1'] . '" alt="Imagen 1" class="evento-thumbnail">';
                echo '<p><strong>Fecha:</strong> ' . $evento['fecha'] . '</p>';
                echo '<p><strong>Lugar:</strong> ' . $evento['lugar'] . '</p>';
                echo '<a href="javascript:void(0);" onclick="verDetalles(' . $evento['id_eve'] . ');">Ver más</a>';
                echo '</div>';
            }

            mysqli_close($conn);
            ?>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Restaurar el valor seleccionado en el selector de ordenamiento
            var urlParams = new URLSearchParams(window.location.search);
            var ordenParam = urlParams.get("orden");
            if (ordenParam) {
                var select = document.getElementById("orden");
                select.value = ordenParam;
            }
        });

        function cambiarOrden() {
            var select = document.getElementById("orden");
            var ordenSeleccionado = select.options[select.selectedIndex].value;
            var url = window.location.href.split("?")[0];
            window.location.href = url + "?orden=" + ordenSeleccionado;
        }

        function verDetalles(eventoId) {
            window.open('verEvento.php?id=' + eventoId, '_blank');
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>