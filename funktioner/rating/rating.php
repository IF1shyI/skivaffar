<?php
require_once __DIR__ . "/../db/connect.php";

error_log("📥 getRating.php anropad");

// Funktion för att beräkna median av en array med värden
function median(array $arr)
{
    sort($arr); // Sortera arrayen i stigande ordning
    $count = count($arr);
    $middle = floor(($count - 1) / 2);

    if ($count === 0) {
        // Om arrayen är tom, returnera 0 som standardvärde
        return 0;
    }

    if ($count % 2) { // Om antalet är udda
        return $arr[$middle];
    } else { // Om antalet är jämnt, ta medelvärdet av två mittersta värden
        return ($arr[$middle] + $arr[$middle + 1]) / 2;
    }
}

// Funktion för att hämta och visa medianbetyget för ett album
function getRating($albumname)
{
    try {
        error_log("🎧 Försöker hämta betyg för album: " . var_export($albumname, true));

        if (empty($albumname)) {
            // Om inget albumnamn anges, logga varning och avbryt funktionen
            error_log("⚠️ Inget albumnamn angivet.");
            return;
        }

        // Anslut till databasen
        $pdo = connectToDb();

        // SQL-fråga för att hämta alla betyg för angivet album
        $sql = "SELECT grade FROM ratings 
                INNER JOIN albums ON albums.rowid = ratings.albumnum
                WHERE albums.name = :albumname";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':albumname' => $albumname]);
        $grades = $stmt->fetchAll(PDO::FETCH_COLUMN);

        error_log("📊 Antal betyg hittade: " . count($grades));

        if (count($grades) === 0) {
            // Om inga betyg hittas, sätt medianbetyg till 0 (inga stjärnor)
            error_log("ℹ️ Inga betyg hittade, visar tomma stjärnor.");
            $medianGrade = 0;
        } else {
            // Beräkna median av betygen och avrunda till närmaste heltal
            $median = median($grades);
            $medianGrade = (int) round($median);
            error_log("✅ Median (avrundad) för betyg: $medianGrade");
        }

        // Bygg HTML för stjärnor (fyllda och tomma)
        $starsHtml = "";
        for ($i = 0; $i < 5; $i++) {
            if ($i < $medianGrade) {
                $starsHtml .= '<img class="rating-star ' . $i . '" src="../../public/bilder/stars/full.svg" alt="full">';
            } else {
                $starsHtml .= '<img class="rating-star ' . $i . '" src="../../public/bilder/stars/empty.svg" alt="tom">';
            }
        }

        // Wrapper för stjärnor och betygsvärde
        $wrapper = <<<HTML
            <div class="star-con" data-album="{$albumname}">
                {$starsHtml}
            </div>
            <div class="rating-val">{$medianGrade}</div>
        HTML;

        // Skriv ut HTML
        echo $wrapper;
        error_log("✅ getRating slutförd utan fel.");
    } catch (PDOException $e) {
        // Logga och visa fel vid databasanrop
        error_log("❌ Databasfel i getRating: " . $e->getMessage());
        echo "<p>Fel vid databasanrop: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
