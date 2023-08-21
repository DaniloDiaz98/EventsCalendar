<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Recuperar Contraseña</title>
</head>
<body>
    <div class="registro">
        <form action="reset_password.php" method="POST" class="form" id="form">
            <h1 class="title">Recuperar Contraseña</h1>
            <div class="inputContainer">
                <input type="email" class="input" placeholder="Correo electrónico" name="email" required>
                <label class="label">Correo Electrónico</label>
            </div>
            <button type="submit" class="btn" name="recuperar">Recuperar Contraseña</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
