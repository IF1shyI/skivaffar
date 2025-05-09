<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/header/header.css">
    <link rel="stylesheet" href="../../css/main/main.css">
    <link rel="stylesheet" href="../../css/sidor/artister/taylor-swift.css">
</head>

<body>
    <?php
    require_once "../../funktioner/db/connect.php";
    require_once "../../mallar/header/header.php";

    ?>
    <div class="artist-profil">
        <div class="artist-bild">
            <img src="https://i.discogs.com/BHATgEBrPeW8vdSQ-TkXKcOXyQqKMk8HKqF2rR8yklk/rs:fit/g:sm/q:90/h:600/w:450/czM6Ly9kaXNjb2dz/LWRhdGFiYXNlLWlt/YWdlcy9BLTExMjQ2/NDUtMTczOTczNDY3/MC0xMzg0LmpwZWc.jpeg" alt="Artist bild">
        </div>

        <div class="Fakta">
            <h2>Taylor Swift</h2>
            <p><strong>Riktigt namn:</strong> Taylor Alison Swift</p>
            <p><strong>Om:</strong> American singer-songwriter, born December 13, 1989 in Reading, Pennsylvania, USA. Swift signed her record deal with Big Machine Records at the age of 15 and released her debut album in October of 2006.</p>

            <p><strong>Sidor:</strong>
                <a href="#">Swift.com</a>,
                <a href="#">Facebook</a>,
                <a href="#">Instagram</a>,
                <a href="#">YouTube</a>
            </p>

            <p><strong>Alias:</strong>Nils sjöberg</p>
            <p><strong>Andra namn:</strong>Swift, T. A. Swift, T. Swift, T.S., Taylor, Taylor Alison Swift, テイラー・スウィフト, テイラー・スウィフト /</p>
        </div>

        <div class="Köp">
            <p><strong>Till salu</strong><br><a href="#">20 exemplar</a></p>
            <button class="shop-button">Köp nu</button>
        </div>
    </div>



</body>

</html>