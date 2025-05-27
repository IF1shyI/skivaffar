<?php
require_once "../../funktioner/db/connect.php";  // Koppla upp mot databasen

// Hämta artistnamnet från URL-parametern 'name'
$artistname = $_GET['name'] ?? '';

if (empty($artistname)) {
    // Om ingen artist angivits, visa felmeddelande och stoppa exekveringen
    echo "Ingen artist vald.";
    exit;
}

$pdo = connectToDb();

// SQL-fråga för att hämta artistdata samt album kopplade till artisten
$sql = "SELECT artister.*, albums.picture AS albumimg, albums.name
        FROM artister
        INNER JOIN albums ON albums.owner = artister.rowid
        WHERE artistname = :name";
$stmt = $pdo->prepare($sql);
$stmt->execute([':name' => $artistname]);

// Hämta alla rader som matchar (artisten kan ha flera album)
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ta första raden som representerar artisten
$artist = $rows[0];

// Om artisten inte hittades, visa felmeddelande och avsluta
if (!$artist) {
    echo "Artisten hittades inte.";
    exit;
}

// Generera HTML för att visa album kopplade till artisten
$albumInput = "";
foreach ($rows as $row) {
    $title = htmlspecialchars($row['name']); // Sanera albumnamnet för säker output
    $albumInput .= <<<HTML
        <a href="/skivaffar/sidor/album/album.php?album={$title}">
            <div class="album-con">
                <img src="{$row['albumimg']}" alt="album bild">
                <p>$title</p>
            </div>
        </a>
    HTML;
}

?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Sätt sidans titel till artistens namn -->
    <title>Unwound || <?= htmlspecialchars($artist['artistname']) ?></title>

    <!-- Koppla CSS-filer -->
    <link rel="stylesheet" href="../../css/header/header.css">
    <link rel="stylesheet" href="../../css/main/main.css">
    <link rel="stylesheet" href="../../css/sidor/artister/artister.css">
</head>

<body>
    <?php
    // Inkludera sidhuvud (header)
    require_once "../../mallar/header/header.php";
    ?>

    <div class="artist-profil">
        <div class="artist-info">
            <div class="artist-bild">
                <!-- Visa artistens bild -->
                <img src="<?= htmlspecialchars($artist['picture']) ?>" alt="Artist bild">
            </div>

            <div class="Fakta">
                <!-- Visa artistnamn och info -->
                <h2><?= htmlspecialchars($artist['artistname']) ?></h2>
                <p><strong>Om:</strong> <?= htmlspecialchars($artist['about']) ?></p>
            </div>
        </div>

        <h3>Album:</h3>
        <div class="albums">
            <!-- Visa alla album som artist har -->
            <?= $albumInput ?>
        </div>
    </div>

</body>

</html>