<?php
require_once "../../../../funktioner/db/connect.php";

try {
    // Läs in söksträngen från GET-parametern 'q', eller sätt till tom sträng om ej satt
    $query = $_GET['q'] ?? '';

    // Anslut till databasen
    $pdo = connectToDb();

    // Om söksträngen inte är tom, gör en sökning i databasen
    if ($query) {
        // Förbered en SQL-sats som söker artistnamn som börjar med söksträngen (case insensitive kan bero på databasinställning)
        $stmt = $pdo->prepare("
            SELECT artistname
            FROM artister
            WHERE artistname LIKE :search
            LIMIT 10;
        ");

        // Kör frågan med bindning av parameter där '%' läggs till för "börjar med"
        $stmt->execute(['search' => "$query%"]);

        // Hämta alla resultat som associerad array
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Loopa igenom resultaten och skriv ut varje artistnamn i en div med klass "sug-item"
        foreach ($results as $row) {
            echo <<<HTML
                <div class="sug-item">
                    <p class="name">{$row['artistname']}</p>
                </div>
            HTML;
        }
    }
} catch (PDOException $e) {
    // Om det blir något fel med databasen, visa ett felmeddelande
    echo "<p>Anslutning misslyckades: " . $e->getMessage() . "</p>";
}
