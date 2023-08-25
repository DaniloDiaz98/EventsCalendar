<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #dfeffb;
        }

        .container {

            width: 5000px;

        }


        /* Estilos para la tabla */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            background-color: white;

        }

        td {
            width: 500px;
        }

        th,
        td {
            padding: 10px;
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
        button{
            margin: 10px;
        }
        

        /* .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        } */
    </style>
</head>

<body>
    <nav style="height: 92px" class="navbar navbar-expand-lg navbar-light bg-primary">

        <a class="navbar-brand" style="color: white">Events Calendar - Administrador</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href=" eventPub.php" class="btn btn-light ml-2">Eventos Publicados</a>
                </li>
                <li class="nav-item">
                    <a href="login.html" class="btn btn-light ml-2">Salir</a>
                </li>
            </ul>
        </div>

    </nav>
    
    <h1 align="center">Eventos a Revizar</h1>

    <div class="container">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Imágenes</th>
                        <th>Categoría</th>
                        <th>Fecha</th>
                        <th>Ciudad</th>
                        <th>Lugar</th>
                        <th>Descripción</th>
                        <th>Creador</th>
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

                    $query = "SELECT * FROM eventos WHERE status = 1";
                    $result = mysqli_query($conn, $query);

                    while ($evento = mysqli_fetch_assoc($result)) {



                        ?>
                        <tr>
                            <td>
                                <?php echo $evento['titulo']; ?>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <div class="mr-2">
                                        <img src="<?php echo $evento['imagen1']; ?>" alt="Imagen 1"
                                            class="evento-thumbnail">
                                    </div>
                                    <div>
                                        <img src="<?php echo $evento['imagen2']; ?>" alt="Imagen 2"
                                            class="evento-thumbnail">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php echo $evento['categoria']; ?>
                            </td>
                            <td>
                                <?php echo $evento['fecha']; ?>
                            </td>
                            <td>
                                <?php echo $evento['ciudad']; ?>
                            </td>
                            <td>
                                <?php echo $evento['lugar']; ?>
                            </td>
                            <td>
                                <?php echo $evento['descripcion']; ?>
                            </td>
                            <td>
                                <?php echo obtenerNombreCreador($conn, $evento['id_org']); ?>
                            </td>
                            <td class="action-buttons">
                                <form method="post">
                                    <input type="hidden" name="aprobar" value="<?php echo $evento['id_eve']; ?>">
                                    <button type="submit" class="btn btn-success">Aprobar</button>
                                </form>
                                <form method="post">
                                    <input type="hidden" name="eliminar" value="<?php echo $evento['id_eve']; ?>">
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <?php

                    }

                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include 'footer.php'; ?>
</body>

</html>