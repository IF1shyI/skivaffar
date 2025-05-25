<?php
require_once __DIR__ . "/../db/connect.php";

// Sätt header så klienten vet att det är JSON
header('Content-Type: application/json');

function sendRating($rating, $albumname, $ratingtxt)
{
    try {
        error_log("== Inkommande betygsförsök ==");
        error_log("Rating: " . var_export($rating, true));
        error_log("Albumname: " . var_export($albumname, true));
        error_log("Text: " . var_export($ratingtxt, true));

        if (empty($rating) || empty($albumname)) {
            error_log("❌ Rating eller albumname saknas.");
            return ['success' => false, 'error' => 'Betyg eller albumnamn saknas.'];
        }

        $pdo = connectToDb();

        // Hämta albumets ID
        $sql = "SELECT rowid FROM albums WHERE albums.name = :albumname COLLATE NOCASE LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':albumname' => $albumname]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            error_log("❌ Inget album hittades med namn: $albumname");
            return ['success' => false, 'error' => 'Album ej hittat.'];
        }

        $album_id = $data['rowid'];

        // Spara betyget
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
