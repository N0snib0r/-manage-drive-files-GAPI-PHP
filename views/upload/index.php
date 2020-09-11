<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <!-- Bootstrap -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> -->
    <!-- FontAwesome -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> -->
    <!-- Mis estilos -->
    <!-- <link rel="stylesheet" href="<?php //echo constant('URL'); ?>public/css/estilos.css"> -->

</head>
<body class="bg-light">
    <?php require 'views/header.php'; ?>

    <div class="container py-3">

        
        <!-- <h1 class="center">Vista principal Drive</h1> -->
        
        <!-- <a href="logout-drive.php" class="btn btn-outline-dark" title="Cerrar Sesión">
            <i class="fa fa-power-off"></i>
        </a> -->
        
        <div class="text-center py-3 rounded-lg w-50 mx-auto bg-dark text-light">
            <div class="center"><?php echo $this->mensaje; ?></div>
            
            <h1 class="text-uppercase">Subir archivos</h1>
            <hr class="bg-secondary w-75 mx-auto">
            
            <div class="mx-auto">

                <form class="mx-auto" action="<?php echo constant('URL') ?>upload/upToDrive" method="POST" enctype="multipart/form-data">
                <div class="contBox bg-white mx-auto" title="Arrastra y suelta un archivo aquí">
                    <img class="vector w-50 mt-3" src="<?php echo constant('URL'); ?>public/svg/google-drive-brands.svg">
                    <input id="file" class="inpFile" type="file" name="file" onchange="return infoFile();">
                </div>

                <input title="Subir a tu Drive" class="btn btn-outline-success my-2" type="submit" value="Subir a Drive" name="btnUpload">
                <!-- <input title="Subir a tu Drive" class="btn btn-outline-success my-2" type="submit" value="Subir a Drive" disabled> -->

                </form>
            </div>
            <!-- <a href="newFolder.php" class="btn btn-outline-warning">Crear carpeta</a>
            <a href="loginG.php" class="btn btn-outline-warning">Login GG</a> -->
            
            <div class="row justify-content-md-center mx-5 border border-white rounded-lg pt-2">
                <div class="col-4 text-left">
                    <p class="font-weight-bold">Nombre: </p>
                    <p class="font-weight-bold">Tamaño: </p>
                    <p class="font-weight-bold">Tipo: </p>
                </div>
                <div class="col-7 text-left">
                    <p id="pName">-</p>
                    <p id="pSize">-</p>
                    <p id="pType">-</p>
                </div>
            </div>
        </div>
        
    </div>

    <!-- Script datos archivos -->
    <script>
        function infoFile(){
            //Cargar la informacion del Archivo en los p
            const input = document.getElementById('file');
            // if(input.files && input.files[0])
            //Imprimir en consola TEST
            // console.log("File Seleccionado : ", input.files[0]);

            document.getElementById('pName').innerHTML = input.files[0].name;
            document.getElementById('pSize').innerHTML = (input.files[0].size / 1000) + ' kB';
            document.getElementById('pType').innerHTML = input.files[0].type;
        }
    </script>
    
    <!-- Scripts -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script> -->
    
    <?php require 'views/footer.php'; ?>
</body>
</html>