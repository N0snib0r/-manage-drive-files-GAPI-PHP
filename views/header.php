
<!-- <div id="header">
    <ul>
        <li><a href="<?php //echo constant('URL'); ?>main">Inicio</a></li>
        <li><a href="<?php //echo constant('URL'); ?>drive">Drive</a></li>
        <li><a href="<?php //echo constant('URL'); ?>nuevo">Nuevo</a></li>
        <li><a href="<?php //echo constant('URL'); ?>consulta">Consulta</a></li>
        <li><a href="<?php //echo constant('URL'); ?>ayuda">Ayuda</a></li>
    </ul>
</div> -->

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

                <!-- <li class="nav-item-dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Drive
                    </a>
                    <div class="dropdown-menu ml-5" aria-labelledby="navbarDropdown">
                        <a href="<?php //echo constant('URL'); ?>drive" class="dropdown-item">Mi drive</a>

                        <div class="dropdown-divider"></div>

                        <a href="<?php //echo constant('URL'); ?>listFiles" class="dropdown-item">Listar Archivos</a>
                        <a href="<?php //echo constant('URL'); ?>main" class="dropdown-item">Subir Archivo</a>
                        <a href="<?php //echo constant('URL'); ?>main" class="dropdown-item">Crear Carpeta</a>
                    </div>
                </li> -->

                <!-- <li>
                    <a class="nav-link" href="#">Boton</a>
                <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a class="dropdown-item" href="#">Dropdown link</a>
                    <a class="dropdown-item" href="#">Dropdown link</a>
                    </div>
                </div>
                </li> -->

                <li class="nav-item"><a href="<?php echo constant('URL'); ?>ayuda" class="nav-link">Ayuda</a></li>
                <li class="nav-item"><a href="<?php echo constant('URL'); ?>#" class="nav-link">Cerrar Sesion</a></li>
            </ul>
        </div>
    </div>
</nav>
