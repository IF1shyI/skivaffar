<?php

// Inkludera konfigurationsfilen som definierar t.ex. BASE_URL
require_once __DIR__ . "/../../config.php";

/**
 * Funktion som genererar HTML för ett album med given data.
 *
 * @param string $namn   Albumets namn
 * @param string $pris   Albumets pris (som text)
 * @param string $artist Artistens namn
 * @param string $img   URL till albumets omslagsbild
 * @return string       HTML-sträng för att visa albumet
 */
function renderAlbum(string $namn, string $pris, string $artist, string $img): string
{
    // Rensa input från potentiellt farliga tecken för att förhindra XSS
    $namn = htmlspecialchars($namn);
    $pris = htmlspecialchars($pris);
    $artist = htmlspecialchars($artist);
    $img = htmlspecialchars($img);

    // Skapa URL till albumets sida, med url-enkodning av albumnamnet
    $albumURL = BASE_URL . "/sidor/album/album.php?album=" . urlencode($namn);

    // Skapa URL till artistens sida, med url-enkodning av artistnamnet
    $artistURL = BASE_URL . "/sidor/artister/artist.php?name=" . urlencode($artist);

    // Returnera en HTML-block som visar albumets omslagsbild, namn, pris och artistlänk
    return <<<HTML
    <div class="album-container">
        <a href="{$albumURL}">
            <img src="{$img}" alt="Omslag för {$namn}">
            <div class="information">
                <div class="album-content">
                    <h2>$namn</h2>
                    <div class="price">$pris KR</div>
                </div>
                <p class="creator"><a href="{$artistURL}">$artist</a></p>
            </div>
        </a>
    </div>
    HTML;
}
