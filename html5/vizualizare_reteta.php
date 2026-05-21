<?php
require_once 'config.php';
global $pdo;

if (!isset($_GET['id'])) {
    die("Rețeta nu a fost găsită.");
}

$id_reteta = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM retete WHERE id = ?");
$stmt->execute([$id_reteta]);
$reteta = $stmt->fetch();

if (!$reteta) {
    die("Rețeta nu există.");
}

$stmt_img = $pdo->prepare("SELECT * FROM retete_imagini WHERE id_reteta = ?");
$stmt_img->execute([$id_reteta]);
$imagini = $stmt_img->fetchAll();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($reteta['nume_reteta']); ?></title>
    <link rel="stylesheet" href="css/orizontal.css">
</head>
<body>
<nav class="navbar">
    <ul class="nav-center">
        <li><a href="home5.html">Acasă</a></li>
        <li><a href="carduri.php">Carduri</a></li>
    </ul>
</nav>

<div style="max-width: 800px; margin: 20px auto; padding: 20px; background: #fff; border-radius: 8px;">
    <h1><?php echo htmlspecialchars($reteta['nume_reteta']); ?></h1>
    <p><strong>Categorie:</strong> <?php echo htmlspecialchars($reteta['categorie']); ?></p>
    <p><strong>Timp preparare:</strong> <?php echo $reteta['timp_preparare']; ?> minute</p>

    <h3>Imagini:</h3>
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <?php foreach ($imagini as $img): ?>
            <div style="position: relative;">
                <img src="<?php echo htmlspecialchars($img['cale_fisier']); ?>" width="200" style="border-radius: 5px;">
                <br>
                <a href="sterge_poza.php?id=<?php echo $img['id']; ?>&reteta=<?php echo $id_reteta; ?>"
                   style="color: red; font-size: 0.8em;"
                   onclick="return confirm('Ștergi poza?')">Șterge poza</a>
            </div>
        <?php endforeach; ?>
    </div>

    <h3>Ingrediente și Instrucțiuni:</h3>
    <p>Aici poți adăuga restul câmpurilor din baza de date...</p>
</div>
</body>
</html>