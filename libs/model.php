<?php 

class Model {
    protected $conn;

    function __construct() {
        //Cargar el SDK de Google
        // require 'google-api-php-client-2.2.4/vendor/autoload.php';
        require 'google-api-php-client-v2.7.0-PHP7.4/vendor/autoload.php';
        
        //Reliza la conxion con la API cuando un modelo hijo es llamado
        $this->conn = new Connection();
    }

}

?>