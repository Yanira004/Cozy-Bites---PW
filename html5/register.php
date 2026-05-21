<?php
global $pdo;
require_once 'config.php';
$mesajEroare = "";
$mesajSucces = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim(isset($_POST['username']) ? $_POST['username'] : '');
    $parola   = trim(isset($_POST['parola']) ? $_POST['parola'] : '');
    $parola2  = trim(isset($_POST['parola2']) ? $_POST['parola2'] : '');

    if (strlen($username) < 3) {
        $mesajEroare = "Username-ul trebuie să aibă minim 3 caractere.";
    } elseif (strlen($parola) < 6) {
        $mesajEroare = "Parola trebuie să aibă minim 6 caractere.";
    } elseif ($parola !== $parola2) {
        $mesajEroare = "Parolele nu coincid.";
    } else {
        $check = $pdo->prepare("SELECT id FROM utilizatori WHERE username = ?");
        $check->execute([$username]);
        if ($check->fetch()) {
            $mesajEroare = "Username-ul este deja folosit.";
        } else {
            $hash = password_hash($parola, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO utilizatori (username, parola, rol) VALUES (?, ?, 'user')");
            $stmt->execute([$username, $hash]);
            $mesajSucces = "Cont creat cu succes! Te poți autentifica acum.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Cozy Bites - Înregistrare</title>
    <link rel="icon" type="image/png" href="../images/LogoCircle.png">
    <link rel="stylesheet" href="css/orizontal.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        <li><a href="carduri.php">Carduri Rețete</a></li>
    </ul>
    <div class="nav-right">
        <a href="contact.html" title="Contact"><i class="fas fa-phone"></i></a>
        <a href="login.php" title="Contul Meu"><i class="fas fa-user"></i></a>
    </div>
</nav>

<h1 class="form-title" style="font-family: 'Pacifico', cursive;">Creare Cont Nou</h1>

<form action="register.php" method="POST">
    <fieldset>
        <legend>Date Înregistrare</legend>

        <?php if ($mesajEroare !== ""): ?>
            <p style="color:red; font-weight:bold;"><?php echo htmlspecialchars($mesajEroare); ?></p>
        <?php endif; ?>
        <?php if ($mesajSucces !== ""): ?>
            <p style="color:green; font-weight:bold;"><?php echo htmlspecialchars($mesajSucces); ?></p>
        <?php endif; ?>

        <p>
            Nume utilizator:
            <input type="text" name="username" required minlength="3">
        </p>
        <p>
            Parolă:
            <input type="password" name="parola" required minlength="6">
        </p>
        <p>
            Confirmă parola:
            <input type="password" name="parola2" required minlength="6">
        </p>
        <p><input type="submit" value="Înregistrare"></p>
        <p style="text-align:center; font-size:14px;">
            Ai deja cont? <a href="login.php" style="color:var(--culoare-meniu); font-weight:bold;">Autentifică-te</a>
        </p>
    </fieldset>
</form>
</body>
</html>