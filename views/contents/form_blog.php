<style>
    .wrp {
        height: 100vh;
        overflow: auto;
        padding-top: 12px;
    }
</style>
<div class="wrp">
    <div class="container">

        <!-- welcome -->
        <div class="mb-3"></div>
        <h1>Welcome []~(￣▽￣)~*</h1>
        <p>Tambah artikel dengan mudah dan buat template blogspot tanpa ribet dan enggak harus pro front-end :2</p>
        
        
        <div class="card text-dark">
            <div class="card-header">
                <h5 class="card-title">Article TOOLS </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md">
                        <form method="post">
                            <input required type="text" name="blogid" class="form-control" placeholder="Input your blogID">
                            <button type="submit" name="submit" class="btn btn-success mt-4">SUBMIT ID</button>
                        </form>
                    </div>
                    <div class="col-md">
                        <form method="post">
                            <input readonly type="text" name="blogid" class="form-control" placeholder="Input your blogURL">
                            <button type="submit" disabled name="submit" class="btn btn-primary mt-4">SUBMIT URL</button>
                        </form>
                        <small>Untuk fitur ini akan datang :o</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 

if ( isset($_POST['submit']) ) {
    $_SESSION['google']['blog']['blogid'] = $_POST['blogid'];
    App::redirect("/dashboard");
}
