<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Evento</title>
    <!-- Agrega el enlace a Bootstrap CDN aquí -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Agrega el SDK de Firebase aquí -->
    <script type="module">
        // Importa las funciones que necesitas del SDK de Firebase
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-app.js";
        import { getStorage, ref, uploadBytes, getDownloadURL } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-storage.js";

        // Configuración de Firebase
        const firebaseConfig = {
            apiKey: "AIzaSyCNOhzbe1R2Wer8C9PKlBldytakp5V8E8A",
            authDomain: "eventcalendar-7e0dc.firebaseapp.com",
            projectId: "eventcalendar-7e0dc",
            storageBucket: "eventcalendar-7e0dc.appspot.com",
            messagingSenderId: "551152349100",
            appId: "1:551152349100:web:02baacf5e8cf3bf6c75409",
            measurementId: "G-1X1F498FZQ"
        };

        // Inicializa Firebase
        const app = initializeApp(firebaseConfig);
        const storage = getStorage(app);

        // Función para cargar una imagen en Firebase Storage y obtener su URL
        async function uploadImage(file) {
            const storageRef = ref(storage, 'images/' + file.name);
            await uploadBytes(storageRef, file);
            const downloadURL = await getDownloadURL(storageRef);
            return downloadURL;
        }
    </script>
    <!-- Agrega estilos CSS personalizados aquí -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        form label {
            font-weight: bold;
        }
       
    </style>

</head>

<body>

    <div class="container">

        <h1 class="mt-5">Generar Evento</h1>
        <form action="procesarEvento.php" method="post" enctype="multipart/form-data" class="mt-4">

            <?php

            if (isset($_GET["organizadorId"])) {
                $usuario = $_GET["usuario"];
                $organizadorId = $_GET["organizadorId"];
                echo "<input type='hidden' name='id_organizador' value='$organizadorId'>";
                echo "<input type='hidden' name='usuario' value='$usuario'>";

            }
            ?>
            <div class="mb-3">
                <label for="titulo" class="form-label">Título del Evento:</label>
                <input type="text" id="titulo" name="titulo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="ciudad" class="form-label">Ciudad:</label>
                <select id="ciudad" name="ciudad" class="form-select" required>
                    <option value="Latacunga">Latacunga </option>
                    <option value="Quito">Quito</option>
                    <option value="Ambato">Ambato</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="lugar" class="form-label">Lugar:</label>
                <input type="text" id="lugar" name="lugar" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría:</label>
                <select id="categoria" name="categoria" class="form-select" required>
                    <option value="musica">Música</option>
                    <option value="danza">Danza</option>
                    <option value="emprendimiento">Emprendimiento</option>
                    <option value="teatro">Teatro</option>
                    <option value="educacion">Educación</option>
                    <option value="deporte">Deporte</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="imagen1" class="form-label">Imagen 1:</label>
                <input type="file" id="imagen1" name="imagen1" accept="image/*" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="imagen2" class="form-label">Imagen 2:</label>
                <input type="file" id="imagen2" name="imagen2" accept="image/*" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Evento</button>
            <a href="mainOrg.php?usuario=<?php echo urlencode($usuario); ?>">Volver al Dashboard</a>

        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>