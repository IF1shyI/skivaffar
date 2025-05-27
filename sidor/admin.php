<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/sidor/admin/admin.css"> <!-- Länk till CSS -->
</head>

<body class="login-page">

    <!-- Loginformulär -->
    <form class="form" method="post" action="admin.php">
        <p id="heading">Login</p>

        <!-- Användarnamn-fält med ikon -->
        <div class="field">
            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                viewBox="0 0 16 16">
                <path
                    d="M13.106 7.222c0-2.967-2.249-5.032-5.482-5.032-3.35 0-5.646 2.318-5.646 5.702 0 3.493 2.235 5.708 5.762 5.708.862 0 1.689-.123 2.304-.335v-.862c-.43.199-1.354.328-2.29.328-2.926 0-4.813-1.88-4.813-4.798 0-2.844 1.921-4.881 4.594-4.881 2.735 0 4.608 1.688 4.608 4.156 0 1.682-.554 2.769-1.416 2.769-.492 0-.772-.28-.772-.76V5.206H8.923v.834h-.11c-.266-.595-.881-.964-1.6-.964-1.4 0-2.378 1.162-2.378 2.823 0 1.737.957 2.906 2.379 2.906.8 0 1.415-.39 1.709-1.087h.11c.081.67.703 1.148 1.503 1.148 1.572 0 2.57-1.415 2.57-3.643zm-7.177.704c0-1.197.54-1.907 1.456-1.907.93 0 1.524.738 1.524 1.907S8.308 9.84 7.371 9.84c-.895 0-1.442-.725-1.442-1.914z" />
            </svg>
            <input autocomplete="off" placeholder="Username" class="input-field" type="text" name="usr">
        </div>

        <!-- Lösenordsfält med ikon -->
        <div class="field">
            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                viewBox="0 0 16 16">
                <path
                    d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
            </svg>
            <input placeholder="Password" class="input-field" type="password" name="psw">
        </div>

        <!-- Submit-knapp -->
        <div class="btn">
            <button type="submit" class="button1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Login&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
        </div>
    </form>

    <!-- Meddelande-sektion där fel eller framgång visas -->
    <div class="message">
        <?php
        // Starta session för att kunna hantera inloggningstillstånd
        session_start();

        // Inkludera databasanslutning
        require_once "../funktioner/db/connect.php";

        // Säkerställ att funktionen finns, annars skriv fel i konsolen
        if (!function_exists('connectToDb')) {
            echo "<script>console.error('Funktionen connectToDb() hittades inte');</script>";
        }

        // Hantera formulärinlämning (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Hämta inmatat användarnamn och lösenord, default tomma strängar om ej satta
            $usr = $_POST['usr'] ?? '';
            $psw = $_POST['psw'] ?? '';

            try {
                $pdo = connectToDb();

                // Förbered SQL-sats för att hitta användare med angivet användarnamn och lösenord
                $sql = "SELECT * FROM users WHERE username = :usr AND psw = :psw";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':usr' => $usr,
                    ':psw' => $psw
                ]);

                // Hämta användardata om det finns
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    // Om användare finns, skapa session och sätt inloggad-status
                    $_SESSION['logged_in'] = true;
                    $_SESSION['username'] = $user['username'];

                    // Omdirigera till adminbeskrivningssida
                    header("Location: admindesc.php");
                    exit;
                } else {
                    // Felaktigt användarnamn eller lösenord - visa felmeddelande
                    echo "<p style='color:red;text-align:center;font-size:3rem;'>Felaktigt användarnamn eller lösenord.</p>";
                }
            } catch (PDOException $e) {
                // Vid databaskopplings- eller fråga-fel, visa felmeddelande
                echo "<p style='color:red'>Databasfel: " . $e->getMessage() . "</p>";
            }
        }
        ?>
    </div>
</body>

</html>