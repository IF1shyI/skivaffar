<?php

require_once __DIR__ . "/../../config.php";

$shopURL = BASE_URL . "/sidor/buy.php";

$st1url = __DIR__ . "../../css/header/header.css";
$st2url = __DIR__ . "../../css/header/search.css";

$header = <<<HTML
<header>
    <h1><a href="/skivaffar">UNWOUND</a></h1>
    <div class="search-wrapper">
        <div class="search-container">
            <input type="text" class="search-input">
            <div class="icon"><img src="./../../skivaffar/public/bilder/m-glass.svg" alt=""></div>
        </div>
        <dialog style="padding:0;" class="search-results anchor"></dialog>
    </div>
    <a href="{$shopURL}" class="to-shop">Affär</a>
    <link rel="stylesheet" href="../../skivaffar/css/header/header.css">
    <link rel="stylesheet" href="../../skivaffar/css/header/search.css">
    <script src="/skivaffar/mallar/header/search.js"></script>
</header>
HTML;

echo $header;
