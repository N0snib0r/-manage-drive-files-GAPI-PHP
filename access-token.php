<?php
function getToken(){
    include_once 'google-api-php-client-2.2.4/vendor/autoload.php';
    $client = new \Google_Client();

    $client->setAuthConfig('orangeCredenciales.json');
    $client->setScopes(array('https://www.googleapis.com/auth/drive'));
    $client->addScope('email');
    $client->addScope('profile');

    $login_button = '';

    if(isset($_GET['code'])){
        echo 'Code declarado';
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $_SESSION['token'] = $token;
        if(!isset($token['error'])){
            echo 'Token de error no declarado';
            $client->setAccessToken($token['access_token']);

            $_SESSION['access_token'] = $token['acces_token'];

        }
    }

    if(!isset($_SESSION['access_token'])){
        $login_button = '<a href="'.$client->createAuthUrl().'">Iniciar sesion</a>';
    }
    echo 'Funcion geToken ' . $token['access_token'];
    return $token['access_token'];
}