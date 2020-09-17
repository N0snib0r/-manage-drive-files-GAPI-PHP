
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Mis estilos -->
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/estilos.css">


<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a href="<?php echo constant('URL'); ?>main" class="nav-link">Inicio</a></li>

                <li class="nav-item">
                    <a href="<?php echo constant('URL'); ?>drive" class="nav-link">Drive</a>
                </li>

                <li class="nav-item"><a href="<?php echo constant('URL'); ?>ayuda" class="nav-link">Ayuda</a></li>
                <li class="nav-item"><a href="<?php echo constant('URL'); ?>#" class="nav-link">Cerrar Sesion</a></li>
            </ul>
        </div>
    </div>
</nav>
