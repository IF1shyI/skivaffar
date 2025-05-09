<?php
function rendersearch($namn, $img, $artist)
{
    $namn = htmlspecialchars($namn);
    $artist = htmlspecialchars($artist);
    $img = htmlspecialchars($img);

    return <<<HTML
    <a href="skivaffar/sidor/album/{$namn}.php" class="res-con">
        <img class="res-img" src="{$img}" alt="bild">
        <div class="info-con">
            <p class="album-name">$namn</p>
            <p class="artist-name">$artist</p>
        </div>
    </a>
    HTML;
}
