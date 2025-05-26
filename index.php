<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/header/header.css">
    <link rel="stylesheet" href="./css/main/main.css">
    <link rel="stylesheet" href="./css/sidor/index/index.css">
</head>

<body>
    <?php
    require_once "./funktioner/db/connect.php";
    require_once "./mallar/header/header.php";

    ?>
    <div class="wrapper">
        <h1>Våra populära</h1>
        <div class="album-grid">
            <?php
            define('ROOT_PATH', dirname("sidor"));
            require_once "./mallar/buy/album-list.php";
            ?>
        </div>

        <h1>Våra senaste</h1>
        <div class="album-grid">
            <?php
            require_once "./mallar/buy/latest.php";
            ?>
        </div>
    </div>

</body>

</html>