<!-- Länka till CSS för albumcontainern -->
<link rel="stylesheet" href="../../skivaffar/css/album/album-container.css">

<?php
// Inkludera databasanslutningsfunktionerna
require_once(ROOT_PATH . '/funktioner/db/connect.php');
// Inkludera funktionen för att rendera album (renderAlbum)
require_once 'album-mall.php';

try {
    // Skapa PDO-anslutning till databasen
    $pdo = connectToDb();

    // SQL-fråga som hämtar de senaste 5 albumen tillsammans med artistnamn
    $sql = "
    SELECT 
        albums.name AS album_namn,      -- Albumets namn
        albums.price AS album_pris,     -- Albumets pris
        artister.artistname AS artistnamn, -- Artistens namn
        albums.picture AS album_picture -- URL till albumets omslagsbild
    FROM albums
    INNER JOIN artister ON albums.owner = artister.rowid  -- Koppla ihop album med rätt artist via owner ID
    ORDER BY albums.rowid DESC  -- Sortera så att senaste albumen kommer först
    LIMIT 5                     -- Visa endast de 5 senaste albumen
    ";

    // Kör SQL-frågan direkt (ingen bindning behövs då inga användarvärden används)
    $stmt = $pdo->query($sql);

    // Hämta resultatet som en array av associerade arrayer
    $album = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Loopar igenom varje album-rad och renderar HTML med hjälp av funktionen renderAlbum
    foreach ($album as $rad) {
        echo renderAlbum(
            $rad['album_namn'],      // Albumets namn
            $rad['album_pris'],      // Albumets pris
            $rad['artistnamn'],      // Artistens namn
            $rad['album_picture']    // URL till omslagsbilden
        );
    }
} catch (PDOException $e) {
    // Om något går fel i databaskopplingen eller frågan, visa felmeddelande
    echo "<p>Anslutning misslyckades: " . $e->getMessage() . "</p>";
}
