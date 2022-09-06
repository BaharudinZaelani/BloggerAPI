<style>
    .center {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center
        ;
    }
</style>
<div class="center">
    <div class="text-center">
        <h1>Hallo <?= APP_NAME ?></h1>
        <span>X-Made-By : @BaharDev</span>
        <br>
        <span><?= App::date(); ?></span>
    </div>
</div>