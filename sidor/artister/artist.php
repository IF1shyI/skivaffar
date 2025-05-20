<?php
require_once "../../funktioner/db/connect.php";

$artistname = $_GET['name'] ?? '';

if (empty($artistname)) {
    echo "Ingen artist vald.";
    exit;
}

$pdo = connectToDb();

$sql = "SELECT * FROM artister WHERE artistname = :name";
$stmt = $pdo->prepare($sql);
$stmt->execute([':name' => $artistname]);
$artist = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$artist) {
    echo "Artisten hittades inte.";
    exit;
}

// Visa albumets sida
?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unwound || <?= htmlspecialchars($artist['artistname']) ?></title>
    <link rel="stylesheet" href="../../css/header/header.css">
    <link rel="stylesheet" href="../../css/main/main.css">
    <link rel="stylesheet" href="../../css/sidor/artister/taylor-swift.css">
</head>

<body>
    <?php
    require_once "../../mallar/header/header.php";

    ?>
    <div class="artist-profil">
        <div class="artist-bild">
            <img src="<?= htmlspecialchars($artist['picture']) ?>" alt="Artist bild">
        </div>

        <div class="Fakta">
            <h2><?= htmlspecialchars($artist['artistname']) ?></h2>
            <p><strong>Om:</strong> <?= htmlspecialchars($artist['about']) ?></p>

            <!-- <p><strong>Medlemmar:</strong><mark>Barry Mitchell</mark>, Brian May,<mark>Freddie Mercury</mark>, <mark>John Deacon</mark>, Roger Taylor</p>
            <p><strong>Andra namn:</strong> Kween, Q, Qeen, Queen Productions, Queens, Quenn, The Queen, Куийн, Куин, クィーン, 皇后乐队, 皇后合唱团, 皇后合唱團, 皇后樂隊, 퀸, 킌</p> -->
        </div>

        <div class="Köp">
            <p><strong>Till salu</strong><br><a href="#">10 exemplar</a></p>
            <button class="shop-button">Köp nu</button>
        </div>
    </div>



</body>

</html>