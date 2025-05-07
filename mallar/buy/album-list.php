<link rel="stylesheet" href="../../css/album/album-container.css">
<?php
require_once(ROOT_PATH . '/funktioner/db/connect.php');
require_once 'album-mall.php';

try {
    $pdo = connectToDb();

    $sql = "
    SELECT 
    album.name AS album_namn,
    album.price AS album_pris,
    artister.artistname AS artistnamn,
    album.picture AS album_picture
    FROM album
    INNER JOIN artister ON album.owner = artister.rowid
    ";
    $stmt = $pdo->query($sql);
    $album = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($album as $rad) {
        echo renderAlbum($rad['album_namn'], $rad['album_pris'], $rad['artistnamn'], $rad['album_picture']);
    }
} catch (PDOException $e) {
    echo "<p>Anslutning misslyckades: " . $e->getMessage() . "</p>";
}
