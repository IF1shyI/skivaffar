<?php
require_once __DIR__ . "../db/connect.php";

function sendRating($rating, $albumname)
{
    try {

        // Kontrollera om alla fält är tomma

        if (empty($rating)) {
            return;
        }

        $pdo = connectToDb();

        // Kolla om artisten finns
        $sql = "SELECT rowid FROM artister WHERE artistname = :artistname LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':rating' => $rating, ':albumname' => $albumname]);
    } catch (PDOException $e) {
        echo "<p>Fel vid databasanrop: " . $e->getMessage() . "</p>";
    }
}
