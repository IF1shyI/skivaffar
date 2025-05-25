<?php
require_once __DIR__ . "/../db/connect.php";

error_log("📥 getRating.php anropad");

function median(array $arr)
{
    sort($arr);
    $count = count($arr);
    $middle = floor(($count - 1) / 2);

    if ($count === 0) {
        return 0;
    }

    if ($count % 2) { // udda antal
        return $arr[$middle];
    } else { // jämnt antal
        return ($arr[$middle] + $arr[$middle + 1]) / 2;
    }
}

function getRating($albumname)
{
    try {
        error_log("🎧 Försöker hämta betyg för album: " . var_export($albumname, true));

        if (empty($albumname)) {
            error_log("⚠️ Inget albumnamn angivet.");
            return;
        }

        $pdo = connectToDb();

        // Hämta alla grade för albumet
        $sql = "SELECT grade FROM ratings 
                INNER JOIN albums ON albums.rowid = ratings.albumnum
                WHERE albums.name = :albumname";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':albumname' => $albumname]);
        $grades = $stmt->fetchAll(PDO::FETCH_COLUMN);

        error_log("📊 Antal betyg hittade: " . count($grades));

        if (count($grades) === 0) {
            error_log("ℹ️ Inga betyg hittade, visar tomma stjärnor.");
            $medianGrade = 0;
        } else {
            $median = median($grades);
            // Avrunda till närmaste heltal
            $medianGrade = (int) round($median);
            error_log("✅ Median (avrundad) för betyg: $medianGrade");
        }

        $starsHtml = "";
        for ($i = 0; $i < 5; $i++) {
            if ($i < $medianGrade) {
                $starsHtml .= '<img class="rating-star ' . $i . '" src="../../public/bilder/stars/full.svg" alt="full">';
            } else {
                $starsHtml .= '<img class="rating-star ' . $i . '" src="../../public/bilder/stars/empty.svg" alt="tom">';
            }
        }

        $wrapper = <<<HTML
            <div class="star-con" data-album="{$albumname}">
                {$starsHtml}
            </div>
            <div class="rating-val">{$medianGrade}</div>
        HTML;

        echo $wrapper;
        error_log("✅ getRating slutförd utan fel.");
    } catch (PDOException $e) {
        error_log("❌ Databasfel i getRating: " . $e->getMessage());
        echo "<p>Fel vid databasanrop: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
