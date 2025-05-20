<link rel="stylesheet" href="../../skivaffar/css/album/album-container.css">
<?php
require_once(ROOT_PATH . '/funktioner/db/connect.php');
require_once 'album-mall.php';

try {
    $pdo = connectToDb();

    $sql = "
    SELECT 
    albums.name AS album_namn,
    albums.price AS album_pris,
    artister.artistname AS artistnamn,
    albums.picture AS album_picture
    FROM albums
    INNER JOIN artister ON albums.owner = artister.rowid
    ";
    $stmt = $pdo->query($sql);
    $album = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($album as $rad) {
        echo renderAlbum($rad['album_namn'], $rad['album_pris'], $rad['artistnamn'], $rad['album_picture']);
    }
} catch (PDOException $e) {
    echo "<p>Anslutning misslyckades: " . $e->getMessage() . "</p>";
}
