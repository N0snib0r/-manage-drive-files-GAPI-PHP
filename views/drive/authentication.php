<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <!-- Bootstrap -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> -->
    <!-- FontAwesome -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> -->
    <!-- Mis estilos -->
    <!-- <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/estilos.css"> -->

</head>
<body>
    <?php require 'views/header.php'; ?>
    
    <div class="text-center pr-3 my-3 w-50 bg-dark mx-auto text-white rounded-lg p-3">
        <span class="font-weight-light">Primero debes</span>
        <a class="btn btn-outline-danger btn-sm mb-1 border-0" href="<?php echo $this->authUrl; ?>">Iniciar Sesión</a>
        <span class="font-weight-light">y conceder los permisos necesarios.</span>
    </div>

    <!-- Scripts -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script> -->

    <?php require 'views/footer.php'; ?>
</body>
</html>