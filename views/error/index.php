<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/estilos.css">
</head>
<body>
    <?php require 'views/header.php' ?>
    <div id="main">
        
        <div class="center"><?php echo $this->mensaje; ?></div>

        <h1 class="error center">CREO QUE NOS PERDIMOS.</h1>
        
    </div>
    <?php require 'views/footer.php' ?>
</body>
</html>