<?php

use function GuzzleHttp\Psr7\try_fopen;

include_once 'models/archivo.php';

class DriveModel extends Model {
    protected $idFolder;
    protected $client;
    protected $service;
    protected $folderName;

    function __construct() {
        parent::__construct();
        $this->folderName = "Folder APP";
        $this->client = $this->conn->getClient();
        $this->service = $this->createService();

        $this->idFolder = $this->searchFolder();
        // $this->folderExist;
        
    }

    function getIdFolder() {
        return $this->idFolder;
    }

    function createService() {
        // Inicializamos el servicio de Google Drive
        $service = new Google_Service_Drive($this->client);
        return $service;
    }

    function isRegister() { //Verifica si el usuario ya esta registrado
        return $this->conn->isConnected();
    }

    function getAuthData() { //Obtiene la URL para Auth
        return $this->conn->getAuthData();
        $this->view->render('consulta/authentication');
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

    function searchFile($params = null) { //En desuso
        $service = new \Google_Service_Drive($this->conn->getClient);
        // $optParams = $params;
        $result = $service->files->listFiles($params);
        $idFile = $result['files'][0]->id;
        return $idFile;
    }

    function getFolderFiles() { ///
        $items = [];
        $optParams = array(
            'pageSize' => 10, //Resultados maximos
            'fields' => 'nextPageToken, files(id,name,size,mimeType,fileExtension,webViewLink,iconLink,webContentLink)', //datos para obtener del archivo
            'q' => "'" . $this->idFolder . "' in parents and trashed = false"
        );
        
        try {
            $results = $this->service->files->listFiles($optParams);

            foreach ($results as $row) {
                $item = new Archivo();
                $item->name = $row['name'];
                $item->type = $row['fileExtension']; //Tambien puede ser mimeType para mas detalle
                $item->size = round($row['size']/1000, 2);
                $item->mime = $row['mimeType'];
                $item->id = $row['id'];
                $item->viewLink = $row['webViewLink'];
                $item->iconLink = $row['iconLink'];
                $item->contentLink = $row['webContentLink'];

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

    function createFolder() {
        try {
            //Creamos los paramatros de busqueda
            $optParams = array(
                'q' => "name = '" . $this->folderName . "' and mimeType = 'application/vnd.google-apps.folder' and trashed = false"
            );

            if(empty($this->idFolder)) {
                //Creacion de la carpeta de la APP
            $file = new \Google_Service_Drive_DriveFile();
            $file->setName($this->folderName);
            $file->setMimeType('application/vnd.google-apps.folder');
            $file->setFolderColorRgb('rgb(22, 167, 101)'); //En base a los colores RGB predeterminados de las carpetas de Drive
            $file->setDescription('Archivos subidos con Grapes'); //O el nombre de la APP
            //Lanzamiento a Drive
            $folder = $this->service->files->create($file);

            $this->idFolder = $folder->getId();
            $this->folderExist = true;
            }

        } catch (Google_Service_Exception $gs) {
            //throw $th;
        } catch (Exception $e) {

        }
    }

    function create($name,$desc) {
        if(empty($name)) $name = "Nueva carpeta";
        if(empty($desc)) $desc = "";
        try {
            $file = new Google_Service_Drive_DriveFile();
            $file->setParents(array($this->idFolder)); //Importante poner el parametro como array()
            $file->setName($name);
            $file->setMimeType('application/vnd.google-apps.folder'); //Por defecto para carpetas
            $file->setDescription($desc);

            //Lanzamiento a Drive
            $this->service->files->create($file);

            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    function delete($id) { // Eliminar archivo o carpeta
        try {
            $this->service->files->delete($id);
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    function trash($id) { //No funciona | Solo en la v2
        try {
            
            $file = $this->service->files->get($id);

            // $file->setTrashed(true);
            // $file->getTrashed();
            $file->setParents("trash");

            //Nueva ubicacion
            // $optParams = array();

            $this->service->files->update($id,$file);

            return true;
        } catch(Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function rename($id,$newName) { //No funciona
        $optParams = array(
            'pageSize' => 1, //Resultados maximos
            'fields' => 'nextPageToken, files(id,name)', //datos para obtener del archivo
            'q' => "'" . $this->idFolder . "' in parents and trashed = false"
        );
        try {
            $file = $this->service->files->get($id);

            $copFile = new Google_Service_Drive_DriveFile();
            $copFile->setName($newName);

            $this->service->files->copy($file, $copFile);
            
            // $file = $this->service->files->copy($id);


            // $copiedFile = new Google_Service_Drive_DriveFile();
            // $copiedFile->setTitle($newName);

            // $file->setName($newName);
            // $file->setOriginalFilename($newName);
            
            // $optParams = array(
            //     'name' => "'".$newName."'"
            // );
            // $this->service->files->update($id, $file);

            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    function getById($id) {
        try {
            $file = $this->service->files->get($id);

            return $file;
            
        } catch (Exception $e) {
            echo 'ERROR Generico: ' . $e->getMessage();
            return false;
        }
    }

    function downloadFile($id) {

        // $optParams = array(
        //     // 'pageSize' => 1, //Resultados maximos
        //     'fields' => 'nextPageToken, files(id,webContentLink)' //datos para obtener del archivo
        // );
        $file = $this->service->files->get($id);

        $urlDown = $file->getWebContentLink();

        // $content = $this->service->files->get($id, array(
        //     'alt' => 'media'
        // ));


        echo '<pre>';
        print_r($urlDown);
        echo '</pre>';

    }
}

?>