<?php 

class Errores extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->mensaje = "La pagina no se pudo encontrar o aun no existe.";
        $this->view->render("error/index");
        //echo "<p>Nueva clase Error declarada</p>";
    }

}