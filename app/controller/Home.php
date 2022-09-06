<?php 

class Home extends Views{

    function __construct()
    {
        if ( isset($_SESSION['google']['login']) ) {
            App::redirect("/dashboard");
        }
    }

    function index(){
        // set FE views
        Views::setContentBody([
            "contents/welcome"
        ]);

        $blog = new GoogleApis();
        $res = $blog->startLogin();
        var_dump($res);
        
    }

}