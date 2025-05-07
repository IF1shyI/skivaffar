<?php
function connectToDb(): PDO
{
    $pathToDb = __DIR__ . '/../../db/skiva.sqlite3'; // Ange sökvägen till din SQLite-fil

    $dsn = "sqlite:$pathToDb";

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try {
        $pdo = new PDO($dsn, null, null, $options);
        return $pdo;
    } catch (PDOException $e) {
        throw new PDOException("Connection failed: " . $e->getMessage());
    }
}
