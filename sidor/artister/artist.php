<?php
require_once "../../funktioner/db/connect.php";

$artistname = $_GET['name'] ?? '';

if (empty($artistname)) {
    echo "Ingen artist vald.";
    exit;
}

$pdo = connectToDb();

$sql = "SELECT artister.*, albums.picture AS albumimg, albums.name
        FROM artister
        INNER JOIN albums ON albums.owner = artister.rowid
        WHERE artistname = :name";
$stmt = $pdo->prepare($sql);
$stmt->execute([':name' => $artistname]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$artist = $rows[0];

if (!$artist) {
    echo "Artisten hittades inte.";
    exit;
}

$albumInput = "";
foreach ($rows as $row) {
    $title = htmlspecialchars($row['name']); // säkerställa säker output
    $albumInput .= <<<HTML
                <a href="/skivaffar/sidor/album/album.php?album={$title}">
                    <div class="album-con">
                        <img src="{$row['albumimg']}" alt="album bild">
                        <p>$title</p>
                    </div>
                </a>
            
            HTML;
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
    <link rel="stylesheet" href="../../css/sidor/artister/artister.css">
</head>

<body>
    <?php
    require_once "../../mallar/header/header.php";

    ?>
    <div class="artist-profil">
        <div class="artist-info">
            <div class="artist-bild">
                <img src="<?= htmlspecialchars($artist['picture']) ?>" alt="Artist bild">
            </div>

            <div class="Fakta">
                <h2><?= htmlspecialchars($artist['artistname']) ?></h2>
                <p><strong>Om:</strong> <?= htmlspecialchars($artist['about']) ?></p>
            </div>
        </div>
        <h3>Album:</h3>
        <div class="albums">
            <?= $albumInput ?>
        </div>
    </div>



</body>

</html>