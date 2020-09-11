<?php 
require_once "controllers/errorController.php";

class App {
    function __construct() {
        // echo "<p>Nueva App</p>";
        $url = isset($_GET['url']) ? $_GET['url']:null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        if(empty($url[0])) {
            $fileController = 'controllers/mainController.php';
            require_once $fileController;
            //Inicializar la clase Main | Crea el objeto view
            $controller = new Main();

            //Crear un modelo
            $controller->loadModel('main'); //Si es que necesita un modelo
            $controller->render(); //Cargar la vista principal
            return false;
        }

        //Ruta del controlador
        $fileController = 'controllers/' . $url[0] . 'Controller.php';

        if(file_exists($fileController)) {
            require_once $fileController;
            //Inicializa el Controlador
            $controller = new $url[0]; //Inicializa el la clase del controlador
            $controller->loadModel($url[0]);

            $nParam = sizeof($url);

            if($nParam > 1) {
                if($nParam > 2) {
                    $param = [];
                    for($i=2; $i<$nParam; $i++) {
                        array_push($param, $url[$i]);
                    }
                    $controller->{$url[1]}($param);
                } else {
                    $controller->{$url[1]}();
                }
            } else {
                $controller->render();
            }
        } else {
            // echo "PASO REQUIRE";
            $controller = new Errores();
        }
    }

    function include() {
        require 'google-api-php-client-2.2.4/vendor/autoload.php';
        include "connection.php";
        $this->conn = new Connection(); //Por si es necesario
    }
}
?>