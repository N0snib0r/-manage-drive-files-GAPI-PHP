<?php 

class Controller {
    protected $view;
    protected $model;

    function __construct() {
        $this->view = new View();
    }

    function loadModel($model) {
        //Crea la ruta del modelo
        $pathModel = 'models/' . $model . 'Model.php';
        
        if(file_exists($pathModel)) {
            require $pathModel;

            //Inicializar el objeto del modelo
            $modelName = $model . 'Model';
            $this->model = new $modelName();

        }
    }
}

?>