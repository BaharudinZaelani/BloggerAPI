<?php 


class BlogLogic {

    static function queryPOST($url = "url", $body = [], $customReq = ""){
        // $url = "https://www.googleapis.com/blogger/v3/blogs/" . $_SESSION['google']['blog']['blogid'] . "/posts?key=" . API_KEYS;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        if ( $customReq == "" ) {
            curl_setopt($curl, CURLOPT_POST, true);
        }else {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT' );
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $header = [
            "Authorization: Bearer " . $_SESSION['google']['accessToken'][0]['access_token'],
            "Content-Type: application/json",
            "Accept: application/json"
        ];
        // $header[0] = $body;
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        $result = curl_exec($curl);
        curl_close($curl);
        
        // var_dump(headers_list());die;
        $result = json_decode($result, true);

        return $result;
    }

    static function queryGET($url, $stringOrArray = true){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET' );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $header = [
            "Authorization: Bearer " . $_SESSION['google']['accessToken'][0]['access_token'],
            "Content-Type: application/json",
            "Accept: application/json"
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        $result = curl_exec($curl);
        curl_close($curl);
        if ( $stringOrArray ) {
            $result = json_decode($result, true);
        }
        // header("Content-type: txt");
        // var_dump($result);die;
        return $result;
    }

    static function countFileFromStorage() {
        $files = glob(PATH . "/storage/" . "*");
        $fn = [];
        foreach ( $files as $row) {
            $ex = explode("/", $row);
            $re = end($ex);
            if ( is_int(strpos($re, "@")) ) {
                $fn[] = $re;
            }
        }
        return $fn;
    }

    static function createFile ( $path, $fileName, $value ) {
        $fs = fopen($path . $fileName, "wb");
        fwrite($fs, $value);
        fclose($fs);
    }

    static function reloadPost() {
        $_SESSION['google']['blog']['data'] = BlogLogic::queryGET("https://blogger.googleapis.com/v3/blogs/". $_SESSION['google']['blog']['blogid'] ."/posts", false);
    }

    static function loadTemplate( $path ){
        return file_get_contents($path);
    }

    static function setTemplate( $path, $string = "" ){
        return file_put_contents($path, $string);
    }

}