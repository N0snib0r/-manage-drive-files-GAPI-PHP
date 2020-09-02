<?php
session_start();
//Recibimos el id de la carpeta
$idFolder = $_SESSION['id-folder'];

include('config-drive.php');

//Verificar si accesToken expiro //Hasta ahora opcional
// if ($client->isAccessTokenExpired()) {
//   $client->fetchAccessTokenWithRefreshToken();
// }

//Obtener archivo de index
try {
  if(!empty($_SESSION['access_token'])) {
    $client->setAccessToken($_SESSION['access_token']);
  }
  // Inicializamos el servicio de Google Drive
  $service = new Google_Service_Drive($client);
  
  //Obtener la ruta del archivo //Ruta temporal
  $file_path = $_FILES["file"]["tmp_name"];
  $nameFile = $_FILES["file"]["name"];

  if(!empty($file_path) || $_FILES['file']['size'] != 0){
    //Instancia del archivo //Nombre del archivo subido
    $file = new Google_Service_Drive_DriveFile();

    //Obtener extension del archivo //TEST
    // $extInfo = new SplFileInfo($nameFile);
    // $extFile = '.' . $extInfo->getExtension();

    //Obtener el mime type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file_path);
    
    //id de la carpeta donde hemos dado el permiso a la cuenta del servicio
    $file->setParents(array($idFolder));

    //Colocamos la informcion del nuevo archivo de drive
    $file->setName($nameFile);
    $file->setDescription('Archivo subido desde PHP');
    $file->setMimeType($mime_type);

    //Subir archivo a Drive
    //Consultar mas propiedades en {var_dump($file)};
    $result = $service->files->create(
      $file,
      array(
        'data'       => file_get_contents($file_path),
        'mimeType'   => $mime_type,
        // 'uploadType' => 'media' /// Hasta ahora opcional
        )
      );
      //Link hacia archivo subido TEST
      // echo '<a href="https://drive.google.com/open?id=' . $result->id . '" target="_blank">' . $result->name . '</a>';
      
      echo '
      <div class="container bg-dark mt-5 py-3 rounded-lg">
      <div class="mx-auto bg-dark text-white w-50 text-center">
      <h3 class="">Archivo subido</h3>
      <div class="row justify-content-md-center mx-5 border border-white rounded-lg pt-2">
      <div class="col-4 text-left">
      <p class="font-weight-bold">Nombre: </p>
      <p class="font-weight-bold">Tamaño: </p>
      <p class="font-weight-bold">Tipo: </p>
      </div>
      <div class="col-7 text-left">
      <p id="pName">'. $_FILES['file']['name'] .'</p>
      <p id="pSize">'. ($_FILES['file']['size'])/1000 .' kB</p>
      <p id="pType">'. $_FILES['file']['type'] .'</p>
      </div>
      </div>
      <a href="index.php" class="btn btn-outline-warning mt-2" title="Volver a inicio">Subir otro</a>
      </div>
      </div>
      ';
  } else {
    echo '
    <div class="container bg-dark mt-5 py-3 rounded-lg">
      <div class="mx-auto bg-dark text-white w-50">
      <h3 class="text-center mx-5">Algo salio mal!</h3>
        <div class="mx-5 border border-white rounded-lg">
          <p class="m-3">-Verifica que hayas seleccionado un archivo valido.</p>
        </div>
      </div>
    </div>
    ';
  }

} catch (Google_Service_Exception $gs) {
  $m = json_decode($gs->getMessage());
  echo '
    <div class="container bg-dark rounded-lg mt-2 p-3">
      <div class="w-50 text-white mx-auto border border-light rounded-lg p-2">
        <p class="m-2">1:)'. $m->error->message .'</p>
      </div>
    </div>
  ';
  // echo $m->error->message;
} catch (Exception $e) {
  echo '
  <div class="container bg-dark rounded-lg mt-2 p-3">
    <div class="w-50 text-white mx-auto border border-light rounded-lg p-2">
      <p class="m-2">2:)'. $e->getMessage() .'</p>
    </div>
  </div>
  ';
  // echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Archivo subido</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body class="bg-light">

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>
