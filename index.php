<?php 

require_once "libs/controller.php"; // Controller Padre | Inicializa la clase vista y carga el modelo
require_once "config/config.php";   // Constantes declaradas
require_once "libs/connection.php"; // Realiza la conexion con la API, genera el cliente y el token de Acceso del Usuario
require_once "libs/model.php";      // Model Padre | Conecta con el SDK de la API
require_once "libs/view.php";       // Vista Padre
require_once "libs/app.php";        // Capturador de argumentos de la URL

//Inicializacion de la clase App | Encargada de capturar los parametros de la URL
$app = new App();

?>