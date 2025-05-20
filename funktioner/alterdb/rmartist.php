<?php
require_once "../db/connect.php";

function rmArtist($data)
{
    $response = [
        'success' => false,
        'message' => ''
    ];

    try {
        $artist = trim($data['artist'] ?? '');

        if (empty($artist)) {
            $response['message'] = "Artistnamn krävs.";
            return json_encode($response);
        }

        $pdo = connectToDb();
        if (!$pdo) {
            $response['message'] = "Kunde inte ansluta till databasen.";
            return json_encode($response);
        }

        $sql = "DELETE FROM artister WHERE artistname = :artist";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':artist' => $artist]);

        $response['success'] = true;
        $response['message'] = "Artist har raderats";
    } catch (PDOException $e) {
        if ($pdo && $pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $response['message'] = "Fel vid databasanrop: " . $e->getMessage();
    }

    return json_encode($response);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['artist'])) {
    header('Content-Type: application/json');
    echo rmArtist($_POST);
}
