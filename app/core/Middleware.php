<?php 

class Middleware {

    private static $login;
    private static $user = [];
    private static $storage = [];

    function __construct(){
        // if ( isset($_SESSION['user']) ){
        //     $getUser = Database::get("user", "=", "username", $_SESSION['user']['username']);
        //     if ( !is_null($getUser) ) {
        //         if( $_SESSION['user']['password'] == $getUser['password'] ){
        //             Middleware::$login = true;
        //             Middleware::$user = $_SESSION['user'];
        //         }
        //     }
        // }
    }

    public static function loginArea(){

        // if not suitable
        if( !Middleware::$login ){
            return [
                "status" => "User not found",
                "cond" => false
            ];
        }

        // if user found
        return [
            "status" => "Found",
            "cond" => true,
        ];
    }

    public static function logout(){
        $_SESSION['user'] = [];
        unset($_SESSION['user']);

        return [
            "status" => "success", 
            "message" => "Berhasil Logout dari Aplikasi !"
        ];
    }
    
    public static function checkLogin(){
        if( !empty(Middleware::$user) ){
            
        }
    }

    // Getter
    public static function getUser() {
        return Middleware::$user;
    }

    public static function getStorage() {
        return Middleware::$storage;
    }


    // Setter
}