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
    require_once "../mallar/header/header.php";
    ?>
    <div class="layout">
        <aside class="sidebar">
            <h3>Kategorier</h3>
            <ul>
                <li><a href="#">Alla</a></li>
                <li><a href="#">Rock</a></li>
                <li><a href="#">Pop</a></li>
                <li><a href="#">Jazz</a></li>
            </ul>
        </aside>

        <main class="content">
            <section class="top-info">
                <h1>Utforska Musik</h1>
                <input type="text" class="search-bar" placeholder="Sök efter artist eller album...">
            </section>

            <section class="album-wrapper">
                <?php require_once "../mallar/buy/album-list.php"; ?>
            </section>
        </main>
    </div>

</body>

</html>