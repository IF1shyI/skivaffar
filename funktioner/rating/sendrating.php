<?php
require_once __DIR__ . "/../db/connect.php"; // OBS: rättat sökvägsslash

function sendRating($rating, $albumname, $ratingtxt)
{
    try {
        // ✅ Logga inkommande data
        error_log("== Inkommande betygsförsök ==");
        error_log("Rating: " . var_export($rating, true));
        error_log("Albumname: " . var_export($albumname, true));
        error_log("Text: " . var_export($ratingtxt, true));

        // ❗ Kontrollera om rating eller albumname saknas
        if (empty($rating) || empty($albumname)) {
            error_log("❌ Rating eller albumname saknas.");
            return;
        }

        $pdo = connectToDb();

        // Hämta albumets ID
        $sql = "SELECT rowid FROM albums WHERE name = :albumname LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':albumname' => $albumname]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            error_log("❌ Inget album hittades med namn: $albumname");
            return;
        }

        $album_id = $data['rowid'];

        // Spara betyget
        $sql = "INSERT INTO ratings (c1, c2, c3) VALUES (:albumnum, :ratingtext, :rating)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':albumnum' => $album_id,
            ':ratingtext' => $ratingtxt,
            ':rating' => $rating
        ]);

        error_log("✅ Betyget sparades för album ID: $album_id");
    } catch (PDOException $e) {
        error_log("❌ Databasfel: " . $e->getMessage());
        echo "<p>Fel vid databasanrop: " . $e->getMessage() . "</p>";
    }
}

// 🟨 Om POST-anrop, kör funktionen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'] ?? null;
    $albumname = $_POST['albumname'] ?? null;
    $ratingtxt = $_POST['ratingtxt'] ?? '';

    sendRating($rating, $albumname, $ratingtxt);
}
