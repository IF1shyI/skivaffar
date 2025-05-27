<?php
require_once __DIR__ . "/../db/connect.php";

// Sätt header så klienten vet att svaret är JSON
header('Content-Type: application/json');

/**
 * Funktion som sparar ett betyg och en text för ett album i databasen.
 * @param int|string $rating - betygsvärdet som skickas in
 * @param string $albumname - namnet på albumet
 * @param string $ratingtxt - texten/recensionen till betyget (kan vara tom)
 * @return array - resultatet av operationen (success + eventuell error)
 */
function sendRating($rating, $albumname, $ratingtxt)
{
    try {
        error_log("== Inkommande betygsförsök ==");
        error_log("Rating: " . var_export($rating, true));
        error_log("Albumname: " . var_export($albumname, true));
        error_log("Text: " . var_export($ratingtxt, true));

        // Kontrollera att betyg och albumnamn finns
        if (empty($rating) || empty($albumname)) {
            error_log("❌ Rating eller albumname saknas.");
            return ['success' => false, 'error' => 'Betyg eller albumnamn saknas.'];
        }

        // Anslut till databasen
        $pdo = connectToDb();

        // Hämta albumets ID med namn (case-insensitive)
        $sql = "SELECT rowid FROM albums WHERE albums.name = :albumname COLLATE NOCASE LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':albumname' => $albumname]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            error_log("❌ Inget album hittades med namn: $albumname");
            return ['success' => false, 'error' => 'Album ej hittat.'];
        }

        $album_id = $data['rowid'];

        // Spara betyget i ratings-tabellen
        $sql = "INSERT INTO ratings (albumnum, ratingtxt, grade) VALUES (:albumnum, :ratingtext, :rating)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':albumnum' => $album_id,
            ':ratingtext' => $ratingtxt,
            ':rating' => $rating
        ]);

        error_log("✅ Betyget sparades för album ID: $album_id");
        return ['success' => true];
    } catch (PDOException $e) {
        error_log("❌ Databasfel: " . $e->getMessage());
        return ['success' => false, 'error' => 'Databasfel: ' . $e->getMessage()];
    }
}

// Hantera POST-anrop
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'] ?? null;
    $albumname = $_POST['albumname'] ?? null;
    $ratingtxt = $_POST['ratingtxt'] ?? '';

    $result = sendRating($rating, $albumname, $ratingtxt);
    echo json_encode($result);
}
