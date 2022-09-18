<?php 
// Part Save
if ( isset($_POST['templateSave']) ) {
    foreach( $_POST as $key => $row ){
        if ( str_contains($key, "filename") ) {
            // take the data
            $filename = $_POST[$key];
            $id = explode("_", $key)[1];
            $sintax = $_POST['sintax_'. $id];

            // save content
            $_SESSION['user']['part']['foreach' . $id] = $_POST['foreach_' . $id];

            // chane content
            BlogLogic::setTemplate(PATH . "/storage/" . $filename, $sintax);
           
            App::redirect("/dashboard");
        }
    }
}


?>
<div class="my-3">
    <div class="container">
        <div class="row">
            <div class="col-md">
                <div class="card text-dark">
                    <div class="card-header">
                        <h5 class="card-title">TOOLS</h4>
                    </div>
                    <div class="card-body">
                        <!-- settings -->
                        <form method="post">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#Setting">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                    <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                </svg>
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addPart">Add Part</button>
                            <a href="<?= URI ?>/dashboard/thememaker" class="btn btn-sm btn-warning">Theme Maker</a>
                            <!-- modal setting -->
                            <div class="modal fade" id="Setting" tabindex="-1" aria-labelledby="SettingLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="SettingLabel">Setting</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body setting">
                                            <p class="alert alert-warning">! Make sure you have added the ID in the template !</p>
                                            <?php foreach ( BlogLogic::countFileFromStorage() as $row ) : ?>
                                                <?php 
                                                    $rawId = explode("@", $row);
                                                    $rawId = explode(".", $rawId[0]);
                                                    $id = end($rawId);
                                                    
                                                    // get content
                                                    $content = file_get_contents(PATH . "/storage/" . $row);
                                                ?>
                                                <input type="text" hidden name="filename_<?= $id ?>" value="<?= $row ?>">
                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col-md">
                                                            <label class="form-label">This ID <code>!<?= $id ?></code> will loaded by template.</label>
                                                            <input required name="fileid_<?= $id; ?>" type="text" class="mb-2 form-control" value="<?= $id; ?>" placeholder="ID">
                                                            
                                                            <label class="form-lable">Name of file in folder /storage (if exists)</label>
                                                            <input required value="<?= $row ?>" type="text" class="mb-2 form-control" placeholder="FileName" >
                                                        </div>
                                                        <div class="col-md">
                                                            <div class="mb-3">
                                                                <label class="form-label">Foreach ( How many u need this form displayed ? )</label>
                                                                <input value="<?= (isset($_SESSION['user']['part']['foreach' . $id]) ? $_SESSION['user']['part']['foreach'. $id] : "1") ?>" type="number" min="1" class="form-control" name="foreach_<?= $id; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <textarea name="sintax_<?= $id ?>" class="form-control bg-dark p-3 text-success" rows="10"><?= $content ?></textarea>
                                                    <button type="submit" name="delete_<?= $id ?>" class="btn btn-sm btn-danger">DELETE FILE</button>
                                                    <?php 
                                                        if ( isset($_POST['delete_' . $id]) ) {
                                                            unset($_SESSION['user']['part']['foreach' . $id]);
                                                            unlink(PATH . "/storage/" . $row);
                                                            // App::redirect("/dashboard");
                                                        }
                                                    ?>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button class="btn btn-success" name="templateSave" type="submit">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Modal add part -->
                        <div class="modal fade" id="addPart" tabindex="-1" aria-labelledby="addPartLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addPartLabel">ADD PART</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="mb-3">
                                                        <label class="form-label">ID for Template</label>
                                                        <input name="idP" type="text" class="form-control" name="idPart" placeholder="ex : description">
                                                    </div>
                                                </div>
                                                <div class="col-md">
                                                    <div class="mb-3">
                                                        <label class="form-label">ID for Content</label>
                                                        <input name="idC" type="text" class="form-control" name="idPart" placeholder="ex : dsc">
                                                    </div>
                                                </div>
        
                                                <div class="mb-3">
                                                    <select name="type" class="form-select form-select" aria-label=".form-select-sm example">
                                                        <option value="text">text</option>
                                                        <option value="textarea">textarea</option>
                                                    </select>
                                                </div>
        
                                                <div class="mb-3">
                                                    <label class="form-label">Content</label>
                                                    <textarea name="content" class="form-control bg-dark text-success" rows="10" placeholder="!dsc"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" name="saveFile" class="btn btn-primary">SAVE</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
        
        
                    </div>
                </div>
            </div>

            <!-- theme maker -->
            <!-- <div class="col-md">
                <div class="card text-dark">
                    <div class="card-header">
                        <h5 class="card-title">Theme Maker</h5>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-sm btn-primary mr-2">Global CSS</button>
                        <button class="btn btn-sm btn-warning mr-2">Global Java Script</button>
                    </div>
                </div>
            </div> -->

            <!-- layout -->
            <!-- <div class="col-md">
                <div class="card text-dark">
                    <div class="card-header">
                        <h5 class="card-title">LAYOUTS</h5>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-sm btn-primary mr-2">isHomePage</button>
                        <button class="btn btn-sm btn-primary mr-2">isSingelItem</button>
                        <button class="btn btn-sm btn-primary mr-2">404 Page</button>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>