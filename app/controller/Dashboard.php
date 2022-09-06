<?php 

class Dashboard extends Views {
    private $client;

    function __construct()
    {
        $app = new GoogleApis();
        $this->client = $app->startLogin();
        // var_dump(!isset($_SESSION['google']['blog']['data']));
        // die;

        Views::setContentBody(['contents/form_blog']);
        

        if ( !isset($_SESSION['google']['blog']['data']) ) {
            if ( isset($_SESSION['google']['blog']['blogid']) ) {
                $_SESSION['google']['blog']['data'] = BlogLogic::queryGET("https://blogger.googleapis.com/v3/blogs/". $_SESSION['google']['blog']['blogid'] ."/posts", false);
                App::redirect("/");
            }
        }
    }

    function index () {
        if ( isset( $_SESSION['google']['blog']['blogid'] ) ) {
            if ( !isset($_SESSION['google']['blog']['data']) ) {
                App::redirect("/dashboard");
            }

            Views::setContentBody(["contents/dashboard/blog"]);
            Views::sendData([
                "postList" => json_decode($_SESSION['google']['blog']['data'], true)
            ]);

        }
    }

}