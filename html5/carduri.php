<?php
require_once 'config.php';
global $pdo;
?>
<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <title>Cozy Bites - Rețete (Carduri)</title>
    <link rel="icon" type="image/png" href="../images/LogoCircle.png">
    <link rel="stylesheet" href="css/orizontal.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .admin-controls { margin-top: 10px; display: flex; gap: 5px; justify-content: center; flex-wrap: wrap; }
        .btn-delete { background-color: #e74c3c; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 0.8em; cursor: pointer; border: none; }
        .btn-admin { background-color: #c0392b; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 0.8em; }
        .container-recomandari { display: flex; gap: 20px; justify-content: center; margin-bottom: 40px; }
    </style>
</head>

<body>
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

<h2 style="text-align: center; font-family: 'Pacifico', cursive;">Recomandările Zilei</h2>

<div class="container-carduri container-recomandari">
    <?php
    $stmtRec = $pdo->query("SELECT * FROM retete ORDER BY id DESC LIMIT 2");
    while ($row = $stmtRec->fetch()) {
        $imgStmt = $pdo->prepare("SELECT cale_fisier FROM retete_imagini WHERE id_reteta = ? LIMIT 1");
        $imgStmt->execute([$row['id']]);
        $foto = $imgStmt->fetch();
        $calePoza = $foto ? $foto['cale_fisier'] : '../images/default_recipe.jpeg';

        echo '
            <div class="card" style="border: 2px solid #ffb3b3;">
                <img src="' . htmlspecialchars($calePoza) . '" alt="Recomandare">
                <div class="card-body">
                    <div class="card-title">' . htmlspecialchars($row['nume_reteta']) . '</div>
                    <p>' . htmlspecialchars($row['categorie']) . ' - Noutate!</p>
                    <a href="vizualizare_reteta.php?id=' . $row['id'] . '" class="card-btn">Vezi Rețeta</a>
                </div>
            </div>';
    }
    ?>
</div>

<hr style="width: 80%; opacity: 0.3;">

<h2 style="text-align: center; font-family: 'Pacifico', cursive; margin-top: 40px;">Toate Rețetele</h2>

<div class="container-carduri">
    <?php
    $stmt = $pdo->query("SELECT * FROM retete ORDER BY id DESC");

    while ($row = $stmt->fetch()) {
        $imgStmt = $pdo->prepare("SELECT id, cale_fisier FROM retete_imagini WHERE id_reteta = ? LIMIT 1");
        $imgStmt->execute([$row['id']]);
        $foto = $imgStmt->fetch();

        $calePoza = $foto ? $foto['cale_fisier'] : '../images/default_recipe.jpeg';
        $idPoza = $foto ? $foto['id'] : null;

        echo '
            <div class="card" id="reteta-' . $row['id'] . '">
                <img src="' . htmlspecialchars($calePoza) . '" alt="Imagine Rețetă" class="recipe-img">
                <div class="card-body">
                    <div class="card-title">' . htmlspecialchars($row['nume_reteta']) . '</div>
                    <p>Categorie: ' . htmlspecialchars($row['categorie']) . ' | ' . $row['timp_preparare'] . ' min</p>
                    
                    <a href="vizualizare_reteta.php?id=' . $row['id'] . '" class="card-btn">Vezi Rețeta</a>
                    <div class="admin-controls">';

        if (isset($_SESSION['logat']) && $idPoza) {
            echo '
                        <button class="btn-delete btn-delete-foto" 
                                data-id="' . $idPoza . '" 
                                id="btn-foto-' . $idPoza . '">
                           <i class="fas fa-trash"></i> Șterge Foto
                        </button>';
        }

        if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
            echo '
                        <a href="sterge_reteta.php?id=' . $row['id'] . '" 
                           class="btn-admin" 
                           onclick="return confirm(\'ATENȚIE! Sigur ștergi TOATĂ rețeta?\')">
                           <i class="fas fa-exclamation-triangle"></i> Șterge Rețeta
                        </a>';
        }
        echo '      </div>
                </div>
            </div>';
    }
    ?>
</div>

<div style="padding: 20px;">
    <h2>Categorii Rețete</h2>
    <ul class="lista-colapsabila">
        <li class="expandabil">Deserturi
            <ul>
                <li class="expandabil">Internaționale
                    <ul>
                        <li class="element-simplu">Tiramisu</li>
                        <li class="element-simplu">Brioșe</li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="jQuery/listeJQ.js"></script>

<script>
    $(document).ready(function() {
        $('.btn-delete-foto').on('click', function() {
            if (!confirm('Sigur ștergi poza?')) return;

            var btn = $(this);
            var idPoza = btn.data('id');
            var card = btn.closest('.card');

            $.ajax({
                url: 'sterge_poza.php',
                type: 'GET',
                data: { id: idPoza },
                success: function() {
                    card.find('.recipe-img').attr('src', '../images/default_recipe.jpeg');
                    btn.fadeOut();
                },
                error: function() {
                    alert('Eroare la ștergerea imaginii. Verificați dacă sunteți logat.');
                }
            });
        });
    });
</script>

</body>
</html>