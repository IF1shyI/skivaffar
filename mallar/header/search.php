<link rel="stylesheet" href="./css/mallar/search/search.css">
<?php
require_once "../../funktioner/db/connect.php";  // Anslut till databasen
require_once "searchresmall.php";                 // Importera funktionen rendersearch()

try {
    // Hämta sökparametern från GET, om den finns
    $query = $_GET['q'] ?? '';
    $pdo = connectToDb();

    if ($query) {
        // Förbered SQL-sats för att söka album som börjar med söksträngen
        $stmt = $pdo->prepare("
            SELECT albums.name, artister.artistname, albums.picture
            FROM albums
            INNER JOIN artister ON albums.owner = artister.rowid
            WHERE albums.name LIKE :search
            LIMIT 10;
        ");
        // Kör frågan med sökparametern, där vi använder "$query%" för prefix-matchning
        $stmt->execute([':search' => "$query%"]);

        // Hämta alla matchande rader som associerande arrayer
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Loopa igenom resultaten och rendera varje träff med rendersearch()
        foreach ($results as $row) {
            echo rendersearch($row['name'], $row['picture'], $row['artistname']);
        }
    }
} catch (PDOException $e) {
    // Om något går fel med databasanropet, visa ett felmeddelande
    echo "<p>Anslutning misslyckades: " . $e->getMessage() . "</p>";
}
?>