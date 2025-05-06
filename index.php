<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/header/header.css">
    <link rel="stylesheet" href="./css/main/main.css">
    <link rel="stylesheet" href="./css/index/index.css">
</head>

<body>
    <?php
    require_once "./mallar/header/header.php"
    ?>
    <h1>Våra populära</h1>
    <div class="album-grid">
        <div class="album-card">
            <img src="./public/bilder/Milly.png" alt="album bild">
            <h3>Livet som en hund</h3>
            <p class="artist">Milo pilo</p>
            <p class="info">2025<br>hund<br>Vinyl</p>
            <p class="pris">12345 för 100kr</p>
            <div class="buttons">
                <button>Köp</button>
                <button>Spara</button>
            </div>
        </div>

</body>

</html>