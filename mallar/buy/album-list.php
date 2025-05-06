<link rel="stylesheet" href="../../css/album/album-container.css">
<?php
require_once(ROOT_PATH . '/funktioner/db/connect.php');

$sql = "
    SELECT 
    album.name AS album_namn,
    album.price AS album_pris,
    artister.artistname AS artistnamn
    FROM album
    INNER JOIN artister ON album.owner = artister.id
    ";
$stmt = $pdo->query($sql);
$album = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 5. Visa resultaten
foreach ($album as $rad) {
    $namn = urlencode($rad['album_namn']);
    $pris = urlencode($rad['album_pris']);
    $artist = urlencode($rad['artistnamn']);

    echo "<a href='album-mall.php?namn=$namn&pris=$pris&artist=$artist'>";
    echo htmlspecialchars($rad['album_namn']) . " – " . htmlspecialchars($rad['artistnamn']);
    echo "</a><br>";
}
