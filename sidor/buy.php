<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affär</title>
    <link rel="stylesheet" href="../css/main/main.css">
    <link rel="stylesheet" href="../css/sidor/buy/buy.css">
</head>

<body>
    <?php
    define('ROOT_PATH', dirname(__DIR__));
    require_once "../mallar/header/header.php"
    ?>
    <div class="layout">
        <div class="sidebar"></div>
        <div class="top-info"></div>
        <?php
        require_once "../mallar/buy/album-list.php"
        ?>
    </div>

</body>

</html>