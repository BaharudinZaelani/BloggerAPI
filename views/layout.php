<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet"> -->

    <!-- style -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap');
        * {
            font-family: 'Ubuntu', sans-serif;
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        /* remove if you dont like it ! */
        .card {
            border-radius: 0 !important;
        }
    </style>
    <!-- bootstrap 5.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  
</head>
<body class="bg-dark">
    <div class="container-fluid bg-dark text-light">
        <!-- hargai pembuat program dengan jangan menghapus watermark -->
        <div class="container mb-1">
            Powered By : @BaharDev <br>
            FW : CRICKETS 1
        </div>
        <!-- tidak mengerti ? jangan ubah ini ! -->
        <?php foreach( Views::getContentBody() as $row ) : ?>
            <?php include $row;?>
        <?php endforeach; ?>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>
</html>