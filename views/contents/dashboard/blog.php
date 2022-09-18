<style>
    .scroll {
        overflow: auto;
        max-height: 230px;
        /* white-space: nowrap; */
    }
    .setting .row {
        padding-top: 12px;
        border-top: 1px solid grey;
    }
</style>
<?php 
// add part
if ( isset($_POST['saveFile']) ) {
    $idPart = $_POST['idP'];
    $idContent = $_POST['idC'];
    $content = $_POST['content'];
    $type = $_POST['type'];

    // string name
    $filename = $idPart . "@" . $idContent . "." . $type;
    $fs = fopen(PATH . "/storage/" . $filename, "w");
    fclose($fs);

    // add content
    BlogLogic::setTemplate(PATH . "/storage/" . $filename, $content);
    // App::redirect("/dahboard");
}

?>
<div class="wrp">
    <?php Views::getComponents("tools"); ?>
    <div class="my-4">
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
                            <div class="p-1">
                                <form method="post">
                                    <button name="reload_post" class="btn btn-sm btn-primary">REALOAD POST</button>
                                </form>
                            </div>
                            <table class="table post">
                                <tr>
                                    <th>postID</th>
                                    <!-- <th>published</th> -->
                                    <th>title</th>
                                    <th>author</th>
                                    <th>Action</th>
                                </tr>
                                <?php foreach ( Views::$dataSend['postList']['items'] as $row ) : ?>
                                    <?php 
                                        // get labels
                                        $labels = "";
                                        
                                        // jika ada
                                        if ( isset($row['labels']) ) {
                                            foreach ( $row['labels'] as $rLabel ) {
                                                $labels .= $rLabel . ", ";
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                        <td><?= $row['title'] ?></td>
                                        <td><?= $row['author']['displayName'] ?></td>
                                        <td>
                                            <!-- <button class="btn btn-sm btn-success">Show Content</button> -->
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#<?= "Modal_" . $row['id'] ?>">
                                                Show Content
                                            </button>
                                            <form method="post">
                                                <input type="text" hidden name="id" value="<?= $row['id'] ?>">
                                                <input type="text" hidden name="title" value="<?= $row['title'] ?>">
                                                <!-- Modal -->
                                                <div class="modal fade" id="<?= "Modal_" . $row['id'] ?>" tabindex="-1" aria-labelledby="<?= "Modal_" . $row['id'] ?>Label" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="<?= "Modal_" . $row['id'] ?>Label"><?= $row['title']; ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Add Labels <code>Separate code with ","</code></label>
                                                                    <input type="text" name="label" class="form-control" value="<?= $labels ?>">
                                                                </div>
                                                                <textarea style="min-height: 50vh;" name="content" class="form-control"><?= htmlspecialchars($row['content']) ?></textarea>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button name="change_post" type="submit" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
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
                                <?php 
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
                                ?>
                                <textarea name="template" style="height: 180px;" class="form-control bg-dark text-success"><?= $template; ?></textarea>
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
                                    <input type="text" class="form-control" name="title" placeholder="Title Post Article">
                                </div>
                                
                                <?php if( count(BlogLogic::countFileFromStorage()) > 0 ) : ?>
                                    <?php foreach( BlogLogic::countFileFromStorage() as $row ) : ?>
                                        <div class="mb-3">
                                            <?php 
                                                $tag = explode(".", $row);
                                                $tag = end($tag);
                                                
                                                $id = explode("@", $row)[0];
                                            ?>
                                            <label class="form-label" for="<?= $id ?>"><?= $id; ?></label>
                                            <?php if ( $tag == "textarea" ) { ?>
                                                <!-- jika lebih dari 1 -->
                                                <?php if ( isset($_SESSION['user']['part']['foreach'. $id]) ) { ?>
                                                    <?php for( $i = 0; $i < $_SESSION['user']['part']['foreach' . $id]; $i++ ) : ?>
                                                        <textarea name="<?= $id . "_$i" ?>" id="<?= $id?>" class="form-control mb-2" rows="5"></textarea>
                                                    <?php endfor; ?>
                                                <?php }else{ ?>
                                                    <textarea name="<?= $id ?>" id="<?= $id ?>" class="form-control" rows="5"></textarea>
                                                <?php }?>
                                            <?php }elseif ( $tag == "text" ) { ?>
                                                <!-- jika lebih dari 1 -->
                                                <?php if ( isset($_SESSION['user']['part']['foreach'. $id]) ) { ?>
                                                    <?php for( $i = 0; $i < $_SESSION['user']['part']['foreach' . $id]; $i++ ) : ?>
                                                        <!-- <textarea name="<?= $id ?>" id="<?= $id ?>" class="form-control" rows="5"></textarea> -->
                                                        <input type="text" class="form-control mb-2" id="<?= $id ?>" name="<?= $id . "_$i"  ?>">
                                                    <?php endfor; ?>
                                                <?php }else{ ?>
                                                    <!-- <textarea name="<?= $id ?>" id="<?= $id ?>" class="form-control" rows="5"></textarea> -->
                                                    <input type="text" class="form-control" id="<?= $id ?>" name="<?= $id ?>">
                                                <?php }?>
                                            <?php }?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>

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

