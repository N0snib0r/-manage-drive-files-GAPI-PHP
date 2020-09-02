<?php
session_start();
$url_array = explode('?', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
$url = $url_array[0];
include_once 'google-api-php-client-2.2.4/vendor/autoload.php';
include 'access-token.php';

$client = new \Google_Client();
// $client->setApplicationName('My App');
// $client->setAccessToken(getToken());
// $client->setAuthConfig('orangeCredenciales.json');///
$client->setClientId('272882240568-tmdm7m6c1rsacdvp3d4qpsr07ujfeqph.apps.googleusercontent.com');
$client->setClientSecret('1wneR_1QJVIzFEgaBaZOwxQ3');
$client->setRedirectUri($url);
$client->setScopes(array('https://www.googleapis.com/auth/drive'));
// $client->addScope('email');
// $client->addScope('profile');

if (!isset($_SESSION['access_token'])) {
  //Create a URL to obtain user authorization
}
echo '<a href="' . $client->createAuthUrl() . '"><img src="sign-in-with-google.png" /></a>';
try {
  // if (isset($_GET["code"])) {
  //   echo 'Code declarado';
  //   //Intentará intercambiar un código por un token de autenticación válido.
  //   $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
  //   $_SESSION['token'] = $token;
  // }
  if (isset($_GET["code"])) {
    echo 'Code declarado';
    //Intentará intercambiar un código por un token de autenticación válido.
    $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
    // $_SESSION['token'] = $token;
    //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
    if (!isset($token['error'])) {
      //Set the access token used for requests
      $client->setAccessToken($token['access_token']);

      //Store "access_token" value in $_SESSION variable for future use.
      $_SESSION['access_token'] = $token['access_token'];
    }
  }
  echo '<br> Aqui token: ' . $_SESSION['access_token'];
  // if ($client->isAccessTokenExpired()) {
  //     $client->fetchAccessTokenWithRefreshToken();
  // }

  // if (isset($_GET['code'])) {
  //     echo 'Intentando FetchAccesToken';
  //     $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  // }
  // if (isset($_GET['code'])) {
  //     $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
  //     echo 'Authenticate obsoleto - Token obtenido'; //
  //     header('location:'.$url);exit;
  // } elseif (!isset($_SESSION['accessToken'])) {
  //     echo 'Acces Token no declarado'; //
  //     $token = $client->authenticate();
  // }

  $api = new \Google_Service_Drive($client);

  $file = new \Google_Service_Drive_DriveFile();
  $file->setName('Folder Name');
  $file->setMimeType('application/vnd.google-apps.folder');
  $folder = $api->files->create($file);

} catch (Google_Service_Exception $gs) {
  $m = json_decode($gs->getMessage());
  echo '
      <div class="container bg-dark rounded-lg mt-2 p-3">
        <div class="w-50 text-white mx-auto border border-light rounded-lg p-2">
          <p class="m-2">1:)' . $m->error->message . '</p>
        </div>
      </div>
    ';
  // echo $m->error->message;
} catch (Exception $e) {
  echo '
    <div class="container bg-dark rounded-lg mt-2 p-3">
      <div class="w-50 text-white mx-auto border border-light rounded-lg p-2">
        <p class="m-2">2:)' . $e->getMessage() . '</p>
      </div>
    </div>
    ';
  // echo $e->getMessage();
}
