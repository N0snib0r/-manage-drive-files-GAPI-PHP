<?php
include_once 'google-api-php-client-2.2.4/vendor/autoload.php';

//Orange
// $idClient = '501572533843-39ht7thec5a0l4ptkjeoovrcil1kvt3t.apps.googleusercontent.com';
// $appSecret = 'cCRkThmies0wPoAYHB-ogNhW';
// $redirectUri = 'http://localhost/robin/gg-drive/loginG.php';

$google_client = new \Google_Client();

$google_client->setAuthConfig('orangeCredenciales.json');
// $client->setApplicationName('My App');
// $google_client->setClientId($idClient);
// $google_client->setClientSecret($appSecret);
// $client->setAccessToken(env('GOOGLE_OAUTH_ACCESS_TOKEN'));
// $google_client->setRedirectUri($redirectUri);
$google_client->setScopes(array('https://www.googleapis.com/auth/drive'));
$google_client->addScope('email');
$google_client->addScope('profile');
