<?php 

class View {

    function __construct() {
        //Llma a la vista que el controlador solicite
    }

    function render($nombre) {
        require "views/" . $nombre . ".php";
    }
}

?>