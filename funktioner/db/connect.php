<?php
$pathToDb = __DIR__ . '../../db/skiva.sqlite3'; // Ange sökvägen till din SQLite-fil

$dsn = "sqlite:$pathToDb";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, null, null, $options);
    echo "Anslutningen till SQLite lyckades!";
} catch (PDOException $e) {
    echo "Anslutningen misslyckades: " . $e->getMessage();
}
