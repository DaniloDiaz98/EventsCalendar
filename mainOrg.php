<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard 1</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            z-index: 1000;
            top: 100%;
            right: 0;
            width: 200px;
        }

        .profile {
            position: relative;
            cursor: pointer;
            text-align: right;
            padding-top: 10px;
            display: inline-block;
            float: right;
            /* Añadido para alinear a la derecha */
        }

        .profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .profile:hover .dropdown-menu {
            display: block;
        }

        .menu-item {
            margin-bottom: 10px;
        }

        .container {
            margin-top: 20px;
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
    </style>
</head>

<body>
    <?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "eventscalendar";

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$conn) {
        echo ("<p class='error'>No hay conexión a la BD " . mysqli_connect_error() . "</p>");
    }

    if (isset($_GET["usuario"])) {
        $usuario = $_GET["usuario"];

        $query = "SELECT * FROM usuarios WHERE usuario='$usuario'";
        $ejecutar = mysqli_query($conn, $query);
        $filas = mysqli_fetch_array($ejecutar);

        if ($filas && $filas['id_cargo'] == 2) {
            $rutaFotoPerfil = "img/" . $filas['foto_perfil'];
            $organizadorId = $filas['id'];
            $organizadorIdEncoded = urlencode($organizadorId);

            // Aquí comienza el nuevo código del navbar
            ?>
            <nav class="navbar navbar-expand-lg navbar-light bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#" style="color: white;">Calendario de Eventos - Organizador de Eventos</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo $rutaFotoPerfil; ?>" alt="Foto de Perfil del Organizador" width="80"
                                        height="80" class="rounded-circle profile-img"> <!-- Agregado class="profile-img" -->
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item"
                                        href="editarPer.php?usuario=<?php echo urlencode($usuario); ?>">Editar Perfil</a>
                                    <a class="dropdown-item"
                                        href="generarEvento.php?usuario=<?php echo urlencode($usuario); ?>&organizadorId=<?php echo $organizadorIdEncoded; ?>">Generar
                                        Evento</a>
                                    <a class="dropdown-item" href="login.html">Salir</a>
                                </div>
                            </li>
                        </ul>
                    </div>
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

                            <div class="form-group">
                                <label for="search">Búsqueda:</label>
                                <input type="text" id="search" class="form-control" name="search"
                                    placeholder="Qué deseas buscar...">
                            </div>

                            <div>
                                <button class="btn btn-primary mr-2" onclick="buscarEventos()">Buscar</button>
                                <button class="btn btn-secondary" onclick="restablecerFiltros()">Restablecer Filtros</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php

            $queryEventos = "SELECT * FROM eventos WHERE status = 2";


            // Apply filters if set
            if (isset($_GET['city']) && $_GET['city'] !== '') {
                $cityFilter = $_GET['city'];
                //echo "Valor de la ciudad: $cityFilter<br>";
                $queryEventos .= " AND ciudad = '$cityFilter'";
            }


            if (isset($_GET['category']) && $_GET['category'] !== '') {
                $categoryFilter = $_GET['category'];
                $queryEventos .= " AND categoria = '$categoryFilter'";
            }

            $orden = "titulo"; // Order by default (title)
            if (isset($_GET['orden'])) {
                if ($_GET['orden'] === 'fecha') {
                    $orden = "fecha";
                }
            }

            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $palabrasClave = $_GET['search'];
                $queryEventos .= " AND (titulo LIKE '%$searchKeywords%' OR descripcion LIKE '%$searchKeywords%' OR lugar LIKE '%$searchKeywords%')";

            }

            $queryEventos .= " ORDER BY " . $orden;
            $resultEventos = mysqli_query($conn, $queryEventos);
            //echo "Consulta SQL: $queryEventos<br>";
            // Mostrar eventos aprobados
            echo "<div class='eventos-row'>";
            while ($evento = mysqli_fetch_assoc($resultEventos)) {

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
            echo "</div>"; // Fin de eventos-row
        } else {
            echo "<p class='error'>Acceso no autorizado</p>";
        }
    } else {
        echo "<p class='error'>Usuario no especificado</p>";
    }

    mysqli_close($conn);
    ?>
    <?php include 'footer.php'; ?>
    </div>


    <script>
        function cambiarOrden() {
            var select = document.getElementById("orden");
            var ordenSeleccionado = select.options[select.selectedIndex].value;
            var url = window.location.href.split("?")[0];
            var usuario = "<?php echo urlencode($usuario); ?>"; // Obtener el valor del usuario desde PHP
            window.location.href = url + "?usuario=" + usuario + "&orden=" + ordenSeleccionado;
        }

        function verDetalles(eventoId) {
            // Abre una nueva ventana o pestaña con el archivo verEvento.php y el ID del evento
            window.open('verEvento.php?id=' + eventoId, '_blank');
        }
        function applyFilters() {
            var citySelect = document.getElementById("city");
            var selectedCity = citySelect.options[citySelect.selectedIndex].value;

            var categorySelect = document.getElementById("category");
            var selectedCategory = categorySelect.options[categorySelect.selectedIndex].value;

            var url = window.location.href.split("?")[0];
            var usuario = "<?php echo urlencode($usuario); ?>";

            var queryParams = [];
            if (selectedCity !== "") {
                queryParams.push("city=" + encodeURIComponent(selectedCity));
            }
            if (selectedCategory !== "") {
                queryParams.push("category=" + encodeURIComponent(selectedCategory));
            }

            var finalUrl = url + "?usuario=" + usuario;
            if (queryParams.length > 0) {
                finalUrl += "&" + queryParams.join("&");
            }

            window.location.href = finalUrl;
        }
        function buscarEventos() {
            var inputBusqueda = document.getElementById("search");
            var palabrasClave = inputBusqueda.value.trim();

            var url = window.location.href.split("?")[0];
            var usuario = "<?php echo urlencode($usuario); ?>";

            var finalUrl = url + "?usuario=" + usuario + "&search=" + encodeURIComponent(palabrasClave);

            window.location.href = finalUrl;
        }
        function restablecerFiltros() {
            var url = window.location.href.split("?")[0];
            var usuario = "<?php echo urlencode($usuario); ?>";

            var finalUrl = url + "?usuario=" + usuario;

            window.location.href = finalUrl;
        }

    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>