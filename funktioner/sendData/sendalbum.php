<?php
require_once "../funktioner/db/connect.php";

/**
 * Funktion för att lägga till eller uppdatera ett album med tillhörande artist och låtar i databasen.
 * @param array $data - associerad array med albumdata: albumname, artist, year, price, picture, songs
 */
function sendAlbum($data)
{
    try {
        // Hämta data från arrayen, sätt tom sträng eller tom array som standard
        $albumname = $data['albumname'] ?? '';
        $artist = $data['artist'] ?? '';
        $year = $data['year'] ?? '';
        $price = $data['price'] ?? '';
        $picture = $data['picture'] ?? '';
        $songs = $data['songs'] ?? [];

        // Kontrollera om alla fält är tomma (dvs. inget att göra)
        $fields = [$albumname, $artist, $year, $price, $picture];
        if (empty(array_filter($fields)) && empty(array_filter($songs))) {
            // Om inga fält innehåller något värde, avsluta funktionen tidigt
            return;
        }

        // Anslut till databasen
        $pdo = connectToDb();

        // Kolla om artisten redan finns i databasen
        $sqlArtist = "SELECT rowid FROM artister WHERE artistname = :artistname LIMIT 1";
        $stmtArtist = $pdo->prepare($sqlArtist);
        $stmtArtist->execute([':artistname' => $artist]);
        $artistData = $stmtArtist->fetch(PDO::FETCH_ASSOC);

        if ($artistData) {
            // Om artist finns, hämta dess id
            $artist_id = $artistData['rowid'];
        } else {
            // Om artist inte finns, skapa en ny artist och hämta dess id
            $sqlCreateArtist = "INSERT INTO artister (artistname) VALUES (:artistname)";
            $stmtCreateArtist = $pdo->prepare($sqlCreateArtist);
            $stmtCreateArtist->execute([':artistname' => $artist]);
            $artist_id = $pdo->lastInsertId();
        }

        // Kontrollera om albumet redan finns för den här artisten
        $sqlCheckAlbum = "SELECT rowid FROM albums WHERE name = :name AND owner = :owner";
        $stmtCheckAlbum = $pdo->prepare($sqlCheckAlbum);
        $stmtCheckAlbum->execute([':name' => $albumname, ':owner' => $artist_id]);
        $existingAlbum = $stmtCheckAlbum->fetch(PDO::FETCH_ASSOC);

        if ($existingAlbum) {
            // Om album finns, hämta albumets id
            $album_id = $existingAlbum['rowid'];

            // Uppdatera albumets data med ny information
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

            // Ta bort alla gamla låtar som är kopplade till albumet
            $pdo->prepare("DELETE FROM songs WHERE album = :album")->execute([':album' => $album_id]);
        } else {
            // Om album inte finns, skapa ett nytt album med angivna data
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
            // Hämta id för det nyskapade albumet
            $album_id = $pdo->lastInsertId();
        }

        // Lägg till låtarna kopplade till albumet och artisten
        $sqlSong = "INSERT INTO songs (songname, owner, year, album)
                    VALUES (:songname, :owner, :year, :album)";
        $stmtSong = $pdo->prepare($sqlSong);

        // Loopar igenom låttitlar och lägger till dem en och en om de inte är tomma
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
        // Fångar och skriver ut felmeddelande om något går fel med databasen
        echo "<p>Fel vid databasanrop: " . $e->getMessage() . "</p>";
    }
}
