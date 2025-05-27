<?php
require_once "../db/connect.php";

// Funktion för att radera ett album samt dess tillhörande låtar
function rmAlbum($data)
{
    // Förbered svarsmall
    $response = [
        'success' => false,
        'message' => ''
    ];

    try {
        // Hämta och trimma albumnamn från inkommande data
        $albumname = trim($data['album'] ?? '');

        // Kontrollera att albumnamn är angivet
        if (empty($albumname)) {
            $response['message'] = "Albumnamn krävs.";
            return json_encode($response);
        }

        // Anslut till databasen
        $pdo = connectToDb();
        if (!$pdo) {
            $response['message'] = "Kunde inte ansluta till databasen.";
            return json_encode($response);
        }

        // Starta transaktion för att säkerställa att båda DELETE-operationerna sker korrekt
        $pdo->beginTransaction();

        // Första SQL-frågan: ta bort alla låtar kopplade till albumet
        $sqlDeleteSongs = "
            DELETE FROM songs
            WHERE album IN (
                SELECT rowid FROM albums WHERE name = :albumname
            )";
        $stmtSongs = $pdo->prepare($sqlDeleteSongs);
        $stmtSongs->execute([':albumname' => $albumname]);

        // Andra SQL-frågan: ta bort själva albumet
        $sqlDeleteAlbum = "
            DELETE FROM albums
            WHERE name = :albumname";
        $stmtAlbum = $pdo->prepare($sqlDeleteAlbum);
        $stmtAlbum->execute([':albumname' => $albumname]);

        // Bekräfta transaktionen
        $pdo->commit();

        // Uppdatera svaret vid lyckad radering
        $response['success'] = true;
        $response['message'] = "Albumet och tillhörande låtar har raderats.";
    } catch (PDOException $e) {
        // Ångra transaktionen om ett fel inträffar
        if ($pdo && $pdo->inTransaction()) {
            $pdo->rollBack();
        }

        // Returnera felmeddelande
        $response['message'] = "Fel vid databasanrop: " . $e->getMessage();
    }

    // Returnera svaret som JSON
    return json_encode($response);
}

// Kontrollera att ett POST-anrop görs och att album är inkluderat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['album'])) {
    header('Content-Type: application/json');
    echo rmAlbum($_POST);
}
