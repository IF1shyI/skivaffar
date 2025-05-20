<?php
function renderAlbum(string $namn, string $pris, string $artist, string $img): string
{
    $namn = htmlspecialchars($namn);
    $pris = htmlspecialchars($pris);
    $artist = htmlspecialchars($artist);
    $img = htmlspecialchars($img);

    return <<<HTML
    <div class="album-container">
        <a href="sidor/album/album.php?album={$namn}">
            <img src="{$img}" alt="Omslag för {$namn}">
            <div class="information">
                <div class="content">
                    <h2>$namn</h2>
                    <div class="price">$pris KR</div>
                </div>
                <p class="creator"><a href="sidor/artister/artist.php?name={$artist}">$artist</a></p>
            </div>
        </a>
    </div>
    HTML;
}
