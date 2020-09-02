<?php
class Api_gd {
    public $conn;
    public function __construct() {
        $this->include();
        
    }

    private function include() {
        require 'google-api-php-client-2.2.4/vendor/autoload.php';
        include "connection.php";
        $this->conn = new Connection(); //Por si es necesario
        
    }

    public function is_register() { ///
        // $this->conn = new Connection();
        if($this->conn->is_connected()) {
            return true;
        } else {
            return false;
        }
    }

    public function get_auth_data() {
        return $this->conn->get_unauthenticated_data();
    }

    public function goUpload() {
        if($this->conn->is_connected()) {
            require_once ("drive.php");
            $drive = new Drive($this->conn->get_client());
            echo "PRUEBA HECHA";
            $drive->uploadFile();
        }
        else return "Ah ocurrido un error, verifica si estas registrado";
    }

    public function go() {
        // $conn = new Connection();

        if($this->conn->is_connected()) {
            require_once ("drive.php");
            $drive = new Drive($this->conn->get_client());
            echo "CONECTADO CON CLIENTE";
            $drive->createFolder();
        } 
        else return "Ah ocurrido un error, verifica si estas registrado";

    }
}

// session_start();
// include 'login-drive.php';

$apiGD =  new Api_gd();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir a G-Drive</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Mis estilos -->
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="bg-dark">
    <div class="container bg-light py-5">
        <a href="logout-drive.php" class="btn btn-outline-dark" title="Cerrar Sesión">
            <i class="fa fa-power-off"></i>
        </a>
        <div class=" text-center border border-dark py-3 rounded-lg w-50 mx-auto bg-dark text-light">
            <?php $apiGD->go(); ?>
            <?php //$apiGD->get_auth_data() ?>
            <?php //if(!isset($_SESSION['access_token'])) {?>
            <!-- <div class="text-center pr-3">
                <span class="font-weight-light">Primero debes</span>
                <a class="btn btn-outline-danger btn-sm mb-1 border-0" href="<?php //echo $_SESSION['urlAuth'] ?>">Iniciar Sesión</a>
                <span class="font-weight-light">y conceder los permisos necesarios.</span>
            </div> -->
            <?php// } ?>

            <?php if(!$apiGD->is_register()) {?>
            <div class="text-center pr-3">
                <span class="font-weight-light">Primero debes</span>
                <a class="btn btn-outline-danger btn-sm mb-1 border-0" href="<?php echo $apiGD->get_auth_data(); ?>">Iniciar Sesión</a>
                <span class="font-weight-light">y conceder los permisos necesarios.</span>
            </div>
            <?php } ?>

            <h1 class="text-uppercase">Subir archivos</h1>
            <hr class="bg-secondary w-75">

            <div class="mx-auto">

                <form class="mx-auto" action="index.php" method="POST" enctype="multipart/form-data">
                <div class="contBox bg-white mx-auto" title="Arrastra y suelta un archivo aquí">
                    <img class="vector w-50 mt-3" src="svg/google-drive-brands.svg">
                    <input id="file" class="inpFile" type="file" name="file" onchange="return infoFile();">
                </div>

                <?php if($apiGD->is_register()) {?>
                <input title="Subir a tu Drive" class="btn btn-outline-success my-2" type="submit" value="Subir a Drive" name="btnUpload">
                <?php } else { ?>
                <input title="Subir a tu Drive" class="btn btn-outline-success my-2" type="submit" value="Subir a Drive" disabled>
                <?php } ?>

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
            <?php if(isset($_POST['btnUpload']))$apiGD->goUpload(); ?>
        </div>
    </div>

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

    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <?php
    // include 'login-drive.php';
    ?>
</body>
</html>