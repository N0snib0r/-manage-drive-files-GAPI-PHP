<?php

include('config-drive.php');

//Reiniciar Oauth access token
$client->revokeToken();

//Destruir valores de Session
session_destroy();
unset($_SESSION['access_token']);

//Redirección
header('location:index.php');