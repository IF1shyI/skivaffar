<?php
require_once "../funktioner/db/connect.php";

if (!function_exists('connectToDb')) {
    echo "<script>console.error('Funktionen connectToDb() hittades inte');</script>";
}

try {
    $pdo = connectToDb();

    // Hämta alla artister
    $sql = "SELECT * FROM artister";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $artists = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Hämta alla album
    $sql = "SELECT * FROM albums
            INNER JOIN artister ON albums.owner = artister.rowid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red'>Databasfel: " . $e->getMessage() . "</p>";
}
?>

<div id="music-content" class="hidden content-menu">
    <h2>🎵 Artister & Album</h2>

    <input type="text" id="searchInput" placeholder="Sök efter artist eller album...">

    <button class="new-artist">➕ Ny artist</button>
    <button class="new-album">➕ Nytt album</button>

    <div id="artist-list">
        <h3>Artister</h3>
        <ul>
            <?php foreach ($artists as $artist): ?>
                <li class="music-item">
                    <?= htmlspecialchars($artist['artistname']) ?>
                    <button class="artist-btn <?= htmlspecialchars($artist['artistname']) ?>">✏️ Redigera</button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div id="album-list">
        <h3>Album</h3>
        <ul>
            <?php foreach ($albums as $album): ?>
                <li class="music-item">
                    <?= htmlspecialchars($album['name']) ?> (<?= $album['artistname'] ?>)
                    <button class="album-btn" data-album="<?= htmlspecialchars($album['name']) ?>" data-artist="<?= $album['artistname'] ?>">✏️ Redigera</button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div id="artist-form" class="hidden-form">
        <h4>Lägg till/Redigera Artist</h4>
        <form>
            <input type="hidden" name="artist_id">
            <input type="text" name="artist_name" placeholder="Artistnamn">
            <button type="submit">💾 Spara</button>
        </form>
    </div>

    <dialog class="edt-info dialog-common">
        <div class="dialog-content">
            <button class="close">Stäng</button>
        </div>
    </dialog>
    <dialog class="create-artist dialog-common">
        <div class="dialog-content">
            <button class="close">Stäng</button>
            <h1>Skapa artist</h1>
            <form method="POST" class="artist-form">
                <input type="hidden" name="form_type" value="create_artist">
                <label>
                    Artistnamn:
                    <input type="text" name="artistname">
                </label>
                <label>
                    Förnamn:
                    <input type="text" name="firstname">
                </label>
                <label>
                    Efternamn:
                    <input type="text" name="lastname">
                </label>
                <label>
                    Startår:
                    <input type="text" name="startyear">
                </label>
                <label>
                    Om text:
                    <textarea name="about"></textarea>
                </label>
                <label>
                    Alias:
                    <input type="text" name="alias">
                </label>
                <label>
                    Andra namn:
                    <input type="text" name="surnames">
                </label>
                <label>
                    Bildlänk:
                    <input type="text" name="picture">
                </label>
                <button type="submit" class="submit-btn">Skapa artist</button>
            </form>
        </div>
    </dialog>
    <dialog class="create-album dialog-common">
        <div class="dialog-content">
            <button class="close">Stäng</button>
            <h1>Skapa album</h1>
            <form method="POST">
                <input type="hidden" name="form_type" value="create_album">
                <label>
                    Album name:
                    <input type="text" name="albumname">
                </label>
                <label class="artist-suggestion">
                    Artist:
                    <input type="text" name="artist" class="artist-suggestion-inp">
                </label>
                <dialog class="sug-box"></dialog>
                <label>
                    År:
                    <input type="number" name="year">
                </label>
                <label>
                    Pris:
                    <input type="number" name="price">
                </label>
                <label>
                    Bildlänk:
                    <input type="text" name="picture">
                </label>
                <div class="songlist">
                    <div class="song1">
                        <p>Låt 1:</p>
                        <label>
                            Namn:
                            <input type="text" name="songs[]">
                        </label>
                    </div>
                </div>
                <button type="button" class="add-song">Lägg till låt</button>
                <button type="submit" class="submit-btn">Skapa album</button>
            </form>
        </div>
    </dialog>
    <div class="edit-album-wapper hidden">
    </div>

    <script src="../mallar/admin/content/js/opendia.js"></script>
    <script src="../mallar/admin/content/js/songinput.js"></script>
    <script src="../mallar/admin/content/js/sugestionArtist.js"></script>
    <script src="../mallar/admin/content/js/openformedt.js"></script>
    <link rel="stylesheet" href="../css/sidor/admin/admindesc/suggestionbox.css">
</div>

<?php
require_once __DIR__ . "/../../../funktioner/sendData/sendartist.php";
require_once __DIR__ . "/../../../funktioner/sendData/sendalbum.php";
if ($_POST && in_array($_POST['form_type'], ['create_artist', 'update_artist'])) {
    sendArtist($_POST);
}
if ($_POST && in_array($_POST['form_type'], ['create_album', 'update_album'])) {
    sendAlbum($_POST);
}
?>