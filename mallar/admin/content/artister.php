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
    $sql = "SELECT * FROM album
            INNER JOIN artister ON album.owner = artister.rowid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red'>Databasfel: " . $e->getMessage() . "</p>";
}
?>

<div id="music-content" class="hidden content-menu">
    <h2>🎵 Artister & Album</h2>

    <input type="text" id="searchInput" placeholder="Sök efter artist eller album..." onkeyup="filterMusic()">

    <button class="new-artist">➕ Ny artist</button>
    <button class="new-album">➕ Nytt album</button>

    <div id="artist-list">
        <h3>Artister</h3>
        <ul>
            <?php foreach ($artists as $artist): ?>
                <li class="music-item">
                    <?= htmlspecialchars($artist['artistname']) ?>
                    <button>✏️ Redigera</button>
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
                    <button>✏️ Redigera</button>
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

    <div id="album-form" class="hidden-form">
        <h4>Lägg till/Redigera Album</h4>
        <form>
            <input type="hidden" name="album_id">
            <input type="text" name="album_title" placeholder="Albumnamn">
            <select name="album_artist">
                <?php foreach ($artists as $artist): ?>
                    <option value="<?= $artist['id'] ?>"><?= htmlspecialchars($artist['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">💾 Spara</button>
        </form>
    </div>
    <dialog class="create-artist">
        <div class="dialog-content">
            <button class="close">Stäng</button>
        </div>
    </dialog>
    <dialog class="create-album"></dialog>

    <script src="../mallar/admin/content/js/opendia.js" is:inline></script>
</div>