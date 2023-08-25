<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Evento</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="img/logo.ico">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            $rutaFotoPerfil = $filas['foto_perfil'];
            $organizadorId = $filas['id'];
            $organizadorIdEncoded = urlencode($organizadorId);

            // Aquí comienza el nuevo código del navbar
            ?>
            <nav class="navbar navbar-expand-lg navbar-light bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" style="color: white;">Events Calendar - Organizador </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo $rutaFotoPerfil; ?>" alt="Foto de Perfil del Organizador" width="60"
                                        height="60" class="rounded-circle profile-img"> <!-- Agregado class="profile-img" -->
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item"
                                        href="editarPer.php?usuario=<?php echo urlencode($usuario); ?>">Editar Perfil</a>
                                    <a class="dropdown-item"
                                        href="generarEvento.php?usuario=<?php echo urlencode($usuario); ?>&organizadorId=<?php echo $organizadorIdEncoded; ?>">Generar
                                        Evento</a>
                                    <a class="dropdown-item" href="login.html?logout=true">Salir</a>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>


            <div class="container">
                <?php

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
                    } else {
                        echo '<p>Evento no encontrado.</p>';
                    }
                } else {
                    echo '<p>ID de evento no especificado.</p>';
                }
        } else {
            echo "<p class='error'>Acceso no autorizado</p>";
        }
    } else {
        echo "<p class='error'>Usuario no especificado</p>";
    }

    // Obtener y mostrar los comentarios del evento
    if ($evento) {
        $queryComentarios = "SELECT c.*, u.nombre, u.foto_perfil FROM comentario c
                             INNER JOIN usuarios u ON c.id_or = u.id
                             WHERE c.id_eve = $eventoId";
        $resultComentarios = mysqli_query($conn, $queryComentarios);

        if ($resultComentarios && mysqli_num_rows($resultComentarios) > 0) {
            echo '<div class="mt-5">';
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


        // Agregamos el formulario para escribir un comentario
    
        echo '<div class="mt-5">';
        echo '<h2 class="mb-4">Escribe un comentario</h2>';
        echo '<form method="post" action="" class="mb-4">';
        echo '<input type="hidden" name="evento_id" value="' . $eventoId . '">';
        echo '<input type="hidden" name="usuario_id" value="' . $organizadorId . '">'; // Cambiar por el ID del usuario actual
        echo '<div class="form-group">';
        echo '<textarea name="comentario" rows="4" class="form-control" placeholder="Escribe tu comentario aquí"></textarea>';
        echo '</div>';
        echo '<button type="submit" name="submit_comment" class="btn btn-primary">Enviar comentario</button>';
        echo '</form>';
        echo '<br>';
        // Procesar el envío del formulario y almacenar el comentario
        if (isset($_POST['submit_comment'])) {
            $comentario = $_POST["comentario"];
            $fecha = date("Y-m-d H:i:s");

            $query = "INSERT INTO comentario (id_eve, id_or, comentario, fecha) VALUES ('$eventoId', '$organizadorId', '$comentario', '$fecha')";

            if (mysqli_query($conn, $query)) {
                echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Comentario Enviado!!",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    </script>';
            } else {
                echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Error al almacenar el comentario",
                            text: "' . mysqli_error($conn) . '"
                        });
                    </script>';
            }
        }

        echo '</div>'; // Cierre del div del formulario
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