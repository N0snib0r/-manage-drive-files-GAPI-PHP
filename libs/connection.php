<?php 

class Connection {
    protected $client;
    protected $credentials;

    function __construct() {
        $this->credentials = "credentials/credentialsGrapes.json";
        $this->client = $this->createClient();
    } 

    function getClient() {
        return $this->client;
    }

    function isConnected() {
        return $this->is_connected;
    }

    function getAuthData() {
        // Request authorization from the user.
        // $authUrl = $this->client->createAuthUrl();
        // return $authUrl;
        // echo "getAuthUrl EJECUTADOSSSS";
        return $this->client->createAuthUrl();
    }

    function credentialsInBrowser() {
        if(isset($_GET['code'])) {
            return true;
        }
        return false;
    }

    function createClient() {
        $client = new Google_Client();
        $client->setApplicationName('Google Drive API');
        $client->setScopes(Google_Service_Drive::DRIVE);
        $client->setAuthConfig($this->credentials);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        $idUser = ""; // ID unico del usuario registrado | Automatizarlo para un futuro

        $tokenPath = 'tokens/' . $idUser . 'token.json'; // Ruta del token | 
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
            // echo "<p>Token no expirado</p>";
        }
        $this->is_connected = true;
        return $client;

    }

}

?>