<?php 

class Upload extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->mensaje = "";
    }

    function render() {
        $this->view->render('upload/index');
    }

    function upToDrive() {
        //Obtener la ruta del archivo //Ruta temporal
        $filePath = $_FILES['file']['tmp_name'];
        $nameFile = $_FILES['file']['name'];

        if($this->model->up($filePath,$nameFile)) {
            $this->view->mensaje = "Archivo SUbido correctamente";
        } else {
            $this->view->mensaje = "ERROR! OCURRIO ALGO, Asegurese de haber seleccionado un archivo";
        }
        $this->render();
    }
}

?>