<!-- Länka till CSS för att styla albumbehållaren -->
<link rel="stylesheet" href="../../skivaffar/css/album/album-container.css">

<?php
// Inkludera databasanslutningsfunktionen
require_once(ROOT_PATH . '/funktioner/db/connect.php');

// Inkludera mallfunktionen för att rendera ett album (renderAlbum)
require_once 'album-mall.php';

try {
    // Skapa PDO-anslutning till databasen
    $pdo = connectToDb();

    // SQL-fråga för att hämta albumets namn, pris, artistnamn och bild från tabellerna
    $sql = "
    SELECT 
        albums.name AS album_namn,
        albums.price AS album_pris,
        artister.artistname AS artistnamn,
        albums.picture AS album_picture
    FROM albums
    INNER JOIN artister ON albums.owner = artister.rowid
    ";

    // Kör SQL-frågan direkt (inga parametrar behövs)
    $stmt = $pdo->query($sql);

    // Hämta alla rader som associerade arrayer
    $album = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Loopa igenom varje album och skriv ut HTML via funktionen renderAlbum
    foreach ($album as $rad) {
        echo renderAlbum(
            $rad['album_namn'],
            $rad['album_pris'],
            $rad['artistnamn'],
            $rad['album_picture']
        );
    }
} catch (PDOException $e) {
    // Om det blir något fel med databasen, skriv ut felmeddelande
    echo "<p>Anslutning misslyckades: " . $e->getMessage() . "</p>";
}
