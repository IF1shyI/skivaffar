<?php
require_once "../../funktioner/db/connect.php";

$albumname = $_GET['album'] ?? '';

if (empty($albumname)) {
    echo "Inget album valt.";
    exit;
}

$pdo = connectToDb();

$sql = "SELECT albums.*, artister.*, songs.songname, albums.picture AS albumimg
        FROM albums
        INNER JOIN artister ON albums.owner = artister.rowid
        INNER JOIN songs ON albums.rowid = songs.album
        WHERE albums.name = :name";
$stmt = $pdo->prepare($sql);
$stmt->execute([':name' => $albumname]);
$albums = $stmt->fetchAll(PDO::FETCH_ASSOC);

$album = $albums[0];

if (!$album) {
    echo "Artisten hittades inte.";
    exit;
}

$songsInputs = "";
foreach ($albums as $song) {
    $title = htmlspecialchars($song['songname']); // säkerställa säker output
    $songsInputs .= <<<HTML
            <div class="song">
                <p>$title</p>
            </div>
            HTML;
}

// Visa albumets sida
?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unwound || <?= htmlspecialchars($album['name']) ?></title>
    <link rel="stylesheet" href="../../css/header/header.css">
    <link rel="stylesheet" href="../../css/main/main.css">
    <link rel="stylesheet" href="../../css/sidor/album/album.css">
</head>

<body>
    <?php
    require_once "../../mallar/header/header.php";

    ?>
    <div class="artist-profil">
        <div class="artist-bild">
            <img src="<?= htmlspecialchars($album['albumimg']) ?>" alt="Album bild">
        </div>

        <div class="Fakta">
            <h2><?= htmlspecialchars($album['name']) ?> - <a href="/skivaffar/sidor/artister/artist.php?name=<?= rawurlencode($album['artistname']) ?>"><?= htmlspecialchars($album['artistname']) ?></a></h2>
            <p><strong>Om:</strong> <?= htmlspecialchars($album['about']) ?></p>
        </div>

        <div class="Köp">
            <button class="shop-button">Köp nu</button>
        </div>

        <div class="songlist">
            <h2>Låtlista</h2>
            <?= $songsInputs ?>
        </div>
    </div>



</body>

</html>