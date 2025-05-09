<?php
$header = <<<HTML
<header>
    <h1><a href="/">UNWOUND</a></h1>
    <div class="search-container">
        <input type="text" class="search-input">
        <div class="icon"><img src="../../public/bilder/m-glass.svg" alt=""></div>
        <dialog class="search-results"></dialog>
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
    <link rel="stylesheet" href="../../css/header/search.css">
    <script src="./search.js"></script>
</header>
HTML;

echo $header;
