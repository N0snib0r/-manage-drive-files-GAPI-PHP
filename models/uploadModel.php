<?php 

class uploadModel extends Model{

    function __construct() {
        parent::__construct();
        $this->folderName = "Folder APP";
        $this->client = $this->conn->getClient();
        $this->service = $this->createService();

        $this->idFolder = $this->searchFolder();
    }

    function createService() {
        // Inicializamos el servicio de Google Drive
        $service = new Google_Service_Drive($this->client);
        return $service;
    }

    function searchFolder() { ///
        //Creamos los paramatros de busqueda
        $optParams = array(
            'pageSize' => 1,
            'fields' => 'nextPageToken, files(id,name,mimeType)', //datos para obtener del archivo
            'q' => "name = '" . $this->folderName . "' and mimeType = 'application/vnd.google-apps.folder' and trashed = false"
        );
        try {
            //Buscamos y guardamos el id de la carpeta
            $result = $this->service->files->listFiles($optParams);
            //CURIOSO | Al pasar los valores con foreach no es necesario especificar la ruta de los atributos
            foreach($result as $value) {
                // echo $value['id'];
                return $value['id'];
            }

        } catch (Google_Service_Exception $gs) {
            $m = json_decode($gs->getMessage());
            echo 'ERROR Googleddd: ' . $m->error->message;
            return [];
        } catch (Exception $e) {
            echo 'ERROR Generico: ' . $e->getMessage();
        }
    }

    function up($file_path,$nameFile) {
        if($this->conn->isConnected()){
            try {
            //Obtener la ruta del archivo //Ruta temporal
            // $file_path = $_FILES["file"]["tmp_name"];
            // $nameFile = $_FILES["file"]["name"];

            if(!file_exists($file_path)) {
                return false;
            } else {
                //Instancia del archivo //Nombre del archivo subido
                $file = new Google_Service_Drive_DriveFile();
                
                //Obtener el mime type
                $fInfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($fInfo, $file_path);
                
                //id de la carpeta donde hemos dado el permiso a la cuenta del servicio
                $file->setParents(array($this->idFolder));
                
                //Colocamos la informcion del nuevo archivo de drive
                $file->setName($nameFile);
                $file->setDescription('Archivo subido desde PHP');
                $file->setMimeType($mime_type);
            
                //Subir archivo a Drive
                //Consultar mas propiedades en {var_dump($file)};
                $result = $this->service->files->create(
                $file,
                array(
                    'data'       => file_get_contents($file_path),
                    'mimeType'   => $mime_type,
                    'uploadType' => 'media' /// Carga rapida del archivo | < 5MB sin metadatos | Para mayor tamaño y carga reanudable 'resumable'
                    )
                );
            }
            
            
            //Obtener la ruta del archivo //Ruta temporal
            // $file_path = $_FILES["file"]["tmp_name"];
            // $nameFile = $_FILES["file"]["name"];
            return true;

            } catch (Exception $e) {
                //throw $th;
                return false;
            }
        }
    }
}

?>