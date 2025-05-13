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

        $pdo = connectToDb();

        $sqlArtist = "SELECT rowid FROM artister WHERE artistname = :artistname LIMIT 1";
        $stmtArtist = $pdo->prepare($sqlArtist);
        $stmtArtist->execute([':artistname' => $artist]);
        $artistData = $stmtArtist->fetch(PDO::FETCH_ASSOC);

        if ($artistData) {
            $artist_id = $artistData['rowid'];  // Hämta artistens ID från resultatet
        } else {
            // Om artisten inte finns, skapa en ny artist
            // Vi skapar här en grundläggande artist (du kan lägga till fler fält om du vill)
            $sqlCreateArtist = "INSERT INTO artists (artistname) VALUES (:artistname)";
            $stmtCreateArtist = $pdo->prepare($sqlCreateArtist);
            $stmtCreateArtist->execute([':artistname' => $artist]);
            $artist_id = $pdo->lastInsertId();  // Hämta den nyligen skapade artistens ID
        }

        // 1. Spara album
        $sql = "INSERT INTO albums (name, numsongs, picture, price, owner, year) 
                VALUES (:name, :numsongs, :picture, :price, :owner, :year)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $albumname,
            ':numsongs' => count($songs),
            ':picture' => $picture,
            ':price' => $price,
            ':owner' => $artist_id,
            ':year' => $year
        ]);

        // 2. Hämta albumets ID (om det behövs i framtiden)
        $album_id = $pdo->lastInsertId();

        // 3. Spara låtar kopplade till albumet
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
        echo "<p>Fel vid databaskoppling: " . $e->getMessage() . "</p>";
    }
}
