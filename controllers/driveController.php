<?php 

class Drive extends Controller { 
    function __construct() {
        parent::__construct();
        $this->view->mensaje = ""; // Mensaje auxiliar para para mostrar an Views
    }

    function render() { // Funcion principal
        if($this->model->isRegister()) { // Verifica si el usuario esta registrado
            if(!$this->model->getIdFolder()) { // Verifica si la carpeta de la app existe
                $this->model->createFolder(); // En caso que no existeriera manda a crear la carpeta
            }

            $files = $this->model->getFolderFiles(); // Obtiene un listado de las carpetas alojadas en la carpeta de la App
            if(empty($files)) {
                $this->view->mensaje = "Ningun archivo encontrado";
            }
            $this->view->files = $files;
            $this->view->render("drive/index");

        } else {
            $this->view->authUrl = $this->model->getAuthData();
            $this->view->render('drive/authentication');
        }
    }

    function createFolder() { // Crea una nueva carpeta en la carpeta de de la App
        isset($_POST['descFold']) ? $descFold = $_POST['inpSearch'] : $descFold = "";
        isset($_POST['nameFold']) ? $nameFold = $_POST['nameFold'] : $nameFold = "Nueva carpeta";

        if($this->model->create($nameFold,$descFold)) { // Manda a crear la carpeta
            $this->view->mensaje = "Carpeta creada correctamente";
        } else {
            $this->view->mensaje = "OCURRIO UN ERROR";
        }
        $this->render();
    }

    function deleteFile($param = null) { // Elimina el archivo/carpeta permanentemente | no pide confirmacion
        $idFile = $param[0];
        if($this->model->delete($idFile)) {
            $this->view->mensaje = "Archivo eliminado correctamente";
        } else {
            $this->view->mensaje = "OCURRIO UN ERROR";
        }
        $this->render();
    }

    function seeFile($param = null) { // Muestra detalles del archivo para renombrar
        $idFile = $param[0];
        if($file = $this->model->getById($idFile)) {
            $this->view->mensaje = "Archivo eliminado correctamente";
        } else {
            $this->view->mensaje = "OCURRIO UN ERROR";
        }

        $this->view->file = $file; // Envia los datos del correo a la vista
        $this->view->render('drive/detalle');
    }

    function renameFile($param = null) { // Renombrar un archivo/carpeta sin alterar su ID
        $idFile = $param[0];
        isset($_POST['inpName']) ? $newName = $_POST['inpName'] : $newName = "";

        if($this->model->rename($idFile,$newName)) {
            $this->view->mensaje = "Archivo renombrado correctamente";
        } else {
            $this->view->mensaje = "OCURRIO UN ERROR";
        }
        $this->render();
    }
}

?>