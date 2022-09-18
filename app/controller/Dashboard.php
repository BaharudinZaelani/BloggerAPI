<?php

use Google\Service\Blogger\Blog;

class Dashboard extends Views {

    function __construct()
    {
        $app = new GoogleApis();
        $this->client = $app->startLogin();

        Views::setContentBody(['contents/form_blog']);
        
        if ( !isset($_SESSION['google']['blog']['data']) ) {
            if ( isset($_SESSION['google']['blog']['blogid']) ) {
                $_SESSION['google']['blog']['data'] = BlogLogic::queryGET("https://blogger.googleapis.com/v3/blogs/". $_SESSION['google']['blog']['blogid'] ."/posts", false);
                App::redirect("/");
            }
        }
    }

    function index ( $key = [] ) {
        // theme maker
        if ( isset($key[0]) AND $key[0] == "thememaker" ) {
            Views::setContentBody(["contents/dashboard/themeMaker"]);
            // generate template file
            if ( isset($_POST['uploadfile']) ) {
                $sintax = [
                    "content" => ( isset($_POST['content']) ? $_POST['content'] : "" ),
                    "head" => ( isset($_POST['head']) ? $_POST['head'] : "" ),
                    "plugin" => ( isset($_POST['plugin']) ? $_POST['plugin'] : "" )
                ];
                $targetDir = PATH . "/bhook";

                // get base and section
                $section = BlogLogic::loadTemplate($targetDir . "/section.html");
                $base = BlogLogic::loadTemplate($targetDir . "/base.html");

                // create tmp file for section
                $sectionResult = str_replace("@content_client", $sintax['content'], $section);
                BlogLogic::createFile($targetDir . "/tmp/" , time() . ".zaw", $sectionResult);

                // get result section
                $scSection = BlogLogic::loadTemplate($targetDir . "/tmp/" . time() . ".zaw");

                // base replace
                $rContent = str_replace("@content", $scSection, $base);

                // add head
                $resHead = str_replace("@head", $sintax['head'], $rContent);

                // add plugin
                $resPlugin = str_replace("@plugin", $sintax['plugin'], $resHead);

                // result
                /* gawean broo. BaharDevSide !!!!, 
                 * tambahan logika ker ngasupken script javaScript. 
                 * Meh gampang engke maneh ngadevloyna TAI !!!
                 * 
                 * @BaharClientSide
                */
                $coreJs = BlogLogic::loadTemplate($targetDir . "/core/app.js");
                $result = str_replace("@core", $coreJs, $resPlugin);

                // base replace
                BlogLogic::setTemplate($targetDir . "/result/base.txt", $result);


            }
            return;
        }
        
        // documentasi
        if ( isset($key[0]) AND $key[0] == "doc" ) {
            Views::setContentBody(["contents/dashboard/doc"]);
            return;
        }

        if ( isset( $_SESSION['google']['blog']['blogid'] ) ) {
            if ( !isset($_SESSION['google']['blog']['data']) ) {
                App::redirect("/dashboard");
            }

            Views::setContentBody(["contents/dashboard/blog"]);
            $content = ["items"=>[]];
            if ( isset(json_decode($_SESSION['google']['blog']['data'], true)['items']) ) {
                $content = json_decode($_SESSION['google']['blog']['data'], true);
            }
            Views::sendData([
                "postList" => $content
            ]);

            // set form
            if ( !isset($_SESSION['form']['image']) OR !file_exists(PATH . "/storage/template.php") ) {
                $_SESSION['user']['template'] = "!dscRes !imgRes !linkRes";
            }

            // save template
            if ( isset($_POST['save_template']) ) {
                $path = PATH . "\storage";
                $_SESSION['user']['template'] = $_POST['template'];
                if ( !file_exists($path . "template.php") ) {
                    $file = fopen($path . "/template.php", "w");
                    fwrite($file, $_POST['template']);
                    fclose($file);
                }
            }

            // add image and link form
            if ( isset($_POST['addForm']) ) {
                $_SESSION['form']['image'] = $_POST['formImage'];
                echo "<script>windows.location.href = '" . URI . "' </script>";
            }
            if ( isset($_POST['addLink']) ) {
                $_SESSION['form']['link'] = $_POST['link'];
                echo "<script>windows.location.href = '" . URI . "' </script>";
            }

            // add article post
            if ( isset($_POST['addPost']) ) {
                header("Content-type: txt");
                $title = $_POST['title'];

                // load template
                $template = "";
                if ( file_exists(PATH . "/storage/template.php") ) {
                    $ff = file_get_contents(PATH . "/storage/template.php");
                    if ( $ff !== "" ) {
                        $f = fopen(PATH . "/storage/template.php", 'r');
                        $template = fread($f, filesize(PATH . "/storage/template.php"));
                        fclose($f);
                    }
                }else if ( isset($_SESSION['user']['template']) ) {
                    $template = $_SESSION['user']['template'];
                }
                
                $result = "";
                foreach ( BlogLogic::countFileFromStorage() as $row ) {
                    // find the id File
                    $idFile = explode('@', $row)[0];
                    
                    // find the id 
                    $rawId = explode("@", $row);
                    $rawId = end($rawId);
                    $R2Id = explode(".", $rawId);
                    $id = $R2Id[0];

                    // save in result
                    $content = file_get_contents(PATH . "/storage/" . $row);
                    if ( isset($_SESSION['user']['part']['foreach' . $idFile]) ) {
                        for ( $i = 0; $i < $_SESSION['user']['part']['foreach' . $idFile]; $i++ ) {
                            $result .= str_replace("!" . $id, $_POST[$idFile . "_$i"], $content);
                        }
                    }else {
                        $result .= str_replace("!" . $id, $_POST[$idFile], $content);
                    }

                    // edit template
                    $template = str_replace("!". $idFile, $result, $template);
                    // var_dump($result);die;
                    $result = "";
                }


                BlogLogic::queryPOST("https://www.googleapis.com/blogger/v3/blogs/" . $_SESSION['google']['blog']['blogid'] . "/posts?key=" . API_KEYS, [
                    "title" => $title,
                    "content" => $template
                ]);

                $_SESSION['google']['blog']['data'] = BlogLogic::queryGET("https://blogger.googleapis.com/v3/blogs/". $_SESSION['google']['blog']['blogid'] ."/posts", false);
                BlogLogic::reloadPost();

                App::redirect("/");
            }

            // change post
            if ( isset($_POST['change_post']) ) {
                $label = [];
                if ( isset($_POST['label']) ) {
                    $cLabel = explode(",", $_POST['label']);
                    foreach ( $cLabel as $row ) {
                        $label[] = $row;
                    }
                }
                // var_dump($_POST['content']); die;
                BlogLogic::queryPOST("https://www.googleapis.com/blogger/v3/blogs/". $_SESSION['google']['blog']['blogid'] . "/posts/" . $_POST['id'] . "?key=" . API_KEYS , [
                    "title" => $_POST['title'],
                    "content" => $_POST['content'],
                    "labels" => $label
                ], "PUT");
                App::redirect("/");
            }

            // reload post
            if ( isset($_POST['reload_post']) ) {
                BlogLogic::reloadPost();
                App::redirect("/");
            }

        }
    }

}