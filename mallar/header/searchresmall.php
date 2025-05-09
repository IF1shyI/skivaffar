<?php
function rendersearch($namn, $img, $artist)
{
    $namn = htmlspecialchars($namn);
    $artist = htmlspecialchars($artist);
    $img = htmlspecialchars($img);

    return <<<HTML
    <div class="res-con">
        <div class="info-con">
            <img src="{$img}" alt="bild">
            <p>$namn</p>
        </div>
        <p>$artist</p>
    </div>
    HTML;
}
