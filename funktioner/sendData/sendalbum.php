<?php
require_once "../funktioner/db/connect.php";

function sendAlbum($data)
{
    try {
        $albumname = $data['albumname'] ?? '';
        $artist = $data['artist'] ?? '';
        $year = $data['year'] ?? '';
        $price = $data['price'] ?? '';
        $picture = $data['picture'] ?? '';
        $songs = $data['songs'] ?? [];

        // Kontrollera om alla fält är tomma
        $fields = [$albumname, $artist, $year, $price, $picture];
        if (empty(array_filter($fields)) && empty(array_filter($songs))) {
            return;
        }

        $pdo = connectToDb();

        // Kolla om artisten finns
        $sqlArtist = "SELECT rowid FROM artister WHERE artistname = :artistname LIMIT 1";
        $stmtArtist = $pdo->prepare($sqlArtist);
        $stmtArtist->execute([':artistname' => $artist]);
        $artistData = $stmtArtist->fetch(PDO::FETCH_ASSOC);

        if ($artistData) {
            $artist_id = $artistData['rowid'];
        } else {
            // Skapa ny artist om den inte finns
            $sqlCreateArtist = "INSERT INTO artister (artistname) VALUES (:artistname)";
            $stmtCreateArtist = $pdo->prepare($sqlCreateArtist);
            $stmtCreateArtist->execute([':artistname' => $artist]);
            $artist_id = $pdo->lastInsertId();
        }

        // Kolla om albumet finns
        $sqlCheckAlbum = "SELECT rowid FROM albums WHERE name = :name AND owner = :owner";
        $stmtCheckAlbum = $pdo->prepare($sqlCheckAlbum);
        $stmtCheckAlbum->execute([':name' => $albumname, ':owner' => $artist_id]);
        $existingAlbum = $stmtCheckAlbum->fetch(PDO::FETCH_ASSOC);

        if ($existingAlbum) {
            $album_id = $existingAlbum['rowid'];

            // Uppdatera befintligt album
            $sqlUpdate = "UPDATE albums SET
                numsongs = :numsongs,
                picture = :picture,
                price = :price,
                year = :year
                WHERE rowid = :id";
            $stmt = $pdo->prepare($sqlUpdate);
            $stmt->execute([
                ':numsongs' => count($songs),
                ':picture' => $picture,
                ':price' => $price,
                ':year' => $year,
                ':id' => $album_id
            ]);

            // Ta bort gamla låtar för detta album
            $pdo->prepare("DELETE FROM songs WHERE album = :album")->execute([':album' => $album_id]);
        } else {
            // Skapa nytt album
            $sqlInsert = "INSERT INTO albums (name, numsongs, picture, price, owner, year)
                          VALUES (:name, :numsongs, :picture, :price, :owner, :year)";
            $stmt = $pdo->prepare($sqlInsert);
            $stmt->execute([
                ':name' => $albumname,
                ':numsongs' => count($songs),
                ':picture' => $picture,
                ':price' => $price,
                ':owner' => $artist_id,
                ':year' => $year
            ]);
            $album_id = $pdo->lastInsertId();
        }

        // Lägg till nya låtar
        $sqlSong = "INSERT INTO songs (songname, owner, year, album)
                    VALUES (:songname, :owner, :year, :album)";
        $stmtSong = $pdo->prepare($sqlSong);

        foreach ($songs as $title) {
            if (!empty($title)) {
                $stmtSong->execute([
                    ':songname' => $title,
                    ':owner' => $artist_id,
                    ':year' => $year,
                    ':album' => $album_id
                ]);
            }
        }
    } catch (PDOException $e) {
        echo "<p>Fel vid databasanrop: " . $e->getMessage() . "</p>";
    }
}
