
<?php
require_once "../../../../funktioner/db/connect.php";


try {

    $query = $_GET['q'] ?? '';
    $pdo = connectToDb();

    if ($query) {
        // Prepare and execute query safely
        $stmt = $pdo->prepare("
        SELECT artistname
        FROM artister
        WHERE artistname LIKE :search
        LIMIT 10;
        ");
        $stmt->execute(['search' => "$query%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            echo <<<HTML
                <div class="sug-item">
                    <p class="name">{$row['artistname']}</p>
                </div>
            HTML;
        }
    }
} catch (PDOException $e) {
    echo "<p>Anslutning misslyckades: " . $e->getMessage() . "</p>";
}
