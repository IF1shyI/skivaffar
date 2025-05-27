<?php
require_once "../db/connect.php";

// Funktion för att radera en artist från databasen
function rmArtist($data)
{
    // Standardstruktur för JSON-svar
    $response = [
        'success' => false,
        'message' => ''
    ];

    try {
        // Hämta och trimma artistnamn från inkommande data
        $artist = trim($data['artist'] ?? '');

        // Kontrollera att artistnamn är angivet
        if (empty($artist)) {
            $response['message'] = "Artistnamn krävs.";
            return json_encode($response);
        }

        // Anslut till databasen
        $pdo = connectToDb();
        if (!$pdo) {
            $response['message'] = "Kunde inte ansluta till databasen.";
            return json_encode($response);
        }

        // Förbered och kör DELETE-fråga för att ta bort artisten
        $sql = "DELETE FROM artister WHERE artistname = :artist";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':artist' => $artist]);

        // Uppdatera svar vid lyckad borttagning
        $response['success'] = true;
        $response['message'] = "Artist har raderats";
    } catch (PDOException $e) {
        // Om ett fel uppstår, rulla tillbaka transaktion om aktiv
        if ($pdo && $pdo->inTransaction()) {
            $pdo->rollBack();
        }
        // Lägg till felmeddelande i svaret
        $response['message'] = "Fel vid databasanrop: " . $e->getMessage();
    }

    // Returnera svaret som JSON
    return json_encode($response);
}

// Hantera POST-förfrågan med artistnamn
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['artist'])) {
    header('Content-Type: application/json');
    echo rmArtist($_POST);
}
