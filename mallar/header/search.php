<link rel="stylesheet" href="./css/mallar/search/search.css">
<?php
require_once "../../funktioner/db/connect.php";
require_once "searchresmall.php";


try {

    $query = $_GET['q'] ?? '';
    $pdo = connectToDb();

    if ($query) {
        // Prepare and execute query safely
        $stmt = $pdo->prepare("
        SELECT albums.name, artister.artistname, albums.picture
        FROM albums
        INNER JOIN artister ON albums.owner = artister.rowid
        WHERE albums.name LIKE :search
        LIMIT 10;
        ");
        $stmt->execute([':search' => "$query%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            echo rendersearch($row['name'], $row['picture'], $row['artistname']);
        }
    }
} catch (PDOException $e) {
    echo "<p>Anslutning misslyckades: " . $e->getMessage() . "</p>";
}
