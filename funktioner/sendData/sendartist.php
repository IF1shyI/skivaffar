<?php
require_once "../funktioner/db/connect.php";

/**
 * Funktion för att lägga till eller uppdatera en artist i databasen.
 * @param array $data - associerad array med artistdata: artistname, firstname, lastname, startyear, about, alias, surnames, picture
 */
function sendArtist($data)
{
    try {
        // Hämta data från arrayen, sätt tom sträng som standard om värdet saknas
        $artistname = $data['artistname'] ?? '';
        $firstname = $data['firstname'] ?? '';
        $lastname = $data['lastname'] ?? '';
        $startyear = $data['startyear'] ?? '';
        $about = $data['about'] ?? '';
        $alias = $data['alias'] ?? '';
        $surnames = $data['surnames'] ?? '';
        $picture = $data['picture'] ?? '';

        // Lägg alla fält i en array för att lätt kunna kontrollera om alla är tomma
        $fields = [
            $artistname,
            $firstname,
            $lastname,
            $startyear,
            $about,
            $alias,
            $surnames,
            $picture
        ];

        // Om alla fält är tomma (ingen data att spara), returnera utan att göra något
        if (empty(array_filter($fields))) {
            return;
        }

        // Anslut till databasen
        $pdo = connectToDb();

        // Kolla om artisten redan finns i databasen baserat på artistnamnet
        $sql = "SELECT * FROM artister WHERE artistname = :artistname";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':artistname' => $artistname]);
        $exist = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($exist) {
            // Om artisten finns, uppdatera artistens information
            $sql = "UPDATE artister SET
                artistname = :artistname,
                firstname = :firstname,
                lastname = :lastname,
                startyear = :startyear,
                about = :about,
                alias = :alias,
                surnames = :surnames,
                picture = :picture
                WHERE artistname = :artistname";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':artistname' => $artistname,
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':startyear' => $startyear,
                ':about' => $about,
                ':alias' => $alias,
                ':surnames' => $surnames,
                ':picture' => $picture,
            ]);
        } else {
            // Om artisten inte finns, skapa en ny artistpost i databasen
            $sql = "INSERT INTO artister (
                artistname, firstname, lastname, startyear, about, alias, surnames, picture
            ) VALUES (
                :artistname, :firstname, :lastname, :startyear, :about, :alias, :surnames, :picture
            )";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':artistname' => $artistname,
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':startyear' => $startyear,
                ':about' => $about,
                ':alias' => $alias,
                ':surnames' => $surnames,
                ':picture' => $picture,
            ]);
        }
    } catch (PDOException $e) {
        // Hantera eventuella fel vid databasanslutningen eller körning
        echo "<p>Anslutning misslyckades: " . $e->getMessage() . "</p>";
    }
}
