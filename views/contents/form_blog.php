<style>
    .wrp {
        height: 100vh;
        overflow: auto;
        padding-top: 12px;
    }
</style>
<div class="wrp">
    <div class="container">
        <form method="post">
            <input type="text" name="blogid" class="form-control" placeholder="Input your blogID">
            <button type="submit" name="submit" class="btn btn-success mt-4">SUBMIT</button>
        </form>
    </div>
</div>
<?php 

if ( isset($_POST['submit']) ) {
    $_SESSION['google']['blog']['blogid'] = $_POST['blogid'];
    App::redirect("/dashboard");
}


?>