<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body class="bg-light">
    
    <?php require 'views/header.php'; ?>

    <div class="container py-3">

    <div class="text-center py-3 rounded-lg w-50 mx-auto bg-dark text-light">
        <div><?php $this->mensaje; ?></div>

        <div class="h1 text-uppercase py-1">Crear Carpeta</div>

        <div class="px-3">
            <form action="<?php echo constant('URL') ?>drive/createFolder" method="post">
                <div class="text-left pl-2">Descripcion</div>
                <input class="form-control mb-3" type="text" name="descFold" placeholder="Descripcion de la carpeta">

                <div class="text-left pl-2">Nombre</div>
                <input type="text" class="form-control mb-3" name="nameFold" placeholder="Nombre de la carpeta">

                <input class="btn btn-outline-success" type="submit" value="Crear carpeta">
            </form>
        </div>
            
    </div>
    <?php 
        //TEST
        // echo "<pre>";
        // print_r($this->file);
        // echo "</pre>";
    ?>
        
    </div>

    <?php require 'views/footer.php'; ?>

</body>
</html>