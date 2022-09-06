<style>
    .wrp {
        height: 100vh;
        overflow: auto;
    }
    .scroll {
        overflow: auto;
        max-height: 230px;
        /* white-space: nowrap; */
    }
</style>
<?php 
// header("Content-type: txt");
if ( !isset($_SESSION['user']['template']) ) {
    $_SESSION['user']['template'] = '<div class="wrp"> <!-- image --> !imgRes <!-- description --> <p> !dscRes </p> <!-- ads --> <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3065472092341208" crossorigin="anonymous"></script> <ins class="adsbygoogle" style="display:block; text-align:center;" data-ad-layout="in-article" data-ad-format="fluid" data-ad-client="ca-pub-3065472092341208" data-ad-slot="3312036695"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script> <!-- download link --> <blockquote> <p> <b>Link Download :</b> <br> !linkRes </p> </blockquote> </div>';
}

if ( !isset($_SESSION['form']['image']) ) {
    $_SESSION['form']['image'] = 1;
    $_SESSION['form']['link'] = 1;
}
if ( isset($_POST['save_template']) ) {
    $_SESSION['user']['template'] = $_POST['template'];
}

if ( isset($_POST['addForm']) ) {
    $_SESSION['form']['image'] = $_POST['formImage'];
    echo "<script>windows.location.href = '" . URI . "' </script>";
    // App::redirect("/");
}
if ( isset($_POST['addLink']) ) {
    $_SESSION['form']['link'] = $_POST['link'];
    echo "<script>windows.location.href = '" . URI . "' </script>";
}

if ( isset($_POST['addPost']) ) {
    $template = $_SESSION['user']['template'];

    $imageSintax = '
        <div class="separator" style="clear: both; text-align: center;">
            <a href="!zaw_image" style="margin-left: 1em; margin-right: 1em;">
                <img border="0" data-original-height="400" data-original-width="800" src="!zaw_image" />
            </a>
        </div>
    ';
    // insert image
    $imgRes = "";
    for( $i = 0; $i < $_SESSION['form']['image']; $i++ ) {
        $imgRes .= str_replace("!zaw_image", $_POST['urlImage_' . $i], $imageSintax);
    }

    $linkSintax = '<a href="!zaw_link" target="_blank">!zaw_link</a>';
    // insert link
    $linkRes = "";
    for ( $i = 0; $i < $_SESSION['form']['link']; $i++ ) {
        $linkRes .= str_replace("!zaw_link", $_POST['urlLink_' . $i], $linkSintax);
    }

    // insert desciption
    $dsc = "<p>!descRes</p>";
    $descRes = str_replace("!descRes", $_POST['description'], $dsc);

    // result sintax
    $result = str_replace("!imgRes", $imgRes, $template);
    $result = str_replace("!dscRes", $descRes, $result);
    $result = str_replace("!linkRes", $linkRes, $result);

    $title = $_POST['title'];

    $ex = BlogLogic::queryPOST("https://www.googleapis.com/blogger/v3/blogs/" . $_SESSION['google']['blog']['blogid'] . "/posts?key=" . API_KEYS, [
        "title" => $title,
        "content" => $result
    ]);

    $_SESSION['google']['blog']['data'] = BlogLogic::queryGET("https://blogger.googleapis.com/v3/blogs/". $_SESSION['google']['blog']['blogid'] ."/posts", false);

    echo "<script>windows.location.href = '" . URI . "' </script>";
}
?>
<div class="wrp">
    <div class="mb-5 mt-5">

        <div class="bloginfo container">
            <div class="row">

                <div class="col-md-3">
                    <div class="card text-dark">
                        <div class="card-header">
                            <h5>Blog Info</h1>
                        </div>
                        <div class="body">
                            <table class="table">
                                <tr>
                                    <th>BogID</th>
                                    <td>: <?= $_SESSION['google']['blog']['blogid'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md">
                    <div class="card text-dark">
                        <div class="card-header">
                            <h5 class="card-title">Post List</h5>
                        </div>
                        <div class="scroll">
                            <table class="table post">
                                <tr>
                                    <th>postID</th>
                                    <!-- <th>published</th> -->
                                    <th>title</th>
                                    <th>author</th>
                                    <th>Action</th>
                                </tr>
                                <?php foreach ( Views::$dataSend['postList']['items'] as $row ) : ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                        <!-- <td><?= explode("T", $row['published'])[0] ?></td> -->
                                        <td><?= $row['title'] ?></td>
                                        <td><?= $row['author']['displayName'] ?></td>
                                        <td>
                                            <!-- <button class="btn btn-sm btn-success">Show Content</button> -->
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                Show Content
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <textarea style="min-height: 50vh;" class="form-control"><?= htmlspecialchars($row['content']) ?></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="content container mt-4">
            <div class="row">
                <div class="col-md">
                    <div class="card template text-dark">
                        <div class="card-header"><h5 class="card-title">Template</h5></div>
                        <div class="card-body">
                            <form method="post">
                                <textarea name="template" style="height: 180px;" class="form-control bg-dark text-success"><?= ( isset($_SESSION['user']['template'])? $_SESSION['user']['template'] : "" ) ?></textarea>
                                <button name="save_template" class="btn btn-sm btn-success">Save Template</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md">
                    <div class="card text-dark addPost">
                        <div class="card-header"><h5 class="card-titme">Add Post</h5></div>
                        <div class="card-body">
                            <form method="post">
                                <!-- title -->
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title">
                                </div>
                                <!-- image -->
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image(url)</label>
                                    <div class="d-flex">
                                        <div style="width: 80%;">
                                            <?php for( $i = 0; $i < $_SESSION['form']['image']; $i++ ) : ?>
                                                <input name="urlImage_<?= $i; ?>" type="text" class="form-control mb-2" placeholder="url = image">
                                            <?php endfor; ?>
                                        </div>
                                        <div>
                                            <!-- <hr class="mx-2 my-2" style="width: 100%;"> -->
                                            <input name="formImage" type="number" class="form-control mx-2 mb-2" value="<?=  $_SESSION['form']['image']; ?>">
                                            <button name="addForm" type="submit" class="mx-2 btn btn-sm btn-success">ADD</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- link -->
                                <div class="mb-3">
                                    <label class="form-label">Link Download (url)</label>
                                    <div class="d-flex">
                                        <div style="width: 80%;">
                                            <?php for( $i = 0; $i < $_SESSION['form']['link']; $i++ ) : ?>
                                                <input name="urlLink_<?= $i; ?>" type="text" class="form-control mb-2" placeholder="url = link">
                                            <?php endfor; ?>
                                        </div>
                                        <div>
                                            <!-- <hr class="mx-2 my-2" style="width: 100%;"> -->
                                            <input name="link" type="number" class="form-control mx-2 mb-2" value="<?=  $_SESSION['form']['link']; ?>">
                                            <button name="addLink" type="submit" class="mx-2 btn btn-sm btn-success">ADD</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- description -->
                                <div class="mb-3">
                                    <textarea name="description" class="form-control" placeholder="Description"></textarea>
                                </div>
                                
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-outline-success" type="submit" name="addPost">SUBMIT</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>

