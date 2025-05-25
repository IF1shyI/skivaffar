<?php
require_once "../db/connect.php";

function getArtist($data)
{
    try {

        $artist = $data["artist"] ?? "";

        $pdo = connectToDb();

        $sqlArtist = "SELECT * FROM artister WHERE artistname = :artistname LIMIT 1";
        $stmtArtist = $pdo->prepare($sqlArtist);
        $stmtArtist->execute([':artistname' => $artist]);
        $artistData = $stmtArtist->fetch(PDO::FETCH_ASSOC);

        if (!is_array($artistData)) {
            $artistData = [
                'artistname' => '',
                'firstname' => '',
                'lastname' => '',
                'startyear' => '',
                'about' => '',
                'alias' => '',
                'surnames' => '',
                'picture' => ''
            ];
        }

        return <<<HTML
            <h1>Redigera artist</h1> 
            <button type="button" class="submit-btn rm-album">🗑️ Ta bort artist + album</button>
            <form method="post">
                <input type="hidden" name="form_type" value="update_artist">
                <label >
                    Artistnamn:
                    <input type="text" name="artistname" value ="{$artistData['artistname']}">
                </label>
                <label>
                    Förnamn:
                    <input type="text" name="firstname" value="{$artistData['firstname']}">
                </label>
                <label>
                    Efternamn:
                    <input type="text" name="lastname" value="{$artistData['lastname']}">
                </label>
                <label>
                    Startår:
                    <input type="text" name="startyear" value="{$artistData['startyear']}">
                </label>
                <label>
                    Om:
                    <textarea name="about">{$artistData['about']}</textarea>
                </label>
                <label>
                    Alias:
                    <input type="text" name="alias" value="{$artistData['alias']}">
                </label>
                <label>
                    Andra namn:
                    <input type="text" name="surnames" value="{$artistData['surnames']}">
                </label>
                <label class="picture">
                    Bild:
                    <img src="{$artistData['picture']}" alt="artistbild.png">
                    <input type="text" name="picture" value="{$artistData['picture']}">
                </label>
                <button type="submit" class="submit-btn">💾 Spara</button>
            </form>
            <button class="submit-btn rm-album">🗑️ Radera artist</button>
                <dialog class="rm-confirm dialog-common">
                    <h1>Bekräfta att du vill ta bort Artisten</h1>
                    <p>Observera att denna åtgärd inte går att ångra när du har klickat på "Fortsätt".</p>
                    <button class="submit-btn rm-deny">Avbryt</button>
                    <button class="submit-btn rm-accept" data-artist="{$artistData['artistname']}">Forsätt</button>
                </dialog>
        HTML;
    } catch (PDOException $e) {
        echo "<p>Fel vid databaskoppling: " . $e->getMessage() . "</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['artist'])) {
    echo getArtist($_POST);
}
