<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: admin.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin desc</title>
    <link rel="stylesheet" href="../css/sidor/admin/admindesc/admindesc.css">
    <link rel="stylesheet" href="../css/main/main.css">
    <link rel="stylesheet" href="../css/sidor/admin/admindesc/dialog.css">

</head>
<html>

<body class="admin-bdy">
    <div class="sidebar">
        <h2>Adminpanel</h2>
        <div>📊 Dashboard</div>
        <div>👥 Användare</div>
        <div class="music-btn adm-btn">🎵 Artister & Album</div>
        <div>🛒 Beställningar</div>
        <div>💬 Meddelanden / Support</div>
        <div>📢 Innehåll / Publicering</div>
        <div>⚙️ Inställningar</div>
        <div>🔒 Säkerhet & Loggar</div>
        <div>🧪 Sandbox</div>
        <div>🚪 Logga ut</div>
    </div>

    <div class="content">
        <?php include("../mallar/admin/content/artister.php"); ?>
    </div>
    <script src="../mallar/admin/content/js/togglemenus.js"></script>
</body>

</html>