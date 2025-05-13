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

        // 1. Spara album
        $sql = "INSERT INTO albums (name, numsongs, picture, price, owner, year) 
                VALUES (:name, :numsongs, :picture, :price, :owner, :year)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $albumname,
            ':numsongs' => count($songs),
            ':picture' => $picture,
            ':price' => $price,
            ':owner' => $artist,
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
                    ':owner' => $artist,
                    ':year' => $year,
                    ':album' => $album_id
                ]);
            }
        }
    } catch (PDOException $e) {
        echo "<p>Fel vid databaskoppling: " . $e->getMessage() . "</p>";
    }
}
