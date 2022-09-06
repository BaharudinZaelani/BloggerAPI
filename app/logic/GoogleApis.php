<?php 
use Google\Client;
use Google\Service\ApigeeRegistry\Api;

class GoogleApis {

    function __construct()
    {
        // error_reporting(E_ERROR | E_PARSE);
    }

    function getClient()
    {
        $client = new Client();
        $client->setApplicationName('ZawBLOG');
        $client->setScopes('https://www.googleapis.com/auth/blogger');
        $client->setAuthConfig( $_SERVER['DOCUMENT_ROOT'] . '/' . CREDENTIAL_JSON );
        $client->setAccessType('offline');
        $client->setClientSecret(CLIENT_SECRET);
        $client->setPrompt('select_account consent');
        return $client;
    }

    function startLogin() {
        $client = $this->getClient();
        if ( isset($_SESSION['google']['accessToken'][0]) ) {
            $accessToken = $_SESSION['google']['accessToken'][0];
            $accessToken = json_encode($accessToken);
            $client->setAccessToken($accessToken);
        }

        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                if ( !isset($_SESSION['google']['login']) ) {
                    $_SESSION['google']['login'] = true;
                    header("Location: $authUrl");
                }

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);
                $_SESSION['google']['accessToken'][] = $accessToken;
                $client->setAccessToken($accessToken['access_token']);
                // $_SESSION['']
                // App::redirect("/home");
            }
        }
        return $client;
    }

    // function testY( $client ) {
    //     $service = new Google_Service_YouTube($client);
    //     $param = [
    //         "id" => "9uWAr7a1mZo"
    //     ];

    //     $response = $service->videos->listVideos("statistics", $param);
    //     return $response;
    // }

    // function editVideo($client) {
    //     $service = new Google_Service_YouTube($client);
    //     $video = new Google_Service_YouTube_Video();
    //     $video->setId('9uWAr7a1mZo');

    //     $videoSnippet = new Google_Service_YouTube_VideoSnippet();
    //     $videoSnippet->setTitle('NyobaYtAPI | Video ini ditonton : ' . $this->testY($client)->items[0]->statistics->viewCount . " Kali");        
    //     $videoSnippet->setCategoryId('24');
    //     $description = "
    //         ============\nUpdated : " . App::date() . " (Asia/Jakarta) " .
    //         "\nTerinspirasi dari Agung Hapsah : https://www.youtube.com/watch?v=E-_W9AxV6kA".
    //         "\n\nYoutube Api : https://developers.google.com/youtube/v3/docs/videos/update".
    //         "\nPHP Tutorial : https://www.youtube.com/watch?v=l1W2OwV5rgY&list=PLFIM0718LjIUqXfmEIBE3-uzERZPh3vp6".
    //         "\n\nMeskipun API ini tanpa harus login youtube studio, untuk mengirim request ke serve harus ada visitor terlebih dahulu jadi, untuk mengupdate total tonton dalam video harus ada yang ngevisit server tersebut, jadi yaaah begitulah tidak bisa otomatis update, JIKALAU PUN :v itu mau otomatsi harus memakai RDP atau bot semacamnya untuk selalu update... ¯\_(ツ)_/¯"
    //     ;
    //     $videoSnippet->setDescription($description);
    //     $video->setSnippet($videoSnippet);
                
    //     $response = $service->videos->update('snippet', $video);

    //     return [
    //         "ress" => $response,
    //         "viewCount" => $this->testY($client)->items[0]->statistics->viewCount,
    //         "description" => $description
            
    //     ];

    // }
    
}