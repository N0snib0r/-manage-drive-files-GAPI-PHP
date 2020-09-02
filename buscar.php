<?php
include('config-drive.php');
session_start();
$folderName = 'Folder APP';

try {
    if (!empty($_SESSION['access_token'])) {
        $client->setAccessToken($_SESSION['access_token']);
    }
    $service = new Google_Service_Drive($client);

    $optParams = array(
        'q' => "name = '".$folderName."' and mimeType = 'application/vnd.google-apps.folder'"
    );
    // echo $_SESSION['access_token'];
    $result = $service->files->listFiles($optParams);
    echo 'Aqui el ID de SESSION'.$_SESSION['id-folder'].'<br>';

    echo var_dump($result) . '<br><br>';
    // $arrFolder = (array) $result;/// AQUI FALTA OBTENER EL ID
    $arrFolder = json_decode(json_encode($result), true);
    // var_dump($arrFolder);
    // $thearray = get_object_vars( $result );
    // var_dump( $thearray );
    // foreach ($arrFolder as $key => $value) {
    //   echo $key .' ==> '. $value . '<br>';
    // }
    // echo "<pre>";
    // print_r($result);
    // echo "</pre>";
    echo '<br> ID: ' . $result->files[0]->id;
    echo '<br> ID: ' . $result["files"][0]->id . '<br>';
    echo '<br>'.var_dump($result->files[0]->id);
    echo '<br>'.var_dump($result["files"][0]->id);


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
