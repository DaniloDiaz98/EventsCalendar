<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Aprobados</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{
            background-color: #dfeffb;
        }
        .evento-card {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 10px;
            background-color: #fff;
            transition: transform 0.3s ease;
            width: calc(15% - 40px);
            margin: 20px;
            /* Margen añadido */
            box-sizing: border-box;
        }


        .evento-thumbnail-container {
            width: 100%;
            height: 150px;
            /* Alto fijo */
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .evento-thumbnail {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .evento-card:hover {
            transform: translateY(-5px);
        }


        .eventos-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 20px;
            padding: 0 20px;
            /* Agrega un espacio uniforme a los lados */
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 15px 0;
            background-color: #007bff;
            /* Cambia al color de fondo deseado */
            text-align: center;
            /* Centrar el contenido horizontalmente */
        }

        .footer p {
            margin: 0;
            /* Eliminar el margen predeterminado del párrafo */
            color: white;
            /* Cambia al color de texto deseado */
        }

        .iniciar-sesion {
            text-align: right;
        }

        /* Estilo para la barra de búsqueda */
        #search {
            border: 1px solid #ccc;
            padding: 8px;
            border-radius: 5px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        /* Cambiar estilo al enfocar la barra de búsqueda */
        #search:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* Estilo para el botón de iniciar sesión */
        .iniciar-sesion a.btn {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 15px;
            transition: background-color 0.3s, transform 0.3s;
        }

        /* Cambiar estilo al pasar el cursor sobre el botón de iniciar sesión */
        .iniciar-sesion a.btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <nav style="height: 92px" class="navbar navbar-expand-lg navbar-light bg-primary">
        <a class="navbar-brand"  style="color: white">Events Calendar</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <input style="height: 40px ; width: 200px;" type="text" id="search" class="form-control mr-sm-2"
                        placeholder="Search">
                </li>
                <li class="nav-item">
                    <button style="height: 40px ; width: 60px;class=" btn btn-light my-2 my-sm-0"
                        onclick="buscarEventos()">Search</button>
                </li>
                <li class="nav-item">
                    <a href="login.html" class="btn btn-light ml-2">Iniciar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="filter-options  p-4 rounded d-flex justify-content-between align-items-center">
                    <div class="form-group">
                        <label for="city">City:</label>
                        <select id="city" class="form-control" onchange="applyFilters();">
                            <option value="">All Cities</option>
                            <option value="Ambato">Ambato</option>
                            <option value="Quito">Quito</option>
                            <option value="Latacunga">Latacunga</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select id="category" class="form-control" onchange="applyFilters();">
                            <option value="">All Categories</option>
                            <option value="musica">Musica</option>
                            <option value="danza">Danza</option>
                            <option value="emprendimiento">Emprendimiento</option>
                            <option value="teatro">Teatro</option>
                            <option value="educacion">Educacion</option>
                            <option value="deporte">Deporte</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="orden">Ordenar por:</label>
                        <select id="orden" class="form-control" onchange="cambiarOrden();">
                            <option value="titulo" <?php echo (isset($_GET['orden']) && $_GET['orden'] === 'titulo' ? 'selected' : ''); ?>>Título</option>
                            <option value="fecha" <?php echo (isset($_GET['orden']) && $_GET['orden'] === 'fecha' ? 'selected' : ''); ?>>Fecha</option>
                        </select>
                    </div>
                    <div>
                        <button class="btn btn-secondary" onclick="restablecerFiltros()">Restablecer
                            Filtros</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="filter-options">
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
        </div> -->

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
            ?>
            <div class="evento-card rounded shadow">
                <h2>
                    <?php echo $evento['titulo']; ?>
                </h2>
                <div class="evento-thumbnail-container">
                    <img src="<?php echo $evento['imagen1']; ?>" alt="Imagen 1" class="evento-thumbnail">
                </div>
                <p><strong>Fecha:</strong>
                    <?php echo $evento['fecha']; ?>
                </p>
                <p><strong>Lugar:</strong>
                    <?php echo $evento['lugar']; ?>
                </p>
                <a href="javascript:void(0);" onclick="verDetalles(<?php echo $evento['id_eve']; ?>);">Ver más</a>
            </div>
            <?php
        }

        mysqli_close($conn);
        ?>
        <?php include 'footer.php'; ?>
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