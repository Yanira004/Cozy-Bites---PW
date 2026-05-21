<?php
require_once 'config.php';
$mesajEroare = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameIntrodus = trim($_POST['username']);
    $parolaIntrodusa = trim($_POST['parola']);
    $captchaUtilizator = isset($_POST['captcha_raspuns']) ? (int)$_POST['captcha_raspuns'] : 0;

    // 1. Verificare Captcha
    if ($captchaUtilizator !== $_SESSION['captcha_rezultat']) {
        $mesajEroare = "Captcha incorect! Cât fac " . $_SESSION['nr1'] . " + " . $_SESSION['nr2'] . "?";
    } else {
        // 2. Verificare utilizator în SQLite
        $stmt = $pdo->prepare("SELECT * FROM utilizatori WHERE username = :user AND parola = :pass");
        $stmt->execute(['user' => $usernameIntrodus, 'pass' => $parolaIntrodusa]);
        $utilizatorGasit = $stmt->fetch(PDO::FETCH_ASSOC); // FETCH_ASSOC e sfânt în SQLite

        if ($utilizatorGasit) {
            $_SESSION['logat'] = true;
            $_SESSION['id_utilizator'] = $utilizatorGasit['id'];
            $_SESSION['username'] = $utilizatorGasit['username'];
            $_SESSION['rol'] = $utilizatorGasit['rol'];

            if (isset($_POST['remember'])) {
                setcookie("user_login", $utilizatorGasit['username'], time() + (86400 * 30), "/");
            }

            header("Location: login.php");
            exit();
        } else {
            $mesajEroare = "Username sau parola incorecte!";
        }
    }
}

// Generăm numere proaspete pentru Captcha
$_SESSION['nr1'] = rand(1, 9);
$_SESSION['nr2'] = rand(1, 9);
$_SESSION['captcha_rezultat'] = $_SESSION['nr1'] + $_SESSION['nr2'];
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Cozy Bites - Autentificare</title>
    <link rel="stylesheet" href="css/orizontal.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        h1 { text-align: center; color: var(--culoare-meniu); margin-top: 40px; }
        .link-inregistrare { text-align: center; margin-top: 15px; font-size: 14px; }
        .link-inregistrare a { color: var(--culoare-meniu); font-weight: bold; text-decoration: none; }
        .buton-logout { display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: var(--culoare-meniu); color: white; text-decoration: none; border-radius: 5px; font-weight: bold; border: none; cursor: pointer; }
    </style>
</head>

<body class="form-page">
<nav class="navbar">
    <div class="nav-left">
        <img src="../images/LogoCircle.png" class="logo-nav" alt="Logo">
        <span class="logo-text">Cozy Bites</span>
    </div>
    <ul class="nav-center">
        <li><a href="home5.html">Acasă</a></li>
        <li><a href="formular5.php">Adaugă Rețetă</a></li>
        <li><a href="carduri.html">Carduri Rețete</a></li>
    </ul>
    <div class="nav-right">
        <a href="contact.html" title="Contact"><i class="fas fa-phone"></i></a>
        <a href="login.php" title="Contul Meu"><i class="fas fa-user"></i></a>
    </div>
</nav>

<?php if (isset($_SESSION['logat']) && $_SESSION['logat'] === true): ?>
    <h1 class="form-title" style="font-family: 'Pacifico', cursive;">Salut, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <form>
        <fieldset style="text-align: center; padding: 40px; background-color: #FFF9F0;">
            <legend>Panou Cont</legend>
            <h3 style="color: #4A3320; margin-bottom: 15px;">Ești autentificat cu succes!</h3>
            <p style="color: #4A3320; font-size: 18px; margin-bottom: 25px;">
                Rolul tău actual: <b style="color: #D2691E;"><?php echo htmlspecialchars($_SESSION['rol']); ?></b>
            </p>
            <a href="logout.php" class="buton-logout">Deconectare (Logout)</a>
        </fieldset>
    </form>
<?php else: ?>
    <h1 class="form-title" style="font-family: 'Pacifico', cursive;">Bine ai revenit!</h1>
    <form id="loginForm" action="login.php" method="POST">
        <fieldset>
            <legend>Autentificare Cont</legend>
            <?php if($mesajEroare != "") echo "<p style='color:red; font-weight:bold; text-align:center;'>$mesajEroare</p>"; ?>
            <p>
                Nume utilizator:
                <input type="text" id="username" name="username" placeholder="Introdu numele de utilizator" required>
            </p>
            <p>
                Parolă:
                <input type="password" id="parola" name="parola" placeholder="Introdu parola" required>
            </p>
            <p style="background: #FFF9F0; padding: 10px; border-radius: 4px; border: 1px solid #ccc;">
                <label><b>Verificare Antirobot (Captcha):</b></label><br>
                Cât fac <?php echo $_SESSION['nr1']; ?> + <?php echo $_SESSION['nr2']; ?>?
                <input type="number" name="captcha_raspuns" required style="width: 80px; margin-left: 10px; padding: 5px;">
            </p>
            <p>
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ține-mă minte (Remember me)</label>
            </p>
            <p><input type="submit" value="Intră în cont"></p>
        </fieldset>
    </form>
<?php endif; ?>
</body>
</html>