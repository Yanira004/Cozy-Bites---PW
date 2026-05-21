<?php
require_once 'config.php';
global $pdo, $mysqli_conn, $sqlite_conn;

if (!isset($_SESSION['logat'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['id_utilizator'];

$stmt = $pdo->prepare("SELECT * FROM utilizatori WHERE id = ?");
$stmt->execute([$id_user]);
$user = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $varsta = $_POST['varsta'];
    $tara = $_POST['tara'];
    $oras = $_POST['oras'];
    $bio = $_POST['bio'];

    $sql_update = "UPDATE utilizatori SET varsta = ?, tara = ?, oras = ?, bio = ? WHERE id = ?";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([$varsta, $tara, $oras, $bio, $id_user]);

    $stmt_log = $sqlite_conn->prepare("INSERT INTO log_profil (id_utilizator, actiune, data_ora) VALUES (?, ?, ?)");
    $stmt_log->execute([$id_user, 'Actualizare profil', date('Y-m-d H:i:s')]);

    header("Location: profil.php?succes=1");
    exit();
}

$logs = $sqlite_conn->prepare("SELECT * FROM log_profil WHERE id_utilizator = ? ORDER BY data_ora DESC LIMIT 3");
$logs->execute([$id_user]);
$istoric = $logs->fetchAll(PDO::FETCH_ASSOC);
?>

<hr>
<h3>Istoric activitate (din SQLite):</h3>
<ul style="font-size: 0.9em; color: #666;">
    <?php foreach ($istoric as $log): ?>
        <li><?php echo $log['actiune']; ?> la data: <?php echo $log['data_ora']; ?></li>
    <?php endforeach; ?>
</ul>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Profilul Meu - Cozy Bites</title>
    <link rel="stylesheet" href="css/orizontal.css">
</head>
<body class="form-page">
<nav class="navbar">
    <ul class="nav-center">
        <li><a href="home5.html">Acasă</a></li>
        <li><a href="carduri.php">Rețete</a></li>
        <li><a href="profil.php">Profilul Meu</a></li>
    </ul>
</nav>

<div style="max-width: 500px; margin: 50px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <h1 style="font-family: 'Pacifico', cursive; text-align: center;">Setări Profil</h1>

    <?php if(isset($_GET['succes'])) echo "<p style='color:green;'>Datele au fost salvate!</p>"; ?>

    <form action="profil.php" method="POST">
        <p>
            Nume utilizator (readonly): <br>
            <input type="text" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
        </p>

        <p>
            Vârstă: <br>
            <input type="number" name="varsta" value="<?php echo htmlspecialchars(isset($user['varsta']) ? $user['varsta'] : ''); ?>">
        </p>

        <p>
            Țară: <br>
            <select name="tara">
                <option value="Romania" <?php if((isset($user['tara']) ? $user['tara'] : '') == 'Romania') echo 'selected'; ?>>România</option>
                <option value="Italia" <?php if((isset($user['tara']) ? $user['tara'] : '') == 'Italia') echo 'selected'; ?>>Italia</option>
                <option value="Franta" <?php if((isset($user['tara']) ? $user['tara'] : '') == 'Franta') echo 'selected'; ?>>Franța</option>
            </select>
        </p>

        <p>
            Oraș: <br>
            <input type="text" name="oras" value="<?php echo htmlspecialchars(isset($user['oras']) ? $user['oras'] : ''); ?>">
        </p>

        <p>
            Despre mine (Bio): <br>
            <textarea name="bio" rows="4" style="width:100%;"><?php echo htmlspecialchars(isset($user['bio']) ? $user['bio'] : ''); ?></textarea>
        </p>

        <p>
            <input type="submit" value="Salvează Modificările" class="card-btn" style="width:100%;">
        </p>
    </form>
</div>
</body>
</html>