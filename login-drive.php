<?php
include('config-drive.php');
// session_start();
$folderName = 'Folder APP'; /// NOMBRE DE LA CARPETA QUE SE CREARA EN EL DRIVE DEL USUARIO

//Obtenemos el Acces Token
try {
    if (isset($_GET["code"])) { //?code=...
        //Intentará intercambiar un código por un token de autenticación válido.
        $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
        //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
        if (!isset($token['error'])) {
            //Set the access token used for requests
            $client->setAccessToken($token['access_token']);

            //Store "access_token" value in $_SESSION variable for future use.
            $_SESSION['access_token'] = $token['access_token'];

            //Inicializacion del servicio de Google Drive
            $service = new \Google_Service_Drive($client);
            //Creamos los paramatros de busqueda
            $optParams = array(
              'q' => "name = '".$folderName."' and mimeType = 'application/vnd.google-apps.folder'"
            );
            //Buscamos y guardamos el id de la carpeta
            $result = $service->files->listFiles($optParams);
            // $idFolder = $result->files[0]->id;
            $idFolder = $result['files'][0]->id;
            //Enviamos el id por SESSION
            if(!empty($idFolder)) {
              $_SESSION['id-folder'] = $idFolder;
            }
            
            if(empty($idFolder)) {
              //Creacion de la carpeta de la APP
              $file = new \Google_Service_Drive_DriveFile();
              $file->setName($folderName);
              $file->setMimeType('application/vnd.google-apps.folder');
              $file->setFolderColorRgb('rgb(22, 167, 101)'); //En base a los colores RGB predeterminados de las carpetas de Drive
              $file->setDescription('Archivos subidos con Grapes');//O el nombre de la APP
              //Lanzamiento a Drive
              $folder = $service->files->create($file);
              
              //Obtener el id de la carpeta
              $result = $service->files->listFiles($optParams);
              $idFolder = $result['files'][0]->id;
              $_SESSION['id-folder'] = $idFolder;
            }

        }
    }
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
