<?php
require_once "../db/connect.php";

function getAlbum($data)
{
    try {

        $artist = $data["artist"] ?? "";
        $album = $data["album"] ?? "";

        $pdo = connectToDb();

        $sqlAlbum = "SELECT *
            FROM albums
            INNER JOIN songs ON songs.album = albums.rowid
            INNER JOIN artister ON songs.owner = artister.rowid
            WHERE albums.name = :albumname
            AND artister.artistname = :artist";
        $stmtAlbum = $pdo->prepare($sqlAlbum);
        $stmtAlbum->execute([':albumname' => $album, ':artist' => $artist]);
        $rows = $stmtAlbum->fetchAll(PDO::FETCH_ASSOC);

        $albumData = $rows[0];

        $songsInputs = "";
        $i = 1;
        foreach ($rows as $row) {
            $title = htmlspecialchars($row['songname']); // säkerställa säker output
            $songsInputs .= <<<HTML
            <div class="song{$i}">
                <label>
                    <p class="song-num">Låt {$i}:</p>
                    Namn:
                    <input type="text" name="songs[]" value="{$title}">
                    <button type="button" class="rm-song" data-songnum="{$i}">Ta bort</button>
                </label>
            </div>
            HTML;
            $i++;
        }

        $albumPicture = htmlspecialchars($albumData['picture'] ?? '');
        return <<<HTML
            <h1>Redigera album</h1>
            <form method="post">
                <input type="hidden" name="form_type" value="update_album">
                <input type="hidden" name="artist" value="{$albumData['artistname']}">
                <label >
                    Albumnamn:
                    <input type="text" value="{$albumData['name']}" name="albumname">
                </label>
                <label >
                    Pris (KR):
                    <input type="number" value="{$albumData['price']}" name="price">
                </label>
                <label >
                    År:
                    <input type="number" value="{$albumData['year']}" name="year">
                </label>
                <label >
                    Bild:
                    <img src='{$albumPicture}' alt='albumbild.png' >
                    <input type="text" name="picture">
                </label>
                <div class="songlist">
                    {$songsInputs}
                </div>
                <button type="button" class="add-song">Lägg till låt</button>
                
                <button type="submit" class="submit-btn">💾 Spara</button>
            </form>
            <button class="submit-btn rm-album">🗑️ Radera album</button>
                <dialog class="rm-confirm dialog-common">
                    <h1>Bekräfta att du vill ta bort albumet</h1>
                    <p>Observera att denna åtgärd inte går att ångra när du har klickat på "Fortsätt".</p>
                    <button class="submit-btn rm-deny">Avbryt</button>
                    <button class="submit-btn rm-accept" data-album="{$albumData['name']}">Forsätt</button>
                </dialog>
        HTML;
    } catch (PDOException $e) {
        echo "<p>Fel vid databaskoppling: " . $e->getMessage() . "</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['artist']) && isset($_POST['album'])) {
    echo getAlbum($_POST);
}
