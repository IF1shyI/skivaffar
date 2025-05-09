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
            <img src="https://i.discogs.com/XztqBh9zPrHpafbPSTRKrSwvTTVZ1JzOhy0I-tyTWo0/rs:fit/g:sm/q:90/h:600/w:595/czM6Ly9kaXNjb2dz/LWRhdGFiYXNlLWlt/YWdlcy9BLTgxMDEz/LTEyMTE5Nzg2NTku/anBlZw.jpeg" alt="Artist bild">
        </div>

        <div class="Fakta">
            <h2>Queen</h2>
            <p><strong>Om:</strong> Queen is a British rock band formed in London in 1970 from the previously disbanded Smile (6) Rock band. Originally called Smile, later in 1970 singer Freddie Mercury came up with the new name for the band. John Deacon joined in March 1971 giving them their fourth and final bass player.</p>

            <p><strong>Sidor:</strong>
                <a href="#">queenonline.com</a>,
                <a href="#">Facebook</a>,
                <a href="#">Instagram</a>,
                <a href="#">YouTube</a>
            </p>

            <p><strong>Medlemmar:</strong><mark>Barry Mitchell</mark>, Brian May,<mark>Freddie Mercury</mark>, <mark>John Deacon</mark>, Roger Taylor</p>
            <p><strong>Andra namn:</strong> Kween, Q, Qeen, Queen Productions, Queens, Quenn, The Queen, Куийн, Куин, クィーン, 皇后乐队, 皇后合唱团, 皇后合唱團, 皇后樂隊, 퀸, 킌</p>
        </div>

        <div class="Köp">
            <p><strong>Till salu</strong><br><a href="#">10 exemplar</a></p>
            <button class="shop-button">Köp nu</button>
        </div>
    </div>



</body>

</html>