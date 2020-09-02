<?php
$url_array = explode('?', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
$url = $url_array[0];
include_once 'google-api-php-client-2.2.4/vendor/autoload.php';

//Inicializar Google Client
$client = new \Google_Client();
$client->setAuthConfig('loginGrapesCred.json');
// $client->setRedirectUri($url); //Hasta ahora opcional
$client->setScopes(array('https://www.googleapis.com/auth/drive'));
// $client->setScopes(Google_Service_Drive::DRIVE);
// $client->setAccessType();

//Obtenemos el UrlAuth
$_SESSION['urlAuth'] = $client->createAuthUrl();
