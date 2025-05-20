<?php

require_once __DIR__ . "/../../config.php";
function renderAlbum(string $namn, string $pris, string $artist, string $img): string
{

    $namn = htmlspecialchars($namn);
    $pris = htmlspecialchars($pris);
    $artist = htmlspecialchars($artist);
    $img = htmlspecialchars($img);

    $albumURL = BASE_URL . "/sidor/album/album.php?album=" . urlencode($namn);
    $artistURL = BASE_URL . "/sidor/artister/artist.php?name=" . urlencode($artist);

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
