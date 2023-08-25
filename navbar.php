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
                        <a class="dropdown-item" href="editarPer.php?usuario=<?php echo urlencode($usuario); ?>">Editar
                            Perfil</a>
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