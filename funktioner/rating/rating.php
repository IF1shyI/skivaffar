<?php
require_once __DIR__ . "/../db/connect.php";

function getRating($albumname)
{
    try {

        // Kontrollera om alla fält är tomma
        if (empty($albumname)) {
            return;
        }

        $pdo = connectToDb();

        // Kolla om artisten finns
        $sql = "SELECT albums.rating, ratings.*
                FROM albums
                INNER JOIN ratings ON ratings.albumnum = albums.rowid
                WHERE albums.name = :albumname";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':albumname' => $albumname]);
        $datarows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $rating = 0;
        $wrapper = "";
        $stars = "";

        if (count($datarows) > 0) {
            $data = $datarows[0];
        } else {
            for ($i = 0; $i < 5; $i++) {
                $stars .= <<<HTML
                    <img class="rating-star {$i}" src="../../public/bilder/stars/empty.svg" alt="tom">
                HTML;
            }
        }
        $starCon = <<<HTML
            <div class="star-con">
                $stars
            </div>
        HTML;
        $ratingdiv = <<<HTML
                    <div class="rating-val">{$rating}</div>
                HTML;
        $ratings = "";
        for ($i = 0; $i < count($datarows); $i++) {
            $ratings .= <<<HTML
                    <img src="../../public/bilder/stars/empty.svg" alt="tom">
                HTML;
        }
        $wrapper .= $starCon;
        $wrapper .= $ratingdiv;

        echo $wrapper;
    } catch (PDOException $e) {
        echo "<p>Fel vid databasanrop: " . $e->getMessage() . "</p>";
    }
}
