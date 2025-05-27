<?php
require_once "../../funktioner/db/connect.php";   // Koppla upp mot databasen
require_once __DIR__ . "/../../funktioner/rating/rating.php";  // Ladda in funktioner för betygsättning

// Hämta albumnamnet från URL-parametern 'album'
$albumname = $_GET['album'] ?? '';

if (empty($albumname)) {
    // Om inget album skickats med, visa felmeddelande och stoppa exekveringen
    echo "Inget album valt.";
    exit;
}

$pdo = connectToDb();

// SQL-fråga för att hämta album, artist och låtar för valt album
$sql = "SELECT albums.*, artister.*, songs.songname, albums.picture AS albumimg
        FROM albums
        INNER JOIN artister ON albums.owner = artister.rowid
        INNER JOIN songs ON albums.rowid = songs.album
        WHERE albums.name = :name";
$stmt = $pdo->prepare($sql);
$stmt->execute([':name' => $albumname]);
$albums = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ta första raden som representerar albumet
$album = $albums[0];

// Om albumet inte hittades, visa felmeddelande och stoppa exekveringen
if (!$album) {
    echo "Artisten hittades inte.";
    exit;
}

// Skapa HTML för låtlistan
$songsInputs = "";
foreach ($albums as $song) {
    // Sanera låtnamn för säker output
    $title = htmlspecialchars($song['songname']);
    $songsInputs .= <<<HTML
        <div class="song">
            <p>$title</p>
        </div>
    HTML;
}
?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Titel på sidan visar albumnamnet -->
    <title>Unwound || <?= htmlspecialchars($album['name']) ?></title>

    <!-- Länka till CSS-filer -->
    <link rel="stylesheet" href="../../css/header/header.css">
    <link rel="stylesheet" href="../../css/main/main.css">
    <link rel="stylesheet" href="../../css/sidor/album/album.css">
</head>

<body>
    <?php
    // Inkludera sidhuvud
    require_once "../../mallar/header/header.php";
    ?>

    <div class="artist-profil">
        <div class="artist-bild">
            <!-- Albumomslag -->
            <img src="<?= htmlspecialchars($album['albumimg']) ?>" alt="Album bild">
        </div>

        <div class="Fakta">
            <!-- Albumnamn och artistlänk -->
            <h2>
                <?= htmlspecialchars($album['name']) ?> -
                <a href="/skivaffar/sidor/artister/artist.php?name=<?= rawurlencode($album['artistname']) ?>">
                    <?= htmlspecialchars($album['artistname']) ?>
                </a>
            </h2>
            <!-- Om-text från databasen -->
            <p><strong>Om:</strong> <?= htmlspecialchars($album['about']) ?></p>
        </div>

        <div class="Köp">
            <div class="rating">
                <!-- Visa betyg för albumet -->
                <?= getRating($albumname); ?>
                <script src="../../funktioner/rating/updatelive.js"></script>
            </div>
            <div class="price">
                <!-- Pris i kronor -->
                <?= $album["price"] ?> KR
            </div>
            <button class="shop-button">Köp nu</button>
        </div>

        <div class="songlist">
            <h2>Låtlista</h2>
            <!-- Lista med låtar -->
            <?= $songsInputs ?>
        </div>
    </div>
</body>

</html>