<?php
require_once "../db/connect.php";
try {
    $artistname = $_POST['artistname'] ?? '';
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $startyear = $_POST['startyear'] ?? '';
    $about = $_POST['about'] ?? '';
    $alias = $_POST['alias'] ?? '';
    $surnames = $_POST['surnames'] ?? '';
    $picture = $_POST['picture'] ?? '';

    $pdo = connectToDb();
    $sql = "INSERT INTO artists (
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
