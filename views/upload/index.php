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

                </form>
            </div>
            
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

    <!-- Script datos archivos | OPCIONAL -->
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
        
    <?php require 'views/footer.php'; ?>
</body>
</html>