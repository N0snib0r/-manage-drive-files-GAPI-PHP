<?php
class Drive {
    private $client;
    private $folderName = 'Folder APP';
    private $idFolder;

    public function __construct($client) {
        $this->client = $client;
    }

    public function searchFolder() {
        $service = new \Google_Service_Drive($this->client);
        //Creamos los paramatros de busqueda
        $optParams = array(
            'q' => "name = '" . $this->folderName . "' and mimeType = 'application/vnd.google-apps.folder'"
        );
        //Buscamos y guardamos el id de la carpeta
        $result = $service->files->listFiles($optParams);
        // $idFolder = $result->files[0]->id;
        $this->idFolder = $result['files'][0]->id;
        //Enviamos el id
        if(isset($result['files'][0]->id)) {
            return $result['files'][0]->id;
        }
    }

    public function createFolder() {
        try {
            //Inicializacion del servicio de Google Drive
            $service = new \Google_Service_Drive($this->client);
            //Creamos los paramatros de busqueda
            $optParams = array(
                'q' => "name = '" . $this->folderName . "' and mimeType = 'application/vnd.google-apps.folder'"
            );
            //Buscamos y guardamos el id de la carpeta
            $result = $service->files->listFiles($optParams);
            // $idFolder = $result->files[0]->id;
            $this->idFolder = $result['files'][0]->id;
            //Enviamos el id por SESSION
            if (!empty($this->idFolder)) {
                $_SESSION['id-folder'] = $this->idFolder;
            }

            if (empty($this->idFolder)) {
                //Creacion de la carpeta de la APP
                $file = new \Google_Service_Drive_DriveFile();
                $file->setName($this->folderName);
                $file->setMimeType('application/vnd.google-apps.folder');
                $file->setFolderColorRgb('rgb(22, 167, 101)'); //En base a los colores RGB predeterminados de las carpetas de Drive
                $file->setDescription('Archivos subidos con Grapes'); //O el nombre de la APP
                //Lanzamiento a Drive
                $folder = $service->files->create($file);

                //Obtener el id de la carpeta
                $result = $service->files->listFiles($optParams);
                $this->idFolder = $result['files'][0]->id;
                // $_SESSION['id-folder'] = $idFolder;
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
    }

    public function uploadFile() {
        try {
            // Inicializamos el servicio de Google Drive
            $service = new Google_Service_Drive($this->client);
            
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
              $file->setParents(array($this->searchFolder()));
          
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
    }
}
