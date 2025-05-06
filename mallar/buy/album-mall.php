<?php

$namn = $_GET['namn'] ?? "Okänd";
$pris = $_GET['pris'] ?? "Okänd";
$artist = $_GET['artist'] ?? "Okänd";
$HTML = <<<HTML
    <div class="album-container">
        <img src="" alt="">
        <h2>$namn</h2>
        <div class="price">$pris</div>
        <p>$artist</p>
    </div>
HTML;

echo $HTML;
