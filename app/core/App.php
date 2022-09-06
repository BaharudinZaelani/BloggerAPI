<?php 

class App {
    // controller
    private $controller = "Home";
    private $method = "index";
    private $params = [];

    function __construct()// priority
    {
        session_start();
        date_default_timezone_set("Asia/Jakarta");

        // if app using database 
        if ( USING_DB ) {    
            new Database();
        }

        $this->pretty($this->url(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    }

    function pretty($url)// priority
    {
        if ( $url[1] !== "" ){
            $this->controller = ucfirst($url[1]);
            unset($url[1]);
        }

        $ch = explode("?", $this->controller);
        $this->controller = $ch[0];

        // var_dump($_SERVER['QUERY_STRING']);die;
        
        // check query string
        if ( isset($_SERVER['QUERY_STRING']) ) {
            if ( $this->controller == "" ) {
                $this->controller = "Home";
            }

            // explode &
            $get = explode("&", $_SERVER['QUERY_STRING']);
            if ( is_array($get) ) {
                foreach ( $get as $row ) {
                    $key = explode("=", $row);
                    $_GET[$key[0]] = $key[1];
                }
            }else {
                $key = explode("=", $_SERVER['QUERY_STRING']);
                $_GET[$key[0]] = $key[1];
            }

            // var_dump($_GET);
            // die;
        }
        
        if( !file_exists( $_SERVER['DOCUMENT_ROOT'] .  "/app/controller/" . $this->controller . ".php") ){
            // header
            header("HTTP/1.1 404 Not Found");
            // data view
            App::errorLog("not_found", "[ Controller ] <b>$this->controller.php</b> Not Found in this project !");
        }

        include  $_SERVER['DOCUMENT_ROOT'] . "/app/controller/" . $this->controller . ".php";
        $this->controller = new $this->controller;

        if ( isset($url[2]) ){
            $url[2] = str_replace("-", "", $url[2]);
            if( method_exists($this->controller, $url[2]) ){
                $this->method = $url[2];
                unset($url[2]);
            }
        }
        
        
        if( !empty($url) ){
            $this->params = array_values($url);
        }

        unset($url);
        
        call_user_func_array([$this->controller, $this->method], [$this->params]);
    
        
    }

    function url()// priority
    {
        // sparate with "/"
        $url = $_SERVER['REQUEST_URI'];
        $url = explode("/", $url);
        
        // unset index 0
        unset($url[0]);
        return $url;
    }

    public static function errorLog($error, $message){
        Views::setContentBody([
            "error"
        ]);
        Views::sendData([
            "error" => $error,
            "message" => $message
        ]);
        die;
    }
    
    // Helper
    public static function date ()// priority
    {
        // $date = date('Y-m-d H:i:s');
        $date = [
            "year" => date("Y"),
            "month" => [
                "toString" => date("M")
            ]
        ];

        $rOne = json_encode($date);
        $res = json_decode($rOne);
        // var_dump($res->month);
        // die;
        return date('Y-M-d | H:i');
    }

    public static function redirect($uri, $message = "")// priority
    {
        header("Location: " . $uri);
    }




    // Models
    public static function loadModel($model) {
        return new $model();
    }
}