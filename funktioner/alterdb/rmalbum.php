<?php
require_once "../db/connect.php";

function rmAlbum($data)
{
    $response = [
        'success' => false,
        'message' => ''
    ];

    try {
        $albumname = trim($data['album'] ?? '');

        if (empty($albumname)) {
            $response['message'] = "Albumnamn krävs.";
            return json_encode($response);
        }

        $pdo = connectToDb();
        if (!$pdo) {
            $response['message'] = "Kunde inte ansluta till databasen.";
            return json_encode($response);
        }

        $pdo->beginTransaction();

        $sqlDeleteSongs = "
            DELETE FROM songs
            WHERE album IN (
                SELECT rowid FROM albums WHERE name = :albumname
            )";
        $stmtSongs = $pdo->prepare($sqlDeleteSongs);
        $stmtSongs->execute([':albumname' => $albumname]);

        $sqlDeleteAlbum = "
            DELETE FROM albums
            WHERE name = :albumname";
        $stmtAlbum = $pdo->prepare($sqlDeleteAlbum);
        $stmtAlbum->execute([':albumname' => $albumname]);

        $pdo->commit();

        $response['success'] = true;
        $response['message'] = "Albumet och tillhörande låtar har raderats.";
    } catch (PDOException $e) {
        if ($pdo && $pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $response['message'] = "Fel vid databasanrop: " . $e->getMessage();
    }

    return json_encode($response);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['album'])) {
    header('Content-Type: application/json');
    echo rmAlbum($_POST);
}
