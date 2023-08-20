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
        }

        .iniciar-sesion {
            text-align: right;
        }

        .filter-options {
            background-color: #f4f4f4;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="iniciar-sesion">
            <a href="login.html" class="btn btn-primary">Iniciar Sesión</a>
        </div>

        <div class="filter-options">
            <label for="city">Ciudad:</label>
            <select id="city" onchange="applyFilters();">
                <option value="">Todas las Ciudades</option>
                <option value="Ambato">Ambato</option>
                <option value="Quito">Quito</option>
                <option value="Latacunga">Latacunga</option>
            </select>

            <label for="category">Categoría:</label>
            <select id="category" onchange="applyFilters();">
                <option value="">Todas las Categorías</option>
                <option value="musica">Música</option>
                <option value="danza">Danza</option>
                <option value="emprendimiento">Emprendimiento</option>
                <option value="teatro">Teatro</option>
                <option value="educacion">Educación</option>
                <option value="deporte">Deporte</option>
            </select>

            <label for="search">Búsqueda:</label>
            <input type="text" id="search" name="search" placeholder="¿Qué deseas buscar...">
            <button onclick="buscarEventos()">Buscar</button>
            <button onclick="restablecerFiltros()">Restablecer Filtros</button>
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

            // Apply filters if set
            if (isset($_GET['city']) && $_GET['city'] !== '') {
                $cityFilter = $_GET['city'];
                $query .= " AND ciudad = '$cityFilter'";
            }

            if (isset($_GET['category']) && $_GET['category'] !== '') {
                $categoryFilter = $_GET['category'];
                $query .= " AND categoria = '$categoryFilter'";
            }

            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $searchKeywords = $_GET['search'];
                $query .= " AND (titulo LIKE '%$searchKeywords%' OR descripcion LIKE '%$searchKeywords%' OR lugar LIKE '%$searchKeywords%')";
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

        // Funciones de JavaScript desde mainOrg.php
        function applyFilters() {
            var citySelect = document.getElementById("city");
            var selectedCity = citySelect.options[citySelect.selectedIndex].value;

            var categorySelect = document.getElementById("category");
            var selectedCategory = categorySelect.options[categorySelect.selectedIndex].value;

            var url = window.location.href.split("?")[0];

            var queryParams = [];
            if (selectedCity !== "") {
                queryParams.push("city=" + encodeURIComponent(selectedCity));
            }
            if (selectedCategory !== "") {
                queryParams.push("category=" + encodeURIComponent(selectedCategory));
            }

            var finalUrl = url;
            if (queryParams.length > 0) {
                finalUrl += "?" + queryParams.join("&");
            }

            window.location.href = finalUrl;
        }

        function buscarEventos() {
            var inputBusqueda = document.getElementById("search");
            var palabrasClave = inputBusqueda.value.trim();

            var url = window.location.href.split("?")[0];

            var finalUrl = url;
            if (palabrasClave !== "") {
                finalUrl += "?search=" + encodeURIComponent(palabrasClave);
            }

            window.location.href = finalUrl;
        }

        function restablecerFiltros() {
            var url = window.location.href.split("?")[0];
            window.location.href = url;
        }

        function verDetalles(eventoId) {
            // Abre una nueva ventana o pestaña con el archivo verEvento.php y el ID del evento
            window.open('verEvento.php?id=' + eventoId, '_blank');
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com
