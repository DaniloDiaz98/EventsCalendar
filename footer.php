<style>
    body {
        margin: 0;
        padding: 0;
        height: 100%;
    }

    .content {
        /* Agrega un margen inferior para dejar espacio para el footer */
        margin-bottom: 54px;
        /* La misma altura que el footer */
    }

    .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 54px;
        background-color: #007bff;
        color: white;
        text-align: center;
        padding: 15px 0;
        /* Cambia al color de fondo y color de texto deseado */
        display: none;
        /* Inicialmente ocultar el footer */
    }
</style>

<body>
    <div class="content">
        <!-- Aquí va el contenido de tu página -->
    </div>
    <footer class="footer" id="site-footer">
        <p>&copy; Derechos Reservados DD</p>
    </footer>

    <script>
        // Mostrar el footer cuando se haya desplazado al final del contenido
        function toggleFooterDisplay() {
            var footer = document.getElementById('site-footer');
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                footer.style.display = 'block';
            } else {
                footer.style.display = 'none';
            }
        }

        window.addEventListener('scroll', toggleFooterDisplay);
        window.addEventListener('resize', toggleFooterDisplay);
        // Llama a la función en carga inicial también
        toggleFooterDisplay();
    </script>
</body>