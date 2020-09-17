<?php 

class Connection {
    protected $client;
    protected $credentials;

    function __construct() {
        // Credenciales de la app => https://console.developers.google.com/
        $this->credentials = "credentials/credentialsGrapes.json";
        // Creacion del cliente y del Token de Acceso
        $this->client = $this->createClient();
    } 

    function getClient() { // Solicitud CLiente
        return $this->client;
    }

    function isConnected() { // Solicitud Verificacion de conexion del cliente
        return $this->is_connected;
    }

    function getAuthData() { // Creacion de la URL para que el usuario se autentifique
        return $this->client->createAuthUrl();
    }

    function credentialsInBrowser() { // Verifica si existe el code de Autenticacion del usuario
        if(isset($_GET['code'])) {
            return true;
        }
        return false;
    }

    function createClient() { // Creacion del cliente
        $client = new Google_Client();
        $client->setApplicationName('Google Drive API');
        $client->setScopes(Google_Service_Drive::DRIVE);
        $client->setAuthConfig($this->credentials);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        $idUser = ""; // ID unico del usuario registrado | Automatizarlo para un futuro

        $tokenPath = 'tokens/' . $idUser . 'token.json'; // Ruta del token/AccesToken
        //Verificar si existe el archio JSON (token)
        if(file_exists($tokenPath)) {
            $accesToken =  json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accesToken);
        }

        //En caso de expirar el token refrescarlo
        if($client->isAccessTokenExpired()) {
            if($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } elseif($this->credentialsInBrowser()) { //Verificar si se declaro GET['code'] (accestoken)
                $authCode = $_GET['code'];
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                if(array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            } else {
                $this->is_connected = false;
                return $client;
            }
            //Crear el archivo JSON (token)
            if(!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            //Una vez creado el accestoken lo codifica a JSON y lo guarda en la ruta del token
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        } else {
            // echo "<p>Token no expirado</p>"; // TEST
        }
        $this->is_connected = true;
        return $client;

    }

}

?>