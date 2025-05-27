<?php
// Funktion för att skapa och returnera en PDO-anslutning till SQLite-databasen
function connectToDb(): PDO
{
    // Definiera sökvägen till SQLite-databasfilen relativt denna fil
    $pathToDb = __DIR__ . '/../../db/skiva.sqlite3';

    // Skapa Data Source Name (DSN) för SQLite
    $dsn = "sqlite:$pathToDb";

    // PDO-alternativ för felhantering och fetch-mode
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,       // Aktivera undantag vid fel
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Som standard returnera resultat som associerade arrayer
    ];

    try {
        // Initiera PDO-anslutning med angivet DSN och alternativ
        $pdo = new PDO($dsn, null, null, $options);
        return $pdo;
    } catch (PDOException $e) {
        // Om anslutningen misslyckas, kasta ett undantag med felmeddelande
        throw new PDOException("Connection failed: " . $e->getMessage());
    }
}
