<?php
require_once "../funktioner/db/connect.php";

function sendArtist($data)
{
    try {
        $artistname = $data['artistname'] ?? '';
        $firstname = $data['firstname'] ?? '';
        $lastname = $data['lastname'] ?? '';
        $startyear = $data['startyear'] ?? '';
        $about = $data['about'] ?? '';
        $alias = $data['alias'] ?? '';
        $surnames = $data['surnames'] ?? '';
        $picture = $data['picture'] ?? '';

        $pdo = connectToDb();
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
    } catch (PDOException $e) {
        echo "<p>Anslutning misslyckades: " . $e->getMessage() . "</p>";
    }
}
