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
        <div class="row">
            <div class="col-md-3">
                <div class="filter-options">
                    <h2>Filter Events</h2>
                    <label for="city">City:</label>
                    <select id="city" onchange="applyFilters();">
                        <option value="">All Cities</option>
                        <option value="Ambato">Ambato</option>
                        <option value="Quito">Quito</option>
                        <option value="Latacunga">Latacunga</option>
                    </select>
                    <label for="category">Category:</label>
                    <select id="category" onchange="applyFilters();">
                        <option value="">All Categories</option>
                        <option value="musica">Musica</option>
                        <option value="danza">Danza</option>
                        <option value="emprendimiento">Emprendimiento</option>
                        <option value="teatro">Teatro</option>
                        <option value="educacion">Educacion</option>
                        <option value="deporte">Deporte</option>
                    </select>
                </div>
            </div>
            <div class="col-md-9">
                <?php
                $dbhost = "localhost";
                $dbuser = "root";
                $dbpass = "";
                $dbname = "eventscalendar";

                $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

<<<<<<< HEAD
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
                if (file_exists($rutaFotoPerfil)) {
                    echo "<div class='profile'>";
                    echo "<h1>Organizador</h1>";
                    echo "<a href='cambiarFoto.php?usuario=" . urlencode($usuario) . "'>";
                    echo "<img src='$rutaFotoPerfil' alt='Foto de Perfil del Organizador' width='100' height='100'>";
                    echo "</a>";
                    echo "<p><strong>Nombre:</strong> " . $filas['nombre'] . "</p>";
                    // Puedes agregar más información sobre el organizador aquí
                    echo "</div>";
                } else {
                    echo "<p class='error'>Foto de perfil no encontrada</p>";
=======
                if (!$conn) {
                    echo ("<p class='error'>No hay conexión a la BD " . mysqli_connect_error() . "</p>");
>>>>>>> Publicacion-de-Eventos
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

                        // Mostrar perfil del organizador
                        if (file_exists($rutaFotoPerfil)) {
                            echo "<div class='row mt-3'>";
                            echo "<div class='col-md-8 offset-md-4'>";
                            echo "<div class='profile'>";
                            echo "<h1>Organizador</h1>";
                            echo "<div class='d-flex align-items-start'>";
                            echo "<img src='$rutaFotoPerfil' alt='Foto de Perfil del Organizador' width='100' height='100'>";
                            echo "<div class='dropdown-menu ml-2'>";
                            echo "<div class='menu-item'>";
                            echo "<a href='editarPer.php?usuario=" . urlencode($usuario) . "'>Editar Perfil</a>";
                            echo "</div>";
                            echo "<div class='menu-item'>";
                            echo "<a href='generarEvento.php?usuario=" . urlencode($usuario) . "&organizadorId=" . $organizadorIdEncoded . "'>Generar Evento</a>";
                            echo "</div>";
                            echo "<div class='menu-item'>";
                            echo "<a href='login.html'>Salir</a>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "<p><strong>Nombre:</strong> " . $filas['nombre'] . "</p>";
                            echo "<p><strong>ID:</strong>" . $filas['id'] . "</p>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        } else {
                            echo "<p class='error'>Foto de perfil no encontrada</p>";
                        }

                        // Mostrar eventos aprobados
                        echo "<div class='eventos-row'>";

                        // Selector de orden
                        echo "<div>";
                        echo "<label for='orden'>Ordenar por:</label>";
                        echo "<select id='orden' onchange='cambiarOrden();'>";
                        echo "<option value='titulo' " . ($_GET['orden'] === 'titulo' ? 'selected' : '') . ">Título</option>";
                        echo "<option value='fecha' " . ($_GET['orden'] === 'fecha' ? 'selected' : '') . ">Fecha</option>";
                        echo "</select>";
                        echo "</div>";

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

                        $queryEventos .= " ORDER BY " . $orden;
                        $resultEventos = mysqli_query($conn, $queryEventos);
                        //echo "Consulta SQL: $queryEventos<br>";
                        while ($evento = mysqli_fetch_assoc($resultEventos)) {
                            echo '<div class="evento-card">';
                            echo '<h2>' . $evento['titulo'] . '</h2>';
                            echo '<img src="' . $evento['imagen1'] . '" alt="Imagen 1" class="evento-thumbnail">';
                            echo '<p><strong>Fecha:</strong> ' . $evento['fecha'] . '</p>';
                            echo '<p><strong>Lugar:</strong> ' . $evento['lugar'] . '</p>';
                            echo '<a href="javascript:void(0);" onclick="verDetalles(' . $evento['id_eve'] . ');">Ver más</a>'; // Cambio en el enlace
                            echo '</div>';
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
            </script>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>