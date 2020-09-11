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

        <div class="h1 text-uppercase py-1">Renombrar</div>

        <div class="px-3">
            <div class="text-left pl-2">ID</div>
            <input type="text" class="form-control mb-3" name="id" value="<?php echo $this->file->id; ?>" disabled>

            <div class="text-left pl-2">Nombre</div>
            <form class="input-group" action="<?php echo constant('URL')."drive/renameFile/".$this->file->id; ?>" method="post">
                <input type="text" class="form-control" name="name" placeholder="Nombre del archivo" value="<?php echo $this->file->name; ?>">
                <div class="input-group-append">
                    <input class="btn btn-outline-light" type="submit" value="Renombrar">
                </div>
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