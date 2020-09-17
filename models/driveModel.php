<?php

include_once 'models/archivo.php';

class DriveModel extends Model {
    protected $idFolder;
    protected $client;
    protected $service;
    protected $folderName;

    function __construct() {
        parent::__construct();
        $this->folderName = "Folder APP";         // Nombre de la carpeta que se creara el la raiz del Usuario
        $this->client = $this->conn->getClient(); // Cliente autentificado
        $this->service = $this->createService();  // Servicio principal de Google Drive
        $this->idFolder = $this->searchFolder();  // Verifica si la carpeta de la App ya ah sido creada
    }

    function getIdFolder() { // Solicitud | Devuelve el ID de la carpeta de la App
        return $this->idFolder;
    }

    function createService() { // Inicializamos el servicio de Google Drive
        $service = new Google_Service_Drive($this->client);
        return $service;
    }

    function isRegister() { // Verifica si el usuario ya esta registrado
        return $this->conn->isConnected();
    }

    function getAuthData() { // Obtiene la URL para Auth
        return $this->conn->getAuthData();
    }

    function searchFolder() { // Verifica la existencia de la carpeta de la app
        //Creamos los paramatros de busqueda
        $optParams = array(
            'pageSize' => 1,
            'fields' => 'nextPageToken, files(id,name,mimeType)', // Datos para obtener del archivo
            'q' => "name = '" . $this->folderName . "' and mimeType = 'application/vnd.google-apps.folder' and trashed = false"
        );
        try {
            // Buscamos y guardamos el id de la carpeta
            $result = $this->service->files->listFiles($optParams);
            // CURIOSO | Al pasar los valores con foreach no es necesario especificar la ruta de los atributos
            foreach($result as $value) {
                if(empty($value['id'])) {
                    return false;
                } else {
                    return $value['id'];
                }
            }
        } catch (Google_Service_Exception $gs) {
            return false;
            $m = json_decode($gs->getMessage());
            echo 'ERROR Google SearchFolder: ' . $m->error->message;
            return [];
        } catch (Exception $e) {
            return false;
            echo 'ERROR Generico: ' . $e->getMessage();
        }
    }

    function searchFile($params = null) { // En desuso
        $service = new \Google_Service_Drive($this->conn->getClient);
        // $optParams = $params;
        $result = $service->files->listFiles($params);
        $idFile = $result['files'][0]->id;
        return $idFile;
    }

    function getFolderFiles() { // Obtiene los archivos/carpetas alojados en la carpeta de la App
        $items = [];
        $optParams = array(
            'pageSize' => 10, // Resultados maximos
            // Datos para obtener del archivo
            'fields' => 'nextPageToken, files(id,name,size,mimeType,fileExtension,webViewLink,iconLink,webContentLink)',
            'q' => "'" . $this->idFolder . "' in parents and trashed = false"
        );
        
        try {
            $results = $this->service->files->listFiles($optParams); // Lista los archivos con los parametros especificados

            foreach ($results as $row) {
                $item = new Archivo(); // Objeto auxiliar
                $item->name = $row['name'];                  // Nombre del archivo/carpeta
                $item->type = $row['fileExtension'];         //Tambien puede ser $row['mimeType'] para mas detalle
                // $item->mime = $row['mimeType'];              
                $item->size = round($row['size']/1000, 2);   // Tamaño del archivo
                $item->id = $row['id'];                      // ID del archivo/carpeta
                $item->viewLink = $row['webViewLink'];       // Link para ver el contenido de la imagen
                $item->iconLink = $row['iconLink'];          // Icono del archivo
                $item->contentLink = $row['webContentLink']; // Link de descarga del archivo | Solo funciona con media

                array_push($items, $item);
            }
            return $items;

        } catch (Google_Service_Exception $gs) {
            $m = json_decode($gs->getMessage());
            echo 'ERROR Googleaaaa: ' . $m->error->message;
            return [];
        } catch (Exception $e) {
            echo 'ERROR Generico: ' . $e->getMessage();
        }
    }

    function createFolder() { // Crea la carpeta de principal de la App
        try {
            if(empty($this->idFolder)) {
            $file = new \Google_Service_Drive_DriveFile(); // Segundo servicio de Google Drive API | Manipula archivos
            $file->setName($this->folderName);
            $file->setMimeType('application/vnd.google-apps.folder');
            $file->setFolderColorRgb('rgb(22, 167, 101)'); // En base a los colores RGB predeterminados de las carpetas de Drive
            $file->setDescription('Carpeta principal Grapes'); // Descripcion de la carpeta
            
            $folder = $this->service->files->create($file); // Lanzamiento a Drive

            $this->idFolder = $folder->getId(); // Guarda el id de la carpeta nueva
            }
        } catch (Google_Service_Exception $gs) {
            return false;
            $m = json_decode($gs->getMessage());
            echo 'ERROR Google SearchFolder: ' . $m->error->message;
            return [];
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function create($name,$desc) { // Crea una nueva carpeta en la carpeta de la App
        if(empty($name)) $name = "Nueva carpeta";
        if(empty($desc)) $desc = "";
        try {
            $file = new Google_Service_Drive_DriveFile();
            $file->setParents(array($this->idFolder)); // IMPORTANTE poner el parametro como array()
            $file->setName($name);
            $file->setMimeType('application/vnd.google-apps.folder'); // Tipo de archivo | Carpeta
            $file->setDescription($desc);

            //Lanzamiento a Drive
            $this->service->files->create($file);

            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    function delete($id) { // Eliminar archivo o carpeta | De manera permanente sin confiracion
        try {
            $this->service->files->delete($id);
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    function rename($id,$newName) {
        try {
            $file = new Google_Service_Drive_DriveFile();
            $file->setName($newName);

            $this->service->files->update($id, $file, array( // Actualiza el archivo
                // 'title' => $newName
                // 'fields' => 'title'
            ));

            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    function getById($id) { // Devuelve los datos del archvivo
        try {
            $file = $this->service->files->get($id);

            return $file;
        } catch (Exception $e) {
            echo 'ERROR Generico: ' . $e->getMessage();
            return false;
        }
    }

    function downloadFile($id) { // Obtine el link de descarga del archivo

        $file = $this->service->files->get($id);

        $urlDown = $file->getWebContentLink();

    }
}

?>