<!-- Scoped CSS -->
<style>
    .container {
        height: 100vh;
        width: 100vw;
        color: #000 !important;
        display: grid;
        justify-content: center;
        align-items: center;
    }
    .card {
        width: 50vw;
    }
    
    /* Mobile View */
    @media screen and ( max-width: 690px ) {
        .container {
            width: auto;
        }
        .card {
            width: 96vw;
        }
    }
</style>

<div class="container">
    <div class="card">
        
        <div class="card-header">
            <h3 class="card-title">

                <!-- Not Found Error  -->
                <?php if ( Views::$dataSend['error'] == "not_found" ) : ?>
                    404 Not Found
                <?php endif; ?>

                <!-- Db Error -->
                <?php if ( Views::$dataSend['error'] == "db_error" ) : ?>
                    Database Error !
                <?php endif; ?>

            </h3>
        </div>

        <div class="card-body">
            <span><?= Views::$dataSend['message']; ?></span>
        </div>
    </div>
</div>