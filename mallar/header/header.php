<?php
$header = <<<HTML
<header>
    <h1><a href="/">UNWOUND</a></h1>
    <div class="search-container">
        <input type="text">
        <div class="icon"><img src="../../public/bilder/m-glass.svg" alt=""></div>
    </div>
    <div class="h-btn-wrapper">
        <details>
            <summary>Marknad</summary>
        </details>
        <details>
            <summary>Artister</summary>
        </details>
    </div>
    <link rel="stylesheet" href="../../css/header/header.css">
</header>
HTML;

echo $header;
