<?php
require_once "../../funktioner/db/connect.php";


try {

    $query = $_GET['q'] ?? '';
    $pdo = connectToDb();

    if ($query) {
        // Prepare and execute query safely
        $stmt = $pdo->prepare("SELECT name FROM album WHERE name LIKE :search LIMIT 10");
        $stmt->execute(['search' => "$query%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            echo "<div>" . htmlspecialchars($row['name']) . "</div>";
        }
    }
} catch (PDOException $e) {
    echo "<p>Anslutning misslyckades: " . $e->getMessage() . "</p>";
}
