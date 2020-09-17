<?php 

class Upload extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->mensaje = ""; // Mensaje auxiliar para para mostrar an Views
    }

    function render() { // Funcion principal
        $this->view->render('upload/index'); // Carga de vista de nuevo mensaje
    }

    function upToDrive() { // Sube un archivo a la carpeta de la App
        //Obtener la ruta del archivo | Ruta temporal
        $filePath = $_FILES['file']['tmp_name'];
        $nameFile = $_FILES['file']['name'];

        if($this->model->up($filePath,$nameFile)) { // Envia la ruta y el nombre del archivo para la subida
            $this->view->mensaje = "Archivo SUbido correctamente";
        } else {
            $this->view->mensaje = "ERROR! OCURRIO ALGO, Asegurese de haber seleccionado un archivo";
        }
        $this->render();
    }
}

?>