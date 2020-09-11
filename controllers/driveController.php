<?php 

class Drive extends Controller { 
    function __construct() {
        parent::__construct();
        $this->view->mensaje = ""; //Mensaje para para mostrar an Views

    }

    function render() {
        if($this->model->isRegister()) {
            if(!$this->model->getIdFolder()) {
                $this->model->createFolder();
            }

            $files = $this->model->getFolderFiles();
            if(empty($files)) {
                $this->view->mensaje = "Ningun archivo encontrado";
            }
            $this->view->files = $files;
            $this->view->render("drive/index");

        } else {
            $this->view->authUrl = $this->model->getAuthData();
            // echo "NO REGISTRADO"; //TEST
            $this->view->render('drive/authentication');
        }
        
    }

    function download($param=null) { //Download no funciona no necesario
        $idFile = $param[0];
        if($this->model->downloadFile($idFile)) {
            $this->view->mensaje = "Archivo descargado correctamente";
        } else {
            $this->view->mensaje = "OCURRIO UN ERRORe";
        }

        $this->render();
    }

    function newFolder() {
        $this->view->render('drive/create');
    }

    function createFolder() {
        $descFold = $_POST['descFold'];
        $nameFold = $_POST['nameFold'];
        // echo $descFold;
        // echo $nameFold;

        if($this->model->create($nameFold,$descFold)) {
            $this->view->mensaje = "Carpeta creada correctamente";
        } else {
            $this->view->mensaje = "OCURRIO UN ERROR";
        }
        $this->render();
    }

    function deleteFile($param = null) { //Elimina el archivo/carpeta permanentemente
        $idFile = $param[0];
        if($this->model->delete($idFile)) {
            $this->view->mensaje = "Archivo eliminado correctamente";
        } else {
            $this->view->mensaje = "OCURRIO UN ERROR";
        }
        $this->render();
    }

    function seeFile($param = null) {
        $idFile = $param[0];
        $file = $this->model->getById($idFile);

        $this->view->file = $file;

        // $this->view->mensaje = "OCURRIO UN ERROR";
        $this->view->render('drive/detalle');
    }

    function renameFile($param = null) { //No funciona
        $idFile = $param[0];
        $newName = $_POST['name'];
        if($this->model->rename($idFile,$newName)) {

            $this->view->mensaje = "Archivo renombrado correctamente";
        } else {
            $this->view->mensaje = "OCURRIO UN ERROR";
        }
        $this->render();
    }
}

?>