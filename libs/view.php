<?php 

class View {

    function __construct() {
        // echo "<p>Esta es una vista</p>";
    }

    function render($nombre) {
        require "views/" . $nombre . ".php";
    }
}

?>